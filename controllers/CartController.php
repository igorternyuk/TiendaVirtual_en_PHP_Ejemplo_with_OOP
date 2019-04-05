<?php

/**
 * Description of CartController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class CartController {
    
    public function actionView(){
        $categories = Category::getAll();
        foreach($categories as &$category){
            $category['total'] = Product::countProductsOfCategory($category['id']);
        }
        
        $productsInCart = Cart::getProductsInCart();
        if($productsInCart){
            $ids = array_keys($productsInCart);
            $products = Product::getProductsByIds($ids);
            //Utils::debug($products);
            $cartCount = Cart::calculateTotalItems();
            $cartTotalSum = Cart::calculateTotalSum();
        }
        
        require_once ROOT . '/views/cart/view.php';
        return true;
    }
    
    public function actionAdd(){
        $productId = filter_input(INPUT_POST, 'productId');
        //Utils::debug($productId);
        Cart::addProduct($productId);
        $cartCount = Cart::calculateTotalItems();
        $cartTotalSum = Cart::calculateTotalSum();
        $res = [];
        $res['cartCount'] = $cartCount;
        $res['cartTotalSum'] = $cartTotalSum;
        //Utils::debug($res);
        echo json_encode($res);
        return true;
    }
    
    public function actionRemove($productId){
        
    }
    
    public function actionChangecount($productId, $newCount){
        //Utils::debug([ 'pid' => $productId, 'count' => $newCount ]);
        $stock = Product::getProductStock($productId);
        if($newCount > $stock){
            $newCount = $stock;
        }
        Cart::changeProductCount($productId, $newCount);
        $res = [];
        
        $currProduct = Product::getProductById($productId);
        
        $res['subtotal'] = $currProduct['price'] * $newCount;
        $res['totalSum'] = Cart::calculateTotalSum();
        $res['totalItems'] = Cart::calculateTotalItems();
        //Utils::debug($res);
        echo json_encode($res);
        return true;
    }
    
    public function actionCheckout(){
        $categories = Category::getAll();
        foreach($categories as &$category){
            $category['total'] = Product::countProductsOfCategory($category['id']);
        }
        
        $result = false;
        
        $formSent = filter_input(INPUT_POST, 'btnCheckout');
        $username = '';
        $userphone = '';
        $usercomment = '';
        
        if($formSent){
            $username = filter_input(INPUT_POST, 'username');
            $userphone = filter_input(INPUT_POST, 'userphone');
            $usercomment = filter_input(INPUT_POST, 'usercomment');
            
            $errors = [];
            
            if(!User::checkUsername($username)){
                array_push($errors, "Имя не должно быть короче 3-х символов");
            }
            
            if(!User::checkPhone($userphone)){
                array_push($errors, "Телефон не соответсвует ни одному из"
                        . " мобильных операторов Украины");
            }
            $productsInCart = Cart::getProductsInCart();
            
            if(count($errors) == 0){
                 
                 $userId = User::getLoggedUserId();
                 $result = Order::saveNewOrder($userId, $username, $userphone,
                                               $usercomment, $productsInCart);
                 if($result){
                     Cart::clear();
                 }
            } else {
                if($productsInCart){
                    $productIds = array_keys($productsInCart);
                    $products = Product::getProductsByIds($productIds);
                    $cartTotalItems = Cart::calculateTotalItems();
                    $cartTotalSum = Cart::calculateTotalSum();
                }
            }
        } else {
            $productsInCart = Cart::getProductsInCart();
            if($productsInCart){
                $productIds = array_keys($productsInCart);
                $products = Product::getProductsByIds($productIds);
                $cartTotalItems = Cart::calculateTotalItems();
                $cartTotalSum = Cart::calculateTotalSum();
                
                
                if(!User::isGuest()){
                    $loggedUserId = User::getLoggedUserId();
                    $loggedUser = User::getById($loggedUserId);
                    $username = $loggedUser['name'];
                }
                
            } else {
                Utils::redirect();
            }
        }
        
        require_once ROOT . '/views/cart/checkout.php';
        return true;
    }
}
