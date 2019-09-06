<?php require('inc/checklogin.php'); ?>
<?php require('inc/connect.php'); ?>
<?php require('inc/function.php');?>

<?php
admin_only();
$page_title = "Leave Application";

?>

<?php
  
  

if (!isset($_GET['id'])||!isset($_GET['id'])){
      die("Invalid Request");
  

  
  }
  else{
    $app_id = (int) $_GET['id'];
    $app_status = $_GET['status'];

  
  
}


$update = $conn->query("UPDATE leave_application SET status='$app_status' WHERE id='$app_id'");

if (!$update)
  die('database error');

header('Location:http://localhost/dashboard/applications_pending.php?success=true');