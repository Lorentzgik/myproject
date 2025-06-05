<!DOCTYPE html>
<!-- parts/header.php -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <link rel="icon" href="imgs/logo_main.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
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
                        ?>
                    </ul>
                </nav>
                
                <div class="auth-buttons">
                    <div class="auth-buttons-container">
                        <button class="auth-btn login-btn"><i class="fas fa-user"></i> Войти</button>
                        <button class="auth-btn register-btn"><i class="fas fa-user-plus"></i> Регистрация</button>
                    </div>
                </div>
            </div>
        </div>
    </header>