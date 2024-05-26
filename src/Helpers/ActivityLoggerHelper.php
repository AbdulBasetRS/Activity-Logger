<?php

namespace Abdulbaset\ActivityLogger\Helpers;

if (!function_exists('getBrowserVersion')) {
    function getBrowserVersion($user_agent) {
        $pattern = '/(?P<browser>Edge|Firefox|Chrome|Safari|Opera|MSIE|Trident).*?((?P<version>\d+[\w\.]*).*)?$/i';
        if (preg_match($pattern, $user_agent, $matches)) {
            return isset($matches['version']) ? $matches['version'] : null;
        }
        return null;
    }
}

if (!function_exists('getDeviceType')) {
    function getDeviceType($userAgent) {
        $device_types = array(
            '/tablet|ipad|playbook|silk/i'          => 'Tablet',
            '/mobile|android|phone|iphone|ipod|blackberry|iemobile|opera mini/i' => 'Mobile',
            '/tv|smart-tv|googletv|appletv|hbbtv|netcast.tv|viera|aquos|bravia|playstation|xbox|roku/i' => 'Smart TV',
            '/game|nintendo|wii|xbox/i'             => 'Game Console',
            '/bot|crawl|spider|slurp|google|baidu|bing|msn|duckduckgo|teoma|cumulus|travis|feedburner|rss/i' => 'Bot/Crawler',
            '/.*/i'                                 => 'Desktop'
        );
    
        foreach ($device_types as $regex => $device_type) {
            if (preg_match($regex, $userAgent)) {
                return $device_type;
            }
        }
    
        return 'Unknown';
    }
}

if (!function_exists('getOperatingSystem')) {
    function getOperatingSystem($user_agent)
    {
        $os_array = array(
            '/windows nt 10.0/i'    => 'Windows 10',
            '/windows nt 6.3/i'     => 'Windows 8.1',
            '/windows nt 6.2/i'     => 'Windows 8',
            '/windows nt 6.1/i'     => 'Windows 7',
            '/windows nt 6.0/i'     => 'Windows Vista',
            '/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     => 'Windows XP',
            '/windows xp/i'         => 'Windows XP',
            '/windows nt 5.0/i'     => 'Windows 2000',
            '/windows me/i'         => 'Windows ME',
            '/win98/i'              => 'Windows 98',
            '/win95/i'              => 'Windows 95',
            '/win16/i'              => 'Windows 3.11',
            '/windows server 2019/i' => 'Windows Server 2019',
            '/windows server 2016/i' => 'Windows Server 2016',
            '/windows server 2012 r2/i' => 'Windows Server 2012 R2',
            '/windows server 2012/i' => 'Windows Server 2012',
            '/windows server 2008 r2/i' => 'Windows Server 2008 R2',
            '/windows server 2008/i' => 'Windows Server 2008',
            '/windows server 2003/i' => 'Windows Server 2003',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i'        => 'Mac OS 9',
            '/linux/i'              => 'Linux',
            '/ubuntu/i'             => 'Ubuntu',
            '/debian/i'             => 'Debian',
            '/fedora/i'             => 'Fedora',
            '/red hat|redhat/i'     => 'Red Hat',
            '/centos/i'             => 'CentOS',
            '/mandriva/i'           => 'Mandriva',
            '/mageia/i'             => 'Mageia',
            '/gentoo/i'             => 'Gentoo',
            '/slackware/i'          => 'Slackware',
            '/suse/i'               => 'SUSE',
            '/openSUSE/i'           => 'openSUSE',
            '/iphone/i'             => 'iPhone OS',
            '/ipod/i'               => 'iPod OS',
            '/ipad/i'               => 'iPad OS',
            '/android/i'            => 'Android',
            '/blackberry/i'         => 'BlackBerry',
            '/webos/i'              => 'WebOS',
            '/symbian/i'            => 'Symbian',
            '/bada/i'               => 'Bada',
            '/tizen/i'              => 'Tizen',
            '/sailfish/i'           => 'Sailfish OS',
            '/kindle/i'             => 'Kindle OS',
            '/playbook/i'           => 'BlackBerry Tablet OS',
            '/nokia/i'              => 'Nokia OS',
            '/series60/i'           => 'Symbian Series 60',
            '/series40/i'           => 'Symbian Series 40',
            '/rim tablet os/i'      => 'BlackBerry Tablet OS',
            '/meego/i'              => 'MeeGo',
            '/palm/i'               => 'Palm OS',
            '/hpwos/i'              => 'HP WebOS',
            '/x11/i'                => 'Unix',
            '/minix/i'              => 'Minix',
            '/beos/i'               => 'BeOS',
            '/os\/2/i'              => 'OS/2',
            '/chromeos/i'           => 'ChromeOS',
            '/cros/i'               => 'ChromeOS',
            '/nintendo wii/i'       => 'Nintendo Wii',
            '/playstation/i'        => 'PlayStation',
            '/xbox/i'               => 'Xbox',
            '/mobile/i'             => 'Mobile Device'
        );
    
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                return $value;
            }
        }
    
        return 'Unknown';
    }
}

if (!function_exists('getBrowser')) {
    function getBrowser($user_agent) {
        $browsers = array(
            '/rv:11/i'                      => 'Internet Explorer 11',
            '/msie/i'                       => 'Internet Explorer',
            '/edg/i'                        => 'Edge',
            '/chrome/i'                     => 'Chrome',
            '/firefox/i'                    => 'Firefox',
            '/safari/i'                     => 'Safari',
            '/opera/i'                      => 'Opera',
            '/googlebot/i'                  => 'Googlebot',
            '/bingbot/i'                    => 'Bingbot',
            '/facebookexternalhit/i'        => 'Facebook',
            '/twitterbot/i'                 => 'Twitter Bot',
            '/baiduspider/i'                => 'Baiduspider',
            '/yandexbot/i'                  => 'Yandex Bot',
            '/duckduckbot/i'                => 'DuckDuckGo Bot',
            '/ia_archiver/i'                => 'Alexa Crawler',
            '/.*/i'                         => 'Unknown'
        );
    
        foreach ($browsers as $regex => $browser) {
            if (preg_match($regex, $user_agent)) {
                return $browser;
            }
        }
    
        return 'Unknown';
    }
}