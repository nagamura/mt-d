<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shopping_mall_orders', function (Blueprint $table) {
            $table->string('id', 255)->comment('ID ユニークキー注文番号 - 商品型番$orderNumber - $itemNumber');
            $table->string('mall_id', 20)->comment('店舗IDsetsubie-setsubi');
            $table->string('order_id', 255)->comment('注文ID');
            $table->string('ukey', 255)->comment('ユニークキー注文番号 - 商品型番$orderNumber - $itemNumber PKのidと同じ値');
            $table->string('shop_mall_id', 255)->comment('以下を組み合わせた文字列(検索用)店舗名s : セツビコムe : イーセツビk : 空調センターモール名  本店 main楽天 rakutenYahoo yahoo店舗IDsetsubie-setsubi');
            $table->string('shop_name', 1)->comment('店舗名s : セツビコムe : イーセツビk : 空調センター');
            $table->string('mall_name', 10)->comment('モール名 プラットフォーム本店楽天Yahoo ');
            $table->string('name', 50)->comment('注文者名');
            $table->string('name_kana', 255)->comment('注文者名カナ');
            $table->string('zip', 10)->comment('注文者郵便番号');
            $table->string('prefecture', 10)->comment('注文者都道府県');
            $table->string('city', 10)->comment('注文者市区町村');
            $table->string('sub_address', 100)->comment('注文者住所');
            $table->string('address', 255)->comment('注文者住所都道府県市区町村住所');
            $table->string('address_kana', 255)->comment('注文者住所カナ都道府県市区町村住所')->default(null);
            $table->string('progress', 50)->comment('注文ステータス楽天:100: 注文確認待ち200: 楽天処理中300: 発送待ち400: 変更確定待ち500: 発送済600: 支払手続き中700: 支払手続き済800: キャンセル確定待ち900: キャンセル確定Yahoo:本店:');
            $table->string('tel', 15)->comment('注文者電話番号');
            $table->string('email', 255)->comment('注文者メールアドレス');
            $table->string('option1', 255)->comment('項目 選択肢空調機 : パネルカラー')->default(null);
            $table->string('option2', 255)->comment('空調機 : リモコン種別ワイヤードワイヤレス判別不能')->default(null);
            $table->string('sender_name', 50)->comment('送付者名');
            $table->string('sender_name_kana', 50)->comment('送付者名カナ');
            $table->string('sender_zip', 10)->comment('送付者郵便番号');
            $table->string('sender_prefecture', 10)->comment('送付者都道府県');
            $table->string('sender_city', 10)->comment('送付者市区町村');
            $table->string('sender_sub_address', 100)->comment('送付者住所');
            $table->string('sender_address', 255)->comment('送付者住所都道府県市区町村住所');
            $table->string('sender_address_kana', 255)->comment('送付者住所カナ都道府県市区町村住所')->default(null);
            $table->string('sender_tel', 15)->comment('送付者電話番号')->default(null);
            $table->string('item_name', 255)->comment('商品名');
            $table->string('item_model', 50)->comment('商品型番');
            $table->integer('item_price')->comment('商品価格')->default(0);
            $table->integer('item_unit')->comment('商品数')->default(0);
            $table->string('payment_code', 10)->comment('支払方法コード楽天1: クレジットカード2: 代金引換4: ショッピングクレジット／ローン5: オートローン6: リース7: 請求書払い8: ポイント9: 銀行振込12: Apple Pay13: セブンイレブン（前払）14: ローソン、郵便局ATM等（前払）16: Alipay17: PayPal21: 後払い決済27: Alipay（支付宝）');
            $table->string('payment_method', 50)->comment('支払方法名楽天クレジットカード');
            $table->tinyInteger('is_stock_confirm')->comment('0 : 未在庫確認9 : 在庫確認済')->default(0);
            $table->text('note')->comment('備考');
            $table->integer('discount_amount')->comment('割引額(クーポン利用総額)')->default(0);
            $table->dateTime('ordered_at')->comment('注文日時')->default(null);
            $table->dateTime('created_at')->comment('作成日時')->default(null);
            $table->dateTime('updated_at')->comment('更新日時')->default(null);

            // Indexes
            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_mall_orders');
    }
};
