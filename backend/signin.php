<?php
session_start();

if(isset($_POST['submit'])){
    require('dbh.php');

    //Inputs data
    $u_username = mysqli_real_escape_string($conn, $_POST['u_username']);
    $u_password = mysqli_real_escape_string($conn, $_POST['u_password']);

    if(empty($u_username) || empty($u_password)){
        header("Location: ../index.php?signin=ERROR");
        exit();
    } else {
        //code for checking username
        $sql = "SELECT * FROM users WHERE u_username='$u_username' OR u_email='$u_username'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        //Checking if the username doesn't exist
        if($resultCheck < 1){
            header("Location: ../index.php?signin=ERROR");
            exit();
        } else {
            if($row = mysqli_fetch_assoc($result)){
                //De-hashing the password
                $hashPasswordCheck = password_verify($u_password, $row['u_password']);

                //Checking if the password is correct or incorrect
                if($hashPasswordCheck == false){
                    header("Location: ../index.php?signin=ERROR");
                    exit();
                } elseif($hashPasswordCheck == true){
                    //LOG IN THE USER
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['firstname'] = $row['firstname'];
                    $_SESSION['lastname'] = $row['lastname'];
                    $_SESSION['u_email'] = $row['u_email'];
                    $_SESSION['u_username'] = $row['u_username'];

                    header("Location: ../index.php?signin=SUCCESS");
                    exit();
                }
            }
        }
    }

} else {
    header("Location: ../index.php?signin=ERROR");
    exit();
}