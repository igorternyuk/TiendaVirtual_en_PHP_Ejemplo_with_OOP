<?php

/**
 * Description of SiteController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class SiteController {
    public function actionIndex(){
        require_once(ROOT . "/views/site/index.php");
        return true;
    }
}
