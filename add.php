<?php
// save_employee.php
include('config.php');
global $conn;
$current_date = date('d-M-y');

$Fname = trim($_POST['Fname']);
$Lname = trim($_POST['Lname']);
$Email = trim($_POST['Email']);
$Phone = trim($_POST['Phone']);
$JobTitle = trim($_POST['JobTitle']);

// Finding duplicates
$sql = "SELECT EmployeeID FROM employees WHERE EmployeeFN = '$Fname' AND EmployeeLN = '$Lname'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Checks current EmployeeID
    $sql = "SELECT MAX(EmployeeID) AS MaxID FROM employees";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $newEmployeeID = $row['MaxID'] + 1;

    $sql = "INSERT INTO employees (EmployeeID, EmployeeFN, EmployeeLN, EmployeeEmail, EmployeePhone, HireDate, ManagerID, JobTitle)
                VALUES ($newEmployeeID, '$Fname', '$Lname', '$Email', '$Phone', '$current_date', 50, '$JobTitle')";

    if ($conn->query($sql)) {
        header("location:index.php");
    } else {
        echo $conn->error;
    }
} else {
    $error = "The name already exists. Please input another one, or edit the information.";
    echo $error;
    header("location:index.php");
}
?>
