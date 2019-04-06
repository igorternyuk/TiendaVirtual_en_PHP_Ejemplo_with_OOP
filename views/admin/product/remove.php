<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/product">Управление товарами</a></li>
                    <li class="active">Удалить товар</li>
                </ol>
            </div>
            
            <h4>Вы действительно хотите удалить товар <?php echo "#".$productId."?"?></h4>
            
            <form action="/admin/product/remove/<?php echo $productId; ?>" method="post">
                <input type="submit" name="btnRemove" value="Удалить">        
            </form>

        </div>
    </div>
</section>

<?php include_once ROOT . '/views/layouts/admin_footer.php';

