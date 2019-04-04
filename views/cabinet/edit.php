<?php include_once(ROOT."/views/layouts/header.php"); ?>

<section>
    <div class="container">
        <div class="col-sm-4 col-sm-offset-4 padding-right">
            <?php if(isset($res) && $res) { ?>
                <h4>Данные успешно обновлены</h4>
            <?php } else { ?>
                <?php if(isset($errors) and is_array($errors)) { ?>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                    <li>
                        <?php echo " - ". $error; ?>
                    </li>
                    <?php } ?>
                </ul>
                <?php } ?>
                <div class="signup-form">
                <h2>Редактирование данных пользователя</h2>
                <form action="#" method="post">
                    <input type="text" name="username" placeholder="Имя" value="<?php echo $username; ?>">
                    <input type="password" name="pwd1" placeholder="Введите новый пароль" value="">
                    <input type="password" name="pwd2" placeholder="Повторите новый пароль" value="">
                    <input type="password" name="currPassword" placeholder="Введите текущий пароль" required="required" value="">
                    <input type="submit" name="btnEdit" class="btn btn-default" value="Обновить данные">
                </form>
                <br />
                <br />
                </div>
            <?php } ?>
                        
        </div>
    </div>
</section>

<?php include_once(ROOT."/views/layouts/footer.php"); 
