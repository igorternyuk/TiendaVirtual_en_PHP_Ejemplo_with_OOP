<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/category">Управление категориями</a></li>
                    <li class="active">Удалить категорию</li>
                </ol>
            </div>
            
            <h4>Вы действительно хотите удалить категорию <?php echo "#".$categoryId."?"?></h4>
            
            <form action="/admin/category/remove/<?php echo $categoryId; ?>" method="post">
                <input type="submit" name="btnRemoveCategory" value="Удалить">        
            </form>

        </div>
    </div>
</section>

<?php include_once ROOT . '/views/layouts/admin_footer.php';