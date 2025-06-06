<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        header('Location: staff_login.php?error=empty');
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT * FROM employee WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($employee && password_verify($password, $employee['password'])) {
            // Установка сессии
            $_SESSION['staff_logged_in'] = true;
            $_SESSION['staff_id'] = $employee['id'];
            $_SESSION['staff_username'] = $employee['username'];
            $_SESSION['staff_name'] = $employee['name'];
            $_SESSION['staff_surname'] = $employee['surname'];
            $_SESSION['staff_position'] = $employee['position'];
            $_SESSION['staff_email'] = $employee['email'];
            $_SESSION['staff_role'] = $employee['role']; // 1 - admin, 0 - manager
            
            session_regenerate_id(true);
            
            header('Location: staff_dashboard.php');
            exit;
        }
        
        sleep(2);
        header('Location: staff_login.php?error=auth');
        exit;
        
    } catch (PDOException $e) {
        error_log("Ошибка авторизации: " . $e->getMessage());
        header('Location: staff_login.php?error=db');
        exit;
    }
}

header('Location: staff_login.php');
exit;