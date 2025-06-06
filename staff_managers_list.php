<?php
require_once 'db.php';

if (!isset($db)) {
    die("Ошибка подключения к базе данных");
}

$current_page = 'managers';
$page_title = 'TravelDream - Менеджеры';
$page_css = 'staff';
require_once 'parts/header.php';

// Получаем всех сотрудников
$stmt = $db->query("SELECT * FROM employee ORDER BY role DESC, id DESC");
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h1><i class="fas fa-user-tie"></i> Менеджеры</h1>
    
    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Логин</th>
                    <th>Имя</th>
                    <th>Фамилия</th>
                    <th>Должность</th>
                    <th>Роль</th>
                    <th>Email</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= htmlspecialchars($employee['id']) ?></td>
                    <td><?= htmlspecialchars($employee['username']) ?></td>
                    <td><?= htmlspecialchars($employee['name']) ?></td>
                    <td><?= htmlspecialchars($employee['surname']) ?></td>
                    <td><?= htmlspecialchars($employee['position']) ?></td>
                    <td>
                        <span class="badge bg-<?= $employee['role'] ? 'primary' : 'secondary' ?>">
                            <?= $employee['role'] ? 'Администратор' : 'Менеджер' ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($employee['email']) ?></td>
                    <td>
                        <a href="staff_managers.php?action=view&id=<?= $employee['id'] ?>" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="staff_managers.php?action=edit&id=<?= $employee['id'] ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <a href="staff_managers.php?action=create" class="btn btn-success">
        <i class="fas fa-user-plus"></i> Добавить менеджера
    </a>
</div>

<?php require_once 'parts/footer.php'; ?>