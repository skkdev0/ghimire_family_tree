// घिमिरे परिवार वेबसाइटको मुख्य जाभास्क्रिप्ट
document.addEventListener('DOMContentLoaded', function() {
    // मोबाइल मेनु टोगल
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mainNav = document.getElementById('mainNav');
    
    if (mobileMenuBtn && mainNav) {
        mobileMenuBtn.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            
            const icon = this.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.replace('fa-bars', 'fa-times');
            } else {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        });
    }
    
    // स्मूथ स्क्रोलिंग
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                const headerHeight = document.querySelector('header').offsetHeight;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
                
                // मोबाइल मोडमा मेनु बन्द गर्नुहोस्
                if (mainNav && mainNav.classList.contains('active')) {
                    mainNav.classList.remove('active');
                    if (mobileMenuBtn) {
                        const icon = mobileMenuBtn.querySelector('i');
                        if (icon.classList.contains('fa-times')) {
                            icon.classList.replace('fa-times', 'fa-bars');
                        }
                    }
                }
            }
        });
    });
    
    // एक्टिभ नेभिगेसन लिंक
    function setActiveNavLink() {
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('nav a');
        
        let currentSection = '';
        
        sections.forEach(section => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const headerHeight = document.querySelector('header').offsetHeight;
            
            if (window.pageYOffset >= sectionTop - headerHeight - 50) {
                currentSection = section.getAttribute('id');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${currentSection}`) {
                link.classList.add('active');
            }
        });
    }
    
    window.addEventListener('scroll', setActiveNavLink);
    
    // तथ्याङ्क एनिमेसन
    function animateStats() {
        const statElements = document.querySelectorAll('.stat-number');
        const statsSection = document.querySelector('.stats-section');
        
        if (!statsSection) return;
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    statElements.forEach(stat => {
                        const target = parseInt(stat.textContent);
                        const duration = 2000;
                        let startTimestamp = null;
                        
                        const step = (timestamp) => {
                            if (!startTimestamp) startTimestamp = timestamp;
                            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                            const value = Math.floor(progress * target);
                            stat.textContent = value.toLocaleString();
                            
                            if (progress < 1) {
                                window.requestAnimationFrame(step);
                            } else {
                                stat.textContent = target.toLocaleString();
                            }
                        };
                        
                        window.requestAnimationFrame(step);
                    });
                    
                    observer.disconnect();
                }
            });
        }, { threshold: 0.5 });
        
        observer.observe(statsSection);
    }
    
    animateStats();
    
    // फर्म सब्मिसन
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // फर्म डाटा
            const formData = new FormData(this);
            const formObject = Object.fromEntries(formData.entries());
            
            // यहाँ वास्तविक फर्म सब्मिसन कोड हुनेछ
            console.log('Form submitted:', formObject);
            
            // सफलता सन्देश
            alert('धन्यवाद! तपाईंको सन्देश पठाइएको छ। हामी चाँडै नै सम्पर्क गर्नेछौं।');
            this.reset();
        });
    }
    
    // सर्च कार्यक्षमता
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    
    if (searchInput && searchButton) {
        searchButton.addEventListener('click', function() {
            performSearch(searchInput.value);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch(this.value);
            }
        });
    }
    
    function performSearch(query) {
        if (!query.trim()) return;
        
        // यहाँ वास्तविक खोज कार्यक्षमता हुनेछ
        console.log('Searching for:', query);
        
        // उदाहरणको लागि
        const searchResults = document.getElementById('searchResults');
        if (searchResults) {
            searchResults.innerHTML = `
                <div class="card">
                    <h3>खोज परिणामहरू</h3>
                    <p>"${query}" को लागि ५ वटा परिणाम फेला पर्यो</p>
                    <div class="search-results-list">
                        <!-- खोज परिणामहरू यहाँ प्रदर्शित हुनेछन् -->
                    </div>
                </div>
            `;
            
            // स्क्रोल गर्नुहोस्
            const headerHeight = document.querySelector('header').offsetHeight;
            const resultsPosition = searchResults.getBoundingClientRect().top + window.pageYOffset - headerHeight;
            
            window.scrollTo({
                top: resultsPosition,
                behavior: 'smooth'
            });
        }
    }
    
    // लोडिंग एनिमेसन
    function showLoading() {
        const loadingElement = document.createElement('div');
        loadingElement.className = 'loading-overlay';
        loadingElement.innerHTML = `
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i>
                <p>लोड हुँदैछ...</p>
            </div>
        `;
        
        document.body.appendChild(loadingElement);
        
        return loadingElement;
    }
    
    function hideLoading(loadingElement) {
        if (loadingElement) {
            loadingElement.remove();
        }
    }
    
    // टूलटिपहरू
    function initTooltips() {
        const tooltipElements = document.querySelectorAll('[data-tooltip]');
        
        tooltipElements.forEach(element => {
            element.addEventListener('mouseenter', function(e) {
                const tooltipText = this.getAttribute('data-tooltip');
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = tooltipText;
                
                document.body.appendChild(tooltip);
                
                const rect = this.getBoundingClientRect();
                tooltip.style.top = `${rect.top - tooltip.offsetHeight - 10}px`;
                tooltip.style.left = `${rect.left + (rect.width - tooltip.offsetWidth) / 2}px`;
                
                this.addEventListener('mouseleave', function() {
                    tooltip.remove();
                }, { once: true });
            });
        });
    }
    
    initTooltips();
    
    // थीम स्विचर
    function initThemeSwitcher() {
        const themeSwitch = document.getElementById('themeSwitch');
        if (!themeSwitch) return;
        
        // डिफल्ट थीम
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        themeSwitch.checked = savedTheme === 'dark';
        
        themeSwitch.addEventListener('change', function() {
            const theme = this.checked ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
        });
    }
    
    initThemeSwitcher();
    
    // काउन्टडाउन टाइमर
    function initCountdown() {
        const countdownElement = document.getElementById('countdown');
        if (!countdownElement) return;
        
        const eventDate = new Date('2025-12-31T00:00:00').getTime();
        
        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = eventDate - now;
            
            if (distance < 0) {
                clearInterval(timer);
                countdownElement.innerHTML = 'घटना समाप्त भयो';
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            countdownElement.innerHTML = `
                <div class="countdown-item">
                    <span class="countdown-number">${days}</span>
                    <span class="countdown-label">दिन</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number">${hours}</span>
                    <span class="countdown-label">घण्टा</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number">${minutes}</span>
                    <span class="countdown-label">मिनेट</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-number">${seconds}</span>
                    <span class="countdown-label">सेकेन्ड</span>
                </div>
            `;
        }, 1000);
    }
    
    initCountdown();
    
    // सामाजिक साझा कार्यक्षमता
    function initSocialShare() {
        const shareButtons = document.querySelectorAll('.share-btn');
        
        shareButtons.forEach(button => {
            button.addEventListener('click', function() {
                const platform = this.getAttribute('data-platform');
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent(document.title);
                
                let shareUrl;
                
                switch(platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                        break;
                    case 'linkedin':
                        shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${url}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${title}%20${url}`;
                        break;
                    default:
                        return;
                }
                
                window.open(shareUrl, '_blank', 'width=600,height=400');
            });
        });
    }
    
    initSocialShare();
    
    // स्क्रोल टप बटन
    function initScrollToTop() {
        const scrollButton = document.createElement('button');
        scrollButton.className = 'scroll-to-top';
        scrollButton.innerHTML = '<i class="fas fa-chevron-up"></i>';
        scrollButton.style.display = 'none';
        
        document.body.appendChild(scrollButton);
        
        scrollButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollButton.style.display = 'block';
            } else {
                scrollButton.style.display = 'none';
            }
        });
    }
    
    initScrollToTop();
    
    // पोपअप सूचनाहरू
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <p>${message}</p>
            <button class="notification-close"><i class="fas fa-times"></i></button>
        `;
        
        document.body.appendChild(notification);
        
        // प्रदर्शन गर्नुहोस्
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // बन्द गर्नुहोस्
        const closeButton = notification.querySelector('.notification-close');
        closeButton.addEventListener('click', function() {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        });
        
        // स्वचालित रूपमा बन्द गर्नुहोस्
        setTimeout(() => {
            if (notification.parentNode) {
                notification.classList.remove('show');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }, 5000);
    }
    
    // उदाहरण सूचना
    // showNotification('यो घिमिरे परिवार वेबसाइटमा स्वागत छ', 'success');
});

// ग्लोबल कार्यहरू
function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(date).toLocaleDateString('ne-NP', options);
}

function truncateText(text, maxLength) {
    if (text.length <= maxLength) return text;
    return text.substr(0, maxLength) + '...';
}

// डार्क थीम स्टाइल्स
const darkThemeStyles = `
    [data-theme="dark"] {
        --light-color: #2d3748;
        --dark-color: #f7fafc;
        background-color: #1a202c;
        color: #e2e8f0;
    }
    
    [data-theme="dark"] .card {
        background-color: #2d3748;
        color: #e2e8f0;
    }
    
    [data-theme="dark"] .form-input {
        background-color: #2d3748;
        color: #e2e8f0;
        border-color: #4a5568;
    }
`;

// डार्क थीम स्टाइल्स थप्नुहोस्
const styleElement = document.createElement('style');
styleElement.textContent = darkThemeStyles;
document.head.appendChild(styleElement);