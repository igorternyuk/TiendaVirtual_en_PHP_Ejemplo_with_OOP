<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <br/>
            <div class="breadcrumbs">
                <ul class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a></li>
                    <li class="active">Просмотр данных о заказе</li>
                </ul>
            </div>
            
            <h4>Данные о заказе</h4>
            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID</th>
                    <th>Дата создания</th>
                    <th>Дата оплаты</th>
                    <th>Id пользователя</th>
                    <th>Имя покупателя</th>
                    <th>Телефон</th>
                    <th>Комментарий</th>
                    <th>Сумма заказа</th>
                    <th>Статус</th>
                    
                </tr>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['date_created']; ?></td>
                    <td><?php echo $order['date_payment']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['username']; ?></td>
                    <td><?php echo $order['userphone']; ?></td>
                    <td><?php echo $order['comment']; ?></td>
                    <td><?php echo $order['total']; ?></td>
                    <td><?php echo Order::getStatusDescription($order['status']); ?></td>
                </tr>
            </table>
            
            <h4>Товары заказа</h4>
            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>Id товара</th>
                    <th>Артикул</th>
                    <th>Название товара</th>
                    <th>Цена за единицу</th>
                    <th>Количество</th>
                </tr>
                <?php foreach($orderItems as $item) { ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['code']; ?></td>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['count']; ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';


