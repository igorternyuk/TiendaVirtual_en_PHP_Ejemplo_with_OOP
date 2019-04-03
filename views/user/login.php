<?php include_once(ROOT."/views/layouts/header.php"); ?>

<section>
    <div class="container">
        <div class="col-sm-4 col-sm-offset-4 padding-right">
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
                <h2>Авторизация на сайте</h2>
                <form action="#" method="post">
                    <input type="email" name="email" placeholder="Введите E-mail" required="required" value="<?php echo $email; ?>">
                    <input type="password" name="password" placeholder="Введите пароль" required="required" value="<?php echo $password; ?>">
                    <input type="submit" name="btnLogin" class="btn btn-default" value="Войти">
                </form>
                <br />
                <br />
            </div>
            
        </div>
    </div>
</section>

<?php include_once(ROOT."/views/layouts/footer.php"); 

