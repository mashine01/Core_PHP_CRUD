<?php
header('Content-Type: application/json');

require "../conn.php";

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {
    $params = $_REQUEST; // Use $_REQUEST to handle both GET and POST requests

    if (isset($params['action'])) {
        switch ($params['action']) {
            case 'addEmployee':
                try {
                    $stmt = $conn->prepare("INSERT INTO emp (empID, empName, empPhone, empMail) VALUES (:empID, :empName, :empPhone, :empMail)");
                    $stmt->bindParam(':empID', $params['empID']);
                    $stmt->bindParam(':empName', $params['empName']);
                    $stmt->bindParam(':empPhone', $params['empPhone']);
                    $stmt->bindParam(':empMail', $params['empMail']);

                    $stmt->execute();
                    $response['message'] = "New record added successfully";
                } catch (PDOException $e) {
                    $response['error'] = "Error: " . $e->getMessage();
                }
                break;
                
            case 'deleteEmployee':
                try {
                    $stmt = $conn->prepare("DELETE FROM emp WHERE empID = :empID");
                    $stmt->bindParam(':empID', $params['empID']);
                    $stmt->execute();
                    $response['message'] = "Selected records deleted successfully";
                    } catch (PDOException $e) {
                    $response['error'] = "Error: " . $e->getMessage();
                }
                
            break;

            case 'updateEmployee':
                try {
                    $updateColumns = array();
                    if (isset($params['empName'])) {
                        $updateColumns[] = "empName = :empName";
                    }
                    if (isset($params['empPhone'])) {
                        $updateColumns[] = "empPhone = :empPhone";
                    }
                    if (isset($params['empMail'])) {
                        $updateColumns[] = "empMail = :empMail";
                    }

                    $updateQuery = "UPDATE emp SET " . implode(', ', $updateColumns) . " WHERE empID = :empID";
                    $stmt = $conn->prepare($updateQuery);
                    $stmt->bindParam(':empID', $params['empID']);

                    if (isset($params['empName'])) {
                        $stmt->bindParam(':empName', $params['empName']);
                    }
            
                    if (isset($params['empPhone'])) {
                        $stmt->bindParam(':empPhone', $params['empPhone']);
                    }
            
                    if (isset($params['empMail'])) {
                        $stmt->bindParam(':empMail', $params['empMail']);
                    }

                    $stmt->execute();
                    $response['message'] = "Selected records updated successfully";
                } catch (PDOException $e) {
                    $response['error'] = "Error: " . $e->getMessage();
                }
                break;

            default:
                $response['error'] = "Invalid action specified";
        }
    } else {
        $response['error'] = "Action parameter is missing";
    }
} else {
    $response['error'] = "Invalid request method";
}

$result = $conn->query("SELECT * FROM emp");
$data = $result->fetchAll(PDO::FETCH_ASSOC);
$response['data'] = $data;

echo json_encode($response);
?>