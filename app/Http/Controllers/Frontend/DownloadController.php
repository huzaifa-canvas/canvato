<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function secureDownload(Template $template)
    {
        // Require authentication
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user owns it
        if (!Auth::user()->hasPurchased($template)) {
            abort(403, 'Unauthorized access. You have not purchased this template.');
        }

        // Check if file exists
        if (!$template->secure_file_path || !Storage::disk('local')->exists($template->secure_file_path)) {
            abort(404, 'Secure file not found.');
        }

        // Provide file securely
        return Storage::disk('local')->download($template->secure_file_path, $template->slug . '-source-files' . '.' . pathinfo($template->secure_file_path, PATHINFO_EXTENSION));
    }
}
