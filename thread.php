<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>iDiscuss - Coding Forums</title>
    <style>
    img {
        width: 50px;
        height: 45px;
    }
    </style>
</head>

<body>
    <?php include("partials/_dbconnect.php")?>
    <?php include("partials/_header.php")?>
    <?php
    $id=$_GET["threadid"];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id";
    $result=mysqli_query($conn,$sql);
    while ($row=mysqli_fetch_assoc($result)) {
        $title=$row["thread_title"];
        $desc=$row["thread_desc"];
        $thread_user_id=$row["thread_user_id"];
        $sql1="SELECT user_email FROM `users` WHERE sno='$thread_user_id'";
        $result1=mysqli_query($conn,$sql1);
        $row1=mysqli_fetch_assoc($result1);
        $posted_by=$row1['user_email'];
    }
    ?>
    <?php
    $showAlert=false;
    $method= $_SERVER['REQUEST_METHOD'];
    if ($method=='POST') {
        // Insert into comment db
        $comment=$_POST['desc'];
        $comment=str_replace("<","&lt;",$comment);
        $comment=str_replace(">","&gt;",$comment);

        $sno=$_POST['sno'];
        $sno=str_replace("<","&lt;",$sno);
        $sno=str_replace(">","&gt;",$sno);
        
        $sql="INSERT INTO `comments`( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment','$id','$sno',current_timestamp())";
        $result=mysqli_query($conn,$sql);
        $showAlert=true;
        if ($showAlert) {
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SUCCESS!</strong> You comment has been added!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
    }
    ?>
    <div class="container my-4">
        <!-- using jumbotron -->
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"><?php echo $desc;?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum is for sharing knowledge with each other. No Spam / Advertising /
                Self-promote in the forums is not allowed. Warn About Adult Content.
                Do not spam.
                Do Not Bump Posts.
                Do Not Offer to Pay for Help.
                Do Not Offer to Work For Hire.
                Do Not Post About Commercial Products.
                Do Not Create Multiple Accounts (Sockpuppets)
                When creating links to other resources.</p>
            <p class="lead">
                <!-- <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a> -->
                Posted by <b><?php echo $posted_by;?></b>
            </p>
        </div>
    </div>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container my-3">
        <h1>Post a comment</h1>
        <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Type your comment</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" id="desc"
                    name="desc"></textarea>
                <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
            </div>
            <button type="submit" class="btn btn-success">Post comment</button>
        </form>
    </div>';
    }
    else {
        echo '<div class="container my-3">
        <h1>Post a comment</h1>
        <p class="lead">Please login to leave your Comment.</p>
        </div>';
    }
    ?>

    <div class="container my-3" style="min-height:400px;">
        <h1>Discussions</h1>
        <?php
        $id=$_GET["threadid"];
        $sql="SELECT * FROM `comments` WHERE thread_id=$id";
        $result=mysqli_query($conn,$sql);
        $noResult=true;
        while ($row=mysqli_fetch_assoc($result)) {
            $noResult=false;
            $content=$row["comment_content"];
            $id=$row["comment_id"];
            $comment_by=$row["comment_by"];
        $sql1="SELECT user_email FROM `users` WHERE sno='$comment_by'";
        $result1=mysqli_query($conn,$sql1);
        $row1=mysqli_fetch_assoc($result1);
        echo '<div class="media my-3">
        <img class="mr-3" src=https://st2.depositphotos.com/1104517/11967/v/950/depositphotos_119675554-stock-illustration-male-avatar-profile-picture-vector.jpg" alt="Generic placeholder image">
        <div class="media-body">
            <p class="font-weight-bold my-0">'.$row1["user_email"].'&nbsp; at &nbsp;'.$row["comment_time"].'</p>
            '.$content.'
        </div>
        </div>';
    }
    if ($noResult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Threads Found</p>
          <p class="lead">Be the first person to ask a question</p>
        </div>
      </div>';
    }
    ?>
        
    </div>
    <?php include("partials/_footer.php")?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
</body>

</html>