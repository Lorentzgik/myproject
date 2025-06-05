document.addEventListener('DOMContentLoaded', () => {
    const tourSelect = document.getElementById('tour-select');
    const hotelCards = document.querySelectorAll('.hotel-card');

    tourSelect.addEventListener('change', (e) => {
        const selectedTourId = e.target.value;

        hotelCards.forEach(card => {
            if (!selectedTourId || card.dataset.tourId === selectedTourId) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});