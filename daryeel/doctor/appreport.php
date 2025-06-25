<?php
session_start();
include('include/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patients | Appointment Report</title>

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
        @media print {
            #filter-search, .page-title-box, .navbar, .sidebar, footer {
                display: none !important;
            }
            #print-report {
                margin-block: 20px;
            }
            table {
                margin-top: 50px;
                page-break-inside: auto;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }
            body {
                background: white !important;
            }
            .card {
                box-shadow: none !important;
            }
        }
        .logo .margin-top-30 a, h2, span, .username {
            color: black;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4" style="margin-block: 20px;">
            <h2 class="text-xl">Appointment Report</h2>
            <button id="print-report" class="btn btn-primary">
                <i class="fa fa-print"></i> Print Report
            </button>
        </div>

        <div class="panel mt-6" id="rowsView">
            <div class="card-body table-responsive">
                <table id="appointment-report-table" class="table table-hover nowrap w-100">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Doctor Specialization</th>
                            <th>Doctor ID</th>
                            <th>User ID</th>
                            <th>Consultancy Fees</th>
                            <th>Appointment Date</th>
                            <th>Appointment Time</th>
                            <th>Posting Date</th>
                            <th>Updation Date</th>
                            <th>User Status</th>
                            <th>Doctor Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM appointment ORDER BY id DESC";
                        $result = mysqli_query($con, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['doctorSpecialization']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['doctorId']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['userId']) . "</td>";
                                echo "<td>$" . number_format($row['consultancyFees'], 2) . "</td>";
                                echo "<td>" . htmlspecialchars($row['appointmentDate']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['appointmentTime']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['postingDate']) . "</td>";
                                echo "<td>" . (!empty($row['updationDate']) ? htmlspecialchars($row['updationDate']) : 'N/A') . "</td>";
                                echo "<td>" . ($row['userStatus'] == 1 ? "Active" : "Inactive") . "</td>";
                                echo "<td>" . ($row['doctorStatus'] == 1 ? "Active" : "Inactive") . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11' class='text-center'>No appointment records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('print-report').addEventListener('click', function () {
            const tableHTML = document.querySelector('#appointment-report-table').outerHTML;
            const printWindow = window.open('', '', 'height=700,width=900');
            
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print Appointment Report</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                margin: 20px;
                            }
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                font-size: 12px;
                            }
                            th, td {
                                border: 1px solid #000;
                                padding: 8px;
                                text-align: left;
                            }
                            @media print {
                                table { page-break-inside: auto; }
                                tr { page-break-inside: avoid; page-break-after: auto; }
                                thead { display: table-header-group; }
                                tfoot { display: table-footer-group; }
                            }
                        </style>
                    </head>
                    <body>
                        <h2>Appointment Report</h2>
                        ${tableHTML}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => printWindow.print(), 500);
        });
    </script>
<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<!-- end: MAIN JAVASCRIPTS -->
		<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
		<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
		<script src="vendor/autosize/autosize.min.js"></script>
		<script src="vendor/selectFx/classie.js"></script>
		<script src="vendor/selectFx/selectFx.js"></script>
		<script src="vendor/select2/select2.min.js"></script>
		<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
		<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
		<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
		<!-- start: CLIP-TWO JAVASCRIPTS -->
		<script src="assets/js/main.js"></script>
		<!-- start: JavaScript Event Handlers for this page -->
		<script src="assets/js/form-elements.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
</body>
</html>
