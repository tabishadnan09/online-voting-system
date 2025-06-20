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
  <title>E-Voting - Home</title>
  <link rel="stylesheet" href="resources/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="resources/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="resources/css/stylesheet.css">
    <script src="resources/Jquery/jquery-3.5.1.js"></script>
    <script src="resources/Bootstrap/js/bootstrap.min.js"></script>
    <script src="resources/js/sweetalert.min.js"></script>
</head>

<body>

<?php
    include('routes/header.php');
?>

<div id="bodySection">
    <div class="container">
        <div class="row py-4 align-items-center">
            <div class="col-md-7 text-center pb-3">
            <h3 >Welcome to Online Voting</h3><br>
            <div id="getData">
            </div>
            </div>
            <div class="col-md-5 text-center">
                <div id="loginSection" class="text-center">
                    <h4><i class="fa fa-user-circle fa-3x" style="color:#27ae60"></i></h4>
                    <form>
                        <div class="form-row py-1 mx-4">
                            <div class="form-group col-md-12">
                            <input type="text" id="mobile" class="form-control" placeholder="Mobile No">
                            </div>
                        </div>
                        <div class="form-row pt-1 mx-4">
                            <div class="form-group col-md-12">
                            <input id="pass" type="password" class="form-control" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                            Forget password? <a href="routes/forget_pass.php">Click here</a>
                            </div>
                        </div>

                        
                    
                        <div class="form-row py-1 mx-4">
                            <div class="form-group col-md-12">
                            <input type="button" onclick="loginFun()" id="loginbtn" class="form-control btn btn-success" value="Login">
                            </div>
                        </div>
                        <div class="form-row py-1">
                            <div class="form-group col-md-12">
                                <h5>Not registered? <a href="routes/register.php">Register here</a></h5>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <div class="row py-1" id="pArea">
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){
        getData();
    });

    // function keyFun(){
    //     var input = document.getElementById("pass");
    //     input.addEventListener("keyup", function(event) {
    //         if (event.keyCode === 13) {
    //             event.preventDefault();
    //             loginFun();
    //         }
    //      });
    // }

    function getData(){
        $.ajax({
            url : 'api/api.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 14
            }),
            success : function(data){
                $("#getData").html('<img src="uploads/'+data.logo+'" style="border-radius:10px" height="200" width="300"><br><br><h5 id="titleText">'+data.text+'</h5>');
                
            }
            
        });
    }

    function loginFun(){
        var mobile = $("#mobile").val();
        var pass = $("#pass").val();

        $.ajax({
            url : 'api/api.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 1,
                mobile : mobile,
                pass : pass,
            }),
            success : function(data){
                if(data==0){
                    swal({
                            title: "Invalid Credentials!",
                            text: "Mobile or Password is invalid!",
                            icon: "error",
                            button: "OK!",
                    });
                }
                else{
                   window.location = 'routes/main.php';
                }
            }
            
        });
    }

 
</script>

</body>

</html>