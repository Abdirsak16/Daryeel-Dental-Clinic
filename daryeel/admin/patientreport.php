<?php
session_start();
include('include/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patients | Full Report</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
    <style>
        @media print {
            .navbar, .sidebar, footer, #print-report {
                display: none !important;
            }
            table {
                margin-top: 30px;
                page-break-inside: auto;
                width: 100%;
                border-collapse: collapse;
                font-size: 12px;
            }
            tr, td, th {
                border: 1px solid #000;
                padding: 8px;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <?php include('include/header.php'); ?>
    <?php include('include/sidebar.php'); ?>

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4 mt-4">
            <h2 class="text-xl">Patient Full Report</h2>
            <button id="print-report" class="btn btn-primary" style="margin-block: 20px;>
                <i class="fa fa-print"></i> Print Report
            </button>
        </div>

        <div class="card-body table-responsive">
            <table id="patient-report-table" class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Doc ID</th>
                        <th>Patient Name</th>
                        <th>Contact No</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Age</th>
                        <th>Medical History</th>
                        <th>Creation Date</th>
                        <th>Updation Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM tblpatient ORDER BY ID DESC";
                    $result = mysqli_query($con, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ID']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['Docid']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PatientName']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PatientContno']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PatientEmail']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PatientGender']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PatientAdd']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PatientAge']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['PatientMedhis']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['CreationDate']) . "</td>";
                            echo "<td>" . (!empty($row['UpdationDate']) ? htmlspecialchars($row['UpdationDate']) : 'N/A') . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11' class='text-center'>No patient records found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include('include/footer.php'); ?>

    <script>
        document.getElementById('print-report').addEventListener('click', function () {
            const tableHTML = document.querySelector('#patient-report-table').outerHTML;

            const printWindow = window.open('', '', 'height=700,width=900');
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Print Patient Report</title>
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
                            thead { display: table-header-group; }
                            tfoot { display: table-footer-group; }
                        </style>
                    </head>
                    <body>
                        <h2>Patient Full Report</h2>
                        ${tableHTML}
                    </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.focus();
            setTimeout(() => printWindow.print(), 500);
        });
    </script>
    <!-- start: MAIN JAVASCRIPTS -->
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
