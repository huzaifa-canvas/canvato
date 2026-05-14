<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\Template;

class FrontendController extends Controller
{
    public function home()
    {
        return view('content.frontend.home');
    }

    public function templates(Request $request, $type = null)
    {
        $categories = \App\Models\Category::whereNull('parent_id')->with('children')->get();
        
        $query = Template::with(['category', 'tags'])->where('is_active', true);

        // All available types and their slugs
        $availableTypes = [
            'printable-templates' => 'Printable Templates',
            'product-mockups' => 'Product Mockups',
            'social-media' => 'Social Media',
            'websites' => 'Websites',
            'ux-ui-toolkits' => 'UX/UI Toolkits',
            'infographics' => 'Infographics',
            'logos' => 'Logos',
            'scene-generators' => 'Scene Generators',
        ];

        // Type filter
        $activeTypeTitle = null;
        if ($type && isset($availableTypes[$type])) {
            $exactType = $availableTypes[$type];
            $query->where('type', $exactType);
            $activeTypeTitle = $exactType;
        }

        // Category filter (Array support for checkboxes)
        if ($request->filled('category')) {
            $categoriesInput = (array) $request->category;
            $dbCategories = \App\Models\Category::whereIn('slug', $categoriesInput)->with('children')->get();
            
            $categoryIds = [];
            foreach ($dbCategories as $cat) {
                $categoryIds[] = $cat->id;
                foreach ($cat->children as $child) {
                    $categoryIds[] = $child->id;
                }
            }
            if (count($categoryIds) > 0) {
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        // Compatible tool filter
        if ($request->filled('tool')) {
            $tools = (array) $request->tool;
            $query->where(function($q) use ($tools) {
                foreach ($tools as $tool) {
                    $q->whereJsonContains('compatible_tools', $tool);
                }
            });
        }

        // Properties filter
        if ($request->filled('property')) {
            $properties = (array) $request->property;
            $query->where(function($q) use ($properties) {
                foreach ($properties as $prop) {
                    $q->whereJsonContains('properties', $prop);
                }
            });
        }

        // Color Space filter
        if ($request->filled('color_space')) {
            $query->whereIn('color_space', (array) $request->color_space);
        }

        // Orientation filter
        if ($request->filled('orientation')) {
            $query->whereIn('orientation', (array) $request->orientation);
        }

        // Sort
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'popular':
                $query->orderBy('created_at', 'desc'); // placeholder until we add downloads/views count
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }

        $templates = $query->paginate(12)->appends($request->query());

        // Get list of tools for sidebar
        $compatibleTools = ['Adobe Photoshop', 'Adobe Illustrator', 'Adobe InDesign', 'Affinity', 'Figma', 'Canva', 'Microsoft Word', 'PowerPoint', 'Keynote'];

        return view('content.frontend.templates', compact('templates', 'categories', 'compatibleTools', 'availableTypes', 'activeTypeTitle', 'type'));
    }

    public function singleTemplate($slug)
    {
        $template = Template::with(['category', 'tags', 'author'])->where('slug', $slug)->firstOrFail();
        return view('content.frontend.single-template', compact('template'));
    }

    public function profile()
    {
        return view('content.frontend.dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        return redirect()->back()->with('success', 'Password changed successfully.');
    }

    public function orders()
    {
        return view('content.frontend.dashboard.orders');
    }

    public function orderDetail($id)
    {
        return view('content.frontend.dashboard.order-detail');
    }

    public function checkout()
    {
        return view('content.frontend.dashboard.checkout');
    }
}
