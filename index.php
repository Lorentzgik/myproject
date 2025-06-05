<!-- index.php -->
<?php
$current_page = 'index';
$page_title = 'TravelDream - Путешествия вашей мечты';
$page_css = 'index';
require_once 'parts/header.php';
?>

<!-- Контент главной страницы -->
<section class="hero">
        <div class="hero-content">
            <h1>Путешествия вашей мечты</h1>
            <p>Откройте для себя новые горизонты с нами - ваш идеальный отдых начинается здесь!</p>
            
            <div class="search-box">
                <input type="text" placeholder="Куда вы хотите поехать?">
                <button><i class="fas fa-search"></i> Найти тур</button>
            </div>
        </div>
    </section>

<section class="container">
        <div class="section-title">
            <h2>Популярные туры</h2>
        </div>
        
        <div class="tours-grid">
            <!-- Тур 1 -->
            <div class="tour-card">
                <div class="tour-image">
                    <img src="https://images.unsplash.com/photo-1565967511849-76a60a516170?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Мальдивы">
                </div>
                <div class="tour-content">
                    <h3 class="tour-title">Райские Мальдивы</h3>
                    <div class="tour-location">
                        <i class="fas fa-map-marker-alt"></i>
                        Мальдивы, Индийский океан
                    </div>
                    <div class="tour-meta">
                        <div><i class="fas fa-calendar"></i> 7 дней</div>
                        <div><i class="fas fa-user-friends"></i> 2 чел.</div>
                    </div>
                    <div class="tour-price">
                        <div class="price">120 000 ₽ <span>145 000 ₽</span></div>
                        <button class="book-btn">Забронировать</button>
                    </div>
                </div>
            </div>
            
            <!-- Тур 2 -->
            <div class="tour-card">
                <div class="tour-image">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Бали">
                </div>
                <div class="tour-content">
                    <h3 class="tour-title">Волшебный Бали</h3>
                    <div class="tour-location">
                        <i class="fas fa-map-marker-alt"></i>
                        Индонезия, Юго-Восточная Азия
                    </div>
                    <div class="tour-meta">
                        <div><i class="fas fa-calendar"></i> 10 дней</div>
                        <div><i class="fas fa-user-friends"></i> 2 чел.</div>
                    </div>
                    <div class="tour-price">
                        <div class="price">95 000 ₽ <span>110 000 ₽</span></div>
                        <button class="book-btn">Забронировать</button>
                    </div>
                </div>
            </div>
            
            <!-- Тур 3 -->
            <div class="tour-card">
                <div class="tour-image">
                    <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80" alt="Альпы">
                </div>
                <div class="tour-content">
                    <h3 class="tour-title">Швейцарские Альпы</h3>
                    <div class="tour-location">
                        <i class="fas fa-map-marker-alt"></i>
                        Швейцария, Европа
                    </div>
                    <div class="tour-meta">
                        <div><i class="fas fa-calendar"></i> 8 дней</div>
                        <div><i class="fas fa-user-friends"></i> 2 чел.</div>
                    </div>
                    <div class="tour-price">
                        <div class="price">135 000 ₽ <span>160 000 ₽</span></div>
                        <button class="book-btn">Забронировать</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="tours.php" class="view-all-btn" style="padding: 12px 40px; display: inline-block; background: #3498db; color: white; border-radius: 8px; text-decoration: none; transition: all 0.3s ease; border: none; outline: none;">
                <i class="fas fa-arrow-right"></i> Смотреть все туры
            </a>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits">
        <div class="container">
            <div class="section-title">
                <h2>Почему выбирают нас</h2>
            </div>
            
            <div class="benefits-grid">
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Безопасность</h3>
                    <p>Все туры застрахованы, а наши партнеры проверены временем</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3>Лучшие цены</h3>
                    <p>Гарантируем самые выгодные цены на рынке туристических услуг</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Поддержка 24/7</h3>
                    <p>Наша команда поддержки всегда готова помочь в любой ситуации</p>
                </div>
                
                <div class="benefit-card">
                    <div class="benefit-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3>Эксклюзивные туры</h3>
                    <p>Уникальные маршруты, недоступные в других агентствах</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="container testimonials">
        <div class="section-title">
            <h2>Отзывы клиентов</h2>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <p class="testimonial-text">Отдых на Бали превзошел все ожидания! Спасибо TravelDream за идеально организованный тур. Отличные отели, интересные экскурсии и приятные цены.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://randomuser.me/api/portraits/women/45.jpg" alt="Мария">
                    </div>
                    <div class="author-info">
                        <h4>Мария Иванова</h4>
                        <p>Бали, июнь 2023</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">Впервые доверил организацию отпуска профессионалам и не пожалел. Мальдивы - это сказка! Особенно понравилась организация трансферов и экскурсий.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Алексей">
                    </div>
                    <div class="author-info">
                        <h4>Алексей Петров</h4>
                        <p>Мальдивы, апрель 2023</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <p class="testimonial-text">Швейцарские Альпы были моей мечтой с детства. Благодаря TravelDream эта мечта сбылась! Отличные гиды, комфортные отели и незабываемые впечатления.</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Екатерина">
                    </div>
                    <div class="author-info">
                        <h4>Екатерина Сидорова</h4>
                        <p>Швейцария, январь 2023</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Special Offers -->
    <section class="benefits" style="background: linear-gradient(135deg, #f97316, #ea580c); margin:0">
        <div class="container">
            <div class="section-title">
                <h2>Специальные предложения</h2>
            </div>
            
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <h3 style="font-size: 1.8rem; margin-bottom: 20px;">Получите скидку 15% на первый тур!</h3>
                <p style="font-size: 1.2rem; margin-bottom: 30px;">Зарегистрируйтесь на нашем сайте и получите персональную скидку на первый заказ.</p>
                <button id="discountBtn" class="book-btn" style="background: white; color: #f97316; padding: 15px 40px;">
                    <i class="fas fa-gift"></i> Получить скидку
                </button>
            </div>
        </div>
    </section>

    <script>
        // Простая функция для подсветки активной ссылки
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('nav ul li a');
            
            navLinks.forEach(link => {
                const linkPage = link.getAttribute('href');
                if (linkPage === currentPage) {
                    link.classList.add('active');
                }
            });
            
            // Анимация для кнопки "Забронировать"
            const bookButtons = document.querySelectorAll('.tour-price .book-btn');
            bookButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Обработка...';
                    setTimeout(() => {
                        window.location.href = 'booking.php';
                    }, 1000);
                });
            });

            // Обработка кнопки "Получить скидку"
            const discountBtn = document.getElementById('discountBtn');
            if (discountBtn) {
                discountBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Перенаправление...';
                    setTimeout(() => {
                        window.location.href = 'registration.php';
                    }, 1000);
                });
            }
            


            // Обработка поиска
            const searchButton = document.querySelector('.search-box button');
            searchButton.addEventListener('click', function() {
                const searchInput = document.querySelector('.search-box input');
                const query = searchInput.value.trim();
                if (query) {
                    window.location.href = `tours.html?search=${encodeURIComponent(query)}`;
                }
            });
        });
    </script>

<?php require_once 'parts/footer.php'; ?>