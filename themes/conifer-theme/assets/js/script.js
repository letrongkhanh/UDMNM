// DOM Elements
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');
const heroSlider = document.querySelector('.hero-slider');
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const filterBtns = document.querySelectorAll('.filter-btn');
const productCards = document.querySelectorAll('.product-card');
const cartCount = document.querySelector('.cart-count');
const addToCartBtns = document.querySelectorAll('.add-to-cart');
const newsletterForm = document.querySelector('.newsletter-form');

// Global Variables
let currentSlide = 0;
let slideInterval;
let cartItems = 0;

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    initSlider();
    initMobileMenu();
    initProductFilters();
    initCart();
    initNewsletter();
    initScrollAnimations();
    initSmoothScrolling();
});

// Hero Slider
function initSlider() {
    if (slides.length === 0) return;
    
    // Auto slide
    slideInterval = setInterval(nextSlide, 5000);
    
    // Event listeners
    prevBtn.addEventListener('click', prevSlide);
    nextBtn.addEventListener('click', nextSlide);
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });
    
    // Pause on hover
    heroSlider.addEventListener('mouseenter', pauseSlider);
    heroSlider.addEventListener('mouseleave', resumeSlider);
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    updateSlider();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    updateSlider();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlider();
}

function updateSlider() {
    slides.forEach((slide, index) => {
        slide.classList.toggle('active', index === currentSlide);
    });
    
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

function pauseSlider() {
    clearInterval(slideInterval);
}

function resumeSlider() {
    slideInterval = setInterval(nextSlide, 5000);
}

// Mobile Menu
function initMobileMenu() {
    if (!hamburger || !navMenu) return;
    
    hamburger.addEventListener('click', toggleMobileMenu);
    
    // Close menu when clicking on a link
    navMenu.addEventListener('click', (e) => {
        if (e.target.tagName === 'A') {
            closeMobileMenu();
        }
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!hamburger.contains(e.target) && !navMenu.contains(e.target)) {
            closeMobileMenu();
        }
    });
}

function toggleMobileMenu() {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
    document.body.classList.toggle('menu-open');
}

function closeMobileMenu() {
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');
    document.body.classList.remove('menu-open');
}

// Product Filters
function initProductFilters() {
    if (filterBtns.length === 0) return;
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');
            filterProducts(filter);
            updateActiveFilter(btn);
        });
    });
}

function filterProducts(filter) {
    productCards.forEach(card => {
        const category = card.getAttribute('data-category');
        
        if (filter === 'all' || category === filter) {
            card.style.display = 'block';
            card.style.animation = 'fadeIn 0.5s ease';
        } else {
            card.style.display = 'none';
        }
    });
}

function updateActiveFilter(activeBtn) {
    filterBtns.forEach(btn => btn.classList.remove('active'));
    activeBtn.classList.add('active');
}

// Shopping Cart
function initCart() {
    if (addToCartBtns.length === 0) return;
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            addToCart(btn);
        });
    });
}

function addToCart(btn) {
    cartItems++;
    updateCartCount();
    
    // Add animation
    btn.innerHTML = '<i class="fas fa-check"></i>';
    btn.style.background = 'linear-gradient(135deg, #2c2c2c 0%, #000000 100%)';
    
    setTimeout(() => {
        btn.innerHTML = '<i class="fas fa-shopping-cart"></i>';
        btn.style.background = '';
    }, 1000);
    
    // Show notification
    showNotification('Đã thêm sản phẩm vào giỏ hàng!');
}

function updateCartCount() {
    if (cartCount) {
        cartCount.textContent = cartItems;
        cartCount.style.animation = 'pulse 0.3s ease';
    }
}

