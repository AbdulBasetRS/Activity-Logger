<?php

namespace Abdulbaset\ActivityLogger\Helpers;

if (!function_exists('getBrowserVersion')) {
    function getBrowserVersion($user_agent) {
        $pattern = '/(?P<browser>Firefox|Chrome|Safari|Opera|MSIE|Trident[^;]+).*?((?P<version>\d+[\w\.]*).*)?$/i';
        if (preg_match($pattern, $user_agent, $matches)) {
            return isset($matches['version']) ? $matches['version'] : null;
        }
        return null;
    }
}

if (!function_exists('getDeviceType')) {
    function getDeviceType($userAgent)
    {
        if (preg_match('/tablet|ipad|playbook|silk/i', $userAgent)) {
            return 'Tablet';
        } elseif (preg_match('/mobile|android|phone|iphone|ipod|blackberry|iemobile|opera mini/i', $userAgent)) {
            return 'Mobile';
        } else {
            return 'Desktop';
        }
    }
}

if (!function_exists('getOperatingSystem')) {
    function getOperatingSystem($userAgent)
    {
        if (preg_match('/windows nt 10/i', $userAgent)) {
            return 'Windows 10';
        } elseif (preg_match('/windows nt 6.3/i', $userAgent)) {
            return 'Windows 8.1';
        } elseif (preg_match('/windows nt 6.2/i', $userAgent)) {
            return 'Windows 8';
        } elseif (preg_match('/windows nt 6.1/i', $userAgent)) {
            return 'Windows 7';
        } elseif (preg_match('/windows nt 6.0/i', $userAgent)) {
            return 'Windows Vista';
        } elseif (preg_match('/windows nt 5.1/i', $userAgent)) {
            return 'Windows XP';
        } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
            return 'Mac OS X';
        } elseif (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        } elseif (preg_match('/iphone|ipad|ipod/i', $userAgent)) {
            return 'iOS';
        } elseif (preg_match('/android/i', $userAgent)) {
            return 'Android';
        } else {
            return 'Unknown';
        }
    }
}

if (!function_exists('getBrowser')) {
    function getBrowser($user_agent) {
        if (preg_match('/msie|trident/i', $user_agent) && !preg_match('/opera/i', $user_agent)) {
            return 'Internet Explorer';
        } elseif (preg_match('/edg/i', $user_agent)) {
            return 'Microsoft Edge';
        } elseif (preg_match('/firefox/i', $user_agent)) {
            return 'Firefox';
        } elseif (preg_match('/chrome/i', $user_agent)) {
            return 'Chrome';
        } elseif (preg_match('/safari/i', $user_agent)) {
            return 'Safari';
        } elseif (preg_match('/opera/i', $user_agent)) {
            return 'Opera';
        }
        return null;
    }
}
