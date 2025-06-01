<?php

if (!function_exists('url')) {
    function url($path = '') {
        $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $base_url .= $_SERVER['HTTP_HOST'];
        $base_url .= BASE_PATH;
        $base_url = rtrim($base_url, '/');
        $path = ltrim($path, '/');
        return $path ? "{$base_url}/{$path}" : $base_url;
    }
}

if (!function_exists('asset')) {
    function asset($path) {
        return url($path);
    }
}

if (!function_exists('config')) {
    function config($key, $default = null) {
        $config = [
            'app.name' => 'Schoolar'
        ];
        
        return array_get($config, $key, $default);
    }
}

if (!function_exists('array_get')) {
    function array_get($array, $key, $default = null) {
        if (is_null($key)) {
            return $array;
        }
        
        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }
            $array = $array[$segment];
        }
        
        return $array;
    }
}

if (!function_exists('guest')) {
    function guest() {
        return !isset($_COOKIE['auth_token']);
    }
}

if (!function_exists('auth')) {
    function auth() {
        static $user = null;
        
        if ($user !== null) {
            return $user;
        }
        
        if (!isset($_COOKIE['auth_token'])) {
            return null;
        }
        
        try {
            $user = JWT::decode($_COOKIE['auth_token'], getenv('JWT_SECRET'), array('HS256'));
            return $user;
        } catch (Exception $e) {
            return null;
        }
    }
} 