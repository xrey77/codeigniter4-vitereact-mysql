<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait; 
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key; 

class Users extends ResourceController
{
    use ResponseTrait;
    protected $format = 'json';

    public function showuser($id = null) {
        try {
            $userModel = new UserModel();
            $data = $userModel->find($id);
            if ($data) {

                return $this->respondCreated([
                    'message' => 'User details retrieved successfully.',
                    'user' => $data], 200);     
            } else {
                return $this->fail('User not found.', 404);
            }
        } catch(\Exceptions $ex) {
            return $this->failUnauthorized('Invalid credentials provided.');            
        }
    }

    public function update_profile($id = null) {
        $json = $this->request->getJSON();

        $userModel = new UserModel();
        $user = $userModel->find($id);
        if ($user) {

            $data = [
                'firstname' => $json->firstname,
                'lastname' => $json->lastname,
                'mobile' => $json->mobile
            ];
    
            $userModel->update($id, $data);
            return $this->response->setJSON(['message' => 'User Profile has been updated successfully.'],200);
    
        } else {
            return $this->fail('User not found.', 404);
        }
    }

    public function change_password($id = null) {
        $req = $this->request->getJSON();

        $userModel = new UserModel();
        $hashedPassword = password_hash($req->password, PASSWORD_DEFAULT);        
        $data = [
            'password' => $hashedPassword
        ];

        $userModel->update($id, $data);
        return $this->response->setJSON(['message' => 'Password has been changed successfully.'], 200);
    }

    public function updateProfilePicture() {
        try {
            // $req = $this->request->getJSON();
            $userModel = new UserModel();
            $id = $this->request->getPost('id');
            $filename = $this->request->getFile('userpic');
            $file_ext = $filename->getClientExtension();

            // $userModel = new UserModel();
            // $filename= $_FILES["file"]["userpic"];
            // $file_ext = "." . pathinfo($filename,PATHINFO_EXTENSION);
            // return $this->response->setJSON(['message' => $id],200);

            $newfilename = "00" . $id . '.' . $file_ext;
            if ($filename->isValid() && !$filename->hasMoved()) {       

                $uploadPath = 'users'; 
                $filename->move(ROOTPATH . 'public/' . $uploadPath, $newfilename);

                $file = 'http://localhost:8080/users/' .$newfilename;
                $data = [
                    'userpic' => $file
                ];
                $userModel->update($id, $data);

                // if ($img->isValid() && ! $img->hasMoved()) {
                //     $image = \Config\Services::image();
    
                //     $image->withFile($img)->fit(100, 100, 'center')
                //     ->save(ROOTPATH . '/public/users/' . $newfilename);                
                    
                //     $urlimg = "http://localhost:8080/users/" . $newfilename;
    
                //     $data = [
                //         'picture' => $urlimg
                //     ];
                    return $this->response->setJSON(['message' => 'Your picture has been changed.'],201);
                //     // $img->move(ROOTPATH . 'public/users', $image);
                // }       
            } else {
                return $this->fail(['message' => 'Unable to upload picture.'], 400);
            }
        } catch(\Exception $ex) {
            return $this->fail($ex->getMessage(), 400);
        }   
    
    }

    public function delete($id = null) {
        $userModel = new UserModel();
        $data = $userModel->find($id);
        if($data){
            $userModel->delete($id);
            return $this->respondCreated([
                'message' => 'User Profile has been deleted successfully.'], 200);
        } else {
            return $this->fail('User not found.', 404);
        }

    }

}