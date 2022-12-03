<!DOCTYPE html>
<html>

<?php
    // Common Page Elements that are echoed are used in this file
    include "../php/PageSetUp.php";
    // Server Connection and vital variables are stored here
    include '../php/ServerConnection.php';

    // create head file
    headElement();
?>
<!-- User Authentication Text -->
<body>
    <!--Insert Page Navigation-->
    <?php pageNavigation(); ?>

    <!-- Sets form vars -->
    <?php 
        include "../php/Authentication.php";
        $_SESSION['code'] = mt_rand(10000000,99999999);
        echo $_SESSION['code'];
    ?>    

    <div class="login-form">
        <h1>Authentication</h1>
        <form method = "POST">
            <div class="content">
                <!-- Security Token -->
                <div class="input-field">
                    <input type="text" placeholder="Security Code" name="account_security" value="<?php echo $account_security; ?>">               
                    <span class="error"><?php echo $account_security_error ?></span>
                </div>
            </div>
            <!-- Submission -->
            <div class="action">
                <input class="userInput" type="submit" value="Submit">               
            </div>
        </form>
    </div>

    <!--Insert Page Footer-->
    <?php pageFooter(); ?>
   
</body>
</html>