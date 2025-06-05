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
require_once 'parts/header_in.php';

// Получение данных пользователя
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT name, surname, email, number FROM client WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Пользователь с ID $user_id не найден в базе данных");
}

// Упрощенный запрос для получения бронирований (без связи с tour)
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
?>

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
                <li><a href="index.php"><i class="fas fa-home"></i> Главная</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Настройки</a></li>
            </ul>
        </nav>
    </div>
    
    <div class="personal-content">
        <div class="personal-header">
            <h1>Добро пожаловать, <?= htmlspecialchars($user['name']) ?>!</h1>
            <p>Здесь вы можете управлять своими бронированиями, настройками и получать персональные предложения.</p>
        </div>
        
        <section class="personal-section">
            <div class="section-header">
                <h2>Мои бронирования</h2>
                <a href="#" class="view-all">Смотреть все</a>
            </div>
            
              <?php if (count($bookings) > 0): ?>
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
                                    <div class="status <?= strtolower(htmlspecialchars($booking['status'])) ?>">
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
        
        <!-- Остальные секции без изменений -->
        <section class="personal-section">
            <div class="section-header">
                <h2>Персональные предложения</h2>
            </div>
            
            <div class="special-offers">
                <div class="offer-card">
                    <div class="offer-badge">-15%</div>
                    <div class="offer-content">
                        <h3>Эксклюзивная скидка</h3>
                        <p>Только для вас - специальная скидка на любой тур в этом месяце!</p>
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
                <a href="#" class="action-card">
                    <i class="fas fa-user-edit"></i>
                    <span>Редактировать профиль</span>
                </a>
                <a href="#" class="action-card">
                    <i class="fas fa-bell"></i>
                    <span>Уведомления</span>
                </a>
            </div>
        </section>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Подсветка активного пункта меню
        const menuItems = document.querySelectorAll('.personal-menu li');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Анимация кнопок
        const buttons = document.querySelectorAll('.book-btn, .booking-details, .offer-btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>

<?php require_once 'parts/footer.php'; ?>