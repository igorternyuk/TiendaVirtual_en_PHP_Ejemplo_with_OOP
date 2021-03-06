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
                    <h2 class="title text-center">Товары в корзине</h2>
                    <?php if($productsInCart) { ?>
                        <table class="table-bordered table-striped table">
                            <tr>
                                <th>Код</th>
                                <th>Название</th>
                                <th>Цена за единицу</th>
                                <th>Количество</th>
                                <th>Действие</th>
                                <th>Стоимость</th>
                            </tr>
                            <?php foreach($products as $product) { ?>
                            <tr id="product_<?php echo $product['id']; ?>">
                                <td><?php echo $product['code']; ?></td>
                                <td>
                                    <p>
                                        <a href="/product/<?php echo $product['id']; ?>">
                                        <?php echo $product['name']; ?>
                                        </a>
                                    </p>
                                    
                                </td>
                                <td><?php echo "$".$product['price']; ?></td>
                                <td><input type="number" id="productCount_<?php echo $product['id']; ?>" min="1" max="<?php echo $product['available']; ?>" value="<?php echo $productsInCart[$product['id']]; ?>" onchange="changeProductCount(<?php echo $product['id']; ?>);"></td>
                                <td><a href="#" onclick="removeProduct(<?php echo $product['id']; ?>); return false;"><i class="fa fa-times"></i>Убрать из корзины</a></td>
                                <td><span id="subtotal_<?php echo $product['id']; ?>"><?php echo "$".($product['price'] * $productsInCart[$product['id']]); ?></span></td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5"><strong>Общая стоимость:</strong></td>
                                <td ><strong><span id="cartTotalSum"><?php echo "$".(Cart::calculateTotalSum()); ?></span></strong></td>
                            </tr>
                        </table>
                    <a href="/cart/checkout" id="btnCheckOut" class="btn btn-default" ><i class="fa fa-shopping-cart"></i>Оформить заказ</a>
                    <br /><br />
                    <?php } else { ?>
                        <p>Корзина пуста</p>
                        <br />
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once(ROOT."/views/layouts/footer.php");