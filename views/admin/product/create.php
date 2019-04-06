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
            
            <h4>Добавить новый товар</h4>
            
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
                    <form action="/admin/product/create" method="post" enctype="multipart/form-data">
                        <p>Название товара</p>
                        <input type="text" name="productName" value="" required />
                        <br />
                        <p>Артикул</p>
                        <input type="text" name="productCode" value="" required />
                        <br />
                        <p>Категория</p>
                        <select name="productCategoryId">
                            <?php
                            unset($category);
                            foreach($categories as $category) { ?>
                                <option value="<?php echo $category['id']; ?>">
                                    <?php echo $category['name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <br /><br />
                        <p>Цена за единицу:</p>
                        <input type="number" name="productPrice" value="1"/>
                        <br /><br />
                        <p>Доступно единиц:</p>
                        <input type="number" min='0' name="productStock" value="1"/>
                        <br /><br />
                        <p>Производитель</p>
                        <input type="text" name="productBrand" value=""/>
                        <br /><br />
                        <p>Детальное описание</p>
                        <textarea name="productDescription"></textarea>
                        
                        <br /><br />
                        <label>Новинка<input type="checkbox" id="isProductNew" name="isProductNew" /></label>
                        <label>Рекомендуемый<input type="checkbox" id="isProductRecommended" name="isProductRecommended" /></label>
                        <label>Отображать товар<input type="checkbox" id="productStatus" name="productStatus"  checked="checked"/></label>
                        <br /><br />
                        <p>Загрузить изображение</p>
                        <input type="file" name="filename" value=''/>
                        <br /><br />
                        <input type="submit" name="btnSaveProduct" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>   
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';