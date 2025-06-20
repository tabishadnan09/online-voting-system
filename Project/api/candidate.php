<?php
    include('connection.php');
    $json = json_decode(file_get_contents("php://input"),true);


    // Add candidate
        $name = $_POST['name'];
        $position = $_POST['position'];
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        $date = date('d-F-Y');

        $query = mysqli_query($con, "insert into candidates (name, position, image, votes, status, created_at) values('$name','$position','$image', 0, 0, '$date')");
        $upload = move_uploaded_file($tmp_name,"../uploads/$image");

        if($query and $upload){
            echo json_encode($response['success']=1);
        }
        else{
            echo json_encode($response['success']=0);
        }
        

?>