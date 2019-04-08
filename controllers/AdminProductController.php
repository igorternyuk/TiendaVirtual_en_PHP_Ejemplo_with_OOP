<?php

/**
 * Description of AdminProductController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminProductController extends AdminBase {
    public function actionIndex($page = 1){
        self::checkIfAdmin();
        
        $btnSearchPressed = filter_input(INPUT_POST, 'btnSearch');
        
        if($btnSearchPressed){
            $searchPattern = filter_input(INPUT_POST, 'searchPattern');
            $_SESSION['searchPattern'] = $searchPattern;
        } else {
            $searchPattern = isset($_SESSION['searchPattern'])
                    ? $_SESSION['searchPattern']
                    : '';
        }
        
        $products = Product::getProductsForPage($page, $searchPattern);
        
        if($searchPattern == ''){
            $productTotal = Product::countAll();
        } else {
            $productTotal = Product::countByName($searchPattern);
            $_SESSION['searchPattern'] = $searchPattern;
        }
        //Utils::debug($productTotal);
        $paginator = new Paginator($page, $productTotal,
                Product::SHOW_BY_DEFAULT_FOR_ADMIN, "page-");
        $pagination = $paginator->getHtml();
        //Utils::debug($pagination);
        require_once ROOT . '/views/admin/product/index.php';
        return true;
    }
    
    public function actionSearch($searchPattern = '',
            $sortCriteria = ' `id` DESC '){
        self::checkIfAdmin();
        if($searchPattern == ''){
            Utils::redirect('/admin/views/product');
        }
        $products = Product::fetchByName($searchPattern, $sortCriteria);
        
        ob_start(); // turn on output buffering
        include(ROOT . '/views/admin/product/view.php');
        $searchResults = ob_get_contents(); // get the contents of the output buffer
        ob_end_clean(); //  clean (erase) the output buffer and turn off output buffering
        
        $res = [];
        if(!empty($products)){
            $res['success'] = true;
            $res['results'] = $searchResults;
        } else {
            $res['success'] = false;
            $res['results'] = "<h4>Ни одного товара не найдено.</h4>";
        }
        
        //Utils::debug($pagination);
        //require_once ROOT . '/views/admin/product/index.php';
        echo json_encode($res);
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
            
            if(empty($errors)){
                $insertedProductId = Product::addNew($options);
                $image = NoImage;
                $success = false;
                if($insertedProductId){
                    if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
                        $localPath = ImageUploadLocalPath;
                        $image = Utils::uploadFile($insertedProductId,
                                $localPath, true);
                    }
                    if(Product::updateImage($insertedProductId, $image)){
                        $success = true;
                    }
                }
                
                if($success){
                    $message = "Новый товар успешно добавлен";
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
            
            if(empty($errors)){
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
