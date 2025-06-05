document.addEventListener('DOMContentLoaded', function() {
    // Таймер обратного отсчета
    function updateTimer() {
        const timerElement = document.querySelector('.offer-timer strong');
        // Здесь должна быть логика отсчета
        timerElement.textContent = '12д 06ч 45м'; // Заглушка
    }
    
    setInterval(updateTimer, 1000);
    
    // Параллакс-эффект для карточек
    const offers = document.querySelectorAll('.offer-card');
    
    offers.forEach(offer => {
        offer.addEventListener('mousemove', (e) => {
            const x = e.clientX - offer.getBoundingClientRect().left;
            const y = e.clientY - offer.getBoundingClientRect().top;
            
            offer.style.transform = `
                translateY(-10px)
                rotateX(${(y - offer.offsetHeight/2) / 20}deg)
                rotateY(${(x - offer.offsetWidth/2) / 20}deg)
            `;
        });
        
        offer.addEventListener('mouseleave', () => {
            offer.style.transform = 'translateY(-10px)';
        });
    });
});