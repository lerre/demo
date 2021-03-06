<?php

namespace App\Providers;

use App\Model\User;
use App\Service\UserService;

class AuthProvider
{
    /**
     * @param array $userInfo
     * @return array
     */
    public static function checkLogin(array &$userInfo)
    {
        $hashPassword = User::getInstance()->getPasswordByName($userInfo['username']);

        if ($hashPassword === false) {
            return [
                'result' => false,
                'errors' => [
                    'User does not exist!',
                ]
            ];
        }

        $password = $userInfo['password'] . $_ENV['PASSWORD_SALT'];
        if (!password_verify($password, $hashPassword)) {
            return [
                'result' => false,
                'errors' => [
                    'Password is not correct!',
                ]
            ];
        }

        return [
            'result' => true,
        ];
    }

    public static function checkRegister(string $username)
    {
        if (UserService::getInstance()->checkUserExist($username)) {
            return [
                'result' => false,
                'errors' => [
                    'User is exist!',
                ]
            ];
        }

        return [
            'result' => true
        ];
    }
}