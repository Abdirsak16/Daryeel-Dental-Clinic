<?php
session_start();
error_reporting(0);
include('include/config.php');

if(strlen($_SESSION['id'])==0) {
    header('location:logout.php');
} else {

    // Delete logic
    if (isset($_GET['delid'])) {
        $id = intval($_GET['delid']);
        $query = mysqli_query($con, "DELETE FROM tblpatient WHERE ID='$id'");
        if ($query) {
            echo "<script>alert('Patient deleted successfully');</script>";
            echo "<script>window.location.href='manage-patient.php'</script>";
        } else {
            echo "<script>alert('Error deleting patient');</script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor | Manage Patients</title>
    <!-- CSS and favicon links -->
    <link href="http://fonts.googleapis.com/css?family=Lato|Raleway|Crete+Round" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    <link rel="shortcut icon" href="assets/images/dental.png" type="image/png">
    <style>
        body {
            background: url('https://media.istockphoto.com/id/1466165845/vector/unhealthy-tooth-white-molar-model-and-protective-vortex-around-tooth-on-pastel-blue.jpg?s=612x612&w=0&k=20&c=-UMh5J5DgQHXD6vTPpAFQprvJOyrYO_8vOpY3pZUzTo=') center/cover no-repeat;
        }
        .logo .margin-top-30, a, h2 {
            color: white;
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
                                <h1 class="mainTitle">Doctor | Manage Patients</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li><span>Doctor</span></li>
                                <li class="active"><span>Manage Patients</span></li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="over-title margin-bottom-15">Manage <span class="text-bold">Patients</span></h5>
                                <table class="table table-hover" id="sample-table-1">
                                    <thead>
                                        <tr>
                                            <th class="center">#</th>
                                            <th>Patient Name</th>
                                            <th>Contact Number</th>
                                            <th>Gender</th>
                                            <th>Created On</th>
                                            <th>Updated On</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $docid = $_SESSION['id'];
                                        $sql = mysqli_query($con, "SELECT * FROM tblpatient WHERE Docid='$docid'");
                                        $cnt = 1;
                                        while($row = mysqli_fetch_array($sql)) {
                                        ?>
                                        <tr>
                                            <td class="center"><?php echo $cnt; ?>.</td>
                                            <td class="hidden-xs"><?php echo $row['PatientName']; ?></td>
                                            <td><?php echo $row['PatientContno']; ?></td>
                                            <td><?php echo $row['PatientGender']; ?></td>
                                            <td><?php echo $row['CreationDate']; ?></td>
                                            <td><?php echo $row['UpdationDate']; ?></td>
                                            <td>
                                                <a href="edit-patient.php?editid=<?php echo $row['ID']; ?>" class="btn btn-primary btn-sm" target="_blank">Edit</a>
                                                <a href="view-patient.php?viewid=<?php echo $row['ID']; ?>" class="btn btn-warning btn-sm" target="_blank">View</a>
                                                <a href="manage-patient.php?delid=<?php echo $row['ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?');">Delete</a>
                                            </td>
                                        </tr>
                                        <?php 
                                        $cnt++;
                                        } 
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer and settings -->
        <?php include('include/footer.php');?>
        <?php include('include/setting.php');?>
    </div>

    <!-- JS Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>
    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>
</body>
</html>
<?php } ?>
