<?php
    session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
    crossorigin="anonymous">
  <title>E-voting - Registration</title>
  <link rel="stylesheet" href="../resources/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../resources/css/stylesheet.css">
    <link rel="stylesheet" href="../resources/Jquery/jquery-ui.css">
    <script src="../resources/Jquery/jquery-3.5.1.js"></script>
    <script src="../resources/Jquery/jquery-ui.js"></script>
    <script src="../resources/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../resources/js/sweetalert.min.js"></script>
</head>

<body>

<?php
    include('header.php');
?>

<div id="bodySection">
    <div class="container">
        <div class="row align-items-center pt-3 text-center">
            <div class="col-md-1"><div id="getData"></div></div>
            <div class="col-md-11"><h4>Registration</h4></div>
        </div>
        <div class="row py-4">
            <div class="col-md-12">
                <div id="regSection" class="text-center">
                    <form id="regForm" enctype="multipart/form-data">
                        <div class="form-row py-1">
                            <div class="form-group col-md-4">
                                <input name="name" type="text" maxlength="10" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input name="email" type="email" class="form-control" placeholder="Email " required>
                            </div>
                            <div class="form-group col-md-4">
                                <input name="mobile" type="number" class="form-control" placeholder="Mobile" required>
                            </div>
                        </div>
                        <div class="form-row py-1">
                            <div class="form-group col-md-4">
                            <input name="dob" id="datepicker" type="text" class="form-control" placeholder="Birth Date" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input name="pass" type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input name="cpass" type="password" class="form-control" placeholder="Confirm password" required>
                            </div>
                        </div>
                        <div class="form-row py-1">
                        <div class="form-group col-md-8">
                            <input name="address" type="text" class="form-control" placeholder="Address" required>
                        </div>
                        <div class="form-group col-md-4">
                            <input name="vcode" type="text" class="form-control" placeholder="Verification code" required>
                        </div>
                        </div>
                        <div class="form-row py-1">
                            <div class="form-group col-md-3"></div>
                            <div class="form-group col-md-6">
                            <input type="submit" class="form-control btn btn-success" id="btnn" name="regbtn" value="Register">
                            </div>
                            <div class="form-group col-md-3"></div>
                        </div>
                    </form>
                    <a href="../"><button type="button" class="btn btn-primary">Back</button></a>

                </div>
            </div>
        </div>
        <div class="row py-1" id="pArea">
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){

        getData();
        
        $("#datepicker").datepicker({
        maxDate : 0,
        changeMonth : true,
        changeYear : true,
        yearRange : "1950:2020"
        });

        $("#regForm").on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url : '../api/register.php',
                type : 'POST',
                data : new FormData(this),
                contentType : false,
                cache : false,
                processData : false,
                success : function(data){
                    if(data == 1){
                        swal({
                            title: "Registration successfull!",
                            text: "You are registered on Online voting panel!",
                            icon: "success",
                            button: "OK!",
                    }).then((value)=>{
                        window.location = '../';
                    });
                    }
                    else if(data==3){
                        swal({
                            title: "Passwords do not match!",
                            text: "Password and Confirm password does not match!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                    else if(data==4){
                        swal({
                            title: "User already exists!",
                            text: "Mobile number is already taken. Try another!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                    else if(data==5){
                        swal({
                            title: "Invalid Mobile No!",
                            text: "Only 10 digits required!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                    else if(data==6){
                        swal({
                            title: "Verification code is not available!",
                            text: "Get verification code from Admin!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                    else{
                        swal({
                            title: "Error!",
                            text: "Some error occured!",
                            icon: "error",
                            button: "OK!",
                    });
                    }
                }
            });
        });
    });

    
    function getData(){
        $.ajax({
            url : '../api/api.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 14
            }),
            success : function(data){
                $("#getData").html('<img height="50" width="50" src="../uploads/'+data.logo+'">');
            }
            
        });
    }

</script>

</body>

</html>