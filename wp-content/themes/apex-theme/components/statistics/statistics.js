/**
 * Statistics Counter Component JavaScript
 * Animated number counting
 * 
 * @package ApexTheme
 * @subpackage Components/Statistics
 */

(function() {
    'use strict';
    
    class ApexStatistics {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-statistics__header');
            this.items = element.querySelectorAll('.apex-statistics__item');
            this.numbers = element.querySelectorAll('.apex-statistics__number');
            this.hasAnimated = false;
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
        }
        
        setupIntersectionObserver() {
            const options = {
                root: null,
                rootMargin: '-50px',
                threshold: 0.2
            };
            
            // Observer for header
            const headerObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        headerObserver.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.header) {
                headerObserver.observe(this.header);
            }
            
            // Observer for items with stagger and counter animation
            const itemObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = parseInt(entry.target.dataset.delay) || 0;
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                            
                            // Start counter animation for this item
                            const number = entry.target.querySelector('.apex-statistics__number');
                            if (number) {
                                this.animateCounter(number);
                            }
                        }, delay);
                        itemObserver.unobserve(entry.target);
                    }
                });
            }, { ...options, threshold: 0.3 });
            
            this.items.forEach(item => {
                itemObserver.observe(item);
            });
        }
        
        animateCounter(element) {
            const target = parseFloat(element.dataset.count);
            const duration = 2000;
            const startTime = performance.now();
            const isDecimal = target % 1 !== 0;
            
            const updateCounter = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function (ease-out-cubic)
                const easeOutCubic = 1 - Math.pow(1 - progress, 3);
                const current = target * easeOutCubic;
                
                if (isDecimal) {
                    element.textContent = current.toFixed(1);
                } else {
                    element.textContent = Math.floor(current);
                }
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = isDecimal ? target.toFixed(1) : target;
                }
            };
            
            requestAnimationFrame(updateCounter);
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-statistics-section]');
        sections.forEach(section => {
            new ApexStatistics(section);
        });
    });
    
    window.ApexStatistics = ApexStatistics;
})();
