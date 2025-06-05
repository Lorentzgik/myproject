<!-- tours.php -->
<?php
$current_page = 'tours';
$page_title = 'TravelDream - Каталог туров';
$page_css = 'tours';
require_once 'parts/header.php';

// Обработка параметров
$region = $_GET['region'] ?? '';
$type = $_GET['type'] ?? '';
?>

<main class="container catalog-container">
        <aside class="filters">
            <div class="filter-section">
                <h3>Направление</h3>
                <div class="filter-options">
                    <label><input type="checkbox"> Европа</label>
                    <label><input type="checkbox"> Азия</label>
                    <label><input type="checkbox"> Африка</label>
                    <label><input type="checkbox"> Северная Америка</label>
                    <label><input type="checkbox"> Южная Америка</label>
                </div>
            </div>
            
            <div class="filter-section">
                <h3>Тип отдыха</h3>
                <div class="filter-options">
                    <label><input type="checkbox"> Пляжный</label>
                    <label><input type="checkbox"> Экскурсионный</label>
                    <label><input type="checkbox"> Горнолыжный</label>
                    <label><input type="checkbox"> Круизы</label>
                    <label><input type="checkbox"> Сафари</label>
                </div>
            </div>
            
            <div class="filter-section">
                <h3>Цена, руб.</h3>
                <div class="price-range">
                    <input type="number" placeholder="От" min="0">
                    <input type="number" placeholder="До" min="0">
                </div>
            </div>
            
            <div class="filter-section">
                <h3>Дата вылета</h3>
                <input type="date" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 5px;">
            </div>
            
            <button class="book-btn" style="width: 100%;">Применить фильтры</button>
        </aside>
        
        <section class="catalog-content">
            <div class="sorting">
                <p>Найдено 24 тура</p>
                <div>
                    <span>Сортировать:</span>
                    <select>
                        <option>По популярности</option>
                        <option>По возрастанию цены</option>
                        <option>По убыванию цены</option>
                        <option>По дате вылета</option>
                    </select>
                </div>
            </div>
            
            <div class="tours-grid">
                <!-- Карточки туров будут здесь -->
                <!-- Пример одной карточки -->
                <div class="tour-card">
                    <div class="tour-image">
                        <img src="https://images.unsplash.com/photo-1565967511849-76a60a516170?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Мальдивы">
                    </div>
                    <div class="tour-content">
                        <h3 class="tour-title">Райские Мальдивы</h3>
                        <div class="tour-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Мальдивы, Индийский океан
                        </div>
                        <div class="tour-meta">
                            <div><i class="fas fa-calendar"></i> 7 дней</div>
                            <div><i class="fas fa-user-friends"></i> 2 чел.</div>
                        </div>
                        <div class="tour-price">
                            <div class="price">120 000 ₽ <span>145 000 ₽</span></div>
                            <button class="book-btn">Забронировать</button>
                        </div>
                    </div>
                </div>
                
                <!-- Еще 11 карточек (всего 12 на странице) -->
                <!-- Для экономии места здесь будет только одна карточка, но в реальном проекте их должно быть больше -->
            </div>
            
            <div class="pagination">
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>4</button>
            </div>
        </section>
    </main>

<?php require_once 'parts/footer.php'; ?>