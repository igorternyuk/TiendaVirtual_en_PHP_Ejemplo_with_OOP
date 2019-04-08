<?php include_once(ROOT."/views/layouts/header.php"); ?>

<section>
            <div class="container">
                <div class="row">
                    <div class="row">
                    <div class="col-sm-3">
                        <div class="left-sidebar">
                            <h2>Каталог</h2>
                            <div class="panel-group category-products">
                                <?php foreach ($categories as $category) { ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="/catalog/<?php echo $category['id']; ?>"
                                               <?php if($category['id'] == $product['category_id']){
                                                   echo "class= 'active'";
                                                } ?>
                                               >
                                                <?php echo $category['name']; ?>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                                <?php } ?>                                
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        <div class="product-details"><!--product-details-->
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="view-product">
                                        <img src="<?php echo $product['image'] ? PathToProductImages.$product['image'] : PathToProductImages.NoImage; ?>" alt="" />
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="product-information"><!--/product-information-->
                                        <img src="/template/images/product-details/new.jpg" class="newarrival" alt="" />
                                        <h2><?php echo $product['name']; ?></h2>
                                        <p>Код товара: <?php echo $product['code']; ?></p>
                                        <span>
                                            <span>US $<?php echo $product['price']; ?></span>
                                            <label>Количество:</label>
                                            <input type="text" value="<?php echo $product['available']; ?>" />
                                            <button type="button" class="btn btn-fefault cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                В корзину
                                            </button>
                                        </span>
                                        <p><b>Наличие:</b>
                                            <?php
                                                if($product['status']){
                                                    echo "Есть на складе";
                                                } else {
                                                    echo "Нет в наличии";
                                                }                                        
                                            ?>
                                        </p>
                                        <p><b>Состояние:</b>
                                            <?php if($product['is_new']) {
                                                    echo "Новое";
                                                } else {
                                                    echo "Старое";
                                                }
                                            ?>
                                        </p>
                                        <p><b>Производитель:</b> <?php echo $product['brand']; ?></p>
                                    </div><!--/product-information-->
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-sm-12">
                                    <h5>Описание товара</h5>
                                    <p><?php echo $product['description']; ?></p>
                                    
                                </div>
                            </div>
                        </div><!--/product-details-->

                    </div>
                </div>
            </div>
        </section>
        

        <br/>
        <br/>
        
<?php include_once(ROOT."/views/layouts/footer.php");