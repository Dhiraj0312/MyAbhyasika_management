<?php
    session_start();
    include('../includes/dbconn.php');
    include('../includes/check-login.php');
    check_login();
    $fd=1; 


    // Execute the query



    ?>


<?php
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");

?>


<h4 class="card-title mt-5">New Payment </h4>

<div class="row">

<?php	
$aid=$_SESSION['id'];
    $ret="select * from userregistration where id=?";
        $stmt= $mysqli->prepare($ret) ;
    $stmt->bind_param('i',$aid);
    $stmt->execute();
    $res=$stmt->get_result();

    while($row=$res->fetch_object())
    {
        ?>






   
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Hostel Management System</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">

    <script>
    function getSeater(val) {
        $.ajax({
        type: "POST",
        url: "get-seater.php",
        data:'roomid='+val,
        success: function(data){
        //alert(data);
        $('#seater').val(data);
        }
        });

        $.ajax({
        type: "POST",
        url: "get-seater.php",
        data:'rid='+val,
        success: function(data){
        //alert(data);
        $('#fpm').val(data);
        }
        });
    }
    </script>
    
</head>

<body background-color="black">
<form method="post" action="phonepe.php">
    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">First Name</h4>
                    <div class="form-group">
                        <input type="text" name="fname" id="fname" value="<?php echo $row->firstName;?>" class="form-control" readonly>
                    </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Middle Name</h4>
                    <div class="form-group">
                        <input type="text" name="mname" id="mname" value="<?php echo $row->middleName;?>" class="form-control" readonly>
                    </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Last Name</h4>
                    <div class="form-group">
                        <input type="text" name="lname" id="lname" value="<?php echo $row->lastName;?>" class="form-control" readonly>
                    
                    </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Email</h4>
                    <div class="form-group">
                        <input type="email" name="email" id="email" value="<?php echo $row->email;?>" class="form-control" readonly>
                    </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Gender</h4>
                    <div class="form-group">
                        <input type="text" name="gender" id="gender" value="<?php echo $row->gender;?>" class="form-control" readonly>
                    </div>
            </div>
        </div>
    </div>


    <div class="col-sm-12 col-md-6 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Contact Number</h4>
                    <div class="form-group">
                        <input type="number" name="contact" id="contact" value="<?php echo $row->contactNo;?>" class="form-control" readonly>
                    </div>
            </div>
        </div>
    </div>




    <?php }?>

    <div class="table-responsive">
                                    <table id="zctb" class="table table-striped table-bordered no-wrap">

                                        <tbody>

                                        <?php	
                                        $aid=$_SESSION['login'];
                                        $ret="SELECT * from registration where emailid=?";
                                        $stmt= $mysqli->prepare($ret) ;
                                        $stmt->bind_param('s',$aid);
                                        $stmt->execute() ;
                                        $res=$stmt->get_result();
                                        $cnt=1;
                                        while($row=$res->fetch_object())
                                            {
                                                ?>

                                            <tr>
                                                <td colspan="3"><b>Date & Time of Registration: <?php echo $row->postingDate;?></b></td>
                                                
                                            </tr>

                                            <tr>

                                            

                                            <td><b>Starting Date :</b></td>
                                            <td><?php echo $row->stayfrom;?></td>

                                            <td><b>Seater :</b></td>
                                            <td><?php echo $row->seater;?></td>
                                            <!-- By CodeAstro - codeastro.com -->

                                            </tr>

                                            <tr>

                                            <td><b>Duration:</b></td>
                                            <td><?php echo $dr=$row->duration;?> Months</td>

                                            <td><b>Food Status:</b></td>
                                            <td>
                                            <?php if($row->foodstatus==0){
                                            echo "Not Required";
                                            } else {
                                            echo "Required";
                                            }
                                            ;?> </td>

                                            <td><b>Fees Per Month :</b></td>
                                            <td>$<?php echo $fpm=$row->feespm;?></td>

                                            

                                            </tr>

                                            <tr>
                                            <td>$<?php echo $totalFees = $dr * $fpm + $fd; ?></td>
                                            <?php if($row->foodstatus==1){ 
                                            
                                            echo '$'.(($fd+$fpm)*$dr);
                                            } else {
                                            echo '$'.$dr*$fpm;
                                            }
                                            ?></b></td>
                                            </tr>


                                          


                                            <?php
                                            $cnt=$cnt+1;
                                            } ?>

                                        </tbody>
                                    </table>
                                   
                                </div>
                      
                      
                      </div>
                   
                   
                   </div>
                 
                 
                 </div>

                 <div class="form-group">
                    <input type="submit" class="btn-btn-danger btn-lg" value="Click to pay : Rs. <?= number_format($totalFees); ?>">
                 </div>
    </form>
</body>




   



    
