<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <br/>

            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="/admin">Админпанель</a></li>
                    <li><a href="/admin/category">Управление заказами</a></li>
                    <li class="active">Редактировать заказ</li>
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
            <?php } ?>
            
            <div class="col-lg-4">
                <div class="login-form">
                    <form action="/admin/order/update/<?php echo $order['id']; ?>" method="post">
                        <p>ID категории</p>
                        <input type="text" name="orderId" value="<?php echo $order['id']; ?>" readonly />
                        <br />
                        <p>Дата создания</p>
                        <input type="text" name="orderDateCreated" value="<?php echo $order['date_created']; ?>" readonly />
                        <br />
                        <p>Дата оплаты</p>
                        <input type="text" name="orderDatePayment" value="<?php echo $order['date_payment']; ?>"/>
                        <br />
                        <p>Id пользователя</p>
                        <input type="text" name="orderUserId" value="<?php echo $order['user_id']; ?>" readonly />
                        <br />
                        <p>Имя пользователя</p>
                        <input type="text" name="orderUsername" value="<?php echo $order['username']; ?>" />
                        <br />
                        <p>Телефон пользователя</p>
                        <input type="text" name="orderUserphone" value="<?php echo $order['userphone']; ?>" />
                        <br />
                        <p>Комментарий заказа</p>
                        <input type="text" name="orderComment" value="<?php echo $order['comment']; ?>" />
                        <br />
                        <p>Сумма заказа</p>
                        <input type="text" name="orderTotalSum" value="<?php echo $order['total']; ?>" readonly />
                        <br />
                        <p>Статус</p>
                        <select name="orderStatus">
                            <?php foreach( OrderStatus as $key => $val ) {?>
                                <option value="<?php echo $key; ?>" ><?php echo $val; ?></option>
                            <?php } ?>
                        </select>
                        <br /><br />                        
                        <input type="submit" name="btnUpdateOrder" class="btn btn-default" value="Сохранить">
                    </form>
                </div>
            </div>   
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';