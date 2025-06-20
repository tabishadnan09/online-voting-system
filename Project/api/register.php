<?php
    include('connection.php');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $dob = $_POST['dob'];
        $pass = $_POST['pass'];
        $cpass = $_POST['cpass'];
        $address = $_POST['address'];
        $vcode = $_POST['vcode'];
        $date = date('d-m-Y');

        $check = mysqli_query($con, "select * from register where mobile='$mobile' ");
        $verify_code = mysqli_query($con, "select code from verify where code='$vcode' ");

        if($pass!==$cpass){
            echo json_encode($response['success'] = 3);        
        }
        else if(strlen($mobile)!=10){
            echo json_encode($response['success'] = 5);
        }
        else if(mysqli_num_rows($check)>0){
            echo json_encode($response['success'] = 4);
        }
        else if(!mysqli_num_rows($verify_code)==1){
            echo json_encode($response['success'] = 6);
        }
        else
        {
            $enc_pass = md5($pass);
            $enc_pass1 = sha1($enc_pass);
            $enc_pass2 = password_hash($enc_pass1, PASSWORD_DEFAULT);
            $query = mysqli_query($con, "insert into register (name, mobile, email, dob, password, address, status, created_at) values('$name','$mobile','$email','$dob','$enc_pass2','$address',0,'$date')");
            
            if($query){
                $del_code = mysqli_query($con,"delete from verify where code='$vcode'");
                echo json_encode($response['success']=1);
            }
            else{
                echo json_encode($response['success']=0);
            }
        }

       
    }

?>