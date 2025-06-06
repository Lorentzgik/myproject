<?php
session_start();
require_once __DIR__ . '/../db.php';

$current_page = 'my_clients';
$page_title = 'TravelDream - Мои клиенты';
$page_css = 'staff';
require_once 'parts/header.php';

$staff_id = $_SESSION['staff_id'];

// Получаем клиентов текущего менеджера
$stmt = $pdo->prepare("
    SELECT c.* 
    FROM client c
    JOIN booking b ON b.client_id = c.id
    WHERE b.employee_id = ?
    GROUP BY c.id
    ORDER BY c.id DESC
");
$stmt->execute([$staff_id]);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1><i class="fas fa-users"></i> Мои клиенты</h1>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                <tr>
                    <td><?= htmlspecialchars($client['id']) ?></td>
                    <td><?= htmlspecialchars($client['name']) ?></td>
                    <td><?= htmlspecialchars($client['surname']) ?></td>
                    <td><?= htmlspecialchars($client['email']) ?></td>
                    <td><?= htmlspecialchars($client['number']) ?></td>
                    <td>
                        <a href="staff_clients.php?action=view&id=<?= $client['id'] ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="staff_clients.php?action=edit&id=<?= $client['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'parts/footer.php'; ?>