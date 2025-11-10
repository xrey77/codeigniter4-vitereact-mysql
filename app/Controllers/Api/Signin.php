<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait; 
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key; 


class Signin extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    public function create()
    {
            $json = $this->request->getJSON();
            $userModel = new UserModel();
            $user = $userModel->where('username', $json->username)->first();
            if($user) {

                $hashpassword = $user['password'];                
                $authenticatePassword = password_verify($json->password, $hashpassword); 
                if($authenticatePassword) { 

                    $issuedAt = time();
                    $expirationTime = $issuedAt + 28800000; // 8hours
                    $fullname = $user['firstname'] . ' ' . $user['lastname'];
                    // $payload = [
                    //     'userid' => $user['id'],
                    //     'name' => $fullname,
                    //     'iat' => $issuedAt,
                    //     'exp' => $expirationTime,
                    // ];
                    $payload = array(
                        "iss" => $fullname,
                        "aud" => "BARCLAYS BANK",
                        "sub" => "1234567890",
                        "iat" => $issuedAt, //Time the JWT issued at
                        "exp" => $expirationTime, // Expiration time of token
                        "email" => $user['email'],
                        );

                    $key = getenv('JWT_SECRET');
                    $algorithm = 'HS256'; //'RS256';
                    $token = JWT::encode($payload, $key, $algorithm);

                    $data = [
                        'message' => 'You have logged-in successfully.',
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'isblocked' => $user['isblocked'],
                        'isactivated' => $user['isactivated'],
                        'roles' => $user['roles'],
                        'userpic' => $user['userpic'],
                        'qrcodeurl' => $user['qrcodeurl'],
                        'token' => $token
                    ];
                    return $this->respondCreated($data, 200); 


                } else {
                    return $this->fail('Invalid Password, try again.', 404);
                }
        
    
            }  else {
                return $this->fail('Username does not exists.', 404);
            }

        

        // $hashedPassword = password_hash($json->password, PASSWORD_DEFAULT);        

        // return $this->respondCreated(['message' => 'You have logged-in successfully.'], 200); 
        // }
        // return $this->fail('Registration Failed. Invalid or empty data provided.', 400);
    }        

}
