<!-- login.php -->
<?php
$current_page = 'login';
$page_title = 'TravelDream - Вход в аккаунт';
$page_css = 'auth';
require_once 'parts/header.php';
?>

<main class="container auth-container">
    <div class="auth-card">
        <h1>Вход в аккаунт</h1>
        
        <form class="auth-form">
            <div class="form-group">
                <label>Электронная почта</label>
                <input type="email" required placeholder="example@mail.ru">
            </div>
            
            <div class="form-group">
                <label>Пароль</label>
                <input type="password" required placeholder="••••••••">
                <a href="#" class="forgot-password">Забыли пароль?</a>
            </div>
            
            <button type="submit" class="book-btn">Войти</button>
            
            <div class="social-login">
                <p>Или войдите с помощью:</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-vk"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            
            <div class="auth-footer">
                Ещё нет аккаунта? <a href="registration.php">Зарегистрироваться</a>
            </div>
        </form>
    </div>
</main>

<?php require_once 'parts/footer.php'; ?>