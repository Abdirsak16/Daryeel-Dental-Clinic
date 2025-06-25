<?php
session_start();
include('include/config.php');

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
    exit();
}

$appointmentId = intval($_GET['id']);
$uid = $_SESSION['id'];

// Fetch appointment details
$query = $con->prepare("
    SELECT a.*, d.doctorName, u.fullName, u.email, u.gender, u.regDate 
    FROM appointment a
    JOIN doctors d ON d.id = a.doctorId
    JOIN users u ON u.id = a.userId
    WHERE a.id = ? AND a.userId = ?
");
$query->bind_param("ii", $appointmentId, $uid);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    echo "No invoice found for this appointment.";
    exit();
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
      <link rel="shortcut icon" href="assets/images/dental.png" type="image/png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 40px;
            background-color: #f2f2f2;
        }

        .invoice-box {
            background: #fff;
            padding: 30px;
            max-width: 800px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 40px;
            color: #2c3e50;
        }

        .section {
            margin-bottom: 20px;
        }

        .section h4 {
            margin-bottom: 10px;
            color: #34495e;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        table th {
            background:rgb(44, 47, 49);
            color: white;
        }

        .total-row {
            font-weight: bold;
            background: #ecf0f1;
        }

        .text-center {
            text-align: center;
        }

        .thank-you {
            text-align: center;
            margin-top: 30px;
            font-style: italic;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .invoice-box, .invoice-box * {
                visibility: visible;
                position: absolute;
                top: 0;
                left: 0;
            }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <h2>Daryeel Dental Clinic - Appointment Invoice</h2>
  
    <div class="section">
        <h4>Patient Information</h4>
        <p><strong>Name:</strong> <?= htmlentities($row['fullName']) ?></p>
        <p><strong>Gender:</strong> <?= htmlentities($row['gender']) ?></p>
        <p><strong>Email:</strong> <?= htmlentities($row['email']) ?></p>
        <p><strong>Registered On:</strong> <?= htmlentities($row['regDate']) ?></p>
    </div>

    <div class="section">
        <h4>Appointment Details</h4>
        <table>
            <thead>
                <tr>
                    <th>Doctor</th>
                    <th>Specialization</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Fee</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlentities($row['doctorName']) ?></td>
                    <td><?= htmlentities($row['doctorSpecialization']) ?></td>
                    <td><?= htmlentities($row['appointmentDate']) ?></td>
                    <td><?= htmlentities($row['appointmentTime']) ?></td>
                    <td>$<?= htmlentities($row['consultancyFees']) ?></td>
                    <td>
                        <?php
                        if ($row['userStatus'] == 1 && $row['doctorStatus'] == 1) echo "Active";
                        elseif ($row['userStatus'] == 0 && $row['doctorStatus'] == 1) echo "Cancelled by Patient";
                        elseif ($row['userStatus'] == 1 && $row['doctorStatus'] == 0) echo "Cancelled by Doctor";
                        ?>
                    </td>
                </tr>
                <tr class="total-row">
                    <td colspan="4" class="text-center">Total</td>
                    <td colspan="2">$<?= htmlentities($row['consultancyFees']) ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <p class="thank-you">Thank you for choosing Daryeel Dental Clinic!</p>
</div>

</body>
</html>
