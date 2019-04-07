<?php

/**
 * Description of AdminProductController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminProductController extends AdminBase {
    public function actionIndex(){
        self::checkIfAdmin();
        $products = Product::getAll();
        require_once ROOT . '/views/admin/product/index.php';
        return true;
    }
    
    public function actionCreate(){
        self::checkIfAdmin();
        $inputFormWasSent = filter_input(INPUT_POST, 'btnSaveProduct');
        if($inputFormWasSent){
            $options = [];
            $options['productName'] = filter_input(INPUT_POST, 'productName');
            $options['productCode'] = filter_input(INPUT_POST, 'productCode');
            $options['productCategoryId'] = filter_input(INPUT_POST, 'productCategoryId');
            $options['productPrice'] = filter_input(INPUT_POST, 'productPrice');
            $options['productStock'] = filter_input(INPUT_POST, 'productStock');
            $options['productBrand'] = filter_input(INPUT_POST, 'productBrand');
            $options['productDescription'] = filter_input(INPUT_POST, 'productDescription');
            $isProductRecommended = filter_input(INPUT_POST, 'isProductRecommended');
            $options['isProductRecommended'] = $isProductRecommended ? 1 : 0;
            $productStatus = filter_input(INPUT_POST, 'productStatus');
            $options['productStatus'] = $productStatus ? 1 : 0;
            $isProductNew = filter_input(INPUT_POST, 'isProductNew');
            $options['isProductNew'] = $isProductNew ? 1 : 0;
            $errors = [];
            if(isset($options['productName']) && empty($options['productName'])){
                $errors[] = "Введите имя товара";
            }
            
            if(count($errors) == 0){
                $insertedProductId = Product::addNew($options);
                
                if($insertedProductId){
                    if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
                        $localPath = ImageUploadLocalPath;
                        $image = Utils::uploadFile($insertedProductId,
                                $localPath, true);
                        if($image){
                            if(Product::updateImage($insertedProductId, $image)){
                                $message = "Новый товар успешно добавлен";
                            }
                        } else {
                            $message = "Ошибка загрузки изображения товара";
                        }
                    } else {
                        $message = "Новый товар успешно добавлен";
                    }
                    
                } else {
                    $message = "Ошибка добавления товара";
                }
            }
            
        } 
        
        $categories = Category::getAll();
        require_once ROOT . '/views/admin/product/create.php';        
        return true;
    }
    
    public function actionUpdate($productId){
        //btnUpdateProduct
        self::checkIfAdmin();
        $inputFormWasSent = filter_input(INPUT_POST, 'btnUpdateProduct');
        if($inputFormWasSent){
            $options = [];
            $options['productName'] = filter_input(INPUT_POST, 'productName');
            $options['productCode'] = filter_input(INPUT_POST, 'productCode');
            $options['productCategoryId'] = filter_input(INPUT_POST, 'productCategoryId');
            $options['productPrice'] = filter_input(INPUT_POST, 'productPrice');
            $options['productStock'] = filter_input(INPUT_POST, 'productStock');
            $options['productBrand'] = filter_input(INPUT_POST, 'productBrand');
            $options['productDescription'] = filter_input(INPUT_POST, 'productDescription');
            $isProductRecommended = filter_input(INPUT_POST, 'isProductRecommended');
            $options['isProductRecommended'] = $isProductRecommended ? 1 : 0;
            $productStatus = filter_input(INPUT_POST, 'productStatus');
            $options['productStatus'] = $productStatus ? 1 : 0;
            $isProductNew = filter_input(INPUT_POST, 'isProductNew');
            $options['isProductNew'] = $isProductNew ? 1 : 0;
            $options['id'] = $productId;
            
            $errors = [];
            
            if(isset($options['productName']) && empty($options['productName'])){
                $errors[] = "Введите имя товара";
            }
            
            if(count($errors) == 0){
                $productUpdated = Product::update($options);
                //Utils::debug($productUpdated);
                if($productUpdated){
                    if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
                        $localPath = ImageUploadLocalPath;
                        $image = Utils::uploadFile($productId, $localPath, true);
                        if($image){
                            if(Product::updateImage($productId, $image)){
                                $message = "Данные товара успешно обновлены";
                            }
                        } else {
                            $message = "Ошибка загрузки изображения товара";
                        }
                    } else {
                        $message = "Данные товара успешно обновлены";
                    }
                    
                } else {
                    $message = "Ошибка обновления товара";
                }
            }
        }
        $categories = Category::getAll();
        $product = Product::getProductById($productId);
        require_once ROOT . '/views/admin/product/update.php';
        return true;
    }
    
    public function actionRemove($productId){
        self::checkIfAdmin();        
        $removeConformed = filter_input(INPUT_POST, 'btnRemove');
        if($removeConformed){
            $ok = Product::removeById($productId);
            //Utils::debug($ok);
            $products = Product::getAll();
            require_once ROOT . '/views/admin/product/index.php';
        } else {
            require_once ROOT . '/views/admin/product/remove.php';
        }
        
        return true;
    }
}
