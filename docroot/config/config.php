<?php
//$sv = $_SERVER['SERVER_NAME'];
$sv = 'setsu-bi.local';
switch ($sv) {
    case 'setsu-bi.local':
    case 'services-b-aircon.local':
        define('ENV', 'local');
        break;
    case 'www.a-aircon.jp':
    case 'a-aircon.jp':
    case 'services.b-aircon.jp':
        define('ENV', 'prd');
        break;
    default:
        define('ENV', 'local');
        break;
}

define('TOKEN_URL', 'https://auth.login.yahoo.co.jp/yconnect/v2/token');
define('LIMIT_DAY', 100);
define('KEY_FILENAME', 'public.key');

$config = [
    'local' => [
        'e-setsubi' => [
            'url' => 'http://setsu-bi.local',
            'callback_url' => 'http://setsu-bi.local/filesystem/getAPI/e-setsubi/yv2/code1v2.php',
			'callback_url_encode' => urlencode('http://setsu-bi.local/filesystem/getAPI/e-setsubi/yv2/code1v2.php'),
            'cert_ver' => 1,
        ],
        'setsu-bi' => [
            'url' => 'http://setsu-bi.local',
		    'callback_url' => 'http://setsu-bi.local/filesystem/getAPI/setsu-bi/yv2/code1v2.php',
			'callback_url_encode' => urlencode('http://setsu-bi.local/filesystem/getAPI/setsu-bi/yv2/code1v2.php'),
            'cert_ver' => 3,
        ],
        'tokyo-aircon' => [
            'url' => 'http://setsu-bi.local',
		    'callback_url' => 'http://setsu-bi.local/filesystem/getAPI/tokyo-aircon/yv2/code1v2.php',
			'callback_url_encode' => urlencode('http://setsu-bi.local/filesystem/getAPI/tokyo-aircon/yv2/code1v2.php'),
            'cert_ver' => 1,
        ]
    ],
    'prd' => [
        'e-setsubi' => [
            'url' => 'https://www.a-aircon.jp/',
		    'callback_url' => 'https://www.a-aircon.jp/filesystem/getAPI/e-setsubi/yv2/code1v2.php',
			'callback_url_encode' => urlencode('https://www.a-aircon.jp/filesystem/getAPI/e-setsubi/yv2/code1v2.php'),
            'cert_ver' => 1,
        ],
        'setsu-bi' => [
            'url' => 'https://www.a-aircon.jp',
		    'callback_url' => 'https://www.a-aircon.jp/filesystem/getAPI/setsu-bi/yv2/code1v2.php',
			'callback_url_encode' => urlencode('https://www.a-aircon.jp/filesystem/getAPI/setsu-bi/yv2/code1v2.php'),
            'cert_ver' => 3,
        ],
        'tokyo-aircon' => [
            'url' => 'https://www.a-aircon.jp/',
		    'callback_url' => 'https://www.a-aircon.jp/filesystem/getAPI/tokyo-aircon/yv2/code1v2.php',
			'callback_url_encode' => urlencode('https://www.a-aircon.jp/filesystem/getAPI/tokyo-aircon/yv2/code1v2.php'),
            'cert_ver' => 1,
        ]
    ]
];
