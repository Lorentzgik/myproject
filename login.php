<!-- login.php -->
<?php
$current_page = 'login';
$page_title = 'TravelDream - Вход в аккаунт';
$page_css = 'auth';
require_once 'parts/header.php';
require_once 'db.php';

// Инициализация переменных
$errors = [];
$email = '';

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение и очистка данных
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Валидация данных
    if (empty($email)) {
        $errors['email'] = 'Пожалуйста, введите email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Некорректный формат email';
    }

    if (empty($password)) {
        $errors['password'] = 'Пожалуйста, введите пароль';
    }

    // Если ошибок нет - проверяем учетные данные
    if (empty($errors)) {
        try {
            // Ищем пользователя по email
            $stmt = $db->prepare("SELECT id, name, surname, email, password FROM client WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Успешная авторизация
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                // Перенаправляем в личный кабинет
                header('Location: personal.php');
                exit();
            } else {
                $errors['auth'] = 'Неверный email или пароль';
            }
        } catch (PDOException $e) {
            $errors[] = 'Ошибка при авторизации: ' . $e->getMessage();
        }
    }
}
?>

<main class="container auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Вход в аккаунт</h1>
            <p class="subtitle">Продолжайте планировать своё идеальное путешествие</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form class="auth-form" method="POST" novalidate>
            <div class="form-group">
                <label for="email">Электронная почта</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" required placeholder="example@mail.ru" value="<?= htmlspecialchars($email) ?>">
                </div>
                <?php if (isset($errors['email'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['email']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" required placeholder="Введите ваш пароль">
                </div>
                <?php if (isset($errors['password'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['password']) ?></span>
                <?php endif; ?>
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