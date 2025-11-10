<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait; 
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;

class Signup extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    public function create()
    {
        $json = $this->request->getJSON();
        $userModel = new UserModel();

        $findemail = $userModel->where('email', $json->email)->first();
        if($findemail)
        {
            return $this->fail('Email Address is already taken.', 409);
        }
        $findusername = $userModel->where('username', $json->username)->first();
        if($findusername)
        {
            return $this->fail('Username is already taken.', 409);
        }

        $hashedPassword = password_hash($json->password, PASSWORD_DEFAULT);        
        if ($json) {
            $data = [
                'firstname' => $json->firstname,
                'lastname' => $json->lastname,
                'email' => $json->email,
                'mobile' => $json->mobile,
                'username' => $json->username,
                'password' => $hashedPassword,
                'roles' =>  json_encode(['ROLE_ADMIN']),
                'isblocked' => 0,
                'mailtoken' => 0,
                'isactivated' => 1,
                'userpic' => '/images/pix.png',
                'secret' => '',
                'qrcodeurl' => null
            ];

            $userModel->save($data);            
            return $this->respondCreated(['message' => 'You have registered successfully.'], 200); 
        }
        return $this->fail('Registration Failed. Invalid or empty data provided.', 400);
    }        

}
