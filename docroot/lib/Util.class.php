<?php

class Util
{
    const LOG_NAME = "log.txt";
    const SAVE_DAYS = "3";
    const MAIL_FROM = "From:noreply@a-aircon.jp";
    const MAIL_SUBJECT = "Yahoo! Shopping API Error";
    const MAIL_TO = "kikaku@e-aircon.jp";
    //const MAIL_TO = "nagamura@mitax.co.jp";
    
    public static function log($contents)
    {
        // タイムゾーン指定
        date_default_timezone_set('Asia/Tokyo');

        $path = basename(realpath("../"));
        $dir  = basename(realpath(""));
        $logPath = "../../" . $path . "/" . $dir . "/log";
        $logFileName = date("Ymd") . "-" . self::LOG_NAME;
        
        if (!file_exists($logPath . "/" .  $logFileName)) {
            touch($logPath . "/" .  $logFileName);
            chmod($logPath . "/" .  $logFileName, 0777);
        }

        $checkDateTime = new DateTime();
        $checkDateTime->modify("-" . self::SAVE_DAYS . " day");
        
        $logFiles = glob($logPath . "/*");
        foreach ($logFiles as $file) {
            $lastUpdateDttm = new DateTime(Date("Y-m-d H:i:s", filemtime($logPath . "/" . $logFileName)));
            if ($lastUpdateDttm < $checkDateTime) {
                unlink($logPath . "/" . $file);
            }
        }
        file_put_contents($logPath . "/" .  $logFileName, date("Y-m-d H:i:s") . " " . $contents . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    public static function mail($result, $options = array())
    {
        // 土日はメール送らない
        // 現在の曜日を取得
        $dayOfWeek = date('N');

        // 土曜日（6）または日曜日（7）であれば、メール送信しない
        if ($dayOfWeek != 6 && $dayOfWeek != 7) {
            // メール情報
            mb_language("ja");
            mb_internal_encoding("UTF-8");
 
            // メール送信処理
            $contents = '';
            if (!empty($options)) {
                foreach ($options as $k => $v) {
                    $contents .= $k . " : " . $v . "\n";
                }
            }
            if (is_array($result)) {
                foreach ($result as $k => $v) {
                    $contents .= $k . " : " . $v . "\n";
                }
            }
            if (is_object($result)) {
                $contents .= "Message : " . $result->Message . "\n";
            }
            return mb_send_mail(self::MAIL_TO, self::MAIL_SUBJECT, $contents, self::MAIL_FROM);
        }
    }
}
