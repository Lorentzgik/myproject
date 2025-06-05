<!-- booking.php -->
<?php
$current_page = '';
$page_title = 'TravelDream - Бронирование тура';
$page_css = 'booking';
require_once 'parts/header.php';

// Получение данных тура из БД
$tour_id = $_GET['id'] ?? 1;
// $tour = get_tour_by_id($tour_id); // Пример функции
?>

<main class="container booking-container">
        <section class="tour-summary">
            <div class="tour-summary-image">
                <img src="https://images.unsplash.com/photo-1565967511849-76a60a516170?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Мальдивы">
            </div>
            <h2>Райские Мальдивы</h2>
            <div class="tour-summary-meta">
                <div>
                    <span><i class="fas fa-map-marker-alt"></i> Направление:</span>
                    <span>Мальдивы</span>
                </div>
                <div>
                    <span><i class="fas fa-calendar"></i> Даты:</span>
                    <span>15.08.2023 - 22.08.2023</span>
                </div>
                <div>
                    <span><i class="fas fa-user-friends"></i> Туристы:</span>
                    <span>2 взрослых</span>
                </div>
                <div>
                    <span><i class="fas fa-hotel"></i> Отель:</span>
                    <span>Paradise Resort 4*</span>
                </div>
            </div>
            <div class="tour-summary-price">
                120 000 ₽
            </div>
            <button class="book-btn" style="width: 100%;">Забронировать</button>
        </section>
        
        <section class="booking-form">
            <div class="booking-steps">
                <div class="step active">
                    <div class="step-icon">1</div>
                    <span class="step-label">Данные туристов</span>
                </div>
                <div class="step">
                    <div class="step-icon">2</div>
                    <span class="step-label">Оплата</span>
                </div>
                <div class="step">
                    <div class="step-icon">3</div>
                    <span class="step-label">Подтверждение</span>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Данные туристов</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Фамилия</label>
                        <input type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Имя</label>
                        <input type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Отчество</label>
                        <input type="text">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Дата рождения</label>
                        <input type="date" required>
                    </div>
                    <div class="form-group">
                        <label>Гражданство</label>
                        <input type="text" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Серия и номер паспорта</label>
                        <input type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Срок действия паспорта</label>
                        <input type="date" required>
                    </div>
                </div>
            </div>
            
            <div class="form-section">
                <h3>Контактная информация</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Электронная почта</label>
                        <input type="email" required>
                    </div>
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="tel" required>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button class="btn btn-prev">Назад</button>
                <button class="btn btn-next">Продолжить</button>
            </div>
        </section>
    </main>

<?php require_once 'parts/footer.php'; ?>