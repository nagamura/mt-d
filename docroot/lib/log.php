<?php
$path = basename(realpath("../"));
$dir  = basename(realpath(""));
$logPath = "../../" . $path . "/" . $dir . "/log";
$logfile = $logPath . '/log.txt';

if (!file_exists($logfile)) {
