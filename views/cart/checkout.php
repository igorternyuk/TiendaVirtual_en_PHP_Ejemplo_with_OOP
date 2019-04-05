<?php include_once(ROOT."/views/layouts/header.php"); ?>
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
                    <h2 class="title text-center">Оформление заказа</h2>
                    
                    <?php if($result) { ?>
                        <p>Заказ оформлен.</p>
                    <?php } else { ?>
                        <div class="col-sm-4 col-sm-offset-2 padding-right">
                            <p>Выбрано <?php echo $cartTotalItems; ?> товаров на сумму <?php echo "$".$cartTotalSum."."; ?></p>
                            <?php if(isset($errors) and is_array($errors)) {?>
                            <ul>
                                <?php foreach ($errors as $error) { ?>
                                <li>
                                    <?php echo " - ". $error; ?>
                                </li>
                                <?php }?>
                            </ul>
                            <?php }?>

                            <div class="signup-form">
                                <h2>Заполните форму:</h2>
                                <form action="#" method="post">
                                    <input type="text" name="username" placeholder="Введите ваше имя" required="required" value="<?php echo $username; ?>">
                                    <input type="text" name="userphone" placeholder="Введите ваш телефон" required="required" value="<?php echo $userphone; ?>">
                                    <input type="text" name="usercomment" placeholder="Комментарий к заказу" value="<?php echo $usercomment; ?>">
                                    <input type="submit" name="btnCheckout" class="btn btn-default" value="Оформить заказ">
                                </form>
                                <br />
                                <br />
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>        
</div>

<?php include_once(ROOT."/views/layouts/footer.php");
