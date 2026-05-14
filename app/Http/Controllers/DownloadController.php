<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    /**
     * Generate a temporary signed URL for a private file.
     * Accessible by users with the 'download files' permission.
     */
    public function generateUrl(Request $request, $filename)
    {
        // 1. Authorization check
        if (!auth()->user()->can('download files')) {
            abort(403, 'You do not have permission to download files.');
        }

        // 2. File existence check
        $path = 'private/products/' . $filename;
        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File not found.');
        }

        // 3. Generate a temporary signed URL (valid for 30 minutes)
        $url = URL::temporarySignedRoute(
            'secure.download', 
            now()->addMinutes(30), 
            ['filename' => $filename]
        );

        return response()->json([
            'download_url' => $url,
            'expires_in' => '30 minutes'
        ]);
    }

    /**
     * Download the file (this route must be signed).
     */
    public function download(Request $request, $filename): StreamedResponse
    {
        // 1. Signature check is handled by the 'signed' middleware on the route

        // 2. Authorization check (extra layer of security)
        if (!auth()->user()->can('download files')) {
            abort(403, 'You do not have permission to download files.');
        }

        // 3. Serve the file
        $path = 'private/products/' . $filename;
        
        if (!Storage::disk('local')->exists($path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->download($path);
    }
}
