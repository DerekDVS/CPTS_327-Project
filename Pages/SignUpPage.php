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
    <?php include "../php/SignUp.php"?>
    
    <!-- User Creation Section --->
    <div class="signUp-form">
        <h1>Create Profile</h1>

        <!-- User Input for the form -->
        <form class="userInput" method = "post">
            <!-- User Creation Text -->
            <div class="content">
                <!-- Username -->
                <div class="input-field">
                    <label>Username</label>
                    <input type="text" placeholder="Username" name="account_username" value="<?php echo $account_username; ?>"> 
                    <span class="error"><?php echo $account_username_error ?></span>              
                </div>
                <!-- Password -->
                <div class="input-field">
                    <label>Password</label>
                    <input type="text" placeholder="Password" name="account_password" value="<?php echo $account_password; ?>">               
                    <span class="error"><?php echo $account_password_error ?></span> 
                </div>
                <!-- Firstname -->
                <div class="input-field">
                    <label>Firstname</label>
                    <input type="text" placeholder="Firstname" name="account_firstname" value="<?php echo $account_firstname; ?>">               
                    <span class="error"><?php echo $account_firstname_error ?></span> 
                </div>
                <!-- Lastname -->
                <div class="input-field">
                    <label>Lastname</label>
                    <input type="text" placeholder="Lastname" name="account_lastname" value="<?php echo $account_lastname; ?>">               
                    <span class="error"><?php echo $account_lastname_error ?></span> 
                    <span class="error"><?php echo $account_duplicate_error ?></span>
                </div>
                <!-- email -->
                <div class="input-field">
                    <label>Email</label>
                    <input type="text" placeholder="Email" name="account_email" value="<?php echo $account_email; ?>">               
                    <span class="error"><?php echo $account_email_error ?></span>
                </div>
            </div>
            <!-- Submission -->
            <div class="action">
                <input type="submit" name="Submit" value="Submit">               
            </div>
        </form>
    </div>

    <!--Insert Page Footer-->
    <?php pageFooter(); ?>
</body>
</html>