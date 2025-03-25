<?php

namespace App\Consts;


class ShoppingMallOrders
{
    const MIN_UNIT_QTY = 1;
    const DAY_30 = 30;
    const MIN_ORDER_COUNT = 1;

    const COL_SHOP_MALL_ID = 'shop_mall_id';    
    const COL_ORDERED_AT = 'ordered_at';
    const FORMAT_SHOP_MALL_ID_RAKUTEN = '%s_rakuten_%s';
    const FORMAT_SHOP_MALL_ID_YAHOO = '%s_yahoo_%s';
    const FORMAT_SHOP_MALL_ID_MAIN = '%s_main_%s';
    
    const ORDERED_AT_FROM_INDEX = 0;
    const ORDERED_AT_TO_INDEX = 1;

    const REGEX_ITEM_MODEL = '/-(2|S|AG|WL|WD|K|KOBETSU|COLOR|WOOD|AIRFLEX|RAKU|OSOUJI|SILENT|CANVAS|WHITE|CLEANER)$/';

    const ITEM_OPTIONS = [
        '2' => '',
        'S' => '',
        'AG' => '昇降パネル',
        'WL' => 'リモコン：ワイヤレス',
        'WD' => 'リモコン：ワイヤード',
        'K' => '個別運転',
        'KOBETSU' => '個別運転',
        'COLOR' => 'カラーパネル',
        'WOOD' => 'ウッドパネル',
        'AIRFLEX' => 'エアフレックスパネル',
        'RAKU' => 'ラクリーナパネル',
        'OSOUJI' => 'お掃除パネル',
        'SILENT' => 'サイレントパネル',
        'CANVAS' => 'キャンバスダクトパネル',
        'WHITE' => '',
        'CLEANER' => 'フラットパネル',
    ];
        
    
    const SEARCH_SHOP_MALL_ID = 'shop_mall_id';
    const SEARCH_ORDERED_AT = 'ordered_at';
    const SEARCH_NAME = 'search_name';
    const SEARCH_TEL = 'search_tel';
    const SEARCH_ADDRESS = 'search_address';
    const SEARCH_ELEMENTS = [
        self::SEARCH_NAME => [
            'name', 'name_kana', 'sender_name', 'sender_name_kana'
        ],
        self::SEARCH_TEL => [
            'tel', 'sender_tel'
        ],
        self::SEARCH_ADDRESS => [
            'sender_address', 'sender_address_kana'
        ],
    ];

    const PROGRESS_RAKUTEN = [
        '100' => '注文確認待ち',
        '200' => '楽天処理中',
        '300' => '発送待ち',
        '400' => '変更確定待ち',
        '500' => '発送済',
        '600' => '支払手続き中',
        '700' => '支払手続き済',
        '800' => 'キャンセル確定待ち',
        '900' => 'キャンセル確定',
    ];

    const PROGRESS_YAHOO = [
        '1' => '予約中',
        '2' => '処理中',
        '3' => '保留',
        '4' => 'キャンセル',
        '5' => '完了',
    ];

    const PROGRESS_SETSUBICOM = [
        '1' => '受付処理中',
        '2' => '在庫状況のご連絡',
        '3' => 'ご入金確認のご連絡',
        '4' => 'お届け日のご連絡',
        '5' => '予備',
        '6' => '打合せ済・未発注',
        '7' => 'キャンセル',
        '8' => '仮受注',
        '9' => 'FAX注文',
    ];

    const PROGRESS_AIRCON_SETSUBICOM = [
        '1' => '新規受付',
        '2' => '入金待ち',
        '3' => 'キャンセル',
        '4' => '取り寄せ中',
        '5' => '発送済み',
        '6' => '入金済み',
        '7' => '決済処理中',
    ];

    const PROGRESS_E_SETSUBIBIZ = [
        '1' => '受付処理中',
        '2' => '在庫状況のご連絡',
        '3' => 'ご入金確認のご連絡',
        '4' => 'お届け日のご連絡',
        '5' => '予備',
        '6' => '予備2',
        '7' => 'キャンセル',
        '8' => '仮受注',
    ];

    const PROGRESS_TOKYO_AIRCONNET = [
        '1' => '新規受付',
        '2' => '入金待ち',
        '3' => 'キャンセル',
        '4' => '取り寄せ中',
        '5' => '発送済み',
        '6' => '入金済み',
        '7' => '決済処理中',
        '8' => '仮受注',
    ];
}
