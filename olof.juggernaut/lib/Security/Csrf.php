<?php

namespace Jugger\Security;

use Bitrix\Main\Context;
use Jugger\Context\Session;

/**
 * Класс для работы с защитой от CSRF атак.
 */
class Csrf
{
    /**
     * Ключ сессии для возможности использовать несколько токенов в одном запросе.
     * Для каждого токена должен быть уникальный ключ сессии
     * @var string
     */
    public static $sessionKey = "csrfSessionKey";
    /**
     * Секретное слово
     * @var string
     */
    public static $secret = "csrfsecretword";
    /**
     * Соль
     * @var string
     */
    public static $salt = "fgjnu24e4t7f97^G&R#";
    /**
     * Создает токен и выводит поле с ним
     */
    public static function printInput() {
        $token = self::createToken();
        echo "<input type='hidden' name='csrf' value='{$token}'>";
    }
    /**
     * Создает токен
     * @return string
     */
    public static function createToken() {
        $token = md5( self::$secret . microtime() );
        $token = md5( self::$salt . $token );
        Session::getInstance()->set(self::$sessionKey, $token);
        Session::getInstance()->commit();
        return $token;
    }
    /**
     * Проверка токена
     * @param string $token токен для проверки
     * @return boolean TRUE - если токен валидный
     */
    public static function validateToken($token) {
        $trueToken = Session::getInstance()->get(self::$sessionKey);
        self::removeToken();
        if (trim($trueToken) !== "" && $token === $trueToken) {
            return true;
        }
        return false;
    }
    /**
     * Удаление токена из сессии
     */
    public static function removeToken() {
        Session::getInstance()->delete(self::$secret);
        Session::getInstance()->commit();
    }
    /**
     * Проверка токена напрямую из запроса
     * @return boolean TRUE - если токен валидный
     */
    public static function validateTokenByPost() {
        $token = Context::getCurrent()->getRequest()->getPost("csrf");
        if ($token) {
            return self::validateToken($token);
        }
        self::removeToken();
        return false;
    }
}