function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: linear-gradient(135deg, #2c2c2c 0%, #000000 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        z-index: 10000;
        animation: slideIn 0.3s ease;
        box-shadow: 0 4px 15px rgba(139, 69, 19, 0.3);
        border: 2px solid rgba(255, 255, 255, 0.2);
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Newsletter
function initNewsletter() {
    if (!newsletterForm) return;
    
    newsletterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const email = newsletterForm.querySelector('input[type="email"]').value;
        
        if (validateEmail(email)) {
            subscribeNewsletter(email);
        } else {
            showNotification('Vui lòng nhập email hợp lệ!', 'error');
        }
    });
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function subscribeNewsletter(email) {
    const submitBtn = newsletterForm.querySelector('button');
    const originalText = submitBtn.textContent;
    
    submitBtn.innerHTML = '<div class="loading"></div>';
    submitBtn.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        submitBtn.textContent = 'Đã đăng ký!';
        submitBtn.style.background = 'linear-gradient(135deg, #2c2c2c 0%, #000000 100%)';
        
        setTimeout(() => {
            submitBtn.textContent = originalText;
            submitBtn.style.background = '';
            submitBtn.disabled = false;
            newsletterForm.reset();
        }, 2000);
        
        showNotification('Đăng ký nhận tin thành công!');
    }, 1500);
}

// Scroll Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);
    
    // Observe elements
    const animatedElements = document.querySelectorAll('.feature-item, .product-card, .section-header');
    animatedElements.forEach(el => {
        el.classList.add('fade-in');
        observer.observe(el);
    });
}

// Smooth Scrolling
function initSmoothScrolling() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                const headerHeight = document.querySelector('.header').offsetHeight;
                const targetPosition = targetElement.offsetTop - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Search Functionality
function initSearch() {
    const searchBtn = document.querySelector('.search-btn');
    const searchInput = document.createElement('input');
    searchInput.type = 'text';
    searchInput.placeholder = 'Tìm kiếm sản phẩm...';
    searchInput.className = 'search-input';
    searchInput.style.cssText = `
        position: absolute;
        top: 100%;
        right: 0;
        width: 300px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        display: none;
        z-index: 1000;
    `;
    
    if (searchBtn) {
        searchBtn.parentNode.style.position = 'relative';
        searchBtn.parentNode.appendChild(searchInput);
        
        searchBtn.addEventListener('click', (e) => {
            e.preventDefault();
            searchInput.style.display = searchInput.style.display === 'none' ? 'block' : 'none';
            if (searchInput.style.display === 'block') {
                searchInput.focus();
            }
        });
        
        searchInput.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            searchProducts(query);
        });
    }
}

function searchProducts(query) {
    productCards.forEach(card => {
        const title = card.querySelector('h3').textContent.toLowerCase();
        const isVisible = title.includes(query);
        
        card.style.display = isVisible ? 'block' : 'none';
    });
}

// Quick View Modal
function initQuickView() {
    const quickViewBtns = document.querySelectorAll('.quick-view');
    
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const productCard = btn.closest('.product-card');
            const productImage = productCard.querySelector('img').src;
            const productTitle = productCard.querySelector('h3').textContent;
            const productPrice = productCard.querySelector('.current-price').textContent;
            
            showQuickViewModal({
                image: productImage,
                title: productTitle,
                price: productPrice
            });
        });
    });
}

function showQuickViewModal(product) {
    const modal = document.createElement('div');
    modal.className = 'quick-view-modal';
    modal.innerHTML = `
        <div class="modal-overlay">
            <div class="modal-content">
                <button class="modal-close">&times;</button>
                <div class="modal-body">
                    <div class="modal-image">
                        <img src="${product.image}" alt="${product.title}">
                    </div>
                    <div class="modal-info">
                        <h3>${product.title}</h3>
                        <div class="modal-price">${product.price}</div>
                        <p>Đây là mô tả sản phẩm mẫu. Bạn có thể thêm thông tin chi tiết về sản phẩm ở đây.</p>
                        <div class="modal-actions">
                            <button class="btn btn-primary add-to-cart-modal">Thêm vào giỏ</button>
                            <button class="btn btn-outline">Xem chi tiết</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 10000;
        animation: fadeIn 0.3s ease;
    `;
    
    document.body.appendChild(modal);
    
    // Close modal
    const closeBtn = modal.querySelector('.modal-close');
    const overlay = modal.querySelector('.modal-overlay');
    
    closeBtn.addEventListener('click', () => closeModal(modal));
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            closeModal(modal);
        }
    });
    
    // Add to cart from modal
    const addToCartBtn = modal.querySelector('.add-to-cart-modal');
    addToCartBtn.addEventListener('click', () => {
        addToCart(addToCartBtn);
        closeModal(modal);
    });
}

