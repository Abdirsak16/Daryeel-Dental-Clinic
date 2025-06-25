<?php
include('include/config.php');
?>
<?php
$con->set_charset("utf8");

// Get All Table Names From the Database
$tables = array();
$sql = "SHOW TABLES";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_row($result)) {
    $tables[] = $row[0];
}

$sqlScript = "";
foreach ($tables as $table) {
    // Prepare SQLscript for creating table structure
    $query = "SHOW CREATE TABLE `$table`";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_row($result);

    $sqlScript .= "\n\n" . $row[1] . ";\n\n";

    // Prepare SQLscript for dumping data for each table
    $query = "SELECT * FROM `$table`";
    $result = mysqli_query($con, $query);

    if ($result !== false) {
        $columnCount = mysqli_num_fields($result);
        while ($row = mysqli_fetch_row($result)) {
            $sqlScript .= "INSERT INTO `$table` VALUES(";
            for ($i = 0; $i < $columnCount; $i++) {
                $row[$i] = addslashes($row[$i]);
                if (isset($row[$i])) {
                    $sqlScript .= '"' . $row[$i] . '"';
                } else {
                    $sqlScript .= '""';
                }
                if ($i < ($columnCount - 1)) {
                    $sqlScript .= ',';
                }
            }
            $sqlScript .= ");\n";
        }
    }
}

if (!empty($sqlScript)) {
    // Save the SQL script to a backup file
    $backup_file_name = $database_name . '_backup_' . date("Y-m-d-H-i-s") . '.sql';
    $fileHandler = fopen($backup_file_name, 'w+');
    $number_of_lines = fwrite($fileHandler, $sqlScript);
    fclose($fileHandler);

    // Download the SQL backup file to the browser
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($backup_file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($backup_file_name));
    ob_clean();
    flush();
    readfile($backup_file_name);
    unlink($backup_file_name);
}
?>