<!-- contacts.php -->
<?php
session_start();
$current_page = 'contacts';
$page_title = 'TravelDream - Контакты';
$page_css = 'contacts';
require_once 'parts/header.php';
?>

<main class="container contacts-container">
    <h1>Наши контакты</h1>
    
    <!-- Контактная плашка в линию -->
    <div class="contact-bar">
        <div class="contact-item">
            <i class="fas fa-map-marker-alt"></i>
            <div>
                <h3>Адрес</h3>
                <p>Москва, ул. Тверская, д. 15</p>
            </div>
        </div>
        
        <div class="contact-item">
            <i class="fas fa-phone"></i>
            <div>
                <h3>Телефон</h3>
                <p>+7 (495) 123-45-67</p>
            </div>
        </div>
        
        <div class="contact-item">
            <i class="fas fa-envelope"></i>
            <div>
                <h3>Email</h3>
                <p>info@traveldream.ru</p>
            </div>
        </div>
        
        <div class="contact-item">
            <i class="fas fa-clock"></i>
            <div>
                <h3>Часы работы</h3>
                <p>Пн-Пт: 10:00–20:00</p>
            </div>
        </div>
    </div>
    
    <!-- Карта -->
    <div class="map-section">
        <h2>Мы на карте</h2>
        <div id="yandex-map" style="width: 100%; height: 400px;"></div>
    </div>
    
    <!-- Форма обратной связи -->
    <div class="feedback-section">
        <h2>Обратная связь</h2>
        <form class="contact-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Ваше имя</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Телефон</label>
                <input type="tel">
            </div>
            
            <div class="form-group">
                <label>Сообщение</label>
                <textarea rows="5" required></textarea>
            </div>
            
            <button type="submit" class="book-btn">Отправить сообщение</button>
        </form>
    </div>
</main>

<script src="https://api-maps.yandex.ru/2.1/?apikey=ваш_ключ&lang=ru_RU" type="text/javascript"></script>
<script>
    ymaps.ready(init);
    function init() {
        const map = new ymaps.Map("yandex-map", {
            center: [55.76, 37.60],
            zoom: 15
        });
        
        const officePlacemark = new ymaps.Placemark([55.76, 37.60], {
            hintContent: 'Офис TravelDream',
            balloonContent: 'ул. Тверская, д. 15'
        });
        
        map.geoObjects.add(officePlacemark);
    }
</script>

<?php require_once 'parts/footer.php'; ?>