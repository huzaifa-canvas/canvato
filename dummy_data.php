<?php

use App\Models\Template;
use App\Models\Category;

$categories = Category::pluck('id')->toArray();
$catId1 = $categories[0] ?? null;
$catId2 = $categories[1] ?? null;

// Get a valid author
$authorId = \App\Models\User::first()->id ?? 1;

// Create 3 Logos
for ($i = 1; $i <= 3; $i++) {
    $title = 'Professional Logo Template ' . $i;
    $template = Template::create([
        'author_id' => $authorId,
        'title' => $title,
        'slug' => \Illuminate\Support\Str::slug($title),
        'type' => 'Logos',
        'short_description' => 'A clean and modern logo template for businesses.',
        'description' => 'Full vector editable logo template with multiple color variations. Perfect for modern tech and corporate businesses.',
        'price' => $i === 1 ? 0 : 15.00 + $i, // First one free
        'color_space' => 'CMYK',
        'orientation' => 'Square',
        'compatible_tools' => ['Adobe Illustrator', 'Figma'],
        'properties' => ['Vector', 'Editable', 'Print Ready'],
        'thumbnail' => ['thumbnails/logo1.png'],
        'is_active' => true,
        'meta_data' => [
            'Resolution' => '300 DPI',
            'Layered' => 'Yes',
        ],
    ]);

    if ($catId1) {
        $template->categories()->attach([$catId1, $catId2]);
    }
}

// Create 3 Websites
for ($i = 1; $i <= 3; $i++) {
    $title = 'Modern Website UI Kit ' . $i;
    $template = Template::create([
        'author_id' => $authorId,
        'title' => $title,
        'slug' => \Illuminate\Support\Str::slug($title),
        'type' => 'Websites',
        'short_description' => 'Complete landing page template with responsive sections.',
        'description' => 'Beautifully crafted website landing page template. Includes hero section, features, testimonials, and contact forms.',
        'price' => $i === 2 ? 0 : 35.00 + $i * 5, // Second one free
        'color_space' => 'RGB',
        'orientation' => 'Landscape',
        'compatible_tools' => ['Figma', 'Adobe XD'],
        'properties' => ['Layered', 'Editable'],
        'thumbnail' => ['thumbnails/website1.png'],
        'is_active' => true,
        'preview_url' => 'https://canvato.com/preview',
        'meta_data' => [
            'Responsive' => 'Yes',
            'Pages' => '5+',
        ],
    ]);

    if ($catId1) {
        $template->categories()->attach([$catId1]);
    }
}

echo "Dummy data created successfully!\n";
