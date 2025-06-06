<!DOCTYPE html>
<!-- parts/header.php -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="icon" href="imgs/logo_main.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/personal.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php if(isset($page_css)): ?>
        <link rel="stylesheet" href="css/<?= $page_css ?>.css">
    <?php endif; ?>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-container">
                    <div class="logo">
                        <svg class="logo-svg" viewBox="0 0 200 50" xmlns="http://www.w3.org/2000/svg">
                            <!-- SVG логотипа -->
                        </svg>
                    </div>
                    <a href="index.php">
                        <div class="logo-text">
                            TravelDream
                            <span class="logo-subtext">путешествия мечты</span>
                        </div>
                    </a>
                </div>
                
                <nav>
                    <ul>
                        <?php
                        $pages = [
                            'index' => ['Главная', 'fas fa-home'],
                            'tours' => ['Туры', 'fas fa-map-marked-alt'],
                            'hotels' => ['Отели', 'fas fa-hotel'],
                            'offers' => ['Акции', 'fas fa-percent'],
                            'contacts' => ['Контакты', 'fas fa-phone-alt']
                        ];
                        
                        foreach ($pages as $key => $value) {
                            $active = ($current_page == $key) ? 'class="active"' : '';
                            echo "<li><a href=\"{$key}.php\" $active><i class=\"{$value[1]}\"></i> {$value[0]}</a></li>";
                        }
                        
                        // Блок авторизации
                        if (isset($_SESSION['staff_logged_in'])): ?>
                            <!-- Версия для сотрудника (админ/менеджер) -->
                            <li>
                                <a href="staff_dashboard.php" class="nav-user">
                                    <i class="fas fa-user-tie"></i>
                                    <span class="user-name">
                                        <?= htmlspecialchars($_SESSION['staff_name'] ?? 'Панель') ?>
                                    </span>
                                </a>
                            </li>
                            <li>
                                <a style="margin-top:10%" href="staff_logout.php" class="logout-btn" title="Выйти">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </li>
                        <?php elseif (isset($_SESSION['user_id'])): ?>
                            <!-- Версия для обычного пользователя -->
                            <li>
                                <a href="personal.php" class="nav-user">
                                    <i class="fas fa-user-circle"></i>
                                    <span class="user-name"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Профиль') ?></span>
                                </a>
                            </li>
                            <li>
                                <a style="margin-top:10%" href="logout.php" class="logout-btn" title="Выйти">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                            </li>
                        <?php else: ?>
                            <!-- Версия для гостей -->
                            <li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Войти</a></li>
                            <li><a href="registration.php" class="register-btn">Регистрация</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>