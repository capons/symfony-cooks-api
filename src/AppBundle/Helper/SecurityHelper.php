<?php
/**
 * Created by PhpStorm.
 * User: Volk
 * Date: 19.08.2016
 * Time: 18:01
 */
namespace AppBundle\Helper;
class SecurityHelper {
    const TOKEN_LENGTH = 24;
    const SERVER_SALT = 'fe34dg4e0b31d6sdf5ece9c7a46e04yyq';
    public static function salt(){
        return uniqid(mt_rand(), true);
    }

    public static function token(){
        try {
            $token = bin2hex(random_bytes(self::TOKEN_LENGTH));
        } catch (\Exception $e) {
            $strong = FALSE;
            $token = bin2hex(openssl_random_pseudo_bytes(self::TOKEN_LENGTH, $strong));
        }
        return $token;
    }

    public static function generateHash($password,$salt){
        return hash('sha512',hash('sha384',hash('sha256', $password).$salt).self::SERVER_SALT);
    }

    public static function checkPassword($password,$salt,$hash){
        return self::generateHash($password,$salt) === $hash;
    }


}