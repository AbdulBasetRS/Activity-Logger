<?php

namespace Abdulbaset\ActivityLogger\Helpers;

if (!function_exists('getBrowserVersion')) {
    function getBrowserVersion($userAgent)
    {
        if (preg_match('/(firefox|msie|trident|chrome|safari|opr|edg|opera)[\/\s](\d+)/i', $userAgent, $matches)) {
            $browser = $matches[1];
            $version = $matches[2];

            // Normalize browser names
            switch (strtolower($browser)) {
                case 'msie':
                case 'trident':
                    return 'Internet Explorer ' . $version;
                case 'edg':
                    return 'Edge ' . $version;
                case 'opr':
                    return 'Opera ' . $version;
                case 'chrome':
                    return 'Chrome ' . $version;
                case 'firefox':
                    return 'Firefox ' . $version;
                case 'safari':
                    return 'Safari ' . $version;
                default:
                    return $browser . ' ' . $version;
            }
        }
        return 'Unknown';
    }
}

if (!function_exists('getDeviceType')) {
    function getDeviceType()
    {
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

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
    function getOperatingSystem()
    {
        $userAgent = strtolower($_SERVER['HTTP_USER_AGENT']);

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
