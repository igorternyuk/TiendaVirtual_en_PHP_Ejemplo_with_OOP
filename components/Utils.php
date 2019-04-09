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
    
    public static function uploadFile($localFileName, $localPath = "/upload/images/",
            $isImage = FALSE){
        $size = $_FILES['filename']['size'];
        if($size > MaxImageFileSize){
            echo "Файл слишком большой.";
            return false;
        }
        $ext = pathinfo($_FILES['filename']['name'], PATHINFO_EXTENSION);
        $pathInfo = pathinfo($localFileName);

        if($isImage){
            $check = getimagesize($_FILES['filename']['tmp_name']);

            if(!$check){
                echo "Файл не является изображением";
                return FALSE;
            }

            if(!in_array($ext, ImageExtensions)){
                echo "Неизвестный формат изображения";
                return FALSE;
            }
            $newFileName = $pathInfo['filename'] . "." . $ext;

        } else {
            if($ext != $pathInfo['extension']){
                return false;
            }
            $newFileName = $pathInfo['filename'] . "_" . time() . "." . $ext;
        }

        $fullPath = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . $localPath;

        if(!file_exists($fullPath)){
            mkdir($fullPath);
        }

        if(is_uploaded_file($_FILES['filename']['tmp_name'])){
            $fullPath .= $newFileName;        
            $success = move_uploaded_file($_FILES['filename']['tmp_name'],
                    $fullPath);
            $response = $success == TRUE ? $newFileName: FALSE;
            return $response;
        }
        return FALSE;
    }
}
