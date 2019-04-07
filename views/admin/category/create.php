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
            
            <h4>Добавить новую категорию</h4>
            
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
                    <form action="/admin/category/create" method="post">
                        <p>Название категории</p>
                        <input type="text" name="categoryName" value="" required />
                        <br />
                        <p>Порядковый номер</p>
                        <input type="text" name="categoryRating" value="" required />
                        <br />
                        <p>Статус</p>
                        <select name="categoryStatus">
                            <option value="1" selected>Отображается</option>
                            <option value="0">Скрыта</option>
                        </select>
                        <br /><br />                        
                        <input type="submit" name="btnSaveCategory" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>   
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';