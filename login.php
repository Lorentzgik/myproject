<!-- login.php -->
<?php
$current_page = 'login';
$page_title = 'TravelDream - Вход в аккаунт';
$page_css = 'auth';
require_once 'parts/header.php';
?>

<main class="container auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Вход в аккаунт</h1>
            <p class="subtitle">Продолжайте планировать своё идеальное путешествие</p>
        </div>
        
        <form class="auth-form">
            <div class="form-group">
                <label for="email">Электронная почта</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" required placeholder="example@mail.ru">
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" required placeholder="Введите ваш пароль">
                </div>
                <a href="#" class="forgot-password">Забыли пароль?</a>
            </div>
            
            <button type="submit" class="book-btn auth-submit">
                <span>Войти</span>
                <i class="fas fa-arrow-right"></i>
            </button>
            
            <div class="social-login">
                <p>Или войдите с помощью:</p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-vk"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>
            
            <div class="auth-footer">
                Ещё нет аккаунта? <a href="registration.php" class="auth-link">Зарегистрироваться</a>
            </div>
        </form>
    </div>
</main>

<?php require_once 'parts/footer.php'; ?>