<?php
require_once __DIR__ . '/db.php';

if (!isset($db)) {
    die("Ошибка подключения к базе данных");
}

$current_page = 'clients';
$page_title = 'TravelDream - Клиенты';
$page_css = 'staff';
require_once 'parts/header.php';

// Получаем всех клиентов
$stmt = $db->query("SELECT * FROM client ORDER BY id DESC");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1><i class="fas fa-users"></i> Клиенты</h1>
    
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