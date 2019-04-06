<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/product">Управление товарами</a></li>
                    <li class="active">Редактировать товар</li>
                </ol>
            </div>
            
            <h4>Редактирование данных товара</h4>
            
            <br />
            <br />
            
            <?php if(isset($errors) and is_array($errors)) {?>
            <ul>
                <?php foreach ($errors as $error) { ?>
                <li>
                    <?php echo " - ". $error; ?>
                </li>
                <?php }?>
            </ul>
            <?php }
            
            if(isset($message)){ ?>
                <h4><?php echo $message; ?></h4>    
            <?php }?>
            
            <div class="col-lg-4">
                <div class="login-form">
                    <form action="/admin/product/update" method="post" enctype="multipart/form-data">
                        <p>ID товара</p>
                        <input type="text" name="productId" value="<?php echo $product['id']; ?>" readonly />
                        <br />
                        <p>Название товара</p>
                        <input type="text" name="productName" value="<?php echo $product['name']; ?>" required />
                        <br />
                        <p>Артикул</p>
                        <input type="text" name="productCode" value="<?php echo $product['code']; ?>" required />
                        <br />
                        <p>Категория</p>
                        <select name="productCategoryId">
                            <?php
                            unset($category);
                            foreach($categories as $category) { ?>
                                <option value="<?php echo $category['id']; ?>"
                                <?php if($category['id'] == $product['category_id']) {
                                    echo " selected ";
                                } ?>        
                                >
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br /><br />
                        <p>Цена за единицу, $:</p>
                        <input type="number" name="productPrice" value="<?php echo $product['price']; ?>"/>
                        <br /><br />
                        <p>Доступно единиц:</p>
                        <input type="number" min='0' name="productStock" value="<?php echo $product['avilable']; ?>"/>
                        <br /><br />
                        <p>Производитель</p>
                        <input type="text" name="productBrand" value="<?php echo $product['brand']; ?>"/>
                        <br /><br />
                        <p>Детальное описание</p>
                        <textarea name="productDescription">
                            <?php echo $product['description']; ?>
                        </textarea>
                        
                        <br /><br />
                        <label>Новинка<input type="checkbox" id="isProductNew" name="isProductNew" <?php if($product['is_new']) { echo ' checked="checked" '; }?> /></label>
                        <label>Рекомендуемый<input type="checkbox" id="isProductRecommended" name="isProductRecommended" <?php if($product['is_recommened']) { echo ' checked="checked" '; }?> /></label>
                        <label>Отображать товар<input type="checkbox" id="productStatus" name="productStatus"  <?php if($product['is_recommened']) { echo ' checked="checked" '; }?>/></label>
                        <br /><br />
                        <p>Загрузить изображение</p>
                        <input type="file" name="filename" value='<?php echo $product['image']; ?>'/>
                        <br /><br />
                        <input type="submit" name="btnUpdateProduct" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>   
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';