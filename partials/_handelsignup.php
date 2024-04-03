<?php
$showError="false";
$showAlert="false";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email=$_POST["signupEmail"];
    $pass=$_POST["signuppassword"];
    $cpass=$_POST["signupcpassword"];

    //check whether this email exists
    $existSql="SELECT * FROM `users` WHERE user_email='$email'";
    $result=mysqli_query($conn,$existSql);
    $numRows=mysqli_num_rows($result);
    if($numRows > 0){
        $showError="Email already in use";
    }
    else{
        if($pass==$cpass){
            $hash=password_hash($pass, PASSWORD_DEFAULT);
            $sql="INSERT INTO `users`( `user_email`, `user_password`, `timestamp`) VALUES ('$email','$hash',current_timestamp())";
            $result=mysqli_query($conn,$sql);
            if ($result){
                $showAlert="true";
                header("Location: /Forum/index.php?signupsuccess=$showAlert");
                exit();
            }
        }
        else{
            $showError="Passwords do not match";
        }
    }
    header("Location: /Forum/index.php?signupsuccess=$showAlert&error=$showError");
}
?>