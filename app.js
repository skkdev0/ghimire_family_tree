// मुख्य एप्लिकेसन लजिक
class GhimireFamilyApp {
    constructor() {
        this.currentView = 'home';
        this.currentMember = null;
        this.searchResults = [];
        this.init();
    }
    
    init() {
        this.setupEventListeners();
        this.loadHomePage();
        this.updateActiveNav();
    }
    
    // इभेन्ट लिस्नरहरू सेटअप गर्नुहोस्
    setupEventListeners() {
        // नेभिगेसन लिंकहरू
        document.querySelectorAll('nav a').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const target = e.target.getAttribute('href').substring(1);
                this.navigateTo(target);
            });
        });
        
        // मोबाइल मेनु बटन
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                const nav = document.getElementById('mainNav');
                nav.classList.toggle('active');
                
                const icon = mobileMenuBtn.querySelector('i');
                if (icon.classList.contains('fa-bars')) {
                    icon.classList.replace('fa-bars', 'fa-times');
                } else {
                    icon.classList.replace('fa-times', 'fa-bars');
                }
            });
        }
        
        // सर्फ फर्म
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const searchInput = document.getElementById('searchInput');
                this.searchMembers(searchInput.value);
            });
        }
        
        // कन्ट्याक्ट फर्म
        const contactForm = document.getElementById('contactForm');
        if (contactForm) {
            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleContactForm(contactForm);
            });
        }
    }
    
    // नेभिगेट गर्नुहोस्
    navigateTo(view) {
        this.currentView = view;
        this.updateActiveNav();
        
        switch(view) {
            case 'home':
                this.loadHomePage();
                break;
            case 'tree':
                this.loadTreePage();
                break;
            case 'members':
                this.loadMembersPage();
                break;
            case 'branches':
                this.loadBranchesPage();
                break;
            case 'about':
                this.loadAboutPage();
                break;
        }
        
        // स्मूथ स्क्रोलिंग
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    // एक्टिभ नेभिगेसन अपडेट गर्नुहोस्
    updateActiveNav() {
        document.querySelectorAll('nav a').forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('href') === `#${this.currentView}`) {
                link.classList.add('active');
            }
        });
    }
    
    // गृहपृष्ठ लोड गर्नुहोस्
    loadHomePage() {
        // होमपेज कन्टेन्ट
        const mainContent = `
            <section class="hero" id="home">
                <div class="hero-content">
                    <h2>घिमिरे परिवारको विस्तृत वंशावली</h2>
                    <p>हजारौं सदस्यहरू, धेरै पुस्ता, एकै ठाउँमा। आफ्नो मूल र परिवारको इतिहासलाई फेरि खोज्नुहोस्।</p>
                    <a href="#tree" class="cta-button">वंशावली हेर्नुहोस् <i class="fas fa-arrow-right"></i></a>
                </div>
            </section>
            
            <div class="container">
                <section class="stats-section">
                    <h2>परिवारको तथ्याङ्क</h2>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">${FamilyDataService.getAllBranches().length}</div>
                            <div class="stat-label">मुख्य शाखाहरू</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-number">${Object.values(familyData.members).length}</div>
                            <div class="stat-label">सदस्यहरू</div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="stat-number">${Math.max(...Object.values(familyData.members).map(m => m.generation))}</div>
                            <div class="stat-label">पुस्ताहरू</div>
                        </div>
                    </div>
                </section>
                
                <section class="branches-preview">
                    <h2>मुख्य शाखाहरू</h2>
                    <div class="branches-grid">
                        ${FamilyDataService.getAllBranches().map(branch => `
                            <div class="branch-card">
                                <div class="branch-icon">
                                    <i class="fas fa-code-branch"></i>
                                </div>
                                <h3>${branch.name}</h3>
                                <p>${branch.memberCount}+ सदस्यहरू</p>
                                <a href="#branches" class="view-button">विस्तृत हेर्नुहोस्</a>
                            </div>
                        `).join('')}
                    </div>
                </section>
            </div>
        `;
        
        document.querySelector('main').innerHTML = mainContent;
        this.setupHomePageInteractions();
    }
    
    // वंशावली पृष्ठ लोड गर्नुहोस्
    loadTreePage() {
        // ट्री पेज कन्टेन्ट
        const mainContent = `
            <div class="tree-page-container">
                <div class="tree-control-panel">
                    <button class="tree-control-button" id="resetTree">
                        <i class="fas fa-sync"></i> रिसेट गर्नुहोस्
                    </button>
                    <button class="tree-control-button" id="centerTree">
                        <i class="fas fa-crosshairs"></i> केन्द्रित गर्नुहोस्
                    </button>
                    
                    <div class="tree-zoom-controls">
                        <button class="zoom-button" id="zoomIn">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="zoom-button" id="zoomOut">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                
                <div class="tree-container">
                    <div class="tree-wrapper" id="treeWrapper">
                        <!-- वंशावली यहाँ रेन्डर हुनेछ -->
                    </div>
                </div>
                
                <div class="copyright">
                    © copyright SKK Apps 2025. Project by Shyam Kumar
                </div>
            </div>
            
            <div class="sidebar" id="sidebar">
                <button class="close-sidebar" id="closeSidebar">
                    <i class="fas fa-times"></i>
                </button>
                
                <div class="sidebar-content" id="sidebarContent">
                    <!-- साइडबार कन्टेन्ट यहाँ रेन्डर हुनेछ -->
                </div>
            </div>
            
            <div class="overlay" id="overlay"></div>
        `;
        
        document.querySelector('main').innerHTML = mainContent;
        this.renderFamilyTree();
        this.setupTreeInteractions();
    }
    
    // सदस्यहरू पृष्ठ लोड गर्नुहोस्
    loadMembersPage() {
        // मेंबर्स पेज कन्टेन्ट
        const mainContent = `
            <div class="main-container">
                <div class="page-title">
                    <h2>घिमिरे परिवारका सदस्यहरू</h2>
                    <p>सम्पूर्ण परिवारका सदस्यहरूको विस्तृत सूची</p>
                </div>
                
                <section class="filters-section">
                    <div class="search-container">
                        <input type="text" class="search-input" placeholder="सदस्यको नाम लेख्नुहोस्..." id="searchInput">
                        <button class="search-button" id="searchButton">
                            <i class="fas fa-search"></i> खोज्नुहोस्
                        </button>
                    </div>
                    
                    <div class="filter-controls">
                        <div class="filter-group">
                            <label class="filter-label">शाखा छान्नुहोस्</label>
                            <select class="filter-select" id="branchFilter">
                                <option value="">सबै शाखाहरू</option>
                                ${FamilyDataService.getAllBranches().map(branch => `
                                    <option value="${branch.id}">${branch.name}</option>
                                `).join('')}
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">पुस्ता छान्नुहोस्</label>
                            <select class="filter-select" id="generationFilter">
                                <option value="">सबै पुस्ताहरू</option>
                                ${Array.from({length: Math.max(...Object.values(familyData.members).map(m => m.generation))}, (_, i) => i + 1)
                                    .map(gen => `<option value="${gen}">${gen} औं पुस्ता</option>`).join('')}
                            </select>
                        </div>
                        
                        <div class="filter-group">
                            <label class="filter-label">क्रमबद्ध गर्नुहोस्</label>
                            <select class="filter-select" id="sortFilter">
                                <option value="name">नाम अनुसार</option>
                                <option value="branch">शाखा अनुसार</option>
                                <option value="generation">पुस्ता अनुसार</option>
                            </select>
                        </div>
                    </div>
                </section>
                
                <section class="members-grid" id="membersGrid">
                    <!-- सदस्यहरू यहाँ रेन्डर हुनेछन् -->
                </section>
                
                <div class="pagination" id="pagination">
                    <!-- पेजिनेशन यहाँ रेन्डर हुनेछ -->
                </div>
            </div>
        `;
        
        document.querySelector('main').innerHTML = mainContent;
        this.renderMembers();
        this.setupMembersPageInteractions();
    }
    
    // शाखाहरू पृष्ठ लोड गर्नुहोस्
    loadBranchesPage() {
        // ब्रान्चेस पेज कन्टेन्ट
        const mainContent = `
            <div class="main-container">
                <div class="page-title">
                    <h2>घिमिरे परिवारका शाखाहरू</h2>
                    <p>परिवारका विभिन्न शाखाहरूको विस्तृत जानकारी</p>
                </div>
                
                <section class="branches-overview" id="branchesOverview">
                    <!-- शाखाहरूको अवलोकन यहाँ रेन्डर हुनेछ -->
                </section>
                
                <section class="branch-details" id="branchDetails">
                    <!-- शाखा विवरणहरू यहाँ रेन्डर हुनेछन् -->
                </section>
            </div>
        `;
        
        document.querySelector('main').innerHTML = mainContent;
        this.renderBranchesOverview();
        this.renderBranchDetails();
        this.setupBranchesPageInteractions();
    }
    
    // बारेमा पृष्ठ लोड गर्नुहोस्
    loadAboutPage() {
        // अबाउट पेज कन्टेन्ट
        const mainContent = `
            <div class="main-container">
                <div class="page-title">
                    <h2>घिमिरे परिवारको बारेमा</h2>
                    <p>हाम्रो परिवारको इतिहास, उद्देश्य र लक्ष्यहरू</p>
                </div>
                
                <section class="history-section">
                    <h2>परिवारको इतिहास</h2>
                    <div class="history-content">
                        <div class="history-text">
                            <p>घिमिरे परिवार नेपालको अर्घाखाँची/गुल्मी क्षेत्रमा मूल भएको ठूलो र प्रतिष्ठित परिवार हो। यो परिवारको इतिहास सयौं वर्ष पुरानो छ र यसका धेरै शाखाहरू छन्।</p>
                            <p>परिवारको मूल पुरुष सोदु जैसी घिमिरे हुन् जसका पाँच छोराहरूले परिवारलाई विभिन्न शाखाहरूमा विस्तार गरेका छन्।</p>
                        </div>
                        <div class="history-image">
                            <i class="fas fa-history"></i>
                        </div>
                    </div>
                </section>
                
                <section class="team-section">
                    <h2>वेबसाइट विकास टिम</h2>
                    <div class="team-grid">
                        <div class="team-member">
                            <div class="member-image">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <h3 class="member-name">श्याम कुमार</h3>
                            <div class="member-role">मुख्य विकासकर्ता</div>
                            <p>वेब डिजाइन र विकासमा विशेषज्ञ</p>
                        </div>
                    </div>
                </section>
                
                <section class="contact-section">
                    <h2>सम्पर्क गर्नुहोस्</h2>
                    <form id="contactForm">
                        <div class="form-group">
                            <label class="form-label">नाम</label>
                            <input type="text" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">इमेल</label>
                            <input type="email" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">सन्देश</label>
                            <textarea class="form-input form-textarea" required></textarea>
                        </div>
                        
                        <button type="submit" class="submit-button">सन्देश पठाउनुहोस्</button>
                    </form>
                </section>
            </div>
        `;
        
        document.querySelector('main').innerHTML = mainContent;
        this.setupAboutPageInteractions();
    }
    
    // होमपेज इन्टरएक्सनहरू सेटअप गर्नुहोस्
    setupHomePageInteractions() {
        // स्ट्याट्स एनिमेसन
        this.animateStats();
    }
    
    // वंशावली रेन्डर गर्नुहोस्
    renderFamilyTree() {
        // यहाँ वंशावली रेन्डर गर्ने लजिक हुनेछ
        console.log("Family tree rendering logic would be implemented here");
    }
    
    // सदस्यहरू रेन्डर गर्नुहोस्
    renderMembers() {
        const membersGrid = document.getElementById('membersGrid');
        const allMembers = Object.values(familyData.members);
        
        membersGrid.innerHTML = allMembers.map(member => `
            <div class="member-card" data-member-id="${member.id}">
                <div class="member-image">
                    <i class="fas fa-${member.gender === 'male' ? 'male' : 'female'}"></i>
                </div>
                <div class="member-info">
                    <h3 class="member-name">${member.name}</h3>
                    <div class="member-relation">${member.relation}</div>
                    ${member.branch ? `<span class="member-branch">${member.branch}</span>` : ''}
                    <div class="member-meta">
                        <span>पुस्ता: ${member.generation}</span>
                        <span>लिंग: ${member.gender === 'male' ? 'पुरुष' : 'महिला'}</span>
                    </div>
                    <a href="#" class="view-profile">विस्तृत हेर्नुहोस्</a>
                </div>
            </div>
        `).join('');
        
        // मेंबर कार्डहरूमा क्लिक इभेन्ट थप्नुहोस्
        document.querySelectorAll('.member-card').forEach(card => {
            card.addEventListener('click', () => {
                const memberId = card.getAttribute('data-member-id');
                this.showMemberDetails(memberId);
            });
        });
    }
    
    // शाखाहरूको अवलोकन रेन्डर गर्नुहोस्
    renderBranchesOverview() {
        const branchesOverview = document.getElementById('branchesOverview');
        const branches = FamilyDataService.getAllBranches();
        
        branchesOverview.innerHTML = branches.map(branch => `
            <div class="branch-overview-card ${branch.id}">
                <div class="branch-icon">
                    <i class="fas fa-code-branch"></i>
                </div>
                <h3 class="branch-name">${branch.name}</h3>
                <p>${branch.founder} को शाखा</p>
                <div class="branch-stats">
                    <div class="stat">
                        <span class="stat-number">${branch.memberCount}+</span>
                        <span class="stat-label">सदस्यहरू</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">${branch.generations}</span>
                        <span class="stat-label">पुस्ता</span>
                    </div>
                </div>
                <a href="#${branch.id}" class="view-branch-button">विस्तृत हेर्नुहोस्</a>
            </div>
        `).join('');
    }
    
    // शाखा विवरणहरू रेन्डर गर्नुहोस्
    renderBranchDetails() {
        const branchDetails = document.getElementById('branchDetails');
        const branches = FamilyDataService.getAllBranches();
        
        branchDetails.innerHTML = branches.map(branch => {
            const branchMembers = FamilyDataService.getBranchMembers(branch.name);
            const prominentMembers = branchMembers.filter(m => 
                m.relation.includes('प्रमुख') || m.relation.includes('संस्थापक') || m.relation.includes('छोरा')
            ).slice(0, 3);
            
            return `
                <section id="${branch.id}" class="branch-detail-section ${branch.id}-detail">
                    <div class="branch-detail-header">
                        <div class="branch-detail-icon">
                            <i class="fas fa-code-branch"></i>
                        </div>
                        <div>
                            <h2 class="branch-detail-title">${branch.name} शाखा</h2>
                            <p class="branch-detail-subtitle">${branch.founder} को शाखा</p>
                        </div>
                    </div>
                    
                    <div class="branch-info-grid">
                        <div class="info-card">
                            <h3 class="info-card-title">स्थापना</h3>
                            <p>${branch.established}</p>
                        </div>
                        
                        <div class="info-card">
                            <h3 class="info-card-title">मुख्य स्थान</h3>
                            <p>${branch.location}</p>
                        </div>
                        
                        <div class="info-card">
                            <h3 class="info-card-title">वर्तमान प्रमुख</h3>
                            <p>${branch.currentHead}</p>
                        </div>
                        
                        <div class="info-card">
                            <h3 class="info-card-title">विशेषता</h3>
                            <p>${branch.specialty}</p>
                        </div>
                    </div>
                    
                    ${prominentMembers.length > 0 ? `
                    <div class="prominent-members">
                        <h3>प्रमुख सदस्यहरू</h3>
                        <div class="members-list">
                            ${prominentMembers.map(member => `
                                <div class="member-item" data-member-id="${member.id}">
                                    <div class="member-icon">
                                        <i class="fas fa-${member.gender === 'male' ? 'male' : 'female'}"></i>
                                    </div>
                                    <div class="member-info">
                                        <div class="member-name">${member.name}</div>
                                        <div class="member-relation">${member.relation}</div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    ` : ''}
                </section>
            `;
        }).join('');
        
        // मेंबर आइटमहरूमा क्लिक इभेन्ट थप्नुहोस्
        document.querySelectorAll('.member-item').forEach(item => {
            item.addEventListener('click', () => {
                const memberId = item.getAttribute('data-member-id');
                this.showMemberDetails(memberId);
            });
        });
    }
    
    // सदस्य विवरण देखाउनुहोस्
    showMemberDetails(memberId) {
        const member = FamilyDataService.getMember(memberId);
        if (!member) return;
        
        this.currentMember = member;
        
        // मोडल वा साइडबारमा विवरण देखाउनुहोस्
        console.log("Showing details for:", member.name);
        // यहाँ मोडल वा साइडबार रेन्डर गर्ने लजिक हुनेछ
    }
    
    // सदस्यहरू खोज्नुहोस्
    searchMembers(query) {
        this.searchResults = FamilyDataService.searchMembers(query);
        this.displaySearchResults();
    }
    
    // खोज परिणामहरू देखाउनुहोस्
    displaySearchResults() {
        // यहाँ खोज परिणामहरू देखाउने लजिक हुनेछ
        console.log("Search results:", this.searchResults);
    }
    
    // सम्पर्क फर्म ह्यान्डल गर्नुहोस्
    handleContactForm(form) {
        const formData = new FormData(form);
        console.log("Contact form submitted:", Object.fromEntries(formData));
        alert('धन्यवाद! तपाईंको सन्देश पठाइएको छ। हामी चाँडै नै सम्पर्क गर्नेछौं।');
        form.reset();
    }
    
    // तथ्याङ्क एनिमेट गर्नुहोस्
    animateStats() {
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const target = parseInt(stat.textContent);
            this.animateValue(stat, 0, target, 2000);
        });
    }
    
    // एनिमेटेड काउन्टर
    animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value.toLocaleString();
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
    
    // वंशावली इन्टरएक्सनहरू सेटअप गर्नुहोस्
    setupTreeInteractions() {
        // यहाँ वंशावली कन्ट्रोलहरूको लजिक हुनेछ
    }
    
    // सदस्य पृष्ठ इन्टरएक्सनहरू सेटअप गर्नुहोस्
    setupMembersPageInteractions() {
        // यहाँ सदस्य पृष्ठका फिल्टरहरूको लजिक हुनेछ
    }
    
    // शाखाहरू पृष्ठ इन्टरएक्सनहरू सेटअप गर्नुहोस्
    setupBranchesPageInteractions() {
        // यहाँ शाखाहरू पृष्ठका इन्टरएक्सनहरूको लजिक हुनेछ
    }
    
    // बारेमा पृष्ठ इन्टरएक्सनहरू सेटअप गर्नुहोस्
    setupAboutPageInteractions() {
        // यहाँ बारेमा पृष्ठका इन्टरएक्सनहरूको लजिक हुनेछ
    }
}

// एप्लिकेसन इनिसियलाइज गर्नुहोस्
document.addEventListener('DOMContentLoaded', function() {
    window.GhimireFamilyApp = new GhimireFamilyApp();
});