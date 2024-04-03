<?php
$showAlert="false";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $email=$_POST["loginEmail"];
    $pass=$_POST["loginpassword"];

    //check whether this email exists
    $existSql="SELECT * FROM `users` WHERE user_email='$email'";
    $result=mysqli_query($conn,$existSql);
    $numRows=mysqli_num_rows($result);
    if($numRows == 1){
        $row=mysqli_fetch_assoc($result);
        if (password_verify($pass,$row["user_password"])) {
            session_start();
            $_SESSION['loggedin'] = true; 
            $_SESSION['sno'] = $row['sno']; 
            $_SESSION['useremail'] = $email;
            
        }
        header("Location: /Forum/index.php"); 
    }
    header("Location: /Forum/index.php");
}
?>