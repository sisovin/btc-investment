<?php

namespace App\Core;

use Exception;

class JWT
{
    private static $secret;
    private static $algorithm = 'HS256';

    /**
     * Initialize JWT with secret key
     */
    public static function init($secret = null)
    {
        self::$secret = $secret ?: getenv('JWT_SECRET') ?: 'your-secret-key-change-this-in-production';
    }

    /**
     * Generate JWT token
     */
    public static function encode(array $payload, $expiration = null)
    {
        if (!self::$secret) {
            self::init();
        }

        // Add standard claims
        $header = [
            'alg' => self::$algorithm,
            'typ' => 'JWT'
        ];

        $payload = array_merge($payload, [
            'iat' => time(),
            'exp' => $expiration ?: time() + (24 * 60 * 60) // 24 hours default
        ]);

        // Encode header
        $headerEncoded = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($header)));

        // Encode payload
        $payloadEncoded = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(json_encode($payload)));

        // Create signature
        $signature = hash_hmac('sha256', $headerEncoded . "." . $payloadEncoded, self::$secret, true);
        $signatureEncoded = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        return $headerEncoded . "." . $payloadEncoded . "." . $signatureEncoded;
    }

    /**
     * Decode and verify JWT token
     */
    public static function decode($token)
    {
        if (!self::$secret) {
            self::init();
        }

        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            throw new Exception('Invalid token format');
        }

        $header = $parts[0];
        $payload = $parts[1];
        $signature = $parts[2];

        // Verify signature
        $expectedSignature = hash_hmac('sha256', $header . "." . $payload, self::$secret, true);
        $expectedSignatureEncoded = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($expectedSignature));

        if (!hash_equals($signature, $expectedSignatureEncoded)) {
            throw new Exception('Invalid token signature');
        }

        // Decode payload
        $payloadDecoded = json_decode(base64_decode(str_replace(['-', '_'], ['+', '/'], $payload)), true);

        if (!$payloadDecoded) {
            throw new Exception('Invalid token payload');
        }

        // Check expiration
        if (isset($payloadDecoded['exp']) && $payloadDecoded['exp'] < time()) {
            throw new Exception('Token has expired');
        }

        return $payloadDecoded;
    }

    /**
     * Generate access token for user
     */
    public static function generateAccessToken($userId, $email, $expiration = null)
    {
        $payload = [
            'sub' => $userId,
            'email' => $email,
            'type' => 'access',
            'iat' => time(),
            'exp' => $expiration ?: time() + (24 * 60 * 60) // 24 hours
        ];

        return self::encode($payload);
    }

    /**
     * Generate refresh token for user
     */
    public static function generateRefreshToken($userId, $expiration = null)
    {
        $payload = [
            'sub' => $userId,
            'type' => 'refresh',
            'iat' => time(),
            'exp' => $expiration ?: time() + (30 * 24 * 60 * 60) // 30 days
        ];

        return self::encode($payload);
    }

    /**
     * Validate token and return payload
     */
    public static function validateToken($token)
    {
        try {
            return self::decode($token);
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get user ID from token
     */
    public static function getUserIdFromToken($token)
    {
        $payload = self::validateToken($token);
        return $payload ? ($payload['sub'] ?? null) : null;
    }

    /**
     * Check if token is expired
     */
    public static function isTokenExpired($token)
    {
        try {
            $payload = self::decode($token);
            return false;
        } catch (Exception $e) {
            return $e->getMessage() === 'Token has expired';
        }
    }

    /**
     * Refresh access token using refresh token
     */
    public static function refreshAccessToken($refreshToken)
    {
        $payload = self::validateToken($refreshToken);

        if (!$payload || ($payload['type'] ?? null) !== 'refresh') {
            throw new Exception('Invalid refresh token');
        }

        $userId = $payload['sub'];
        $user = \App\Models\User::find($userId);

        if (!$user) {
            throw new Exception('User not found');
        }

        return self::generateAccessToken($userId, $user->email);
    }

    /**
     * Generate password reset token
     */
    public static function generatePasswordResetToken($userId, $expiration = null)
    {
        $payload = [
            'sub' => $userId,
            'type' => 'password_reset',
            'iat' => time(),
            'exp' => $expiration ?: time() + (60 * 60) // 1 hour
        ];

        return self::encode($payload);
    }

    /**
     * Generate email verification token
     */
    public static function generateEmailVerificationToken($userId, $email, $expiration = null)
    {
        $payload = [
            'sub' => $userId,
            'email' => $email,
            'type' => 'email_verification',
            'iat' => time(),
            'exp' => $expiration ?: time() + (24 * 60 * 60) // 24 hours
        ];

        return self::encode($payload);
    }

    /**
     * Get token expiration time
     */
    public static function getTokenExpiration($token)
    {
        $payload = self::validateToken($token);
        return $payload ? ($payload['exp'] ?? null) : null;
    }

    /**
     * Get token type
     */
    public static function getTokenType($token)
    {
        $payload = self::validateToken($token);
        return $payload ? ($payload['type'] ?? null) : null;
    }
}