<?php include_once ROOT . '/views/layouts/admin_header.php'; ?>

<section>
    <div class="container">
        <div class="row">
            <br/>
            <div class="breadcrumbs">
                <ul class="breadcrumb">
                    <li><a href="/admin">Панель администратора</a></li>
                    <li class="active">Управление категориями</li>
                </ul>
            </div>
            
            <a href="/admin/category/create" class="btn btn-default back"><i class="fa fa-plus"></i> Добавить категорию</a>
            
            <?php if(isset($removedSuccessfully) && $removedSuccessfully) { ?>
                <h4>Категория успешно удалена</h4>
            <?php } ?>
            <h4>Список категорий</h4>
            
            <table class="table-bordered table-striped table">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Порядковый номер</th>
                    <th>Статус</th>
                </tr>
                <?php
                unset($category);
                foreach($categories as $category) { ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td><?php echo $category['name']; ?></td>
                    <td><?php echo $category['rating']; ?></td>
                    <td><?php echo $category['status'] == 1 ? "Отображается" : "Скрыта"; ?></td>
                    <td><a href="/admin/category/update/<?php echo $category['id']; ?>" title="Редактировать"><i class="fa fa-pencil-square-o"></i></a></td>
                    <td><a href="/admin/category/remove/<?php echo $category['id']; ?>" title="Удалить"><i class="fa fa-times"></a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</section>
<?php include_once ROOT . '/views/layouts/admin_footer.php';




