<?php
// index.php
session_start();
require_once __DIR__ . '/db.php'; // Подключаем файл с соединением к БД

$current_page = 'index';
$page_title = 'TravelDream - Путешествия вашей мечты';
$page_css = 'index';
require_once 'parts/header.php';

// Получаем туры из базы данных
try {
    $stmt = $db->query("SELECT * FROM tour LIMIT 3"); // Берем 3 первых тура
    $tours = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Ошибка при получении туров: " . $e->getMessage());
}
?>

<section class="hero">
    <div class="hero-content">
        <h1>Путешествия вашей мечты</h1>
        <p>Откройте для себя новые горизонты с нами - ваш идеальный отдых начинается здесь!</p>
        
        <div class="search-box">
            <input type="text" placeholder="Куда вы хотите поехать?">
            <button><i class="fas fa-search"></i> Найти тур</button>
        </div>
    </div>
</section>

<section class="container">
    <div class="section-title">
        <h2>Популярные туры</h2>
    </div>
    
    <div class="tours-grid">
        <?php foreach ($tours as $tour): ?>
        <div class="tour-card">
            <div class="tour-image">
                <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="<?= htmlspecialchars($tour['title']) ?>">
            </div>
            <div class="tour-content">
                <h3 class="tour-title"><?= htmlspecialchars($tour['title']) ?></h3>
                <div class="tour-location">
                    <i class="fas fa-map-marker-alt"></i>
                    <?= htmlspecialchars($tour['type']) ?>
                </div>
                <div class="tour-meta">
                    <div><i class="fas fa-calendar"></i> 
                        <?= date('d.m.Y', strtotime($tour['start_date'])) ?> - <?= date('d.m.Y', strtotime($tour['end_date'])) ?>
                    </div>
                    <div><i class="fas fa-clock"></i> 
                        <?= date_diff(date_create($tour['start_date']), date_create($tour['end_date']))->format('%a') ?> дней
                    </div>
                </div>
                <div class="tour-price">
                    <div class="price"><?= number_format($tour['price'], 0, '', ' ') ?> ₽</div>
                    <a href="booking.php?tour_id=<?= $tour['id'] ?>" class="book-btn">Забронировать</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div style="text-align: center; margin: 30px 0;">
        <a href="tours.php" class="view-all-btn" style="padding: 12px 40px; display: inline-block; background: #3498db; color: white; border-radius: 8px; text-decoration: none; transition: all 0.3s ease; border: none; outline: none;">
            <i class="fas fa-arrow-right"></i> Смотреть все туры
        </a>
    </div>
</section>

<section class="benefits">
    <div class="container">
        <div class="section-title">
            <h2>Почему выбирают нас</h2>
        </div>
        
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Безопасность</h3>
                <p>Все туры застрахованы, а наши партнеры проверены временем</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <h3>Лучшие цены</h3>
                <p>Гарантируем самые выгодные цены на рынке туристических услуг</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Поддержка 24/7</h3>
                <p>Наша команда поддержки всегда готова помочь в любой ситуации</p>
            </div>
            
            <div class="benefit-card">
                <div class="benefit-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3>Эксклюзивные туры</h3>
                <p>Уникальные маршруты, недоступные в других агентствах</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="container testimonials">
    <div class="section-title">
        <h2>Отзывы клиентов</h2>
    </div>
    
    <div class="testimonials-grid">
        <div class="testimonial-card">
            <p class="testimonial-text">Отдых на Бали превзошел все ожидания! Спасибо TravelDream за идеально организованный тур. Отличные отели, интересные экскурсии и приятные цены.</p>
            <div class="testimonial-author">
                <div class="author-avatar">
                    <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Мария">
                </div>
                <div class="author-info">
                    <h4>Мария Иванова</h4>
                    <p>Бали, июнь 2023</p>
                </div>
            </div>
        </div>
        
        <div class="testimonial-card">
            <p class="testimonial-text">Впервые доверил организацию отпуска профессионалам и не пожалел. Мальдивы - это сказка! Особенно понравилась организация трансферов и экскурсий.</p>
            <div class="testimonial-author">
                <div class="author-avatar">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Алексей">
                </div>
                <div class="author-info">
                    <h4>Алексей Петров</h4>
                    <p>Мальдивы, апрель 2023</p>
                </div>
            </div>
        </div>
        
        <div class="testimonial-card">
            <p class="testimonial-text">Швейцарские Альпы были моей мечтой с детства. Благодаря TravelDream эта мечта сбылась! Отличные гиды, комфортные отели и незабываемые впечатления.</p>
            <div class="testimonial-author">
                <div class="author-avatar">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Екатерина">
                </div>
                <div class="author-info">
                    <h4>Екатерина Сидорова</h4>
                    <p>Швейцария, январь 2023</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Special Offers -->
<section class="benefits" style="background: linear-gradient(135deg, #f97316, #ea580c); margin:0">
    <div class="container">
        <div class="section-title">
            <h2>Специальные предложения</h2>
        </div>
        
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h3 style="font-size: 1.8rem; margin-bottom: 20px;">Получите скидку 15% на первый тур!</h3>
            <p style="font-size: 1.2rem; margin-bottom: 30px;">Зарегистрируйтесь на нашем сайте и получите персональную скидку на первый заказ.</p>
            <button id="discountBtn" class="book-btn" style="background: white; color: #f97316; padding: 15px 40px;">
                <i class="fas fa-gift"></i> Получить скидку
            </button>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Обработка кнопки "Получить скидку"
        const discountBtn = document.getElementById('discountBtn');
        if (discountBtn) {
            discountBtn.addEventListener('click', function(e) {
                e.preventDefault();
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Перенаправление...';
                setTimeout(() => {
                    window.location.href = 'registration.php';
                }, 1000);
            });
        }

        // Обработка поиска
        const searchButton = document.querySelector('.search-box button');
        searchButton.addEventListener('click', function() {
            const searchInput = document.querySelector('.search-box input');
            const query = searchInput.value.trim();
            if (query) {
                window.location.href = `tours.php?search=${encodeURIComponent(query)}`;
            }
        });
    });
</script>

<?php require_once 'parts/footer.php'; ?>