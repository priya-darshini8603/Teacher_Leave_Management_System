<?php
session_start();
error_reporting(0);
include('../includes/dbconn.php');

if(strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {

    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $id = $_GET['id'];

        // Check if the teacher exists and fetch their details
        $sql = "SELECT * FROM tblteachers WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if($result) {
            // Perform the deletion query
            $deleteSql = "DELETE FROM tblteachers WHERE id = :id";
            $deleteQuery = $dbh->prepare($deleteSql);
            $deleteQuery->bindParam(':id', $id, PDO::PARAM_STR);
            $deleteQuery->execute();

            if($deleteQuery) {
                $_SESSION['msg'] = "Teacher record deleted successfully";
                header('location:teachers.php');
                exit;
            } else {
                $_SESSION['error'] = "Failed to delete teacher record";
                header('location:teachers.php');
                exit;
            }
        } else {
            $_SESSION['error'] = "Teacher not found";
            header('location:teachers.php');
            exit;
        }
    } else {
        $_SESSION['error'] = "Invalid teacher ID";
        header('location:teachers.php');
        exit;
    }
}
?>
