<?php

session_start();
include('connection.php');
$json = json_decode(file_get_contents("php://input"),true);


if($json['call'] == 1){
    
    $v_id = $json['v_id'];
    $c_id = $json['c_id'];
    $votes = $json['votes'];

    $query = mysqli_query($con, "insert into voting (v_id) values('$v_id')");
    $vote = mysqli_query($con, "update candidates set votes='$votes' where id='$c_id'");
    if($query and $vote){
        $updateStatus = mysqli_query($con, "update register set status=1 where id='$v_id'");
        echo json_encode($response['success'] = 1);
    }
    else{
        echo json_encode($response['success'] = 0);
    }
    
    

}

if($json['call'] == 2){

        $code = $json['code'] ;
        $mycode = 'abcd';
        $state = $json['vote'] ;

        if($code==$mycode){

            if($state=='on'){
                $vote = mysqli_query($con, "update candidates set status = 1");
                if($vote){
                    echo json_encode($response['success'] = 1);
                }
                else{
                    echo json_encode($response['success'] = 0);
                }
            }
            else{
                $vote = mysqli_query($con, "update candidates set status = 2");
                if($vote){
                    echo json_encode($response['success'] = 1);
                }
                else{
                    echo json_encode($response['success'] = 0);
                }
            }
           
        }
        else{
            echo json_encode($response['success'] = 2);
        }
       
    }

    
if($json['call'] == 4){

        $resetMembers = mysqli_query($con, "update register set status = 0, is_verified=0");
        $resetCandidates = mysqli_query($con, "update candidates set status = 0, votes=0");
        $resetVoting = mysqli_query($con, "TRUNCATE TABLE voting");
        if($resetMembers && $resetCandidates && $resetVoting){
            echo json_encode($response['success'] = 1);
        }
        else{
            echo json_encode($response['success'] = 0);
        }
}


// Send verification code 
if($json['call'] == 5){
    
    $v_id = $json['v_id'];
    $c_id = $json['c_id'];
    $votes = $json['votes'];
    $value = $json['value'];


    $check = mysqli_query($con, "select * from voting where v_id='$v_id' and c_id='$c_id' ");

    if(mysqli_num_rows($check)>0){
        echo json_encode($response['success'] = 0);
    }
    else{
        $query = mysqli_query($con, "insert into voting (v_id, c_id, value) values('$v_id','$c_id','$value')");
        $vote = mysqli_query($con, "update candidates set no_votes='$votes' where id='$c_id'");
        if($query and $vote){
            echo json_encode($response['success'] = 1);
        }
        else{
            echo json_encode($response['success'] = 0);
        }
    }
    

}


?>