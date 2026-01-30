/**
 * Who We Are Component JavaScript
 * Scroll-based animations
 * 
 * @package ApexTheme
 * @subpackage Components/WhoWeAre
 */

(function() {
    'use strict';
    
    class ApexWhoWeAre {
        constructor(element) {
            this.section = element;
            this.content = element.querySelector('.apex-who-we-are__content');
            this.visual = element.querySelector('.apex-who-we-are__visual');
            this.features = element.querySelectorAll('.apex-who-we-are__feature');
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
            this.setupFeatureAnimations();
        }
        
        setupIntersectionObserver() {
            const options = {
                root: null,
                rootMargin: '-50px',
                threshold: 0.2
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.animateIn();
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            observer.observe(this.section);
        }
        
        animateIn() {
            if (this.content) {
                this.content.classList.add('is-visible');
            }
            
            if (this.visual) {
                this.visual.classList.add('is-visible');
            }
            
            // Stagger feature animations
            this.features.forEach((feature, index) => {
                setTimeout(() => {
                    feature.style.opacity = '1';
                    feature.style.transform = 'translateY(0)';
                }, 200 + (index * 100));
            });
        }
        
        setupFeatureAnimations() {
            this.features.forEach(feature => {
                feature.style.opacity = '0';
                feature.style.transform = 'translateY(20px)';
                feature.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            });
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.apex-who-we-are');
        sections.forEach(section => {
            new ApexWhoWeAre(section);
        });
    });
    
    window.ApexWhoWeAre = ApexWhoWeAre;
})();
