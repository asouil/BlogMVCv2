<?php

namespace Core\Controller;

class FlashController
{
    private $sessionKey = "flash";

    private $message;

    public function __construct() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function success(string $message)
    {
        $flash = $this->sessionGet($this->sessionKey);
        $flash['success'][] = $message;
        $this->sessionSet($this->sessionKey, $flash);
    }

    public function error(string $message): void
    {
        $flash = $this->sessionGet($this->sessionKey);
        $flash['error'][] = $message;
        $this->sessionSet($this->sessionKey, $flash);        
    }

    public function get(string $type)
    {
        if(is_null($this->message)) {
            $this->message = $this->sessionGet($this->sessionKey, []);
            $this->sessionDelete($this->sessionKey);
        }
        if(array_key_exists($type, $this->message)) {
            return $this->message[$type];
        }
    }

    public function sessionGet(string $key, $default=[]): ?array
    {
        if(array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    public function sessionSet(string $key, $value) :void 
    {
        $_SESSION[$key] = $value;
    }

    public function sessionDelete(string $key) :void
    {
        unset($_SESSION[$key]);
    }

}