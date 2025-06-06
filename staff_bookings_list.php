<?php
require_once __DIR__ . '/db.php';
// Проверяем, определена ли переменная $db (должна быть подключена из db.php через staff_dashboard.php)
if (!isset($db)) {
    die("Ошибка подключения к базе данных");
}

global $db;
$pdo = $db;

// Устанавливаем переменные для header.php
$current_page = 'bookings';
$page_title = 'TravelDream - Бронирования';
$page_css = 'staff';

// Получаем все бронирования
$stmt = $db->query("
    SELECT b.*, c.name as client_name, c.surname as client_surname, 
           e.name as employee_name, e.surname as employee_surname 
    FROM booking b
    LEFT JOIN client c ON b.client_id = c.id
    LEFT JOIN employee e ON b.employee_id = e.id
    ORDER BY b.created_at DESC
");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1><i class="fas fa-calendar-check"></i> Бронирования</h1>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Клиент</th>
                    <th>Статус</th>
                    <th>Дата брони</th>
                    <th>Цена</th>
                    <th>Кол-во чел.</th>
                    <th>Менеджер</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['id']) ?></td>
                    <td><?= htmlspecialchars($booking['client_name'] . ' ' . $booking['client_surname']) ?></td>
                    <td>
                        <span class="badge bg-<?= 
                            $booking['status'] == 'confirmed' ? 'success' : 
                            ($booking['status'] == 'pending' ? 'warning' : 'danger') 
                        ?>">
                            <?= htmlspecialchars($booking['status']) ?>
                        </span>
                    </td>
                    <td><?= date('d.m.Y', strtotime($booking['booking_date'])) ?></td>
                    <td><?= number_format($booking['price'], 0, '', ' ') ?> ₽</td>
                    <td><?= htmlspecialchars($booking['amount_per_person']) ?></td>
                    <td>
                        <?= $booking['employee_id'] ? 
                            htmlspecialchars($booking['employee_name'] . ' ' . $booking['employee_surname']) : 
                            'Не назначен' 
                        ?>
                    </td>
                    <td>
                        <a href="staff_bookings.php?action=view&id=<?= $booking['id'] ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="staff_bookings.php?action=edit&id=<?= $booking['id'] ?>" class="btn btn-sm btn-warning">
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