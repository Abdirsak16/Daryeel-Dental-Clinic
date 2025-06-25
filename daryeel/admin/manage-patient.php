<?php
session_start();
error_reporting(0);
include('include/config.php');
if(strlen($_SESSION['id']==0)) {
 header('location:logout.php');
  } else{

// Handle update form submission
if(isset($_POST['update'])) {
	$pid = $_POST['pid'];
	$name = $_POST['name'];
	$contact = $_POST['contact'];
	$gender = $_POST['gender'];
	$query = mysqli_query($con,"UPDATE tblpatient SET PatientName='$name', PatientContno='$contact', PatientGender='$gender', UpdationDate=NOW() WHERE ID='$pid'");
	if($query) {
		$_SESSION['msg'] = "Patient updated successfully!";
	} else {
		$_SESSION['msg'] = "Error updating patient.";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin | View Patients</title>
		<link rel="shortcut icon" href="assets/images/dental.png" type="image/png">
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
    <style>
        body {
            background: url('https://media.istockphoto.com/id/1466165845/vector/unhealthy-tooth-white-molar-model-and-protective-vortex-around-tooth-on-pastel-blue.jpg') center/cover no-repeat;
        }
        .logo .margin-top-30, a, h2 {
            color: black;
            font-weight: 500;
        }
    </style>
	</head>
	<body>
		<div id="app">
			<?php include('include/sidebar.php');?>
			<div class="app-content">
				<?php include('include/header.php');?>
				<div class="main-content">
					<div class="wrap-content container" id="container">
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">Admin | View Patients</h1>
								</div>
								<ol class="breadcrumb">
									<li><span>Admin</span></li>
									<li class="active"><span>View Patients</span></li>
								</ol>
							</div>
						</section>
						<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-md-12">
									<h5 class="over-title margin-bottom-15">View <span class="text-bold">Patients</span></h5>
									<p style="color:green;"><?php echo htmlentities($_SESSION['msg']); ?><?php echo htmlentities($_SESSION['msg']="");?></p>
									<table class="table table-hover" id="sample-table-1">
										<thead>
											<tr>
												<th class="center">#</th>
												<th>Patient Name</th>
												<th>Contact</th>
												<th>Gender</th>
												<th>Creation Date</th>
												<th>Update Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
<?php
$sql=mysqli_query($con,"select * from tblpatient");
$cnt=1;
while($row=mysqli_fetch_array($sql)) {
?>
<tr>
	<td class="center"><?php echo $cnt;?>.</td>
	<td><?php echo $row['PatientName'];?></td>
	<td><?php echo $row['PatientContno'];?></td>
	<td><?php echo $row['PatientGender'];?></td>
	<td><?php echo $row['CreationDate'];?></td>
	<td><?php echo $row['UpdationDate'];?></td>
	<td>
		<a href="view-patient.php?viewid=<?php echo $row['ID'];?>" class="btn btn-primary btn-xs" target="_blank">View</a>
		<button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#editModal<?php echo $row['ID']; ?>">Edit</button>
	</td>
</tr>
<!-- Edit Modal -->
<div class="modal fade" id="editModal<?php echo $row['ID']; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Patient</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="POST">
				<div class="modal-body">
					<input type="hidden" name="pid" value="<?php echo $row['ID']; ?>">
					<div class="form-group">
						<label>Full Name</label>
						<input type="text" name="name" value="<?php echo $row['PatientName']; ?>" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Contact</label>
						<input type="text" name="contact" value="<?php echo $row['PatientContno']; ?>" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Gender</label>
						<select name="gender" class="form-control" required>
							<option value="Male" <?php if($row['PatientGender']=='Male') echo 'selected'; ?>>Male</option>
							<option value="Female" <?php if($row['PatientGender']=='Female') echo 'selected'; ?>>Female</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="update" class="btn btn-success">Update</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php $cnt=$cnt+1; } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php include('include/footer.php');?>
			<?php include('include/setting.php');?>
		</div>
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
<?php } ?>
