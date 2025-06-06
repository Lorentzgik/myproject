<?php
require_once __DIR__ . '/db.php';

if (!isset($db)) {
    die("Ошибка подключения к базе данных");
}

global $db;
$pdo = $db;

$current_page = 'promotions';
$page_title = 'TravelDream - Скидки';
$page_css = 'staff';

// Получаем все скидки из таблицы discount
$stmt = $db->query("
    SELECT d.*, t.title as tour_title 
    FROM discount d
    LEFT JOIN tour t ON d.id = t.discount_id
    ORDER BY d.start_date DESC
");
$discounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once 'parts/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-percentage"></i> Скидки</h1>
        <a href="staff_discounts.php?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Добавить скидку
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Тип</th>
                    <th>Тур</th>
                    <th>Размер</th>
                    <th>Дата начала</th>
                    <th>Дата окончания</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($discounts as $discount): ?>
                <tr>
                    <td><?= htmlspecialchars($discount['id']) ?></td>
                    <td><?= htmlspecialchars($discount['type']) ?></td>
                    <td><?= htmlspecialchars($discount['tour_title'] ?? 'Все туры') ?></td>
                    <td><?= htmlspecialchars($discount['value']) ?>%</td>
                    <td><?= date('d.m.Y', strtotime($discount['start_date'])) ?></td>
                    <td><?= date('d.m.Y', strtotime($discount['end_date'])) ?></td>
                    <td>
                        <?php 
                        $now = time();
                        $start = strtotime($discount['start_date']);
                        $end = strtotime($discount['end_date']);
                        $status = ($now < $start) ? 'Ожидается' : (($now <= $end) ? 'Активна' : 'Завершена');
                        $badge_class = ($status == 'Активна') ? 'success' : (($status == 'Ожидается') ? 'warning' : 'secondary');
                        ?>
                        <span class="badge bg-<?= $badge_class ?>">
                            <?= $status ?>
                        </span>
                    </td>
                    <td>
                        <a href="staff_discounts.php?action=view&id=<?= $discount['id'] ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="staff_discounts.php?action=edit&id=<?= $discount['id'] ?>" class="btn btn-sm btn-warning">
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