<?php include_once(ROOT."/views/layouts/header.php"); ?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Каталог</h2>
                    <div class="panel-group category-products">
                        <?php foreach ($categories as $cat) { ?>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a href="/catalog/<?php echo $cat['id']; ?>">
                                        <?php echo $cat['name'] . "(" . $cat['total'] . ")"; ?>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <?php } unset($cat); ?>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Список заказов</h2>
                    <?php if($userOrders) { ?>
                        <table class="table-bordered table-striped table">
                            <tr>
                                <th>Id</th>
                                <th>Дата создания</th>
                                <th>Дата платежа</th>
                                <th>Id клиента</th>
                                <th>Имя клиента</th>
                                <th>Телефон клиента</th>
                                <th>Сумма заказа</th>
                                <th>Комментарий</th>
                                <th>Статус</th>
                                <th>Действие</th>
                            </tr>
                            <?php
                            unset($order);
                            foreach($userOrders as $order) { ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['date_created']; ?></td>
                                <td><?php echo $order['date_payment']; ?></td>
                                <td><?php echo $order['user_id']; ?></td>
                                <td><?php echo $order['username']; ?></td>
                                <td><?php echo $order['userphone']; ?></td>
                                <td><?php echo "$".$order['total']; ?></td>
                                <td><?php echo $order['comment']; ?></td>
                                <td><?php echo $order['status'] == 0 ? "Не оплачен" : "Оплачен"; ?></td>
                                <td><a id="toggleProduct_<?php echo $order['id'];?>" href="#" onclick="toggleOrderProductsView(<?php echo $order['id'];?>); return false;">Показать товары заказа</a></td>
                            </tr>
                            <tr id="orderProducts_<?php echo $order['id']; ?>" class="hideme">
                                <td colspan="10">
                                    <table class="table-bordered table-striped table">
                                        <tr>
                                            <th>Название товара</th>
                                            <th>Код товара товара</th>
                                            <th>Цена за единицу</th>
                                            <th>Количество</th>
                                            <th>Стоимость</th>                                            
                                        </tr>
                                        <?php
                                        $products = $order['items'];
                                        foreach($products as $product) { ?>
                                        <tr>
                                            <td><a href="/product/<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a></td>
                                            <td><?php echo $product['code']; ?></td>
                                            <td><?php echo "$".$product['price']; ?></td>
                                            <td><?php echo $product['count']; ?></td>
                                            <td><?php echo "$".($product['price'] * $product['count']); ?></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                    
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    <a href="/cabinet">Назад</a>
                    <?php } else { ?>
                        <p>Нет заказов</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once(ROOT."/views/layouts/footer.php");

