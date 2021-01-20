<?php

$stripeNatPK = 'pk_test_ourS2tdhFgELjHFlycJfiyNu00ulrF5GOb';
$stripeNatSK = 'sk_test_rB0ZqLNR9gfoCqUyGTrMMQPZ00zJoyxsEX';

$stripeSmaTestSK = 'sk_test_dhwJKitkTyxpplssM4ESHdHn00jp46mkRu';
$stripeSmaTestPK = 'pk_test_Sxw7yPpo3AHGUpZAb90bobZx';

if ($_SERVER['SERVER_ADDR'] === '127.0.0.1') {
    $stripePK = $stripeNatPK;
    $stripeSK = $stripeNatSK;
} else {
    $stripePK = $stripeSmaTestPK;
    $stripeSK = $stripeSmaTestSK;
}

return [
    'adminEmail' => 'support@socialmediaaudit.io',
    'leadFromEmail' => 'support@socialmediaaudit.io',
    'leadFromName' => 'Social Media Audit',
    'fromEmail' => 'support@socialmediaaudit.io',
    'fromName' => 'Social Media Audit',
    'auditResultFrom' => 'Social Audit Server',
    'auditResultEmailFrom' => 'noreply@socialauditserver.com',
    'scoreGrades' => [
        0  => 'F-',
        5  => 'F',
        10 => 'E-',
        15 => 'E',
        20 => 'E+',
        25 => 'D-',
        30 => 'D',
        40 => 'D+',
        45 => 'C-',
        50 => 'C',
        55 => 'C+',
        62 => 'B-',
        70 => 'B',
        75 => 'B+',
        80 => 'A-',
        85 => 'A',
        90 => 'A+',
    ],
    'social' => [
        //new fb 106369589432600|-dEvPYJeZpZ4Q03pCTv922417X4
        //old fb 106369589432600|-dEvPYJeZpZ4Q03pCTv922417X4
        'facebook_api_access_token' => '106369589432600|-dEvPYJeZpZ4Q03pCTv922417X4',
        'twitterPosts' => 200,
        'twitter_api_bearer_token' => 'AAAAAAAAAAAAAAAAAAAAAHllvAAAAAAADyosFSkR7lcpksddivICUo6kJSo%3DWjkfn6DC8WJPzkXMaVKADGU2CWqpKjauvN9kPWt2uEcfonw12h',
        'google_api_key' => 'AIzaSyBBSjXJJCfB3YhUfKF-EGlL2iSRYhEvUxI',
        'google_plus_api_key' => 'AIzaSyBc1wascOD3eInWXDetUhapyRuBgYcPNRc',
        'youtube_api_key' => 'AIzaSyA6fnfZP7XYFi7vU6k2rPSC7XxB9jJW-R4',
        'youtubeVideos' => 50,
    ],
    'moz' => [
        array(
            'server_url' 	=> 'http://104.236.163.104',
            'mozApiKey' 	=> 'mozscape-50d4e28fa8',
            'mozApiSecret' 	=> '498c6b49029ed0eaf26739698e7e7239'
        ),
        array(
            'server_url' 	=> 'http://107.170.194.130',
            'mozApiKey' 	=> 'mozscape-10752e4c6b',
            'mozApiSecret' 	=> 'a6f02e22cdf2912e2096e68a77697cf9'
        ),
        array(
            'server_url' 	=> 'http://138.197.209.87',
            'mozApiKey' 	=> 'mozscape-b03e37270b',
            'mozApiSecret' 	=> 'a5f978cd67f7925fd37ce75942226cfa'
        ),
        array(
            'server_url' 	=> 'http://138.68.224.151',
            'mozApiKey' 	=> 'mozscape-ca14e5377',
            'mozApiSecret' 	=> '5810aaa7d9c56d75989551e54f7b40d9'
        ),
        //
        array(
            'server_url' 	=> 'http://104.236.190.32',
            'mozApiKey' 	=> 'mozscape-bdfa6e111b',
            'mozApiSecret' 	=> '4ec8e1b8e11ab775fc7e8e9aefe1459e'
        ),
        array(
            'server_url' 	=> 'http://104.236.189.139',
            'mozApiKey' 	=> 'mozscape-2c7f538b48',
            'mozApiSecret' 	=> '901dc920908335fd069baa4433d85196'
        ),
        array(
            'server_url' 	=> 'http://104.236.189.139',
            'mozApiKey' 	=> 'mozscape-6ff4d8680f',
            'mozApiSecret' 	=> 'b2ec8077b7f5cec87da9ca55a4551428'
        ),

    ],
    'mozKey'		    => '184c8a634bd0d4223d75794ae188e',
    'mozRequestLimit'   => 20000,
    'chromeAPI'		    => 'http://138.68.13.96/metrics.php',

    // client Id: 2da9602359aedaf5bf150997be820c28
    // 'SMA Test' ListId: 2c434c9ad722d9fd7d1f7121ee6daa71
    // 'Edit SEOptimer Intentional Opt In at Signup' ListId: e6bc30f1a9e58f15b9bdc6bf0e3d9271
    //
    'campaign_monitor'   => [
        'list_id'        => '2c434c9ad722d9fd7d1f7121ee6daa71',
        'api_key'        => 'e6bc30f1a9e58f15b9bdc6bf0e3d9271',
    ],

    'chromeHtml'		=> 'http://107.170.244.127/?secret=supersecretpassword&url=',
    //'chromeMetrics'		=> 'http://162.243.132.39/?secret=supersecretpassword&url=',
    'dataForSeoLogin'	=> 'adam@seoptimer.com',
    'dataForSeoPassword'=> 'Wol4ZquYFIUW7LTD',
    'dataForSeoUrl'=> 'https://api.dataforseo.com/',
    'auditDomain'=> 'socialmediaaudit.io',

    'wordpressApi' => [
        'url' => 'https://account.socialmediaaudit.io/?rest_route=/wc/',
        'ip' => '178.128.6.124',
        'key' => 'ck_11125327a3c95291167b12991f935f656935c0eb',
        'secret' => 'cs_88f67b30990d46e691b72f34a1a834749683fd7d',
    ],

    'stripe' => [
        'public_key' => $stripePK,
        'secret_key' => $stripeSK,
    ],

    'stubRegisterIp' =>[
        'usa' => [
            'idaho' => '129.101.191.124'
        ]
    ],
    'proxy' => [
        '131.108.17.238:80:mad:7scUGjdsfSnSKds',
        '104.160.4.166:80:mad:7scUGjdsfSnSKds',
        '107.150.67.239:80:mad:7scUGjdsfSnSKds',
        '103.221.235.44:80:mad:7scUGjdsfSnSKds',
        '107.150.67.64:80:mad:7scUGjdsfSnSKds',
    ]
];
