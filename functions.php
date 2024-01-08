<script src="functions.js"></script>
<?php
require "conn.php";

function addEmployee($conn, $empID, $empName, $empPhone, $empMail) {
    try {
        $stmt = $conn->prepare("INSERT INTO emp (empID, empName, empPhone, empMail, CreatedAt, UpdatedAt) VALUES (:empID, :empName, :empPhone, :empMail, NOW(), NOW());");
        $stmt->bindParam(':empID', $empID);
        $stmt->bindParam(':empName', $empName);
        $stmt->bindParam(':empPhone', $empPhone);
        $stmt->bindParam(':empMail', $empMail);
        $stmt->execute();
        echo '<script>alert("New record added successfully");</script>';
    } catch(PDOException $e) {
        echo "<script>alert('Error: {$e->getMessage()}');</script>";
    }
}

function updateEmployee($conn, $empID, $empName, $empPhone, $empMail) {
    try {
        $stmt = $conn->prepare("UPDATE emp SET empName = :empName, empPhone = :empPhone, empMail = :empMail, UpdatedAt = now() WHERE empID = :empID");
        $stmt->bindParam(':empID', $empID);
        $stmt->bindParam(':empName', $empName);
        $stmt->bindParam(':empPhone', $empPhone);
        $stmt->bindParam(':empMail', $empMail);
        $stmt->execute();

        echo '<script>alert("Employee updated successfully!");</script>';
    } catch (PDOException $e) {
        echo "Error updating employee: " . $e->getMessage();
    }
}

function deleteEmployee($conn, $empID) {
    $sql = "DELETE FROM emp WHERE empID = :empID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':empID', $empID, PDO::PARAM_INT);

    try {
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        return false;
    }
}
?>