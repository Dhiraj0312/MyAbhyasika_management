<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your HTML and PHP code for displaying transactions
?>

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<div class="container py-4">
    <!-- Your HTML content here -->
    <!-- ... -->
    <table class="table table-bordered table-stripped">
        <colgroup>
            <!-- ... -->
        </colgroup>
        <thead>
            <tr>fghghghjn
                <th>#</th>
                <th>Date Created</th>
                <th>Transaction Code</th>
                <th>Information</th>
                <th>Paid Amount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            $qry = $conn->query("SELECT t.*,c.name as company from `transaction_list` t inner join company_list c on t.company_id = c.id where t.id = '{$_settings->userdata('id')}' order by unix_timestamp(t.`date_created`) desc ");
            while($row = $qry->fetch_assoc()):
            ?>
                <tr>
                    <td class="text-center"><?php echo $i++; ?></td>
                    <td><?php echo date("Y-m-d H:i",strtotime($row['date_created'])) ?></td>
                    <td><?php echo $row['tracking_code'] ?></td>
                    <td>
                        <dl class="lh-1">
                            <dt class="text-info">Account Name:</dt>
                            <dd class="pl-3"><?php echo $row['account_name'] ?></dd>
                            <dt class="text-info">Account #:</dt>
                            <dd class="pl-3"><?php echo $row['account_number'] ?></dd>
                        </dl>
                    </td>
                    <td class="text-right"><?php echo number_format($row['payable_amount'],2) ?></td>
                    <td align="center">
                        <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                            Action
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <a class="dropdown-item view_details" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-light"></span> View</a>
                        </div>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script>
$(document).ready(function(){
    $('#create_new').click(function(){
        uni_modal("New Payment","manage_payment.php",'mid-large')
    })
    $('.view_details').click(function(){
        uni_modal("Payment Details","view_payment.php?id="+$(this).attr('data-id'),'mid-large')
    })
    $('.table td,.table th').addClass('py-1 px-2 align-middle')
    $('.table').dataTable();
})
function delete_transaction($id){
    start_loader();
    $.ajax({
        url:_base_url_+"classes/Master.php?f=delete_transaction",
        method:"POST",
        data:{id: $id},
        dataType:"json",
        error:err=>{
            console.log(err)
            alert_toast("An error occured.",'error');
            end_loader();
        },
        success:function(resp){
            if(typeof resp== 'object' && resp.status == 'success'){
                location.reload();
            }else{
                alert_toast("An error occured.",'error');
                end_loader();
            }
        }
    })
}
</script>

<?php
// Close the database connection
$conn->close();
?>
