<?php include_once(ROOT."/views/layouts/header.php"); ?>
    
<div class="container">
    <div class="row">
        <h1>Кабинет пользователя</h1>
        <h4><?php echo "Мы приветствуем Вас на нашем сайте уважаемый, "
                    . $user['name']."!<br />"; ?></h4>
        <ul>
            <li><a href="/user/edit">Редактировать данные</a></li>
            <li><a href="/user/history">Список покупок</a></li>
        </ul>
    </div>
</div>

<?php include_once(ROOT."/views/layouts/footer.php");