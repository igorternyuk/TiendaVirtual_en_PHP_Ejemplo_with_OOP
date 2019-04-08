<?php

/**
 * Description of AdminOrderController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminOrderController extends AdminBase{
    public function actionIndex($page = 1){
        self::checkIfAdmin();
        $orders = Order::getForPage($page);
        $orderTotal = Order::countAll();
        $paginator = new Paginator($page, $orderTotal,
                Order::SHOW_BY_DEFAULT, "page-");
        $pagination = $paginator->getHtml();
        require_once ROOT . '/views/admin/order/index.php';
        return true;
    }
    
    public function actionView($orderId){
        $order = Order::getById($orderId);
        $orderItems = OrderItem::getAllItemsByOrderId($orderId);
        require_once ROOT . '/views/admin/order/view.php';
        return true;
    }
    
    public function actionUpdate($orderId){
        
        $formWasSet = filter_input(INPUT_POST, 'btnUpdateOrder');
        if($formWasSet){
            $options = [];
            $errors = [];
            $options['date_payment'] = filter_input(INPUT_POST, 'orderDatePayment');
            $options['username'] = filter_input(INPUT_POST, 'orderUsername');
            $options['userphone'] = filter_input(INPUT_POST, 'orderUserphone');
            $options['comment'] = filter_input(INPUT_POST, 'orderComment');
            $options['total'] = filter_input(INPUT_POST, 'orderTotalSum');
            $options['status'] = filter_input(INPUT_POST, 'orderStatus');
            $options['id'] = $orderId;
            //Utils::debug($options);
            if(isset($options['username']) ){
                if(empty($options['username'])){
                    array_push($errors, 'Задайте имя покупателя');
                }
                if(!User::checkUsername($options['username'])){
                    array_push($errors, 'Имя должно содержать не менее 3-х символов');
                }
            }
            
            if(isset($options['userphone'])){
                if(empty($options['userphone'])){
                    array_push($errors, 'Задайте телефон покупателя');
                }
                
                if(!User::checkPhone($options['userphone'])){
                    array_push($errors, 'Неверный формат телефонного номера');
                }
            }
            
            if(empty($errors)){
                $orderUpdated = Order::update($options);
                //Utils::debug($orderUpdated);
                if($orderUpdated){
                    $message = "Данные заказа успешно обновлены";
                } else {
                    $message = "Ошибка обновления заказа";
                }
            }
        }
        $order = Order::getById($orderId);
        require_once ROOT . '/views/admin/order/update.php';
        return true;
    }
    
    public function actionRemove($orderId){
        self::checkIfAdmin();
        $removeConformed = filter_input(INPUT_POST, 'btnRemoveOrder');        
        if($removeConformed){
            $removedSuccessfully = Order::removeById($orderId);
            $orders = Order::getAll();
            require_once ROOT . '/views/admin/category/index.php';
        } else {
            require_once ROOT . '/views/admin/category/remove.php';
        }
        
        return true;
    }
}
