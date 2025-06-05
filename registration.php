<!-- registration.php -->
<?php
$current_page = 'registration';
$page_title = 'TravelDream - Регистрация';
$page_css = 'auth';
require_once 'parts/header.php';
require_once 'db.php';

// Инициализация переменных
$errors = [];
$firstname = $lastname = $email = $phone = '';

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получение и очистка данных
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $agreement = $_POST['agreement'] ?? '';

    // Валидация данных
    if (empty($firstname)) {
        $errors['firstname'] = 'Пожалуйста, введите ваше имя';
    } elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $firstname)) {
        $errors['firstname'] = 'Имя содержит недопустимые символы';
    }

    if (empty($lastname)) {
        $errors['lastname'] = 'Пожалуйста, введите вашу фамилию';
    } elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-]+$/u', $lastname)) {
        $errors['lastname'] = 'Фамилия содержит недопустимые символы';
    }

    if (empty($email)) {
        $errors['email'] = 'Пожалуйста, введите email';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Некорректный формат email';
    } else {
        // Проверка на существующий email
        $stmt = $db->prepare("SELECT id FROM client WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors['email'] = 'Этот email уже зарегистрирован';
        }
    }

    if (empty($password)) {
        $errors['password'] = 'Пожалуйста, введите пароль';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Пароль должен содержать минимум 8 символов';
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Пожалуйста, подтвердите пароль';
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Пароли не совпадают';
    }

    $phone_clean = preg_replace('/[^0-9]/', '', $phone);

    // Проверяем, что номер:
    // - Не пустой (если поле обязательно)
    // - Содержит 11 цифр
    // - Начинается на 7 или 8 (для российских номеров)
    if (!empty($phone)) {
        if (strlen($phone_clean) !== 11) {
            $errors['phone'] = 'Номер должен содержать 11 цифр';
        } elseif (!preg_match('/^[78]/', $phone_clean)) {
            $errors['phone'] = 'Номер должен начинаться с 7 или 8';
        }
    }

    if (empty($agreement)) {
        $errors['agreement'] = 'Необходимо согласиться с условиями';
    }

    // Если ошибок нет - сохраняем пользователя в БД
    if (empty($errors)) {
        try {
            // Хеширование пароля
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Используем уже очищенный $phone_clean
            $phone_clean = (strlen($phone_clean) === 11) ? $phone_clean : null;
            
            $stmt = $db->prepare("INSERT INTO client (name, surname, email, password, number) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$firstname, $lastname, $email, $hashed_password, $phone_clean]);
            
            // Регистрация прошла успешно
            echo '<div class="alert alert-success">Регистрация прошла успешно! Теперь вы можете <a href="login.php">войти</a>.</div>';
            // Сброс полей формы
            $firstname = $lastname = $email = $phone = '';
        } catch (PDOException $e) {
            $errors[] = 'Ошибка при регистрации: ' . $e->getMessage();
        }
    }
}
?>

<main class="container auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Создать аккаунт</h1>
            <p class="subtitle">Начните планировать своё идеальное путешествие</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <form class="auth-form" method="POST" novalidate>
            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">Имя</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="firstname" name="firstname" required placeholder="Введите ваше имя" value="<?= htmlspecialchars($firstname) ?>">
                    </div>
                    <?php if (isset($errors['firstname'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['firstname']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="lastname">Фамилия</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-user"></i></span>
                        <input type="text" id="lastname" name="lastname" required placeholder="Введите вашу фамилию" value="<?= htmlspecialchars($lastname) ?>">
                    </div>
                    <?php if (isset($errors['lastname'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['lastname']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
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
            
            <div class="form-row">
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" required placeholder="Не менее 8 символов">
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['password']) ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Подтвердите пароль</label>
                    <div class="input-wrapper">
                        <span class="input-icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Повторите пароль">
                    </div>
                    <?php if (isset($errors['confirm_password'])): ?>
                        <span class="error-message"><?= htmlspecialchars($errors['confirm_password']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="phone">Телефон</label>
                <div class="input-wrapper">
                    <span class="input-icon"><i class="fas fa-phone"></i></span>
                    <input type="tel" id="phone" name="phone" placeholder="Введите 11 цифр" value="<?= htmlspecialchars($phone) ?>">
                </div>
                <?php if (isset($errors['phone'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['phone']) ?></span>
                <?php endif; ?>
            </div>
            
            <div class="form-checkbox">
                <input type="checkbox" id="agreement" name="agreement" required>
                <label for="agreement">Я согласен с <a href="#">условиями использования</a> и <a href="#">политикой конфиденциальности</a></label>
                <?php if (isset($errors['agreement'])): ?>
                    <span class="error-message"><?= htmlspecialchars($errors['agreement']) ?></span>
                <?php endif; ?>
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

<script>
    $(document).ready(function() {
        $('#phone').inputmask('99999999999', {
            placeholder: '',  
            showMaskOnHover: false
        });
    });
</script>

<?php require_once 'parts/footer.php'; ?>