function closeModal(modal) {
    modal.style.animation = 'fadeOut 0.3s ease';
    setTimeout(() => {
        document.body.removeChild(modal);
    }, 300);
}

// Wishlist Functionality
function initWishlist() {
    const wishlistBtns = document.querySelectorAll('.add-to-wishlist');
    
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleWishlist(btn);
        });
    });
}

function toggleWishlist(btn) {
    const icon = btn.querySelector('i');
    
    if (icon.classList.contains('fas')) {
        icon.classList.remove('fas');
        icon.classList.add('far');
        btn.style.color = '';
        showNotification('Đã xóa khỏi danh sách yêu thích!');
    } else {
        icon.classList.remove('far');
        icon.classList.add('fas');
        btn.style.color = '#ff4757';
        showNotification('Đã thêm vào danh sách yêu thích!');
    }
}

// Initialize additional features
document.addEventListener('DOMContentLoaded', function() {
    initSearch();
    initQuickView();
    initWishlist();
});

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%); }
        to { transform: translateX(0); }
    }
    
    @keyframes slideOut {
        from { transform: translateX(0); }
        to { transform: translateX(100%); }
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    .nav-menu.active {
        display: flex;
        flex-direction: column;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        padding: 20px;
    }
    
    .hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }
    
    .hamburger.active span:nth-child(2) {
        opacity: 0;
    }
    
    .hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -6px);
    }
    
    .modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    
    .modal-content {
        background: white;
        border-radius: 10px;
        max-width: 800px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
    }
    
    .modal-close {
        position: absolute;
        top: 15px;
        right: 20px;
        background: none;
        border: none;
        font-size: 30px;
        cursor: pointer;
        z-index: 1;
    }
    
    .modal-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        padding: 30px;
    }
    
    .modal-image img {
        width: 100%;
        height: 400px;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .modal-info h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }
    
     .modal-price {
         font-size: 1.3rem;
         font-weight: 700;
         color: #2c2c2c;
         margin-bottom: 20px;
     }
    
    .modal-actions {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    @media (max-width: 768px) {
        .modal-body {
            grid-template-columns: 1fr;
        }
        
        .modal-actions {
            flex-direction: column;
        }
    }
`;
document.head.appendChild(style);

// Brand Logos Slider
document.addEventListener('DOMContentLoaded', function() {
    const logosTrack = document.getElementById('logosTrack');
    const prevBtn = document.querySelector('.prev-logo');
    const nextBtn = document.querySelector('.next-logo');
    
    if (logosTrack && prevBtn && nextBtn) {
        let currentIndex = 0;
        const itemsPerView = 5;
        const totalItems = logosTrack.children.length;
        const maxIndex = Math.max(0, totalItems - itemsPerView);
        
        function updateSlider() {
            const itemWidth = 200; // logo-item min-width
            const gap = 40; // gap between items
            const translateX = -currentIndex * (itemWidth + gap);
            logosTrack.style.transform = `translateX(${translateX}px)`;
            
            // Update button states
            prevBtn.style.opacity = currentIndex === 0 ? '0.3' : '1';
            nextBtn.style.opacity = currentIndex >= maxIndex ? '0.3' : '1';
            prevBtn.disabled = currentIndex === 0;
            nextBtn.disabled = currentIndex >= maxIndex;
        }
        
        prevBtn.addEventListener('click', function() {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });
        
        nextBtn.addEventListener('click', function() {
            if (currentIndex < maxIndex) {
                currentIndex++;
                updateSlider();
            }
        });
        
        // Initialize
        updateSlider();
    }
});

