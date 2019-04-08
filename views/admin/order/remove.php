<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">

            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/product">Управление заказами</a></li>
                    <li class="active">Удалить заказ</li>
                </ol>
            </div>
            
            <h4>Вы действительно хотите удалить заказ <?php echo "#".$orderId."?"?></h4>
            
            <form action="/admin/order/remove/<?php echo $orderId; ?>" method="post">
                <input type="submit" name="btnRemoveOrder" value="Удалить">        
            </form>

        </div>
    </div>
</section>

<?php include_once ROOT . '/views/layouts/admin_footer.php';

