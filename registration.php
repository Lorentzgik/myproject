<!-- registration.php -->
<?php
$current_page = 'registration';
$page_title = 'TravelDream - Регистрация';
$page_css = 'auth';
require_once 'parts/header.php';


?>

<main class="container auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Создать аккаунт</h1>
            <p class="subtitle">Начните планировать своё идеальное путешествие</p>
        </div>
        
        <form class="auth-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">Имя</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="firstname" name="firstname" required placeholder="Введите ваше имя">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname">Фамилия</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="lastname" name="lastname" required placeholder="Введите вашу фамилию">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="email">Электронная почта</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" required placeholder="example@mail.ru">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" required placeholder="Не менее 8 символов">
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Подтвердите пароль</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Повторите пароль">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="phone">Телефон</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-phone"></i></span>
                    <input type="tel" id="phone" name="phone" placeholder="+7 (___) ___-__-__">
                </div>
            </div>
            
            <div class="form-checkbox">
                <input type="checkbox" id="agreement" name="agreement" required>
                <label for="agreement">Я согласен с <a href="#">условиями использования</a> и <a href="#">политикой конфиденциальности</a></label>
            </div>
            
            <button type="submit" class="book-btn auth-submit">
                <span>Зарегистрироваться</span>
                <i class="fas fa-arrow-right"></i>
            </button>
            
            <div class="auth-footer">
                Уже есть аккаунт? <a href="login.php" class="auth-link">Войти</a>
            </div>
        </form>
    </div>
</main>

<?php require_once 'parts/footer.php'; ?>