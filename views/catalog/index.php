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
                                
                                <?php } unset($cat);?>                                
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">Последние товары</h2>
                            <?php foreach ($products as $product) {?>
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <a href="/product/<?php echo $product['id']; ?>">
                                                <img src="/template/images/home/product1.jpg" alt="" />
                                            </a>
                                            <h2><?php echo "$".$product['price']; ?></h2>
                                            <p>
                                                <a href="/product/<?php echo $product['id']; ?>">
                                                <?php echo $product['name']; ?>
                                                </a>
                                            </p>
                                            <a href="#" productId="<?php echo $product['id']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В корзину</a>
                                        </div>
                                        <?php if($product['is_new']) { ?>
                                            <img src="/template/images/home/new.png" class="new" alt="" />
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                        </div><!--features_items-->                       

                    </div>
                </div>
            </div>
        </section>
<?php include_once(ROOT."/views/layouts/footer.php");

