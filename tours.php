<?php
// tours.php
session_start();
require_once __DIR__ . '/db.php'; // Подключаем файл с соединением к БД

$current_page = 'tours';
$page_title = 'TravelDream - Каталог туров';
$page_css = 'tours';
require_once 'parts/header.php';

// Параметры фильтрации
$region = $_GET['region'] ?? '';
$type = $_GET['type'] ?? '';
$price_min = $_GET['price_min'] ?? '';
$price_max = $_GET['price_max'] ?? '';
$date = $_GET['date'] ?? '';
$search = $_GET['search'] ?? '';

// Получаем туры из базы данных с учетом фильтров
try {
    // Базовый запрос
    $sql = "SELECT * FROM tour WHERE 1=1";
    $params = [];
    
    // Добавляем фильтры
    if (!empty($region)) {
        $sql .= " AND type LIKE ?";
        $params[] = "%$region%";
    }
    
    if (!empty($type)) {
        $sql .= " AND type LIKE ?";
        $params[] = "%$type%";
    }
    
    if (!empty($price_min) && is_numeric($price_min)) {
        $sql .= " AND price >= ?";
        $params[] = $price_min;
    }
    
    if (!empty($price_max) && is_numeric($price_max)) {
        $sql .= " AND price <= ?";
        $params[] = $price_max;
    }
    
    if (!empty($date)) {
        $sql .= " AND start_date >= ?";
        $params[] = $date;
    }
    
    if (!empty($search)) {
        $sql .= " AND (title LIKE ? OR description LIKE ? OR type LIKE ?)";
        $searchTerm = "%$search%";
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }
    
    // Сортировка
    $sort = $_GET['sort'] ?? 'popular';
    switch ($sort) {
        case 'price_asc':
            $sql .= " ORDER BY price ASC";
            break;
        case 'price_desc':
            $sql .= " ORDER BY price DESC";
            break;
        case 'date':
            $sql .= " ORDER BY start_date ASC";
            break;
        default:
            $sql .= " ORDER BY id DESC"; // По умолчанию сортируем по популярности (новые сначала)
    }
    
    // Подготовка и выполнение запроса
    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $tours = $stmt->fetchAll();
    
    // Количество найденных туров
    $tours_count = count($tours);
    
} catch (PDOException $e) {
    die("Ошибка при получении туров: " . $e->getMessage());
}
?>

