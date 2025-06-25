<?php
session_start();
error_reporting(0);
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit();
}

// Cancel appointment
if (isset($_GET['cancel']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $con->prepare("UPDATE appointment SET userStatus = 0 WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $_SESSION['msg'] = "Your appointment has been canceled!";
}

// Delete appointment
if (isset($_GET['delete']) && isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $con->prepare("DELETE FROM appointment WHERE id = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $_SESSION['msg'] = "Appointment deleted successfully!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
		  <title>Doctor | Appointment History</title>
		
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>

	<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'email='+$("#patemail").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>
	</head>
<body>
<div id="app">
    <?php include('include/sidebar.php'); ?>
    <div class="app-content">
        <?php include('include/header.php'); ?>
        <div class="main-content">
            <div class="wrap-content container" id="container">
                <section id="page-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h1 class="mainTitle">Patients | Appointment History</h1>
                        </div>
                        <ol class="breadcrumb">
                            <li><span>Patients</span></li>
                            <li class="active"><span>Appointment History</span></li>
                        </ol>
                    </div>
                </section>
                <div class="container-fluid container-fullw bg-white">
                    <div class="row">
                        <div class="col-md-12">
                            <p style="color:red;"><?php echo htmlentities($_SESSION['msg']); $_SESSION['msg'] = ""; ?></p>
                            <table class="table table-hover" id="sample-table-1">
                                <thead>
                                <tr>
                                    <th class="center">#</th>
                                    <th>Doctor Name</th>
                                    <th>Specialization</th>
                                    <th>Fee</th>
                                    <th>Appointment Date / Time</th>
                                    <th>Created On</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                    <th>Invoice</th>
                                </tr>
                                </thead>
                                <tbody>
<?php
$uid = $_SESSION['id'];
$stmt = $con->prepare("
    SELECT d.doctorName AS docname, a.* 
    FROM appointment a
    JOIN doctors d ON d.id = a.doctorId
    WHERE a.userId = ?
    ORDER BY a.appointmentDate DESC
");
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
$cnt = 1;
while ($row = $result->fetch_assoc()) {
?>
<tr>
    <td class="center"><?= $cnt ?>.</td>
    <td><?= htmlentities($row['docname']); ?></td>
    <td><?= htmlentities($row['doctorSpecialization']); ?></td>
    <td>$<?= htmlentities($row['consultancyFees']); ?></td>
    <td><?= htmlentities($row['appointmentDate'] . ' / ' . $row['appointmentTime']); ?></td>
    <td><?= htmlentities($row['postingDate']); ?></td>
    <td>
        <?php
        if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1) echo "Active";
        elseif ($row['userStatus'] == 0 && $row['doctorStatus'] == 1) echo "Cancelled by You";
        elseif ($row['userStatus'] == 1 && $row['doctorStatus'] == 0) echo "Cancelled by Doctor";
        ?>
    </td>
    <td>
        <?php if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1): ?>
            <a href="appointment-history.php?id=<?= $row['id'] ?>&cancel=1"
               class="btn btn-warning btn-xs"
               onclick="return confirm('Cancel this appointment?')">Cancel</a>
        <?php else: ?>
            <span class="text-muted">Canceled</span>
        <?php endif; ?>
        <a href="appointment-history.php?id=<?= $row['id'] ?>&delete=1"
           class="btn btn-danger btn-xs"
           onclick="return confirm('Delete this appointment permanently?')">Delete</a>
    </td>
    <td>
        <a href="invoice.php?id=<?= $row['id'] ?>" target="_blank" class="btn btn-success btn-xs">View</a>
    </td>
</tr>
<?php $cnt++; } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('include/footer.php'); ?>
</div>

<!-- JS Files -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/form-elements.js"></script>
<script>
    jQuery(document).ready(function () {
        Main.init();
        FormElements.init();
    });
</script>
</body>
</html>
