<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/db.php';

global $db;
$pdo = $db;

if (!isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_login.php');
    exit;
}

$role = $_SESSION['staff_role'] ?? 0; // 1 - admin, 0 - manager
$staff_id = $_SESSION['staff_id'];
$full_name = trim($_SESSION['staff_name'] . ' ' . $_SESSION['staff_surname']);

$current_page = 'dashboard';
$page_title = 'TravelDream - Панель сотрудника';
$page_css = 'staff_dashboard';

require_once 'parts/header.php';
?>

<section class="staff-dashboard">
    <div class="container">
        <!-- Шапка -->
        <div class="dashboard-header">
            <div>
                <h1><i class="fas fa-tachometer-alt"></i> Панель управления</h1>
                <p class="text-white mb-0">Добро пожаловать, <?= htmlspecialchars($full_name) ?></p>
            </div>
            <div class="user-info">
                <span class="badge bg-<?= $role == 1 ? 'primary' : 'secondary' ?>">
                    <?= $role == 1 ? 'Администратор' : 'Менеджер' ?>
                </span>
                <a href="staff_logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Выйти
                </a>
            </div>
        </div>

        <!-- Быстрые действия -->
        <div class="section-title">
            <h2>Все действия</h2>
        </div>

        <div class="quick-actions-container">
            <?php if ($role == 1): ?>
                <!-- Администратор -->
                <div class="quick-actions-row centered-row">
                    <a href="staff_tours_list.php?action=create" class="quick-action-card">
                        <i class="fas fa-plus-circle"></i>
                        <h3>Добавить тур</h3>
                    </a>
                    <a href="staff_managers_list.php?action=create" class="quick-action-card">
                        <i class="fas fa-user-plus"></i>
                        <h3>Добавить менеджера</h3>
                    </a>
                    <a href="staff_bookings_list.php" class="quick-action-card">
                        <i class="fas fa-calendar-check"></i>
                        <h3>Все бронирования</h3>
                    </a>
                </div>
                
                <div class="quick-actions-row centered-row">
                    <a href="staff_hotels_list.php" class="quick-action-card">
                        <i class="fas fa-hotel"></i>
                        <h3>Отели</h3>
                    </a>
                    <a href="staff_promotions_list.php" class="quick-action-card">
                        <i class="fas fa-percentage"></i>
                        <h3>Акции</h3>
                    </a>
                    <a href="staff_clients_list.php" class="quick-action-card">
                        <i class="fas fa-users"></i>
                        <h3>Все клиенты</h3>
                    </a>
                </div>
            <?php else: ?>
                <!-- Менеджер -->
                <div class="quick-actions-row centered-row">
                    <a href="staff_my_bookings_list.php?manager=<?= $staff_id ?>" class="quick-action-card">
                        <i class="fas fa-calendar"></i>
                        <h3>Мои бронирования</h3>
                    </a>
                    <a href="staff_my_clients_list.php?manager=<?= $staff_id ?>" class="quick-action-card">
                        <i class="fas fa-users"></i>
                        <h3>Мои клиенты</h3>
                    </a>
                    <a href="staff_bookings.php?action=create" class="quick-action-card">
                        <i class="fas fa-calendar-plus"></i>
                        <h3>Новое бронирование</h3>
                    </a>
                </div>
                
                <div class="quick-actions-row centered-row">
                    <a href="staff_hotels_list.php" class="quick-action-card">
                        <i class="fas fa-hotel"></i>
                        <h3>Отели</h3>
                    </a>
                    <a href="staff_promotions_list.php" class="quick-action-card">
                        <i class="fas fa-percentage"></i>
                        <h3>Акции</h3>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/parts/footer.php'; ?>