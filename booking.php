<?php
// booking.php
session_start();

// Подключаем файл с соединением к БД
require_once __DIR__ . '/db.php';

// Проверяем, что переменная $db существует (подключение успешно)
if (!isset($db)) {
    die("Ошибка подключения к базе данных");
}

// Проверка авторизации пользователя
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$current_page = 'booking';
$page_title = 'TravelDream - Бронирование';
require_once 'parts/header.php';

// Валидация tour_id
$tour_id = filter_input(INPUT_GET, 'tour_id', FILTER_VALIDATE_INT);
if (!$tour_id || $tour_id < 1) {
    die("Неверный идентификатор тура");
}

try {
    // Получаем информацию о туре
    $stmt = $db->prepare("SELECT * FROM tours WHERE id = ?");
    $stmt->execute([$tour_id]);
    $tour = $stmt->fetch();
    
    if (!$tour) {
        die("Тур не найден");
    }
} catch (PDOException $e) {
    die("Ошибка базы данных: " . $e->getMessage());
}

// Обработка формы бронирования
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Валидация данных
    $amount_people = filter_input(INPUT_POST, 'amount_people', FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 10]
    ]);
    
    if (!$amount_people) {
        $error = "Укажите корректное количество человек (от 1 до 10)";
    } else {
        try {
            $db->beginTransaction();
            
            // Проверка доступности тура
            $stmt = $db->prepare("SELECT available_places FROM tours WHERE id = ? FOR UPDATE");
            $stmt->execute([$tour_id]);
            $tour = $stmt->fetch();
            
            if ($tour['available_places'] < $amount_people) {
                throw new Exception("Недостаточно свободных мест");
            }
            
            // Создание бронирования
            $stmt = $db->prepare("INSERT INTO booking 
                                (tour_id, client_id, status, booking_date, price, amount_people, description) 
                                VALUES 
                                (?, ?, 'pending', CURDATE(), ?, ?, ?)");
            
            $price = $tour['price'] * $amount_people;
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            
            $stmt->execute([
                $tour_id,
                $_SESSION['user_id'],
                $price,
                $amount_people,
                $description
            ]);
            
            // Обновление доступных мест
            $stmt = $db->prepare("UPDATE tours SET available_places = available_places - ? WHERE id = ?");
            $stmt->execute([$amount_people, $tour_id]);
            
            $db->commit();
            
            // Перенаправление после успешного бронирования
            header("Location: booking_confirmation.php?id=" . $db->lastInsertId());
            exit();
            
        } catch (Exception $e) {
            $db->rollBack();
            $error = "Ошибка при бронировании: " . $e->getMessage();
        }
    }
}
?>

<main class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Бронирование тура: <?= htmlspecialchars($tour['title']) ?></h1>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <input type="hidden" name="tour_id" value="<?= $tour_id ?>">
                
                <div class="mb-3">
                    <label class="form-label">Количество человек</label>
                    <select class="form-select" name="amount_people" required>
                        <?php for ($i = 1; $i <= min(10, $tour['available_places']); $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?> чел.</option>
                        <?php endfor; ?>
                    </select>
                    <small class="text-muted">Доступно мест: <?= $tour['available_places'] ?></small>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Дополнительные пожелания</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>
                
                <div class="alert alert-info">
                    <h5>Итого к оплате: <span id="total-price"><?= $tour['price'] ?></span> ₽</h5>
                    <small>Цена за 1 человека: <?= $tour['price'] ?> ₽</small>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg">Забронировать</button>
            </form>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <img src="<?= htmlspecialchars($tour['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($tour['title']) ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($tour['title']) ?></h5>
                    <p class="card-text">
                        <i class="fas fa-calendar-alt"></i> <?= date('d.m.Y', strtotime($tour['start_date'])) ?> - <?= date('d.m.Y', strtotime($tour['end_date'])) ?><br>
                        <i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($tour['destination']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pricePerPerson = <?= $tour['price'] ?>;
    const amountSelect = document.querySelector('select[name="amount_people"]');
    const totalPriceElement = document.getElementById('total-price');
    
    amountSelect.addEventListener('change', function() {
        totalPriceElement.textContent = pricePerPerson * this.value;
    });
});
</script>

<?php require_once 'parts/footer.php'; ?>