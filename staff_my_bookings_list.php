<?php
session_start();
require_once __DIR__ . '/../db.php';

$current_page = 'my_bookings';
$page_title = 'TravelDream - Мои бронирования';
$page_css = 'staff';
require_once 'parts/header.php';

$staff_id = $_SESSION['staff_id'];

// Получаем бронирования текущего менеджера
$stmt = $pdo->prepare("
    SELECT b.*, c.name as client_name, c.surname as client_surname 
    FROM booking b
    LEFT JOIN client c ON b.client_id = c.id
    WHERE b.employee_id = ?
    ORDER BY b.created_at DESC
");
$stmt->execute([$staff_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1><i class="fas fa-calendar"></i> Мои бронирования</h1>
    
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
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['id']) ?></td>
                    <td><?= htmlspecialchars($booking['client_name'] . ' ' . htmlspecialchars($booking['client_surname'])) ?></td>
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
    
    <a href="staff_bookings.php?action=create" class="btn btn-primary">
        <i class="fas fa-calendar-plus"></i> Новое бронирование
    </a>
</div>

<?php require_once 'parts/footer.php'; ?>