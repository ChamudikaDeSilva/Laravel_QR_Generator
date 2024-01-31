<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Response;
use Log;

class QrCodeController extends Controller
{
    public function showQrCodeForm()
    {
        return view('qrcode');
    }

    public function generateQrCode(Request $request)
    {
        $content = $request->input('content');

        // Generate QR code using SimpleSoftwareIO/QrCode package
        $qrCode = QrCode::size(300)->generate($content);

        // If the request is an AJAX request, return the QR code as JSON
        if ($request->ajax()) {
            return response()->json(['qrCode' => $qrCode]);
        }

        // For regular requests, return the view with the QR code
        return view('qrcode', compact('qrCode'));
    }

    public function downloadQrCode(Request $request)
    {
        $content = $request->input('content');

        // Log the received content for debugging
        Log::info('Received content for QR code: ' . $content);

        // Check if $content is null or empty, and handle it appropriately
        if (!$content) {
            return response()->json(['error' => 'Content is missing or empty.'], 400);
        }

        // Generate QR code using SimpleSoftwareIO/QrCode package
        $qrCode = QrCode::size(300)->generate($content);

        // Convert the QR code to PNG image
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $qrCode));

        // Save the image to a temporary file
        $tempFilePath = tempnam(sys_get_temp_dir(), 'qrcode_');
        file_put_contents($tempFilePath, $image);

        // Set the response headers for image download
        $headers = [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qrcode.png"',
        ];

        // Send the image as a response
        return response()->download($tempFilePath, 'qrcode.png', $headers)->deleteFileAfterSend(true);
    }

}
