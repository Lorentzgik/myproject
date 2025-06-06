<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$current_page = 'personal';
$page_title = 'TravelDream - Личный кабинет';
$page_css = 'personal';

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Подключаем БД и header
require_once 'db.php';
require_once 'parts/header.php';

// Получение данных пользователя
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT name, surname, email, number FROM client WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Пользователь с ID $user_id не найден в базе данных");
}

// Обработка формы настроек
$settings_errors = [];
$settings_success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_settings'])) {
    $new_email = trim($_POST['email']);
    $new_number = trim($_POST['number']);
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Валидация email
    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $settings_errors['email'] = 'Введите корректный email';
    }

    // Валидация номера телефона
    if (!preg_match('/^[\d\+\-\(\)\s]{10,20}$/', $new_number)) {
        $settings_errors['number'] = 'Введите корректный номер телефона';
    }

    // Проверка пароля
    $password_changed = false;
    if (!empty($new_password)) {
        if (empty($current_password)) {
            $settings_errors['current_password'] = 'Введите текущий пароль';
        } else {
            $stmt = $db->prepare("SELECT password FROM client WHERE id = ?");
            $stmt->execute([$user_id]);
            $db_password = $stmt->fetchColumn();
            
            if (!password_verify($current_password, $db_password)) {
                $settings_errors['current_password'] = 'Неверный текущий пароль';
            } elseif (strlen($new_password) < 6) {
                $settings_errors['new_password'] = 'Пароль должен содержать минимум 6 символов';
            } elseif ($new_password !== $confirm_password) {
                $settings_errors['confirm_password'] = 'Пароли не совпадают';
            } else {
                $password_changed = true;
            }
        }
    }

    // Если нет ошибок - обновляем данные
    if (empty($settings_errors)) {
        try {
            $db->beginTransaction();
            
            if ($password_changed) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("UPDATE client SET email = ?, number = ?, password = ? WHERE id = ?");
                $success = $stmt->execute([$new_email, $new_number, $hashed_password, $user_id]);
            } else {
                $stmt = $db->prepare("UPDATE client SET email = ?, number = ? WHERE id = ?");
                $success = $stmt->execute([$new_email, $new_number, $user_id]);
            }
            
            if ($success) {
                $db->commit();
                $settings_success = true;
                // Обновляем данные пользователя
                $stmt = $db->prepare("SELECT name, surname, email, number FROM client WHERE id = ?");
                $stmt->execute([$user_id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $db->rollBack();
                $settings_errors['general'] = 'Не удалось обновить данные';
            }
        } catch (PDOException $e) {
            $db->rollBack();
            $settings_errors['general'] = 'Ошибка базы данных: ' . $e->getMessage();
            error_log('DB Error: ' . $e->getMessage());
        }
    }
}

