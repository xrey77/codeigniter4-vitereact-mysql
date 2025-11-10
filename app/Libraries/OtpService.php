<?php namespace App\Libraries;

use OTPHP\TOTP;
use OTPHP\Factory;


class OtpService
{
    /**
     * Generate a new secret key for a user.
     * @return string
     */
    public function generateSecret(): string
    {
        return TOTP::create()->getSecret();
    }

    /**
     * Get the provisioning URI (for QR code generation).
     *
     * @param string $username The user's name/email.
     * @param string $secret The user's secret key.
     * @param string $issuer The application name (e.g., "MyApp").
     * @return string
     */
    public function getProvisioningUri(string $username, string $secret, string $issuer): string
    {
        $otp = TOTP::create($secret);
        $otp->setLabel($username);
        $otp->setIssuer($issuer);

        // Most authenticator apps support 6 digits, 30 seconds, SHA1 by default.
        // You can configure these if needed, but the defaults are widely compatible.
        $otp->setDigits(6);
        $otp->setPeriod(30);

        return $otp->getProvisioningUri();
    }

    /**
     * Verify a time-based OTP code.
     *
     * @param string $otpCode The user-entered OTP code.
     * @param string $secret The user's stored secret key.
     * @return bool
     */
    public function verifyCode(string $otpCode, string $secret): bool
    {
        $otp = TOTP::create($secret);
        // The verify method also checks the "window" of past/future codes (default 1 period)
        return $otp->verify($otpCode);
    }    
}
