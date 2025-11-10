<?php namespace App\Libraries;
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '../vendor/autoload.php'; // Adjust path if needed

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\Output\QROutputInterface;

class QrCodeGenerator
{
    public function generateBase64($otp_uri)
    {
        try {
            $qrcode = new QRCode([
                'outputType' => QROutputInterface::MARKUP_SVG, // SVG is clean for base64, or use PNG if you configure the renderer
                'imageBase64' => true, // This option might be specific to certain library versions. The method below is more reliable.
            ]);
            
            // The render method generates the data URI scheme string (e.g., 'data:image/svg+xml;base64,...')
            $dataUri = $qrcode->render($otp_uri); 

            return $dataUri;

        } catch (\Exception $e) {
            // Handle exceptions (e.g., invalid URI, library errors)
            log_message('error', 'QR Code generation error: ' . $e->getMessage());
            return false;
        }

    }
}
