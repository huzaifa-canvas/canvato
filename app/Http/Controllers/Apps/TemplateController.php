<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $query = Template::with('categories');
        
        $route = $request->route()->getName();
        $typeMapping = [
            'templates.type.printable' => 'Printable Templates',
            'templates.type.mockups' => 'Product Mockups',
            'templates.type.social' => 'Social Media',
            'templates.type.websites' => 'Websites',
            'templates.type.ux' => 'UX/UI Toolkits',
            'templates.type.infographics' => 'Infographics',
            'templates.type.logos' => 'Logos',
            'templates.type.scene' => 'Scene Generators',
        ];
        
        $currentType = null;
        if (array_key_exists($route, $typeMapping)) {
            $currentType = $typeMapping[$route];
            $query->where('type', $currentType);
        } elseif ($request->has('type')) {
            $currentType = $request->type;
            $query->where('type', $currentType);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_range')) {
            $dates = explode(' to ', $request->date_range);
            if (count($dates) == 2) {
                $query->whereDate('created_at', '>=', $dates[0])
                      ->whereDate('created_at', '<=', $dates[1]);
            } elseif (count($dates) == 1) {
                $query->whereDate('created_at', $dates[0]);
            }
        }
        
        $templates = $query->latest()->paginate(10)->withQueryString();
        return view('content.apps.templates.index', compact('templates', 'currentType'));
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        return view('content.apps.templates.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|array|min:1',
            'price' => 'nullable|numeric|min:0',
            'thumbnails.*' => 'nullable|image|max:20480',
            'secure_file' => 'nullable|file|max:307200',
            'preview_url' => 'nullable|url',
        ]);

        // Handle multiple thumbnails
        $thumbnails = [];
        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $file) {
                $thumbnails[] = $file->store('templates/thumbnails', 'public');
            }
        }

        $secureFilePath = null;
        if ($request->hasFile('secure_file')) {
            $secureFilePath = $request->file('secure_file')->store('templates/secure_files', 'local');
        }

        // Process dynamic meta data
        $metaData = [];
        if ($request->meta_keys && $request->meta_values) {
            foreach ($request->meta_keys as $index => $key) {
                if (!empty($key) && isset($request->meta_values[$index])) {
                    $metaData[$key] = $request->meta_values[$index];
                }
            }
        }

        $price = $request->price ?? 0;

        $isActive = $request->has('is_active');
        if ($isActive && !auth()->user()->can('publish products')) {
            $isActive = false; // Default to inactive if they don't have permission to publish
        }

        $template = Template::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'category_id' => $request->category_id[0] ?? null, // keep backward compat
            'type' => $request->type,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $price,
            'color_space' => $request->color_space,
            'orientation' => $request->orientation,
            'properties' => $request->properties ?? [],
            'compatible_tools' => $request->compatible_tools ?? [],
            'thumbnail' => $thumbnails,
            'secure_file_path' => $secureFilePath,
            'preview_url' => $request->preview_url,
            'meta_data' => $metaData,
            'is_active' => $isActive,
            'author_id' => auth()->id() ?? 1,
        ]);

        // Sync categories (many-to-many)
        $template->categories()->sync($request->category_id);

        // Attach Tags
        if ($request->has('tags') && is_array($request->tags)) {
            $tagsArray = array_filter(array_map('trim', $request->tags));
            $template->attachTags($tagsArray);
        }

        return redirect()->route('templates.index')->with('success', 'Template created successfully.');
    }

    public function edit(Template $template)
    {
        $template->load('categories', 'tags');
        $categories = Category::all();
        $tagsString = $template->tags->pluck('name')->implode(', ');
        return view('content.apps.templates.edit', compact('template', 'categories', 'tagsString'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|array|min:1',
            'price' => 'nullable|numeric|min:0',
            'thumbnails.*' => 'nullable|image|max:20480',
            'secure_file' => 'nullable|file|max:307200',
        ]);

        // Handle thumbnails
        $existingThumbs = is_array($template->thumbnail) ? $template->thumbnail : [];
        
        // Remove selected thumbnails
        if ($request->has('remove_thumbnails')) {
            foreach ($request->remove_thumbnails as $idx) {
                if (isset($existingThumbs[$idx])) {
                    Storage::disk('public')->delete($existingThumbs[$idx]);
                    unset($existingThumbs[$idx]);
                }
            }
            $existingThumbs = array_values($existingThumbs); // re-index
        }

        // Add new thumbnails
        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $file) {
                $existingThumbs[] = $file->store('templates/thumbnails', 'public');
            }
        }

        if ($request->hasFile('secure_file')) {
            if ($template->secure_file_path) {
                Storage::disk('local')->delete($template->secure_file_path);
            }
            $template->secure_file_path = $request->file('secure_file')->store('templates/secure_files', 'local');
        }

        $metaData = [];
        if ($request->meta_keys && $request->meta_values) {
            foreach ($request->meta_keys as $index => $key) {
                if (!empty($key) && isset($request->meta_values[$index])) {
                    $metaData[$key] = $request->meta_values[$index];
                }
            }
        }

        $price = $request->price ?? 0;

        $isActive = $template->is_active;
        if ($request->has('is_active') && !$template->is_active) {
            // Trying to publish
            if (auth()->user()->can('publish products')) {
                $isActive = true;
            }
        } elseif (!$request->has('is_active') && $template->is_active) {
            // Trying to unpublish
            if (auth()->user()->can('unpublish products')) {
                $isActive = false;
            }
        }

        $template->update([
            'title' => $request->title,
            'category_id' => $request->category_id[0] ?? null,
            'type' => $request->type,
            'description' => $request->description,
            'short_description' => $request->short_description,
            'price' => $price,
            'color_space' => $request->color_space,
            'orientation' => $request->orientation,
            'properties' => $request->properties ?? [],
            'compatible_tools' => $request->compatible_tools ?? [],
            'thumbnail' => $existingThumbs,
            'preview_url' => $request->preview_url,
            'meta_data' => $metaData,
            'is_active' => $isActive,
        ]);

        // Sync categories
        $template->categories()->sync($request->category_id);

        // Sync Tags
        if ($request->has('tags')) {
            $tagsArray = is_array($request->tags) ? array_filter(array_map('trim', $request->tags)) : [];
            $template->syncTags($tagsArray);
        }

        return redirect()->route('templates.index')->with('success', 'Template updated successfully.');
    }

    public function destroy(Template $template)
    {
        // Delete all thumbnails
        if (is_array($template->thumbnail)) {
            foreach ($template->thumbnail as $thumb) {
                Storage::disk('public')->delete($thumb);
            }
        }
        if ($template->secure_file_path) {
            Storage::disk('local')->delete($template->secure_file_path);
        }
        $template->categories()->detach();
        $template->delete();
        return redirect()->route('templates.index')->with('success', 'Template deleted successfully.');
    }

    public function duplicate(Template $template)
    {
        $newTemplate = $template->replicate();
        $newTemplate->title = $template->title . ' (Duplicate)';
        $newTemplate->slug = Str::slug($newTemplate->title) . '-' . time();
        $newTemplate->author_id = auth()->id();
        $newTemplate->is_active = 0; // Set as draft

        // Copy Thumbnails
        $newThumbs = [];
        if (is_array($template->thumbnail)) {
            foreach ($template->thumbnail as $thumb) {
                if (Storage::disk('public')->exists($thumb)) {
                    $newPath = 'templates/thumbnails/' . Str::random(40) . '.' . pathinfo($thumb, PATHINFO_EXTENSION);
                    Storage::disk('public')->copy($thumb, $newPath);
                    $newThumbs[] = $newPath;
                }
            }
        }
        $newTemplate->thumbnail = $newThumbs;

        // Copy Secure File
        if ($template->secure_file_path && Storage::disk('local')->exists($template->secure_file_path)) {
            $newSecurePath = 'templates/secure_files/' . Str::random(40) . '.' . pathinfo($template->secure_file_path, PATHINFO_EXTENSION);
            Storage::disk('local')->copy($template->secure_file_path, $newSecurePath);
            $newTemplate->secure_file_path = $newSecurePath;
        }

        $newTemplate->save();

        // Copy relations
        $newTemplate->categories()->sync($template->categories->pluck('id'));
        $newTemplate->syncTags($template->tags);

        return redirect()->route('templates.edit', $newTemplate->id)
                         ->with('success', 'Template duplicated successfully.');
    }

    public function downloadSample()
    {
        $filePath = public_path('samples/templates_sample.csv');
        return response()->download($filePath, 'templates_sample.csv');
    }

    public function bulkUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120',
        ]);

        $file = $request->file('csv_file');
        $type = $request->input('bulk_type'); // The type from the current page

        $handle = fopen($file->getRealPath(), 'r');
        if (!$handle) {
            return back()->with('error', 'Could not read the CSV file.');
        }

        // Read header row
        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return back()->with('error', 'CSV file is empty or has no header row.');
        }

        // Normalize header names (trim, lowercase)
        $header = array_map(function ($col) {
            // Remove UTF-8 BOM if present
            $col = preg_replace('/^[\xef\xbb\xbf]+/', '', $col);
            // Also strip any surrounding quotes or whitespace
            $col = trim($col, " \t\n\r\0\x0B\"");
            return strtolower($col);
        }, $header);

        $requiredColumns = ['title'];
        foreach ($requiredColumns as $col) {
            if (!in_array($col, $header)) {
                fclose($handle);
                return back()->with('error', "CSV is missing required column: '{$col}'.");
            }
        }

        $imported = 0;
        $skipped = 0;
        $skippedTitles = [];
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;

            // Skip empty rows
            if (count($row) === 0 || (count($row) === 1 && empty($row[0]))) {
                continue;
            }

            // Map row to header
            $data = [];
            foreach ($header as $i => $colName) {
                $data[$colName] = isset($row[$i]) ? trim($row[$i]) : '';
            }

            // Skip if title is empty
            if (empty($data['title'])) {
                continue;
            }

            // Check duplicate by title
            if (Template::where('title', $data['title'])->exists()) {
                $skipped++;
                $skippedTitles[] = $data['title'];
                continue;
            }

            // Parse comma-separated fields
            $categoriesNames = !empty($data['categories']) ? array_map('trim', explode(',', $data['categories'])) : [];
            $tags = !empty($data['tags']) ? array_map('trim', explode(',', $data['tags'])) : [];
            $compatibleTools = !empty($data['compatible_tools']) ? array_map('trim', explode(',', $data['compatible_tools'])) : [];
            $properties = !empty($data['properties']) ? array_map('trim', explode(',', $data['properties'])) : [];

            $price = isset($data['price']) && is_numeric($data['price']) ? (float) $data['price'] : 0;

            // Create template
            $template = Template::create([
                'title'            => $data['title'],
                'slug'             => Str::slug($data['title']) . '-' . uniqid(),
                'type'             => $type,
                'description'      => $data['description'] ?? '',
                'short_description' => $data['short_description'] ?? '',
                'price'            => $price,
                'preview_url'      => !empty($data['preview_url']) ? $data['preview_url'] : null,
                'color_space'      => $data['color_space'] ?? null,
                'orientation'      => $data['orientation'] ?? null,
                'compatible_tools' => $compatibleTools,
                'properties'       => $properties,
                'thumbnail'        => [],
                'meta_data'        => [],
                'is_active'        => true,
                'author_id'        => auth()->id(),
            ]);

            // Sync categories (find or create)
            if (!empty($categoriesNames)) {
                $categoryIds = [];
                foreach ($categoriesNames as $catName) {
                    $category = Category::firstOrCreate(
                        ['slug' => Str::slug($catName)],
                        ['name' => $catName, 'slug' => Str::slug($catName)]
                    );
                    $categoryIds[] = $category->id;
                }
                $template->category_id = $categoryIds[0] ?? null;
                $template->save();
                $template->categories()->sync($categoryIds);
            }

            // Attach tags
            if (!empty($tags)) {
                $template->attachTags($tags);
            }

            $imported++;
        }

        fclose($handle);

        $message = "{$imported} templates imported successfully.";
        if ($skipped > 0) {
            $message .= " {$skipped} skipped (duplicate titles: " . implode(', ', array_slice($skippedTitles, 0, 5));
            if ($skipped > 5) {
                $message .= '... and ' . ($skipped - 5) . ' more';
            }
            $message .= ').';
        }

        return back()->with('success', $message);
    }
}
