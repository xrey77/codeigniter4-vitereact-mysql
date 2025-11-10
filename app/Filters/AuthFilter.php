<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $header = $request->getHeaderLine("Authorization");
        $token = null;

        if (!empty($header) && preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $token = $matches[1];
        }

        if (is_null($token) || empty($token)) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON([
                'status' => 401,
                'error' => 'Unauthorized Access',
                'message' => 'Access denied. Bearer Token is required.'
            ]);
            return $response;            
        }

        try {
            $secretKey = getenv('JWT_SECRET'); // Retrieve your secret key from .env
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        } catch (Exception $e) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON([
                'status' => 401,
                'error' => 'Unauthorized Access.',
                'message' => 'Access denied. Invalid or expired Bearer Token: ' . $e->getMessage()
            ]);
            return $response;            
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
