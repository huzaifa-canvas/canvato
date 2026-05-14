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
        
        $templates = $query->latest()->get();
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
            'thumbnails.*' => 'nullable|image|max:2048',
            'secure_file' => 'nullable|file|max:100000',
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
            'is_active' => $request->has('is_active'),
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
            'thumbnails.*' => 'nullable|image|max:2048',
            'secure_file' => 'nullable|file|max:100000',
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
            'is_active' => $request->has('is_active'),
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
}
