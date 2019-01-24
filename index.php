<?php
    session_start();
?>

<form action="backend/signup.php" method="POST">
    <legend>Sign Up!</legend>
    <input type="text" name="firstname" placeholder="Firstname"><br>
    <input type="text" name="lastname" placeholder="Lastname"><br>
    <input type="text" name="u_email" placeholder="E-mail"><br>
    <input type="text" name="u_username" placeholder="Username"><br>
    <input type="password" name="u_password" placeholder="Password"><br>
    <input type="submit" name="submit" value="Sign Up">
</form>

<br><br>

<form action="backend/signin.php" method="POST">
    <legend>Sign In!</legend>
    <input type="text" name="u_username" placeholder="Username or E-mail"><br>
    <input type="password" name="u_password" placeholder="Password"><br>
    <input type="submit" name="submit" value="Sign In">
</form>

<br>

<?php
    if(isset($_SESSION['u_username'])){
        echo "You are logged in as: ".$_SESSION['u_username'];
    } else {
        echo "YOU ARE NOT LOGGED IN!!!";
    }
?>


<br><br>

<form action="backend/signout.php" method="POST">
    <input type="submit" name="submit" value="Log out">
</form>
