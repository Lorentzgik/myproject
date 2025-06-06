<?php
require_once __DIR__ . '/db.php';
// Проверяем, определена ли переменная $db (должна быть подключена из db.php через staff_dashboard.php)
if (!isset($db)) {
    die("Ошибка подключения к базе данных");
}

try {
    // Получаем все туры с информацией о транспорте
    $stmt = $db->query("
        SELECT t.*, tr.company as transport_company, tr.transport_type 
        FROM tour t
        LEFT JOIN transport tr ON t.transport_id = tr.id
        ORDER BY t.start_date DESC
    ");
    $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Ошибка при получении данных: " . $e->getMessage());
}
?>

<div class="container">
    <h1><i class="fas fa-suitcase"></i> Управление турами</h1>
    
    <?php if (empty($tours)): ?>
        <div class="alert alert-info">Нет доступных туров</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Тип</th>
                        <th>Даты</th>
                        <th>Цена</th>
                        <th>Транспорт</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tours as $tour): ?>
                    <tr>
                        <td><?= htmlspecialchars($tour['id']) ?></td>
                        <td><?= htmlspecialchars($tour['title']) ?></td>
                        <td><?= htmlspecialchars($tour['type']) ?></td>
                        <td>
                            <?= date('d.m.Y', strtotime($tour['start_date'])) ?> - 
                            <?= date('d.m.Y', strtotime($tour['end_date'])) ?>
                        </td>
                        <td><?= number_format($tour['price'], 0, '', ' ') ?> ₽</td>
                        <td>
                            <?= $tour['transport_id'] ? 
                                htmlspecialchars($tour['transport_company'] . ' (' . $tour['transport_type'] . ')') : 
                                'Не указан' 
                            ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="staff_tours.php?action=view&id=<?= $tour['id'] ?>" class="btn btn-sm btn-info" title="Просмотр">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="staff_tours.php?action=edit&id=<?= $tour['id'] ?>" class="btn btn-sm btn-warning" title="Редактировать">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="staff_tours.php?action=delete&id=<?= $tour['id'] ?>" class="btn btn-sm btn-danger" title="Удалить" onclick="return confirm('Вы уверены, что хотите удалить тур?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
    
    <a href="staff_tours.php?action=create" class="btn btn-primary mt-3">
        <i class="fas fa-plus"></i> Добавить тур
    </a>
</div>