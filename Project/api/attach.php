<?php
session_start();
include('connection.php');
        
if(isset($_POST['getFile'])){

    $output = '';
    $voting = mysqli_query($con, "select * from candidates");
    $winner = mysqli_query($con, "select name, votes from candidates where votes=(select max(votes) from candidates)");
    $winner_detail = mysqli_fetch_array($winner);
    $total = mysqli_query($con, "select * from voting");
    $totalVotes = mysqli_num_rows($total);
    
        if(mysqli_num_rows($voting)>0){
            $same = $winner_detail['votes'];
            $check_same_votes = mysqli_query($con, "select name, votes from candidates where votes='$same'");

            if(mysqli_num_rows($check_same_votes)>1){
                $output.=   '<table class="table" bordered="1">
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Votes</th>
                            </tr>';
    
            while($row = mysqli_fetch_array($voting)){
                $output.=
                        '<tr>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['position'].'</td>
                            <td>'.$row['votes'].'</td>
                        </tr>';
            }
            $output.=   '<tr>
                            <th colspan="2">Total</th>
                            <td>'. $totalVotes.'</td>
                        </tr>
                        <tr>
                            <th colspan="2">Election tied on</th>
                            <td>'.$winner_detail['votes'].'</td>
                        </tr>
                    
                        </table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=results.xls");
            echo $output;
            }
            

        else{
            $output.=   '<table class="table" bordered="1">
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Votes</th>
                            </tr>';
    
            while($row = mysqli_fetch_array($voting)){

                $output.=
                        '<tr>
                            <td>'.$row['name'].'</td>
                            <td>'.$row['position'].'</td>
                            <td>'.$row['votes'].'</td>
                        </tr>';
            }
            $output.=   '<tr>
                            <th colspan="2">Total</th>
                            <td>'. $totalVotes.'</td>
                        </tr>
                        <tr>
                            <th colspan="2">Winner is '.$winner_detail['name'].'</th>
                            <td>'.$winner_detail['votes'].'</td>
                        </tr>
                    
                        </table>';
            header("Content-Type: application/xls");
            header("Content-Disposition: attachment; filename=results.xls");
            echo $output;


        }
    }
}


    
?>