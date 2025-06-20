<?php
    session_start();

    if(!isset($_SESSION['user_id'])){
        header('location:../');
    }
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
  <title>E-voting - Voting Panel</title>
  <link rel="stylesheet" href="../resources/Bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../resources/css/stylesheet.css">
    <script src="../resources/Jquery/jquery-3.5.1.js"></script>
    <script src="../resources/Bootstrap/js/bootstrap.min.js"></script>
    <script src="../resources/js/sweetalert.min.js"></script>
</head>

<body>

<div id="headerSection" class="sticky-top">
    <div class="container" >
        <div class="row align-items-center">
            <div class="col-md-10 text-center pt-3">
                <p id="brand">Online Voting System</p>
            </div>
            <div class="col-md-2 text-center ">
                <h5><a style="color:white; text-decoration:none" href="logout.php">Logout <i class="fa fa-user-circle"></i></a></h5>
            </div>
        </div>
    </div>
</div>

<div id="bodySection">
    <div class="container">
        <div class="row py-4">
            <div class="col-md-4 py-1">
                <div id="infoSection" style="padding: 5px;border: 1px solid #6ab04c;background-color: white; border-radius: 10px;">
                    <div id="getLogo" class="text-center pt-2"></div>
                    <div id="info"></div>
                </div>
            </div>
            <div class="col-md-8 py-1"> 
                    <div id="groupArea" style="padding: 5px;border: 1px solid #6ab04c;background-color: white; border-radius: 10px;">
                        <div id="groupSection">
                            <div id="group" style="display:none" class="p-1"></div>
                        </div>
                        <div id="codeArea" style="display:none">
                            <div id="loadingIcon" style="display:none" class="py-3">
                                <center>
                                    <div id="loadSpinner" class="spinner-border text-success" role="status">
                                    <span class="sr-only">Loading...</span>
                                    </div>
                                </center>
                            </div>
                           
                            <div id="getCodeBtn" class="py-3">
                            <center>
                            <button id="getCode" type="button" class="btn btn-success">Get Code</button>
                            </center>
                            </div>
                            <form>
                                <div class="form-row pl-3 text-center">
                                        <div class="form-group col-md-10">
                                            <input type="text" id="verifyCode" class="form-control" placeholder="Enter Code">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button class="btn btn-success" type="button" id="submitVote">Verify</button>            
                                        </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function(){

        $(document).ajaxStart(function(){
            $("#loadingIcon").show();
            $("#getCodeBtn").hide();

        });
        $(document).ajaxComplete(function(){
            $("#loadingIcon").hide();
            $("#getCodeBtn").show();
        });

        getData();
        getLogo();

        $("#getCode").click(function(){
            $.ajax({
            url : '../api/verify.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 1,
                id : <?php echo $_SESSION['user_id'] ?>,
            }),
            success : function(data){
                if(data==1){
                    getData();
                    $("#getCodeBtn").html('<center><p style="color:green">Verification code is sent to email!</p>')
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

        $("#submitVote").click(function(){

            if($("#verifyCode").val()==''){
                swal({
                        title: "Enter Verification code!",
                        text: "Verification code cannot be blank!",
                        icon: "error",
                        button: "OK!",
                    }); 
            }

            else
            {
                $.ajax({
                url : '../api/verify.php',
                type : 'POST',
                dataType : 'json',
                contentType : 'application/json',
                data : JSON.stringify({
                    call : 2,
                    code : $("#verifyCode").val(),
                    id : <?php echo $_SESSION['user_id'] ?>,
                }),
                success : function(data){
                    if(data==1){
                        getData();
                        $("#verifyCode").val('');
                        swal({
                                title: "You are verified for voting!",
                                text: "Now you can vote for your best ones!",
                                icon: "success",
                                button: "OK!",
                        });
                    }
                    else{
                        swal({
                                title: "Invalid verification code!",
                                text: "Enter proper code!",
                                icon: "error",
                                button: "OK!",
                        });
                    }
                }
                });
            }
            
        });

    });

    function yesVote(v_id, c_id, votes){
        var v_id = v_id;
        var c_id = c_id;
        var votes = parseInt(votes)+1;
        
        swal({
            title: 'Are you sure?',
            text: "Once you voted you won't be able to vote again!",
            icon: "warning",
            buttons: ['Cancel', 'Confirm'],
            dangerMode: true,
            })
            .then((vote) => {
            if (vote) {
                voteDone(v_id, c_id, votes);
            } else {
                swal("Think again and vote for best one!");
            }
        });
    }

    function voteDone(v_id, c_id, votes){

        $.ajax({
            url : '../api/vote.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 1,
                votes : votes,
                c_id : c_id,
                v_id : v_id,
            }),
            success : function(data){
                if(data==1){
                    swal({
                            title: "Thank You!",
                            text: 'Your vote is successfull',
                            icon: "success",
                            button: "OK!",
                    });
                    getData();
                    
                }
                else{
                    swal({
                            title: "Vote already given!",
                            text: "You cannot vote twice to same person!",
                            icon: "error",
                            button: "OK!",
                    });
                }
            }
        });
    }


    function getData(){
        var id = <?php echo $_SESSION['user_id'] ?>;
        $.ajax({
            url : '../api/api.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 2,
                id : id,
            }),
            success : function(data){
                var voter = data[0];
                var groupsArray = data[1];
                var groupsInfo = '';
                var status = (voter.status==1) ? '<b style="color:green">Voted</b>' : '<b style="color:red">Not Voted</b>';


                if(voter.is_verified==1 && voter.status==0){
                    $("#codeArea").html('<center><h4 style="color:green">You are verified!</h4></center>');
                    $("#codeArea").show();
                }
                else if(voter.is_verified==0 && voter.status==0){
                    $("#codeArea").show();
                }
                else{
                    $("#codeArea").html('<center><h4 style="color:green">Thank you!</h4></center>');
                    $("#codeArea").show();
                }

                if(groupsArray.length==0){
                    $("#groupArea").html('<br><div class="text-center"><h5>No data available</h5><br><p>List will be soon available here!</p><img height="150" width="150" src="../uploads/smile.png"></div><br>');
                    $("#groupArea").show();
                }
                else{
                    $.each(groupsArray, function(i, d){
                                    var yesBtn = (voter.status==0  && voter.is_verified==1) ? '<button type="button" class="btn btn-success" onclick="yesVote(\''+voter.id+'\',\''+d.id+'\',\''+d.votes+'\')" >Vote</button>' : '<button class="btn btn-success" disabled>Vote</button>' ;
                                    i++;
                                groupsInfo+='<div class="text-center" style="border:1px solid black;background-color: #f1f2f6; margin-bottom:10px; padding:10px; border-radius:10px">'+
                                                '<form>'+
                                                    '<div class="form-row align-items-center">'+
                                                        '<div class="form-group col-sm-1"><b>'+i+'</b></div>'+
                                                        '<div class="form-group col-sm-5"><b>'+d.position+'</b><br><b>( '+d.name+' )</b></div>'+
                                                        '<div class="form-group col-sm-3"><img src="../uploads/'+d.image+'" height="60" width="60"></div>'+
                                                        '<div class="form-group col-sm-3">'+yesBtn+'</div>'+
                                                    '</div>'+
                                                '</form>'+
                                            '</div>';
                               
                            }); 
                            $("#group").html(groupsInfo);
                            $("#group").show();
                            $("#codeArea").show();
                }

                
                var voterInfo = '<center><h5 style="color:green" class="py-3">'+voter.name+'</h5></center>'+
                            '<form>'+
                                '<div class="form-row px-3">'+
                                    '<div class="form-group col-3"><b>Mobile</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.mobile+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row px-3">'+
                                    '<div class="form-group col-3"><b>Address</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.address+
                                        '</div>'+
                                '</div>'+
                                '<div class="form-row px-3">'+
                                    '<div class="form-group col-3"><b>D.O.B.</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                        +voter.dob+
                                        '</div>'+
                                '</div>'+                             
                                '<div class="form-row px-3">'+
                                    '<div class="form-group col-3"><b>Status</b></div>'+
                                    '<div class="form-group col-1">:</div>'+
                                        '<div class="form-group col-8">'
                                           +status+ 
                                        '</div>'+
                                '</div>'+ 
                            '</form>';

                                    
                            
                $("#info").html(voterInfo);
                            
             }
            
        });
    }

    function getLogo(){
        $.ajax({
            url : '../api/api.php',
            type : 'POST',
            dataType : 'json',
            contentType : 'application/json',
            data : JSON.stringify({
                call : 14
            }),
            success : function(data){
                $("#getLogo").html('<img height="70" width="70" src="../uploads/'+data.logo+'">');
            }
            
        });
    }
</script>

</body>

</html>