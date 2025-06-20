<?php
    session_start();
    include('connection.php');
    $json = json_decode(file_get_contents("php://input"),true);
    
    // Check login
    if($json['call'] == 10){
        
        $pid = $json['id'];
        $pass = $json['pass'];

        $id = 1234;
        $password = 'lion';

        if( $id==$pid && $pass==$password){
            $_SESSION['admin_id'] = $id;
            echo json_encode($response['success'] = 1);
        }
        else{
            echo json_encode($response['success'] = 0);
        }

    }

    if($json['call'] == 11){
        
        $random = mt_rand(100000,999999);
        $insert = mysqli_query($con, "insert into verify (code) values('$random')");
        echo json_encode($random);
       
    }

?>