// Получение бронирований
$bookings_stmt = $db->prepare("
    SELECT 
        id AS booking_id,
        booking_date,
        status,
        price AS total_price,
        amount_per_person,
        description AS booking_description
    FROM booking
    WHERE client_id = ?
    ORDER BY booking_date DESC
    LIMIT 3
");
$bookings_stmt->execute([$user_id]);
$bookings = $bookings_stmt->fetchAll(PDO::FETCH_ASSOC);

$active_section = isset($_GET['settings']) ? 'settings' : 'main';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/personal.css">
</head>
<body>
    <?php require_once 'parts/header.php'; ?>

    <main class="personal-container">
        <div class="personal-sidebar">
            <div class="user-profile">
                <div class="user-avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-info">
                    <h3><?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></h3>
                    <p><?= htmlspecialchars($user['email']) ?></p>
                </div>
            </div>
            
            <nav class="personal-menu">
                <ul>
                    <li class="<?= $active_section === 'main' ? 'active' : '' ?>">
                        <a href="personal.php"><i class="fas fa-home"></i> Главная</a>
                    </li>
                    <li class="<?= $active_section === 'settings' ? 'active' : '' ?>">
                        <a href="?settings"><i class="fas fa-cog"></i> Настройки</a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <div class="personal-content">
            <?php if ($active_section === 'settings'): ?>
                <div class="personal-header">
                    <h1>Настройки профиля</h1>
                    <p>Обновите ваши контактные данные и пароль</p>
                </div>
                
                <section class="personal-section settings-section">
                    <?php if ($settings_success): ?>
                        <div class="alert success-alert">
                            <i class="fas fa-check-circle"></i>
                            <span>Ваши данные успешно обновлены!</span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($settings_errors['general'])): ?>
                        <div class="alert error-alert">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?= htmlspecialchars($settings_errors['general']) ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="modern-form">
                        <div class="form-section">
                            <h3><i class="fas fa-user-edit"></i> Основная информация</h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope"></i> Email
                                    </label>
                                    <div class="input-with-icon">
                                        <input type="email" id="email" name="email" 
                                            value="<?= htmlspecialchars($user['email']) ?>" required>
                                        <i class="fas fa-check-circle valid-icon"></i>
                                    </div>
                                    <?php if (!empty($settings_errors['email'])): ?>
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <?= htmlspecialchars($settings_errors['email']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="number">
                                        <i class="fas fa-phone"></i> Телефон
                                    </label>
                                    <div class="input-with-icon">
                                        <input type="tel" id="number" name="number" 
                                            value="<?= htmlspecialchars($user['number'] ?? '') ?>">
                                        <i class="fas fa-check-circle valid-icon"></i>
                                    </div>
                                    <?php if (!empty($settings_errors['number'])): ?>
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <?= htmlspecialchars($settings_errors['number']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-section password-section">
                            <h3><i class="fas fa-lock"></i> Смена пароля</h3>
                            <p class="section-description">Оставьте эти поля пустыми, если не хотите менять пароль</p>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="current_password">
                                        <i class="fas fa-key"></i> Текущий пароль
                                    </label>
                                    <div class="input-with-icon password-field">
                                        <input type="password" id="current_password" name="current_password">
                                        <button type="button" class="toggle-password" aria-label="Показать пароль">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <?php if (!empty($settings_errors['current_password'])): ?>
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <?= htmlspecialchars($settings_errors['current_password']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="new_password">
                                        <i class="fas fa-key"></i> Новый пароль
                                    </label>
                                    <div class="input-with-icon password-field">
                                        <input type="password" id="new_password" name="new_password">
                                        <button type="button" class="toggle-password" aria-label="Показать пароль">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <?php if (!empty($settings_errors['new_password'])): ?>
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <?= htmlspecialchars($settings_errors['new_password']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirm_password">
                                        <i class="fas fa-key"></i> Подтвердите пароль
                                    </label>
                                    <div class="input-with-icon password-field">
                                        <input type="password" id="confirm_password" name="confirm_password">
                                        <button type="button" class="toggle-password" aria-label="Показать пароль">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <?php if (!empty($settings_errors['confirm_password'])): ?>
                                        <span class="error-message">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <?= htmlspecialchars($settings_errors['confirm_password']) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-actions" style="justify-content: center; gap: 20px;">
                            <button type="submit" name="update_settings" class="btn-save" style="padding: 12px 40px; background: #3498db; color: white; border-radius: 8px; text-decoration: none; transition: all 0.3s ease; border: none; outline: none;">
                                <i class="fas fa-save"></i> Сохранить изменения
                            </button>
                            <a href="personal.php" class="btn-cancel" style="padding: 12px 40px; display: inline-block; background: #f5f5f5; color: #2c3e50; border-radius: 8px; text-decoration: none; transition: all 0.3s ease; border: none; outline: none;">
                                <i class="fas fa-times"></i> Отмена
                            </a>
                        </div>
                    </form>
                </section>
            <?php else: ?>
                <!-- Основной контент -->
                <div class="personal-header">
                    <h1>Добро пожаловать, <?= htmlspecialchars($user['name']) ?>!</h1>
                    <p>Здесь вы можете управлять своими бронированиями и настройками</p>
                </div>
                
                <section class="personal-section">
                    <div class="section-header">
                        <h2>Мои бронирования</h2>
                        <a href="#" class="view-all">Смотреть все</a>
                    </div>
                    
                    <?php if (!empty($bookings)): ?>
                        <div class="bookings-grid">
                            <?php foreach ($bookings as $booking): ?>
                                <div class="booking-card">
                                    <div class="booking-image">
                                        <i class="fas fa-suitcase fa-4x"></i>
                                    </div>
                                    <div class="booking-content">
                                        <h3>Бронирование #<?= htmlspecialchars($booking['booking_id']) ?></h3>
                                        <div class="booking-meta">
                                            <div><i class="fas fa-calendar-alt"></i> <?= date('d.m.Y', strtotime($booking['booking_date'])) ?></div>
                                            <div><i class="fas fa-users"></i> <?= htmlspecialchars($booking['amount_per_person']) ?> чел.</div>
                                            <div class="status <?= strtolower($booking['status']) ?>">
                                                <i class="fas fa-circle"></i> <?= htmlspecialchars($booking['status']) ?>
                                            </div>
                                        </div>
                                        <div class="price-info">
                                            <div class="total-price">Итого: <?= number_format($booking['total_price'], 0, '', ' ') ?> ₽</div>
                                        </div>
                                        <?php if (!empty($booking['booking_description'])): ?>
                                            <p class="booking-description"><?= htmlspecialchars($booking['booking_description']) ?></p>
                                        <?php endif; ?>
                                        <button class="booking-details">Подробнее</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-suitcase"></i>
                            <p>У вас пока нет бронирований</p>
                            <a href="tours.php" class="book-btn">Найти тур</a>
                        </div>
                    <?php endif; ?>
                </section>
                
                <!-- Другие секции -->
                <section class="personal-section">
                    <div class="section-header">
                        <h2>Персональные предложения</h2>
                    </div>
                    <div class="special-offers">
                        <div class="offer-card">
                            <div class="offer-badge">-15%</div>
                            <div class="offer-content">
                                <h3>Эксклюзивная скидка</h3>
                                <p>Специальная скидка на любой тур в этом месяце!</p>
                                <button class="offer-btn">Использовать</button>
                            </div>
                        </div>
                        <div class="offer-card">
                            <div class="offer-badge">Бесплатно</div>
                            <div class="offer-content">
                                <h3>Экскурсия в подарок</h3>
                                <p>При бронировании тура на 7+ дней - бесплатная экскурсия!</p>
                                <button class="offer-btn">Подробнее</button>
                            </div>
                        </div>
                    </div>
                </section>
                
                <section class="personal-section quick-actions">
                    <h2>Быстрые действия</h2>
                    <div class="actions-grid">
                        <a href="tours.php" class="action-card">
                            <i class="fas fa-search"></i>
                            <span>Найти тур</span>
                        </a>
                        <a href="#" class="action-card">
                            <i class="fas fa-history"></i>
                            <span>История бронирований</span>
                        </a>
                        <a href="?settings" class="action-card">
                            <i class="fas fa-user-edit"></i>
                            <span>Редактировать профиль</span>
                        </a>
                        <a href="#" class="action-card">
                            <i class="fas fa-bell"></i>
                            <span>Уведомления</span>
                        </a>
                    </div>
                </section>
            <?php endif; ?>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Переключение видимости пароля
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('input');
                    const icon = this.querySelector('i');
                    
                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });
            
            // Анимация кнопок
            const buttons = document.querySelectorAll(
                '.book-btn, .booking-details, .offer-btn, .btn-save, .btn-cancel, .action-card'
            );
            
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
        });
    </script>

    <?php require_once 'parts/footer.php'; ?>
</body>
</html>