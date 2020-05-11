<?php
/**
 * https://gist.github.com/chuckreynolds/c93791dc8179288a7d08c29f31bf1080
 */
namespace Nagy\HealthChecker;

class StopWatch {

    private static $startTimes = array();

    public static function start($timerName = 'default') {
        self::$startTimes[$timerName] = microtime(true);
    }

    public static function elapsed($timerName = 'default') {
        return microtime(true) - self::$startTimes[$timerName];
    }
}
