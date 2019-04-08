<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <br/>
            <div class="breadcrumbs">
                <ul class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a></li>
                    <li class="active">Управление заказами</li>
                </ul>
            </div>
            
            <!-- <a href="/admin/product/create" class="btn btn-default back"><i class="fa fa-plus"></i> Добавить товар</a> -->
            
            
            <?php if(isset($ok) && $ok) { ?>
                <h4>Заказ успешно удален</h4>
            <?php } ?>
            <h4>Список заказов</h4>
            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID</th>
                    <th>Имя покупателя</th>
                    <th>Телефон</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th colspan="3">Действия</th>
                </tr>
                <?php foreach($orders as $order) { ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['username']; ?></td>
                    <td><?php echo $order['userphone']; ?></td>
                    <td><?php echo $order['date_created']; ?></td>
                    <td><?php echo Order::getStatusDescription($order['status']); ?></td>
                    <td><a href="/admin/order/view/<?php echo $order['id']; ?>" title="Смотреть"><i class="fa fa-eye"></i></a></td>
                    <td><a href="/admin/order/update/<?php echo $order['id']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></a></td>
                    <td><a href="/admin/order/remove/<?php echo $order['id']; ?>" title="Удалить"><i class="fa fa-times"></a></td>
                </tr>
                <?php } ?>
            </table>
            <center><?php echo $pagination; ?></center>
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';


