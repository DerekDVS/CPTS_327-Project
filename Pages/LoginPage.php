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
 
<body>
    <!--Insert Page Navigation-->
    <?php pageNavigation(); ?>

    <!-- Sets form vars -->
    <?php include '../php/Login.php' ?>

    <!-- User Login Text -->
    <div class="login-form">
        <h1>Login</h1>
        <form method = "POST">
            <div class="content">
                <!-- Username -->
                <div class="input-field">
                    <input type="text" placeholder="Username" name="account_username" value="<?php echo $account_username; ?>"> 
                    <span class="error"><?php echo $account_username_error ?></span> 
                </div>             
                <!-- Password -->
                <div class="input-field">
                    <input type="text" placeholder="Password" name="account_password" value="<?php echo $account_password; ?>">               
                    <span class="error"><?php echo $account_password_error ?></span>
                </div> 
            </div>
            <!-- Submission -->
            <div class="action">
                <input class="userInput" type="submit" value="Submit">               
            </div>
        </form>
    </div>

    <!-- User Display Section -->
    <section class="section">
        <div class="display-class">
            <?php
                displayUsers($_SESSION['conn']);
            ?> 
        </div>
    </section>

    <!--Insert Page Footer-->
    <?php pageFooter(); ?>
</body>
</html>