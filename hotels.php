<!-- hotels.php -->
<?php
$current_page = 'hotels';
$page_title = 'TravelDream - Отели';
$page_css = 'hotels';
require_once 'parts/header.php';

$tour_id = $_GET['tour_id'] ?? 0;
?>

<main class="container hotels-container">
        <h1>Отели для вашего тура</h1>
        
        <div class="hotel-filters">
            <select id="tour-select">
                <option value="">Все туры</option>
                <option value="1">Мальдивы</option>
                <option value="2">Бали</option>
            </select>
        </div>

        <div class="hotels-grid">
            <!-- Отель 1 -->
            <div class="hotel-card" data-tour-id="1">
                <div class="hotel-image">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" alt="Paradise Resort">
                </div>
                <div class="hotel-content">
                    <h2>Paradise Resort 4*</h2>
                    <p><i class="fas fa-map-marker-alt"></i> Мальдивы, атолл Северный Мале</p>
                    
                    <div class="room-types">
                        <h3>Варианты размещения:</h3>
                        <div class="room-option">
                            <span>Стандарт (2 чел.)</span>
                            <span>8 000 ₽/ночь</span>
                            <button class="book-btn">Выбрать</button>
                        </div>
                        <div class="room-option">
                            <span>Люкс с бассейном (2 чел.)</span>
                            <span>12 000 ₽/ночь</span>
                            <button class="book-btn">Выбрать</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Отель 2 -->
            <div class="hotel-card" data-tour-id="2">
                <div class="hotel-image">
                    <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa" alt="Bali Dream">
                </div>
                <div class="hotel-content">
                    <h2>Bali Dream Villa 5*</h2>
                    <p><i class="fas fa-map-marker-alt"></i> Индонезия, Убуд</p>
                    
                    <div class="room-types">
                        <h3>Варианты размещения:</h3>
                        <div class="room-option">
                            <span>Вилла с садом (2 чел.)</span>
                            <span>10 500 ₽/ночь</span>
                            <button class="book-btn">Выбрать</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<?php require_once 'parts/footer.php'; ?>