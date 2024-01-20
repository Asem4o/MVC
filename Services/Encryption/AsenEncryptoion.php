<?php

namespace ServServices\Encryption;


use Services\Encryption\EncryptionServiceInterface;

class AsenEncryptoion implements EncryptionServiceInterface
{
    public function hash(string $password): string
    {
        $newPassword = '';
        for ($i = 0; $i < mb_strlen($password); $i++) {
            $newPassword .= chr(ord($password[$i]) + 2);
        }

        return $newPassword;
    }

    public function verify(string $password, string $hash): bool
    {
        for ($i = 0; $i < mb_strlen($hash); $i++) {
            if ($password[$i] != chr(ord($hash[$i]) - 2)) {
                return false;
            }
        }

        return true;
    }
}