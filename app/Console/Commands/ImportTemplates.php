<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImportTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'templates:import {csv} {images_dir} {--type=} {--author=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import templates from a CSV file with local images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $csvPath = $this->argument('csv');
        $imagesDir = $this->argument('images_dir');
        $type = $this->option('type');
        $authorId = $this->option('author') ?? 1;

        if (!file_exists($csvPath)) {
            $this->error("CSV file not found at: {$csvPath}");
            return 1;
        }

        if (!is_dir($imagesDir)) {
            $this->error("Images directory not found at: {$imagesDir}");
            return 1;
        }

        $handle = fopen($csvPath, 'r');
        $header = fgetcsv($handle);

        if (!$header) {
            $this->error("CSV file is empty or missing headers.");
            fclose($handle);
            return 1;
        }

        $header = array_map(function ($col) {
            // Remove any BOM (UTF-8, UTF-16 LE/BE, UTF-32)
            $col = preg_replace('/^\x{FEFF}/u', '', $col);
            $col = preg_replace('/^[\xef\xbb\xbf\xff\xfe\xfe\xff]+/', '', $col);
            // Strip surrounding quotes, whitespace, and non-printable chars
            $col = preg_replace('/[^\x20-\x7E]/', '', $col);
            $col = trim($col, " \t\n\r\0\x0B\"'");
            return strtolower($col);
        }, $header);

        if (!in_array('title', $header)) {
            $this->error("CSV must contain at least a 'title' column. Found headers: " . implode(', ', $header));
            fclose($handle);
            return 1;
        }

        // Count rows for progress bar
        $rowCount = 0;
        while (fgetcsv($handle) !== false) {
            $rowCount++;
        }
        rewind($handle);
        fgetcsv($handle); // Skip header again

        $this->info("Found {$rowCount} rows to process.");
        $bar = $this->output->createProgressBar($rowCount);
        $bar->start();

        $imported = 0;
        $skipped = 0;
        $missingImagesCount = 0;

        while (($row = fgetcsv($handle)) !== false) {
            if (empty(array_filter($row))) {
                $bar->advance();
                continue;
            }

            $data = [];
            foreach ($header as $i => $colName) {
                $data[$colName] = isset($row[$i]) ? trim($row[$i]) : '';
            }

            if (empty($data['title'])) {
                $bar->advance();
                continue;
            }

            if (Template::where('title', $data['title'])->exists()) {
                $skipped++;
                $bar->advance();
                continue;
            }

            // Handle images
            $thumbnailPaths = [];
            if (!empty($data['thumbnail_files'])) {
                $filenames = array_map('trim', explode(',', $data['thumbnail_files']));
                foreach ($filenames as $filename) {
                    $sourcePath = rtrim($imagesDir, '/\\') . DIRECTORY_SEPARATOR . $filename;
                    if (file_exists($sourcePath)) {
                        $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                        $newFilename = Str::random(40) . '.' . $extension;
                        $destPath = 'templates/thumbnails/' . $newFilename;
                        
                        Storage::disk('public')->put($destPath, file_get_contents($sourcePath));
                        $thumbnailPaths[] = $destPath;
                    } else {
                        $missingImagesCount++;
                        $this->newLine();
                        $this->warn("Warning: Image not found '{$sourcePath}' for template '{$data['title']}'");
                    }
                }
            }

            // Handle secure file (if column exists)
            $secureFilePath = null;
            if (!empty($data['secure_file'])) {
                $secureFilename = trim($data['secure_file']);
                $sourceSecurePath = rtrim($imagesDir, '/\\') . DIRECTORY_SEPARATOR . $secureFilename;
                if (file_exists($sourceSecurePath)) {
                    $extension = pathinfo($sourceSecurePath, PATHINFO_EXTENSION);
                    $newSecureFilename = Str::random(40) . '.' . $extension;
                    $destSecurePath = 'templates/secure_files/' . $newSecureFilename;
                    
                    Storage::disk('local')->put($destSecurePath, file_get_contents($sourceSecurePath));
                    $secureFilePath = $destSecurePath;
                } else {
                     $this->newLine();
                     $this->warn("Warning: Secure file not found '{$sourceSecurePath}' for template '{$data['title']}'");
                }
            }

            $categoriesNames = !empty($data['categories']) ? array_map('trim', explode(',', $data['categories'])) : [];
            $tags = !empty($data['tags']) ? array_map('trim', explode(',', $data['tags'])) : [];
            $compatibleTools = !empty($data['compatible_tools']) ? array_map('trim', explode(',', $data['compatible_tools'])) : [];
            $properties = !empty($data['properties']) ? array_map('trim', explode(',', $data['properties'])) : [];
            $price = isset($data['price']) && is_numeric($data['price']) ? (float) $data['price'] : 0;

            $template = Template::create([
                'title'            => $data['title'],
                'slug'             => Str::slug($data['title']) . '-' . uniqid(),
                'type'             => $type ?? ($data['type'] ?? null),
                'description'      => $data['description'] ?? '',
                'short_description' => $data['short_description'] ?? '',
                'price'            => $price,
                'preview_url'      => !empty($data['preview_url']) ? $data['preview_url'] : null,
                'color_space'      => $data['color_space'] ?? null,
                'orientation'      => $data['orientation'] ?? null,
                'compatible_tools' => $compatibleTools,
                'properties'       => $properties,
                'thumbnail'        => $thumbnailPaths,
                'secure_file_path' => $secureFilePath,
                'meta_data'        => [],
                'is_active'        => true,
                'author_id'        => $authorId,
            ]);

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

            if (!empty($tags)) {
                $template->attachTags($tags);
            }

            $imported++;
            $bar->advance();
        }

        $bar->finish();
        fclose($handle);

        $this->newLine(2);
        $this->info("Import Complete!");
        $this->line("- Successfully imported: <info>{$imported}</info>");
        if ($skipped > 0) {
            $this->line("- Skipped (Duplicates): <comment>{$skipped}</comment>");
        }
        if ($missingImagesCount > 0) {
            $this->line("- Missing Images: <error>{$missingImagesCount}</error>");
        }

        return 0;
    }
}
