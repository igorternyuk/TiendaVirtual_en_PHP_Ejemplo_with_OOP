<?php

/**
 * Description of Utils
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Utils {
   public static function debug($val = null, $die = TRUE){
        function debugOut($val){
            $info = "<font color='blue'>".basename($val['file'])."</font>&nbsp;";
            $info .= "<font color='red'>{$val['line']}</font><br />&nbsp;";
            $info .= "<font color='green'>{$val['function']}</font><br />&nbsp;";
            $info .= "<font color='purple'>".dirname($val['file'])."</font><br /><br />";
            echo $info;
        }   
        echo "<pre>";
        $trace = debug_backtrace();
        array_walk($trace, 'debugOut');
        echo "\n\n";
        var_dump($val);
        echo "</pre>";
        if($die){
            die;
        }
    }
    
    public static function redirect($url = '/'){
        header("Location: {$url}");
    exit;
}
}
