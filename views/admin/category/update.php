<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/category">Управление категориями</a></li>
                    <li class="active">Редактировать категорию</li>
                </ol>
            </div>
            
            <h4>Редактирование данных категории</h4>
            
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
                    <form action="/admin/category/update/<?php echo $category['id']; ?>" method="post">
                        <p>ID категории</p>
                        <input type="text" name="categoryId" value="<?php echo $category['id']; ?>" readonly />
                        <br />
                        <p>Название категории</p>
                        <input type="text" name="categoryName" value="<?php echo $category['name']; ?>" required />
                        <br />
                        <p>Порядковый номер</p>
                        <input type="text" name="categoryRating" value="<?php echo $category['rating']; ?>" required />
                        <br />
                        <p>Статус</p>
                        <select name="categoryStatus">
                            <option value="1" <?php if($category['status'] == 1) { echo "selected"; } ?> >Отображается</option>
                            <option value="0" <?php if($category['status'] == 0) { echo "selected"; } ?>>Скрыта</option>
                        </select>
                        <br /><br />                        
                        <input type="submit" name="btnUpdateCategory" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>   
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';