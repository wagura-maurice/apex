/**
 * Solutions Detail Component JavaScript
 * Tab switching and animations
 * 
 * @package ApexTheme
 * @subpackage Components/SolutionsDetail
 */

(function() {
    'use strict';
    
    class ApexSolutionsDetail {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-solutions-detail__header');
            this.tabsContainer = element.querySelector('.apex-solutions-detail__tabs');
            this.tabs = element.querySelectorAll('.apex-solutions-detail__tab');
            this.panels = element.querySelectorAll('.apex-solutions-detail__panel');
            this.comparison = element.querySelector('.apex-solutions-detail__comparison');
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
            this.bindTabEvents();
        }
        
        setupIntersectionObserver() {
            const options = {
                root: null,
                rootMargin: '-50px',
                threshold: 0.1
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.header) observer.observe(this.header);
            if (this.tabsContainer) observer.observe(this.tabsContainer);
            if (this.comparison) observer.observe(this.comparison);
        }
        
        bindTabEvents() {
            this.tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetId = tab.dataset.tab;
                    this.switchTab(targetId);
                });
            });
        }
        
        switchTab(targetId) {
            // Update tabs
            this.tabs.forEach(tab => {
                tab.classList.toggle('is-active', tab.dataset.tab === targetId);
            });
            
            // Update panels
            this.panels.forEach(panel => {
                panel.classList.toggle('is-active', panel.dataset.panel === targetId);
            });
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-solutions-detail-section]');
        sections.forEach(section => {
            new ApexSolutionsDetail(section);
        });
    });
    
    window.ApexSolutionsDetail = ApexSolutionsDetail;
})();
