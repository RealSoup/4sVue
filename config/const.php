<?php
return [
    'file' => [
        'def_wid' => 1920,
        'def_hei' => 1080,
        'thumb_wid' => 350,
        'thumb_hei' => 240,
    ],


    'user_div' => [
        'user'      => ['min'=> 0,'max'=> 9 ],
        'dealer'    => ['min'=>10,'max'=>19 ],
        'admin'     => ['min'=>20,'max'=>29 ],
    ],
    'cookie_nm' => [
        'guest_id' => 'guestId',
        'cart_size' => 'cartSize',
    ],
    'tbl_alias' => [
        'quote_req' => 'quoteReq',
        'quote_reply' => 'quoteReply',
    ],
    'inicis' => [
        'signKey' => "RGtOL1hyQW5PT0U4L3l1aTlaN2IrUT09",
        'apiKey' => "CpTE9SIlh9HMbPII",
        'apiiv' => "nlR9f2bz5XafPy==",
        'cardComNm' => ['11' => 'BC카드',                  '12' => '삼성카드',
                        '14' => '신한카드',                '15' => '한미카드',
                        '16' => 'NH카드',                  '17' => '하나 SK카드',
                        '21' => '글로벌 VISA',               '22' => '글로벌 MASTER',
                        '23' => '글로벌 JCB',                '24' => '글로벌 아멕스',
                        '25' => '글로벌 다이너스',            '93' => '토스머니(포인트 100% 사용)',
                        '94' => 'SSG머니(포인트 100% 사용)',  '96' => '엘포인트(포인트 100% 사용)',
                        '97' => '카카오머니',                 '98' => '페이코(포인트 100% 사용)',
                        '01' => '외환카드',                  '03' => '롯데카드',
                        '04' => '현대카드',                  '06' => '국민카드']
    ],
    'pay_method' => [
        'C' => "카드결제",
        'K' => "국민은행",
        'W' => "우리은행"
    ],
    'dlvy' => [
        'dlvyComCode' => "3003997",
        'siteCode' => "4SCIENCE"
    ]

];
