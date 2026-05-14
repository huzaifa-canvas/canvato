<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\Category;
use App\Models\User;

class HomePage extends Controller
{
  public function index()
  {
    $stats = [
      'templates' => Template::count(),
      'active_templates' => Template::where('is_active', true)->count(),
      'categories' => Category::count(),
      'users' => User::count(),
    ];

    $recentTemplates = Template::latest()->take(5)->get();

    return view('content.pages.pages-home', compact('stats', 'recentTemplates'));
  }
}
