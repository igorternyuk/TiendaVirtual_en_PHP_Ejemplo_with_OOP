<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <br/>
            <div class="breadcrumbs">
                <ul class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a></li>
                    <li class="active">Управление товарами</li>
                </ul>
            </div>
            
            <a href="/admin/product/create" class="btn btn-default back"><i class="fa fa-plus"></i> Добавить товар</a>
            <br /><br />
            <form action="/admin/product/search/page-1" method="post">
                <div class="search_box">
                    <input id="searchPattern" name="searchPattern" type="text" placeholder="Поиск..." value="<?php if(isset($searchPattern)) { echo $searchPattern; }; ?>"/>                
                </div>
                <input type="submit" class="btn btn-default" name="btnSearch" value="Поиск" />
            </form>
            
            <?php if(isset($ok) && $ok) { ?>
                <h4>Товар успешно удален</h4>
            <?php } ?>
            <h4>Список товаров</h4>
            <div id="productTable">
                <table class="table-bordered table-striped table">
                <tr>
                    <th>ID</th>
                    <th>Артикул</th>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                </tr>
                <?php foreach($products as $product) { ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['code']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo "$".$product['price']; ?></td>
                    <td><a href="/admin/product/update/<?php echo $product['id']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
                    <td><a href="/admin/product/remove/<?php echo $product['id']; ?>" title="Удалить"><i class="fa fa-times"></a></td>
                </tr>
                <?php } ?>
                </table>
            <center><?php echo $pagination; ?></center>
            </div>
            
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';


