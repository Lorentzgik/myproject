<?php
require_once __DIR__ . '/db.php';

if (!isset($db)) {
    die("Ошибка подключения к базе данных");
}

global $db;
$pdo = $db;

$current_page = 'hotels';
$page_title = 'TravelDream - Отели';
$page_css = 'staff';

// Получаем все отели
$stmt = $db->query("
    SELECT h.*, COUNT(r.id) as rooms_count 
    FROM hotel h
    LEFT JOIN room r ON h.id = r.hotel_id
    GROUP BY h.id
    ORDER BY h.name ASC
");
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'parts/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-hotel"></i> Отели</h1>
        <a href="staff_hotels.php?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить отель
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Страна</th>
                    <th>Город</th>
                    <th>Звезды</th>
                    <th>Номера</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($hotels as $hotel): ?>
                <tr>
                    <td><?= htmlspecialchars($hotel['id']) ?></td>
                    <td><?= htmlspecialchars($hotel['name']) ?></td>
                    <td><?= htmlspecialchars($hotel['country']) ?></td>
                    <td><?= htmlspecialchars($hotel['city']) ?></td>
                    <td>
                        <?php for ($i = 0; $i < $hotel['stars']; $i++): ?>
                            <i class="fas fa-star text-warning"></i>
                        <?php endfor; ?>
                    </td>
                    <td><?= htmlspecialchars($hotel['rooms_count']) ?></td>
                    <td>
                        <span class="badge bg-<?= $hotel['is_active'] ? 'success' : 'secondary' ?>">
                            <?= $hotel['is_active'] ? 'Активен' : 'Неактивен' ?>
                        </span>
                    </td>
                    <td>
                        <a href="staff_hotels.php?action=view&id=<?= $hotel['id'] ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="staff_hotels.php?action=edit&id=<?= $hotel['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/parts/footer.php'; ?>