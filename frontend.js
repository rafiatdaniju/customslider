// frontend.js
document.addEventListener('DOMContentLoaded', function() {
    const sliders = document.querySelectorAll('.custom-image-slider');
    
    sliders.forEach(slider => {
        const container = slider.querySelector('.slider-container');
        const slides = slider.querySelectorAll('.slide');
        const prevBtn = slider.querySelector('.slider-prev');
        const nextBtn = slider.querySelector('.slider-next');
        
        let currentIndex = 0;
        let slidesPerView = 1;
        
        // Determine slides per view based on screen size
        function updateSlidesPerView() {
            if (window.innerWidth >= 1024) {
                slidesPerView = 3;
            } else if (window.innerWidth >= 768) {
                slidesPerView = 2;
            } else {
                slidesPerView = 1;
            }
        }
        
        function updateSlidePosition() {
            const slideWidth = 100 / slidesPerView;
            container.style.transform = `translateX(-${currentIndex * slideWidth}%)`;
        }
        
        function nextSlide() {
            const maxIndex = slides.length - slidesPerView;
            currentIndex = currentIndex >= maxIndex ? 0 : currentIndex + 1;
            updateSlidePosition();
        }
        
        function prevSlide() {
            const maxIndex = slides.length - slidesPerView;
            currentIndex = currentIndex <= 0 ? maxIndex : currentIndex - 1;
            updateSlidePosition();
        }
        
        // Initialize
        updateSlidesPerView();
        updateSlidePosition();
        
        // Event listeners
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
        
        window.addEventListener('resize', () => {
            updateSlidesPerView();
            updateSlidePosition();
        });
        
        // Auto-slide every 5 seconds
        // setInterval(nextSlide, 5000);
    });
});