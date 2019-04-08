<table class="table-bordered table-striped table">
    <tr>
        <th><?php echo "ID"; ?></th>
        <th><?php echo "Артикул"; ?></th>
        <th><?php echo "Название"; ?></th>
        <th><?php echo "Цена"; ?></th>
        <th><?php echo "Редактировать"; ?></th>
        <th><?php echo "Удалить"; ?></th>
    </tr>
    <?php foreach($products as $product) : ?>
    <tr>
        <td><?php echo $product['id']; ?></td>
        <td><?php echo $product['code']; ?></td>
        <td><?php echo $product['name']; ?></td>
        <td><?php echo "$".$product['price']; ?></td>
        <td><a href="/admin/product/update/<?php echo $product['id']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
        <td><a href="/admin/product/remove/<?php echo $product['id']; ?>" title="Удалить"><i class="fa fa-times"></a></td>
    </tr>
    <?php endforeach; ?>
</table>