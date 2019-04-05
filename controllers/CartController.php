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
}
