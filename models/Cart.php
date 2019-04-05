<?php

/**
 * Description of Cart
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class Cart {
    public static function addProduct($productId){
        //Utils::debug($productId);
        $productsInCart = [];
        if(isset($_SESSION['cart'])){
            $productsInCart = $_SESSION['cart'];
        }
        
        if(array_key_exists($productId, $productsInCart)){
            ++$productsInCart[$productId];
        } else {
            $productsInCart[$productId] = 1;
        }
        
        $_SESSION['cart'] = $productsInCart;
    }
    
    public static function removeProduct($productId){
        if(isset($_SESSION['cart'])){
            unset($_SESSION['cart'][$productId]);
        }
    }
    
    public static function clear(){
        unset($_SESSION['cart']);
    }
    
    public static function calculateTotalItems(){
        $total = 0;
        if(isset($_SESSION['cart'])){
            $products = $_SESSION['cart'];

            foreach ($products as $id => $amount) {
                $total += $amount;
            }
        }
        return $total;
    }
    
    public static function calculateTotalSum(){
        $sum = 0;
        if(isset($_SESSION['cart'])){
            $productIds = $_SESSION['cart'];
            //Utils::debug($productIds);
            foreach ($productIds as $productId => $amount){
                $product = Product::getProductById($productId);
                $subTotal = $product['price'] * $amount;
                $sum += $subTotal;
            }
        }
        return $sum;
    }
    
    public static function getProductsInCart(){
        if(isset($_SESSION['cart'])){
            return $_SESSION['cart'];
        }
        return false;
    }
    
    public static function changeProductCount($productId, $newCount){
        if(isset($_SESSION['cart'])){
            $productsInCart = $_SESSION['cart'];
            if(array_key_exists($productId, $productsInCart)){
                $productsInCart[$productId] = $newCount;
            }
            $_SESSION['cart'] = $productsInCart;
        }
    }
}
