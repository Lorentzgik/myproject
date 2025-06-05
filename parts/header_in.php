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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/jquery.inputmask.min.js"></script>
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
                        
                        // Измененные элементы авторизации
                        if(isset($_SESSION['user'])): ?>
                            <li>
                                <a href="profile.php" class="nav-user">
                                    <i class="fas fa-user-circle"></i>
                                    <?= htmlspecialchars($_SESSION['user']['name']) ?>
                                </a>
                            </li>
                            <li><a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Выйти</a></li>
                        <?php else: ?>
                            <li><a href="login.php" class="auth-btn <?= ($current_page == 'login' || $current_page == 'registration') ? 'active' : '' ?>"><i class="fas fa-user"></i> Выйти</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>