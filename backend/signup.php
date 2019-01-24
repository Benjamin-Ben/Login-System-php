<?php
if(isset($_POST['submit'])){
    require('dbh.php');

    //Data users put in
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $u_email = mysqli_real_escape_string($conn, $_POST['u_email']);
    $u_username = mysqli_real_escape_string($conn, $_POST['u_username']);
    $u_password = mysqli_real_escape_string($conn, $_POST['u_password']);

    //If fields are empty
    if(empty($firstname) || empty($lastname) || empty($u_email) || empty($u_username) || empty($u_password)){
        header("Location: ../index.php?signup=empty_fields");
        exit();
    } else {
        //If firstname and lastname is valid
        if(!preg_match("/^[a-zA-Z]*$/", $firstname) || !preg_match("/^[a-zA-Z]*$/", $lastname)){
            header("Location: ../index.php?signup=invalid_name");
            exit();
        } else {
            //if email is invalid
            if(!filter_var($u_email, FILTER_VALIDATE_EMAIL)){
                header("Location: ../index.php?signup=invalid_email");
                exit();
            } else {
                //code for username check
                $sql = "SELECT * FROM users WHERE u_username='$u_username'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);

                //if username is taken
                if($resultCheck > 0){
                    header("Location: ../index.php?signup=username_taken");
                    exit();
                } else {
                    //hashing the password
                    if(strlen($u_password) < 5){
                        header("Location: ../index.php?signup=short_password_5");
                        exit();
                    } else {
                        //hashing the password
                        $hashedPassword = password_hash($u_password, PASSWORD_DEFAULT);

                        //Put the user into the database 
                        $sql = "INSERT INTO users (firstname, lastname, u_email, u_username, u_password) 
                        VALUES ('$firstname', '$lastname', '$u_email', '$u_username', '$hashedPassword')";
                        mysqli_query($conn, $sql);

                        header("Location: ../index.php?signup=SUCCESS");
                        exit();
                    }
                }
            }
        }
    }
    
} else {
    header("Location: ../index.php?signup=ERROR");
    exit();
}