<main class="container catalog-container">
    <aside class="filters">
        <form method="GET" id="filters-form">
            <div class="filter-section">
                <h3>Направление</h3>
                <div class="filter-options">
                    <label><input type="checkbox" name="region" value="Европа" <?= $region === 'Европа' ? 'checked' : '' ?>> Европа</label>
                    <label><input type="checkbox" name="region" value="Азия" <?= $region === 'Азия' ? 'checked' : '' ?>> Азия</label>
                    <label><input type="checkbox" name="region" value="Африка" <?= $region === 'Африка' ? 'checked' : '' ?>> Африка</label>
                    <label><input type="checkbox" name="region" value="Северная Америка" <?= $region === 'Северная Америка' ? 'checked' : '' ?>> Северная Америка</label>
                    <label><input type="checkbox" name="region" value="Южная Америка" <?= $region === 'Южная Америка' ? 'checked' : '' ?>> Южная Америка</label>
                </div>
            </div>
            
            <div class="filter-section">
                <h3>Тип отдыха</h3>
                <div class="filter-options">
                    <label><input type="checkbox" name="type" value="Пляжный" <?= $type === 'Пляжный' ? 'checked' : '' ?>> Пляжный</label>
                    <label><input type="checkbox" name="type" value="Экскурсионный" <?= $type === 'Экскурсионный' ? 'checked' : '' ?>> Экскурсионный</label>
                    <label><input type="checkbox" name="type" value="Горнолыжный" <?= $type === 'Горнолыжный' ? 'checked' : '' ?>> Горнолыжный</label>
                    <label><input type="checkbox" name="type" value="Круизы" <?= $type === 'Круизы' ? 'checked' : '' ?>> Круизы</label>
                    <label><input type="checkbox" name="type" value="Сафари" <?= $type === 'Сафари' ? 'checked' : '' ?>> Сафари</label>
                </div>
            </div>
            
            <div class="filter-section">
                <h3>Цена, руб.</h3>
                <div class="price-range">
                    <input type="number" name="price_min" placeholder="От" min="0" value="<?= htmlspecialchars($price_min) ?>">
                    <input type="number" name="price_max" placeholder="До" min="0" value="<?= htmlspecialchars($price_max) ?>">
                </div>
            </div>
            
            <div class="filter-section">
                <h3>Дата вылета</h3>
                <input type="date" name="date" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 5px;" value="<?= htmlspecialchars($date) ?>">
            </div>
            
            <input type="hidden" name="search" value="<?= htmlspecialchars($search) ?>">
            
            <button type="submit" class="book-btn" style="width: 100%;">Применить фильтры</button>
            <button type="button" id="reset-filters" class="btn btn-secondary" style="width: 100%; margin-top: 10px;">Сбросить фильтры</button>
        </form>
    </aside>
    
    <section class="catalog-content">
        <div class="sorting">
            <p>Найдено <?= $tours_count ?> <?= $tours_count == 1 ? 'тур' : ($tours_count > 1 && $tours_count < 5 ? 'тура' : 'туров') ?></p>
            <div>
                <span>Сортировать:</span>
                <select name="sort" id="sort-select">
                    <option value="popular" <?= $sort === 'popular' ? 'selected' : '' ?>>По популярности</option>
                    <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>По возрастанию цены</option>
                    <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>По убыванию цены</option>
                    <option value="date" <?= $sort === 'date' ? 'selected' : '' ?>>По дате вылета</option>
                </select>
            </div>
        </div>
        
        <?php if ($tours_count > 0): ?>
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
                                <span><?= htmlspecialchars($tour['type']) ?></span>
                            </div>
                            <div class="tour-meta">
                                <div class="meta-item"><i class="fas fa-calendar"></i><span>
                                    <?= date('d.m.Y', strtotime($tour['start_date'])) ?> - <?= date('d.m.Y', strtotime($tour['end_date'])) ?>
                                </span></div>
                                <div class="meta-item"><i class="fas fa-clock"></i><span>
                                    <?= date_diff(date_create($tour['start_date']), date_create($tour['end_date']))->format('%a') ?> дней
                                </span></div>
                            </div>
                            <div class="tour-price">
                                <div class="price-container">
                                    <div class="price"><?= number_format($tour['price'], 0, '', ' ') ?> ₽</div>
                                </div>
                                <a href="booking.php?tour_id=<?= $tour['id'] ?>" class="book-btn">
                                    <span class="btn-text">Забронировать</span>
                                    <i class="fas fa-arrow-right btn-icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-tours-found">
                <i class="fas fa-search" style="font-size: 48px; color: #ccc; margin-bottom: 20px;"></i>
                <h3>Туры не найдены</h3>
                <p>Попробуйте изменить параметры поиска или <a href="tours.php">сбросить фильтры</a></p>
            </div>
        <?php endif; ?>
        
        <?php if ($tours_count > 0): ?>
            <div class="pagination">
                <button class="active">1</button>
                <button>2</button>
                <button>3</button>
                <button>4</button>
            </div>
        <?php endif; ?>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Обработка сортировки
    document.getElementById('sort-select').addEventListener('change', function() {
        const form = document.getElementById('filters-form');
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'sort';
        input.value = this.value;
        form.appendChild(input);
        form.submit();
    });
    
    // Сброс фильтров
    document.getElementById('reset-filters').addEventListener('click', function() {
        window.location.href = 'tours.php';
    });
    
    // Обработка кнопки "Забронировать"
    document.querySelectorAll('.book-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.classList.contains('loading')) return;
            
            // Если это ссылка (не кнопка в фильтрах), добавляем анимацию
            if (this.tagName === 'A') {
                e.preventDefault();
                
                this.classList.add('loading');
                const btnText = this.querySelector('.btn-text');
                const btnIcon = this.querySelector('.btn-icon');
                
                btnText.textContent = 'Обработка...';
                btnIcon.className = 'fas fa-spinner fa-spin btn-icon';
                
                setTimeout(() => {
                    window.location.href = this.href;
                }, 1000);
            }
        });
    });
});
</script>

<?php require_once 'parts/footer.php'; ?>