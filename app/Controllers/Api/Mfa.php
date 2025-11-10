<?php

namespace App\Controllers\Api;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait; 
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

use App\Libraries\OtpService;


class Mfa extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';
    protected $otpService;

    public function __construct()
    {
        $this->otpService = new OtpService();
    }

    public function getQrcode($id = null) {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if ($user) {
            $label = $user['email'];
            $secret = $user['secret'];
            $issuer = "BARCLAYS BANK";
            $uri = $this->otpService->getProvisioningUri($label, $secret, $issuer);
        
            $options = new QROptions([
                'eccLevel' => QRCode::ECC_L,
                'outputType' => QRCode::OUTPUT_MARKUP_SVG, // SVG is default and recommended
                'imageBase64' => true, // Default
                'scale' => 5,
            ]);
    
            // Generate the QR code data URI
            $qrcode = new QRCode($options);
            $qrcodeurl = $qrcode->render($uri);
            return $this->response->setJSON(['qrcodeurl' => $qrcodeurl],200);
        }
    }

    public function activate_mfa($id = null) {
        $req = $this->request->getJSON();
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if ($user) {
            if ($req->Twofactorenabled == true) {

                $label = $user['email'];
                $secret = $this->otpService->generateSecret();
                $issuer = "BARCLAYS BANK";
                $uri = $this->otpService->getProvisioningUri($label, $secret, $issuer);
            
                $options = new QROptions([
                    'eccLevel' => QRCode::ECC_L,
                    'outputType' => QRCode::OUTPUT_MARKUP_SVG, // SVG is default and recommended
                    'imageBase64' => true, // Default
                    'scale' => 5,
                ]);
        
                // Generate the QR code data URI
                $qrcode = new QRCode($options);
                $qrcodeurl = $qrcode->render($uri);
                $prefix = 'data:image/svg+xml;base64,';
                $replacement = 'data:image/png;base64,';
                // $qrcodeurl_base64 = str_replace($prefix, $replacement, $qrcodeurl);
                // $qrcodeurl_base64 = str_replace($prefix, $replacement, $qrcodeurl);

                // $finalQrcode =  + $qrcodeurl_base64;

                $data = [
                    'secret' => $secret,
                    'qrcodeurl' => base64_encode($qrcodeurl)
                ];

                $userModel->update($id, $data );
                return $this->response->setJSON([
                    'message' => 'Multi-Factor Authenticator has been enabled.',
                    'qrcodeurl' => $qrcodeurl],200);
        
            } else {
                $data = [
                    'secret' => null,
                    'qrcodeurl' => null
                ];
                $userModel->update($id, $data );
                return $this->response->setJSON([
                    'message' => 'Multi-Factor Authenticator has been disabled.',
                    'qrcodeurl' => null],200);

            }
        } else {
            return $this->fail('User not found.', 404);
        }
    }

    public function otpvalidation() {
        $req = $this->request->getJSON();
        $userModel = new UserModel();
        $user = $userModel->find($req->id);
        if ($user) {
            $otp = $req->otp;
            $secret = $user['secret'];
            if ($this->otpService->verifyCode($otp, $secret)) {
                $data = [
                    'message' => 'OTP Code verification successfull.',
                    'username' => $user['username']
                ];
                return $this->response->setJSON($data,200);
            } else {
                return $this->fail('Invalid OTP Code.', 404);
            }
        } else {
            return $this->fail('User not found.', 404);
        }

    }


}