<?php

// app/Helpers/jwt_helper.php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

function validateJWT($token)
{
    $secretKey = JWT_SECRET; // Use the secret key defined earlier

    try {
        // Decode the JWT
        $decoded = JWT::decode($token, new Key($secretKey, 'HS256'));
        
        // You can add further validation here, e.g., issuer (iss), audience (aud) claims
        // if ($decoded->iss !== 'your_issuer') { ... }

        return (array) $decoded; // Token is valid, return the payload
    } catch (ExpiredException $e) {
        // Token has expired
        return false; // Or throw a specific exception
    } catch (SignatureInvalidException $e) {
        // Token signature is invalid
        return false;
    } catch (\Exception $e) {
        // Other validation errors (e.g., malformed token)
        return false;
    }
}
