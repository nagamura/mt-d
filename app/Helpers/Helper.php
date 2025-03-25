<?php

namespace App\Helpers;

use App\Consts\Stock;
use App\Consts\ShoppingMallOrders;

class Helper
{
    const MALLS = [
        'setsubi' => 'bg-red-100',
        'e-setsubi' => 'bg-yellow-100',
        'tokyo-aircon' => 'bg-blue-100',
    ];

    const SHOP_NAMES = [
        's' => 'セツビコム',
        'e' => 'イーセツビ',
        'k' => '空調センター',
    ];

    const REPLACE_OPTION1_TEXT = [
        "時間指定希望の場合は有料での対応です。（メーカーによる）:",
        "事前、当日の問合番号・時間確認の対応は出来かねます。:",
        "4トントラックでの配送、荷台上での商品お引き渡しです。:",
        "配達時ご不在の場合は持ち戻り・再配達料をご請求します。:",
        "不在時の置き配は対応できかねます。:",
        "時間指定、AM・PM指定不可、再配達は有料となります。:",
        "直送便の為、問合番号・時間確認の対応は出来かねます。:",
        "配送は車上渡しです。荷下ろしの人員手配お願いします。:",
        "常時お受取り可能な配送先と繋がる番号をご登録ください。:",
        "パネルカラーをお選びください:",
        "パネル色をお選びください:",
        "パネル色をお選び下さい:",
        "パネルをお選びください:",
        "パネルをお選び下さい:",
        "パネル：",
        "システムマルチの商品です",
        "（室外機は別売り）:",
	    "部材のみでは販売不可です。本体機器はご注文済みですか？:",
	    "部材のみのご注文不可。本体機器はご注文済みでしょうか？:",
	    "室外機は別売りです:",
	    "部材のみの販売不可。本体機器はご注文済みでしょうか？:",
	    "室外機は別売りの商品です:",
	    "時間指定は有料です（メーカーによる）:",
	    "事前・当日の問合せ番号・時間確認はできかねます。:",
	    "4トントラックでの配送、荷台上での商品お引き渡しです。:",
	    "配達時ご不在の場合は再配達料をご請求します。:",
	    "不在時の置き配はできかねます。:",
	    "時間指定は追加料金を頂戴します（メーカーによる）:",
	    "事前・当日の問合せ番号・時間の確認はできかねます。:",
	    "4トントラックでの配送、荷台上での商品お引き渡しです。:",
	    "配達時ご不在の際は再配達料を頂戴します。:",
	    "ご不在時の置き配対応はいたしかねます。:",
        "時間指定は不要です（終日対応）",
        "有料時間指定可否を確認する",
        "有料時間指定可否を確認希望する",
        "問合番号・時間確認不可を了承した",
        "荷下ろし必要の旨了承した",
        "不在時は費用発生の旨了承する",
        "不在置き不可の旨了承した",
        "セツビコムで本体機器購入済み。",
	    "室内機のみ注文する",
	    "イーセツビで本体機器購入済",
	    "室内機のみ注文する",
	    "空調センターで本体機器購入済み",
	    "室内機のみ注文する",
	    "時間指定は不要（終日対応）",
	    "問合せ番号・時間確認不可の旨、了承した",
	    "荷台上で受取の旨、了承した",
	    "追加費用発生の旨、了承した",
	    "置き配不可の旨、了承した",
	    "時間指定しない（終日対応）",
	    "配達時間等確認不可の旨、了承した",
	    "荷下ろし作業必要な旨、了承した",
	    "別途費用発生の旨、了承した",
	    "置き配不可の旨、了承した",
        "了承した",
        "",
        "。。。。",
        "。。。",
        "。。",
        "。",
        "\n",
        "レビューを書いてプレゼント（クオカード）をもらう",
		"レビューを書かない",
		"レビューを書く",
		"レビューを投稿してQUOカードを獲得",
		"レビューを投稿しない",
		"レビューを投稿する",
		"レビューを記入してQUOカードをもらう",
		"レビューを記入しない",
		"レビューを記入する（QUOカードをもらう）"
    ];

    public static function getShopName($shopName)
    {
        return self::SHOP_NAMES[$shopName];
    }
    
    public static function getBgColorFromMallId($mallId)
    {
        return self::MALLS[$mallId];
    }

    public static function splitZip($zip) {
        return substr($zip, 0, 3) . '-' . substr($zip, -4);
    }

    public static function normalizeOption1Text($option1)
    {
        if (!is_null($option1)) {
            return str_replace(self::REPLACE_OPTION1_TEXT, '', $option1);
        }
        return $option1;
    }

    public static function normalizeItemModel($itemModel)
    {
        if ($itemModel !== '') {
            $itemModel = mb_strtoupper($itemModel);
            $itemModel = preg_replace(ShoppingMallOrders::REGEX_ITEM_MODEL, '', $itemModel);
            return $itemModel;
        }
        return $itemModel;
    }

    public static function getOptionText($itemModel, $option)
    {
        $texts = [];
        if (preg_match(ShoppingMallOrders::REGEX_ITEM_MODEL, $itemModel, $match)) {
            if (!empty($match)) {
                $texts[] = ShoppingMallOrders::ITEM_OPTIONS[$match[1]];
            }
        }
        $texts[] = $option;
        return implode('', $texts);
    }

    public static function closeStockCheckAfterTimeout($date)
    {
        $day1 = new DateTime();
        $day2 = new DateTime($date);
        $interval = $day1->diff($day2);
        $remaingDate = Stock::STATUS_DEADLINE_DAYS - $interval->d;
        if ($remaingDate > 0) {
            return $remaingDate;
        }
        return null;
    }
}
