/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
DROP TABLE IF EXISTS `department_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department_sections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `m_departments_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`m_departments_id`),
  KEY `fk_department_sections_m_departments1_idx` (`m_departments_id`),
  CONSTRAINT `fk_department_sections_m_departments1` FOREIGN KEY (`m_departments_id`) REFERENCES `m_departments` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='部署・課';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `m_departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_departments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='部署';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `m_makers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_makers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `name_alpha` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `m_models`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_models` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='AC型番マスター';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `m_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `m_models_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_available` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_models_id` (`m_models_id`),
  CONSTRAINT `fk_m_products_m_models1_idx` FOREIGN KEY (`m_models_id`) REFERENCES `m_models` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='AC型番マスター';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `users_id` bigint unsigned NOT NULL,
  `mall_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '店舗ID\nsetsubi\ne-setsubi',
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文ID\n',
  `case_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '案件番号',
  `shop_mall_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '以下を組み合わせた文字列(検索用)\n店舗名\ns : セツビコム\ne : イーセツビ\nk : 空調センター\n\nモール名  \n本店 main\n楽天 rakuten\nYahoo yahoo\n\n店舗ID\nsetsubi\ne-setsubi\n',
  `shop_name` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '店舗名\ns : セツビコム\ne : イーセツビ\nk : 空調センター\n\n\n',
  `mall_name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'モール名 \n本店\n楽天\nYahoo	',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者名',
  `name_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者名カナ',
  `zip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者郵便番号\n',
  `prefecture` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者都道府県',
  `city` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者市区町村',
  `sub_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者住所',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者住所\n都道府県\n市区町村\n住所\n',
  `address_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '注文者住所カナ\n都道府県\n市区町村\n住所\n',
  `progress` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文ステータス\n楽天:\n100: 注文確認待ち\n200: 楽天処理中\n300: 発送待ち\n400: 変更確定待ち\n500: 発送済\n600: 支払手続き中\n700: 支払手続き済\n800: キャンセル確定待ち\n900: キャンセル確定\nYahoo:\n本店:\n',
  `tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者電話番号',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者メールアドレス',
  `option1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '項目 選択肢\n空調機 : パネルカラー\n',
  `option2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '空調機 : リモコン種別\nワイヤード\nワイヤレス\n判別不能',
  `sender_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者名',
  `sender_name_kana` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者名カナ',
  `sender_zip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者郵便番号',
  `sender_prefecture` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者都道府県',
  `sender_city` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者市区町村',
  `sender_sub_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者住所',
  `sender_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者住所\n都道府県\n市区町村\n住所\n',
  `sender_address_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '送付者住所カナ\n都道府県\n市区町村\n住所\n',
  `sender_tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '送付者電話番号',
  `payment_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '支払方法コード\n楽天\n1: クレジットカード\n2: 代金引換\n4: ショッピングクレジット／ローン\n5: オートローン\n6: リース\n7: 請求書払い\n8: ポイント\n9: 銀行振込\n12: Apple Pay\n13: セブンイレブン（前払）\n14: ローソン、郵便局ATM等（前払）\n16: Alipay\n17: PayPal\n21: 後払い決済\n27: Alipay（支付宝）',
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '支払方法名\n楽天\nクレジットカード',
  `is_hurry` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 : 通常  1: 急ぎ',
  `is_order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 : 未在庫確認\r\n1 : 在庫確認済み(在庫確認中?)\r\n2 : 仮発注可\r\n3 : 仮発注済み\r\n4 : 他に仮発注のため不可\r\n5 : 仮発注済み\r\n6 : 在庫無し\r\n7 : クローズ',
  `closed_at` datetime DEFAULT NULL COMMENT '案件クローズ日時',
  `ordered_at` datetime DEFAULT NULL COMMENT '注文日時',
  `created_at` datetime DEFAULT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`,`users_id`) USING BTREE,
  KEY `fk_orders_users1_idx` (`users_id`),
  CONSTRAINT `fk_orders_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orders_id` bigint unsigned NOT NULL,
  `suppliers_id` bigint unsigned NOT NULL,
  `m_products_id` bigint unsigned NOT NULL,
  `ukey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `item_price` int NOT NULL DEFAULT '0' COMMENT '金額',
  `item_unit` int NOT NULL DEFAULT '0' COMMENT '数量',
  `option1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `option2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '備考',
  `last_commented_by` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `discount_amount` int NOT NULL DEFAULT '0' COMMENT '割引額(クーポン利用総額)',
  `is_stock_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 : 未在庫確認\n9 : 在庫確認済',
  `is_stock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '在庫有無\n0:あり 1:無し',
  `is_order_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '在庫確認状況\r\n0 : 未在庫確認\r\n1 : 在庫確認済み(在庫確認中?)\r\n2 : 仮発注可\r\n3 : 仮発注済み\r\n4 : 他に仮発注のため不可\r\n5 : 仮発注済み\r\n6 : 在庫無し\r\n7 : クローズ',
  `is_close` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'クローズステータス\n0 : オープン 1 : クローズ',
  `created_at` datetime DEFAULT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`,`orders_id`,`suppliers_id`,`m_products_id`),
  KEY `fk_orders_suppliers_orders1_idx` (`orders_id`),
  KEY `fk_orders_suppliers_suppliers1_idx` (`suppliers_id`),
  KEY `fk_orders_suppliers_m_products1_idx` (`m_products_id`),
  CONSTRAINT `fk_orders_suppliers_m_products1` FOREIGN KEY (`m_products_id`) REFERENCES `m_products` (`id`),
  CONSTRAINT `fk_orders_suppliers_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`),
  CONSTRAINT `fk_orders_suppliers_suppliers1` FOREIGN KEY (`suppliers_id`) REFERENCES `suppliers` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `orders_suppliers_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders_suppliers_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `orders_id` bigint unsigned NOT NULL,
  `sender_id` bigint unsigned NOT NULL,
  `sender_type` enum('user','supplier') COLLATE utf8mb4_general_ci NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `receiver_type` enum('user','supplier') COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`orders_id`),
  KEY `fk_orders_suppliers_comments_orders1_idx` (`orders_id`) USING BTREE,
  CONSTRAINT `fk_orders_suppliers_comments_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `payload` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `shopping_mall_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shopping_mall_orders` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ID ユニークキー\n注文番号 - 商品型番\n$orderNumber - $itemNumber',
  `mall_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '店舗ID\nsetsubi\ne-setsubi',
  `order_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文ID\n',
  `ukey` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ユニークキー\n注文番号 - 商品型番\n$orderNumber - $itemNumber\nPKのidと同じ値',
  `shop_mall_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '以下を組み合わせた文字列(検索用)\r\n店舗名\r\ns : セツビコム\r\ne : イーセツビ\r\nk : 空調センター\r\n\r\nモール名  \r\n本店 main\r\n楽天 rakuten\r\nYahoo yahoo\r\n\r\n店舗ID\r\nsetsubi\r\ne-setsubi',
  `shop_name` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '店舗名\ns : セツビコム\ne : イーセツビ\nk : 空調センター',
  `mall_name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'モール名 プラットフォーム\n本店\n楽天\nYahoo	',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者名',
  `name_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者名カナ',
  `zip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者郵便番号\n',
  `prefecture` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者都道府県',
  `city` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者市区町村',
  `sub_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者住所',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者住所\n都道府県\n市区町村\n住所\n',
  `address_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '注文者住所カナ\n都道府県\n市区町村\n住所\n',
  `progress` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文ステータス\n楽天:\n100: 注文確認待ち\n200: 楽天処理中\n300: 発送待ち\n400: 変更確定待ち\n500: 発送済\n600: 支払手続き中\n700: 支払手続き済\n800: キャンセル確定待ち\n900: キャンセル確定\nYahoo:\n本店:\n',
  `tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者電話番号',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '注文者メールアドレス',
  `option1` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '項目 選択肢\r\n空調機 : パネルカラー\r\n',
  `option2` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '空調機 : リモコン種別\r\nワイヤード\r\nワイヤレス\r\n判別不能',
  `sender_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者名',
  `sender_name_kana` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者名カナ',
  `sender_zip` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者郵便番号',
  `sender_prefecture` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者都道府県',
  `sender_city` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者市区町村',
  `sender_sub_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者住所',
  `sender_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '送付者住所\n都道府県\n市区町村\n住所\n',
  `sender_address_kana` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '送付者住所カナ\n都道府県\n市区町村\n住所\n',
  `sender_tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '送付者電話番号',
  `item_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品名',
  `item_model` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品型番',
  `item_price` int NOT NULL DEFAULT '0' COMMENT '商品価格',
  `item_unit` int unsigned NOT NULL DEFAULT '0' COMMENT '商品数',
  `payment_code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '支払方法コード\n楽天\n1: クレジットカード\n2: 代金引換\n4: ショッピングクレジット／ローン\n5: オートローン\n6: リース\n7: 請求書払い\n8: ポイント\n9: 銀行振込\n12: Apple Pay\n13: セブンイレブン（前払）\n14: ローソン、郵便局ATM等（前払）\n16: Alipay\n17: PayPal\n21: 後払い決済\n27: Alipay（支付宝）',
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '支払方法名\n楽天\nクレジットカード',
  `is_stock_confirm` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 : 未在庫確認\r\n9 : 在庫確認済',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci COMMENT '備考',
  `discount_amount` int NOT NULL DEFAULT '0' COMMENT '割引額(クーポン利用総額)',
  `ordered_at` datetime DEFAULT NULL COMMENT '注文日時',
  `created_at` datetime DEFAULT NULL COMMENT '作成日時',
  `updated_at` datetime DEFAULT NULL COMMENT '更新日時',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `can_stock` tinyint(1) NOT NULL DEFAULT '0' COMMENT '在庫確保可否\r\n0 : 確保不可\r\n1: 確保可',
  `can_order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '発注可能',
  `can_preorder` tinyint(1) NOT NULL DEFAULT '0' COMMENT '仮発注可能',
  `can_quotation` tinyint(1) NOT NULL DEFAULT '0' COMMENT '見積依頼可能',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='仕入先';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `suppliers_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers_products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `m_products_id` bigint unsigned NOT NULL,
  `suppliers_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `original_price` int NOT NULL DEFAULT '0',
  `selling_price` int NOT NULL DEFAULT '0',
  `is_available` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_products_id` (`m_products_id`),
  KEY `suppliers_id` (`suppliers_id`),
  CONSTRAINT `fk_suppliers_products_m_models1_idx` FOREIGN KEY (`suppliers_id`) REFERENCES `suppliers` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_suppliers_products_m_products1_idx` FOREIGN KEY (`m_products_id`) REFERENCES `m_products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='商品';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `user_rolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_rolls` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ロール名',
  `roll` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ロール',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ユーザーロール パーミッション管理';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_rolls_id` bigint unsigned NOT NULL,
  `department_sections_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `code` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`,`user_rolls_id`,`department_sections_id`),
  KEY `fk_users_user_rolls1_idx` (`user_rolls_id`),
  KEY `fk_users_department_sections1_idx` (`department_sections_id`),
  CONSTRAINT `fk_users_department_sections1` FOREIGN KEY (`department_sections_id`) REFERENCES `department_sections` (`id`),
  CONSTRAINT `fk_users_user_rolls1` FOREIGN KEY (`user_rolls_id`) REFERENCES `user_rolls` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ユーザー';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1);
