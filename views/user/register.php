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
            
            <?php if($registered) { ?>
                <h4>Новый пользователь успешно зарегистрирован</h4>
            <?php } else { ?>
                <div class="signup-form">
                <h2>Регистрация на сайте</h2>
                <form action="#" method="post">
                    <input type="text" name="username" placeholder="login" required="required" value="<?php echo $username; ?>">
                    <input type="email" name="email" placeholder="email" required="required" value="<?php echo $email; ?>">
                    <input type="password" name="pwd1" placeholder="enter password" required="required" value="<?php echo $pwd1; ?>">
                    <input type="password" name="pwd2" placeholder="repeat password" required="required" value="<?php echo $pwd2; ?>">
                    <input type="submit" name="btnRegister" class="btn btn-default" value="Регистрация">
                </form>
                <br />
                <br />
                </div>
            <?php }?>
            
        </div>
    </div>
</section>

<?php include_once(ROOT."/views/layouts/footer.php"); 

