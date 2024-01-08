<?php
require "functions.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addEmployee'])) {
        $empID = $_POST['empID'];
        $empName = $_POST['empName'];
        $empPhone = $_POST['empPhone'];
        $empMail = $_POST['empMail'];
        addEmployee($conn, $empID, $empName, $empPhone, $empMail);
    } elseif (isset($_POST['deleteEmployee'])) {
        $empIDToDelete = $_POST['deleteEmployee'];
        deleteEmployee($conn, $empIDToDelete);
    } elseif (isset($_POST['empIDToUpdate'])) {
        $empIDToUpdate = $_POST['empIDToUpdate'];
        $empName = $_POST['empName'];
        $empPhone = $_POST['empPhone'];
        $empMail = $_POST['empMail'];
        updateEmployee($conn, $empIDToUpdate, $empName, $empPhone, $empMail);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Table</title>
    <link rel="stylesheet" href="index.css">

</head>
<body>
<div class="header">
    <h2>Manage Employees</h2>
    <div class="buttonsContainer">
        <button onclick="openAddEmployeePopup()">Add New Employee</button>
    </div>
</div>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="employeeForm">
    <table class="crud" border="1">
        <tr>
            <th>Select</th>
            <th>Employee ID</th>
            <th>Full Name</th>
            <th>Phone #</th>
            <th>E-Mail</th>
            <th>Created At</th>
            <th>Updated On</th>
            <th>Actions</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM emp");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td><input type='checkbox' name='selectID[]' value='" . $row['empID'] . "'></td>";
            echo "<td>" . $row['empID'] . "</td>";
            echo "<td>" . $row['empName'] . "</td>";
            echo "<td>" . $row['empPhone'] . "</td>";
            echo "<td>" . $row['empMail'] . "</td>";
            echo "<td>" . $row['CreatedAt'] . "</td>";
            echo "<td>" . $row['UpdatedAt'] . "</td>";
            echo "<td>
            <button type='submit' name='deleteEmployee' value='" . $row['empID'] . "'>Delete</button>
            <button onclick=\"event.preventDefault(); populateUpdateForm('" . $row['empID'] . "', '" . $row['empName'] . "', '" . $row['empPhone'] . "', '" . $row['empMail'] . "')\">Update</button>
            </td>";
    
            echo "</tr>";
        }
        ?>
    </table>
    <br>
</form>

<div id="addEmployeePopup" class="popup">
    <h2>Add Employee Details</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="empID">Employee ID:</label>
        <input type="text" name="empID" required><br>

        <label for="empName">Employee Name:</label>
        <input type="text" name="empName" required><br>

        <label for="empPhone">Employee Phone:</label>
        <input type="text" name="empPhone" required><br>

        <label for="empMail">Employee Mail:</label>
        <input type="text" name="empMail" required><br>

        <input type="submit" name="addEmployee" value="Add Employee">
        <button type="button" onclick="closePopup()">Close</button>
    </form>
</div>

<div id="updateEmployeePopup" class="popup">
    <h2>Update Employee</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <input type="hidden" name="empIDToUpdate" id="updateEmployee">

        <label for="empName">Employee Name:</label>
        <input type="text" name="empName" required><br>

        <label for="empPhone">Employee Phone:</label>
        <input type="text" name="empPhone" required><br>

        <label for="empMail">Employee Mail:</label>
        <input type="text" name="empMail" required><br>

        <input type="submit" name="updateEmployee" value="Update Employee">
        <button type="button" onclick="closePopup()">Close</button>
    </form>
</div>

</body>
<script src="functions.js"></script>
</html>