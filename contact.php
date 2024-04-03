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
    .container {
        min-height: 90vh;
    }

    img {
        width: 100%;
        height: 500px;
    }

    .content {
        background-color: black;
        color: white;
        padding-top: 5px;
        padding-bottom: 10px;
        padding-left: 15px;
        padding-right: 15px;
        border-bottom-right-radius: 30px;
        border-top-left-radius: 30px;
    }
    </style>
</head>

<body>
    <?php include("partials/_dbconnect.php")?>
    <?php include("partials/_header.php")?>
    <?php
    $showAlert=false;
    $method= $_SERVER['REQUEST_METHOD'];
    if ($method=='POST') {
        // Insert into thread db
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $phone_number=$_POST['pno'];
        $address=$_POST['address'];
        $city=$_POST['city'];
        $state=$_POST['state'];
        $pincode=$_POST['pinno'];
        
        $sql="INSERT INTO `contact`(`fname`, `lname`, `email`, `pnumber`, `address`, `city`, `state`, `pincode`, `timestamp`) VALUES ('$fname','$lname','$email','$phone_number','$address','$city','$state','$pincode',current_timestamp())";
        $showAlert=true;
        $result=mysqli_query($conn,$sql);
        if ($showAlert) {
            echo'<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>SUCCESS!</strong> You details has been successfuly added! We are contact you as soon as possible.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
        }
    }
    ?>
    <?php
    echo '<div class="container">
        <img class="my-3" src="https://wallpaperaccess.com/full/3124518.jpg" alt="image of contact us">
        <div class="content text-center my-2">
            <h2 class="my-3">Contact Us</h2>
            <form action= '.$_SERVER["REQUEST_URI"].' method="post">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">First name</label>
                        <input type="text" class="form-control" id="inputEmail4" name="fname" placeholder="Enter your first name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Last name</label>
                        <input type="text" class="form-control" id="inputPassword4" name="lname" placeholder="Enter your last name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Email</label>
                    <input type="email" class="form-control" id="inputAddress" name="email" placeholder="Enter your email-id">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Phone number</label>
                    <input type="text" class="form-control" id="inputAddress" name="pno" placeholder="Enter your phone number">
                </div>
                <div class="form-group">
                    <label for="inputAddress2">Address</label>
                    <input type="text" class="form-control" id="inputAddress2" name="address"
                        placeholder="Enter your full address here">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputCity">City</label>
                        <input type="text" class="form-control" id="inputCity" name="city">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputState">State</label>
                        <select id="inputState" name="state" class="form-control">
                            <option selected>Choose...</option>
                            <option>...</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label for="inputZip">Pincode</label>
                        <input type="text" class="form-control" id="inputZip" name="pinno">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>';
    ?>
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