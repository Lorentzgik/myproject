<?php
session_start();
if (isset($_SESSION['staff_logged_in'])) {
    header('Location: staff_dashboard.php');
    exit;
}

$current_page = 'staff_login';
$page_title = 'TravelDream - Вход для сотрудников';
$page_css = 'auth';
require_once 'parts/header.php';
?>

<main class="container auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1><i class="fas fa-user-shield"></i> Вход для сотрудников</h1>
            <p class="subtitle">Доступ к панели администратора</p>
        </div>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <p>Неверное имя пользователя или пароль</p>
            </div>
        <?php endif; ?>
        
        <form class="auth-form" action="staff_auth.php" method="post">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-user-tie"></i></span>
                    <input type="text" id="username" name="username" required placeholder="Введите имя пользователя">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" required placeholder="Введите ваш пароль">
                </div>
            </div>
            
            <button type="submit" class="book-btn auth-submit">
                <span>Войти</span>
                <i class="fas fa-arrow-right"></i>
            </button>
            
            <div class="auth-footer">
                Вернуться на <a href="index.php" class="auth-link">главную страницу</a>
            </div>
        </form>
    </div>
</main>

<?php require_once 'parts/footer.php'; ?>