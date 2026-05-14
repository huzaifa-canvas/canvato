<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show(Template $template)
    {
        // If already purchased, redirect to details page
        if (Auth::check() && Auth::user()->hasPurchased($template)) {
            return redirect()->route('frontend.single-template', $template->slug)
                ->with('info', 'You already own this template.');
        }

        return view('content.frontend.checkout', compact('template'));
    }

    public function process(Request $request, Template $template)
    {
        // Mock payment processing
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->hasPurchased($template)) {
            return redirect()->route('frontend.single-template', $template->slug);
        }

        Order::create([
            'user_id' => Auth::id(),
            'template_id' => $template->id,
            'amount' => $template->price,
            'status' => 'completed',
            'payment_id' => 'mock_txn_' . uniqid()
        ]);

        return redirect()->route('frontend.single-template', $template->slug)
            ->with('success', 'Purchase successful! You can now download the secure files.');
    }
}
