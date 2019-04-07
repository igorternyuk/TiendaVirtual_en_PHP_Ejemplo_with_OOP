<?php

/**
 * Description of AdminCategoryController
 *
 * @author Igor Ternyuk <xmonad100 at gmail.com>
 */
class AdminCategoryController extends AdminBase{
    public function actionIndex(){
        self::checkIfAdmin();
        $categories = Category::getAll();
        require_once ROOT . '/views/admin/category/index.php';
        return true;
    }
    
    public function actionCreate(){
        self::checkIfAdmin();
        $formDataWasSent = filter_input(INPUT_POST, 'btnSaveCategory');
        if($formDataWasSent){
            $options = [];
            $errors = [];
            $options['name'] = filter_input(INPUT_POST, 'categoryName');
            $options['rating'] = filter_input(INPUT_POST, 'categoryRating');
            $options['status'] = filter_input(INPUT_POST, 'categoryStatus');
            if(isset($options['name']) && empty($options['name'])){
                array_push($errors, "Задайте имя для категории");
            }
            if(empty($errors)){
                $categoryAdded = Category::addNew($options);
                if($categoryAdded){
                    $message = "Категория успешно добавлена";
                } else {
                    $message = "Ошибка добавления категории";
                }                
            }
        }
        require_once ROOT . '/views/admin/category/create.php';        
        return true;
    }
    
    public function actionUpdate($categoryId){
        self::checkIfAdmin();
        $formDataWasSent = filter_input(INPUT_POST, 'btnUpdateCategory');
        if($formDataWasSent){
            $options = [];
            $errors = [];
            $options['id'] = $categoryId;
            $options['name'] = filter_input(INPUT_POST, 'categoryName');
            $options['rating'] = filter_input(INPUT_POST, 'categoryRating');
            $options['status'] = filter_input(INPUT_POST, 'categoryStatus');
            
            if(isset($options['name']) && empty($options['name'])){
                array_push($errors, "Задайте имя для категории");
            }
            
            if(empty($errors)){
                $categoryUpdated = Category::update($options);
                if($categoryUpdated){
                    $message = "Категория успешно обновлена";
                } else {
                    $message = "Ошибка обновления категории";
                }
            }
        }
        $category = Category::getById($categoryId);
        require_once ROOT . '/views/admin/category/update.php';        
        return true;
    }
    
    public function actionRemove($categoryId){
        self::checkIfAdmin();
        $removeConformed = filter_input(INPUT_POST, 'btnRemoveCategory');        
        if($removeConformed){            
            $removedSuccessfully = Category::removeById($categoryId);
            $categories = Category::getAll();
            require_once ROOT . '/views/admin/category/index.php';
        } else {
            require_once ROOT . '/views/admin/category/remove.php';
        }
        
        return true;
    }
}
