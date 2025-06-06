<!-- offers.php -->
<?php
session_start();
$current_page = 'offers';
$page_title = 'TravelDream - Акции и скидки';
$page_css = 'offers';
require_once 'parts/header.php';
?>

<main class="container offers-container">
    <h1>Акции и специальные предложения</h1>
    <p class="subtitle">Эксклюзивные условия для наших клиентов</p>
    
    <!-- Баннер главной акции -->
    <div class="main-offer">
        <div class="offer-content">
            <span class="offer-badge">Акция месяца</span>
            <h2>Скидка 25% на раннее бронирование</h2>
            <p>Забронируйте тур до 31 декабря и получите скидку 25% на все направления!</p>
            <div class="offer-timer">
                <i class="fas fa-clock"></i>
                <span>До конца акции: <strong>12д 06ч 45м</strong></span>
            </div>
            <button class="book-btn">Узнать подробности</button>
        </div>
        <div class="offer-image">
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4" alt="Акция">
        </div>
    </div>
    
    <!-- Сетка акций -->
    <div class="offers-grid">
        <!-- Акция 1 -->
        <div class="offer-card hot-offer">
            <div class="offer-card-header">
                <span class="discount">-15%</span>
                <span class="offer-label">Горящий тур</span>
            </div>
            <img src="https://images.unsplash.com/photo-1503917988258-f87a78e3c995" alt="Мальдивы">
            <div class="offer-card-body">
                <h3>Мальдивы - спеццена</h3>
                <p>Только до 15 января скидка 15% на все бунгало</p>
                <div class="price">
                    <span class="old-price">145 000 ₽</span>
                    <span class="new-price">123 250 ₽</span>
                </div>
            </div>
        </div>
        
        <!-- Акция 2 -->
        <div class="offer-card">
            <div class="offer-card-header">
                <span class="discount">-10%</span>
            </div>
            <img src="https://images.unsplash.com/photo-1535463731090-e34f4b5098c5" alt="Бали">
            <div class="offer-card-body">
                <h3>Скидка на виллы на Бали</h3>
                <p>При бронировании до 20 февраля</p>
                <div class="price">
                    <span class="old-price">98 000 ₽</span>
                    <span class="new-price">88 200 ₽</span>
                </div>
            </div>
        </div>
        
        <!-- Акция 3 -->
        <div class="offer-card family-offer">
            <div class="offer-card-header">
                <span class="discount">Ребёнок 0₽</span>
                <span class="offer-label">Семейный отдых</span>
            </div>
            <img src="https://images.unsplash.com/photo-1590523278191-995cbcda646b" alt="Турция">
            <div class="offer-card-body">
                <h3>Ребёнок бесплатно в Турции</h3>
                <p>При бронировании номера для 2 взрослых</p>
                <div class="price">
                    <span class="old-price">85 000 ₽</span>
                    <span class="new-price">85 000 ₽</span>
                    <span class="child-price">+ ребёнок 0₽</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Дополнительные условия -->
    <div class="offer-conditions">
        <h2>Как получить скидку?</h2>
        <div class="conditions-grid">
            <div class="condition-card">
                <i class="fas fa-calendar-check"></i>
                <h3>Раннее бронирование</h3>
                <p>Бронируйте за 3-6 месяцев до поездки и экономьте до 30%</p>
            </div>
            <div class="condition-card">
                <i class="fas fa-users"></i>
                <h3>Групповые скидки</h3>
                <p>От 5 человек - специальные условия</p>
            </div>
            <div class="condition-card">
                <i class="fas fa-gift"></i>
                <h3>Подарочные сертификаты</h3>
                <p>Дарите путешествия со скидкой 10%</p>
            </div>
        </div>
    </div>
</main>

<script src="js/offers.js"></script>
<?php require_once 'parts/footer.php'; ?>