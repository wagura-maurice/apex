/**
 * How We Do It Component JavaScript
 * Timeline animations
 * 
 * @package ApexTheme
 * @subpackage Components/HowWeDoIt
 */

(function() {
    'use strict';
    
    class ApexHowWeDoIt {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-how-we-do-it__header');
            this.steps = element.querySelectorAll('.apex-how-we-do-it__step');
            this.ctaWrapper = element.querySelector('.apex-how-we-do-it__cta-wrapper');
            this.timelineLine = element.querySelector('.apex-how-we-do-it__timeline-line');
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
            this.setupTimelineAnimation();
        }
        
        setupIntersectionObserver() {
            const options = {
                root: null,
                rootMargin: '-50px',
                threshold: 0.1
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
            
            // Observer for steps with stagger
            const stepObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = parseInt(entry.target.dataset.delay) || 0;
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, delay);
                        stepObserver.unobserve(entry.target);
                    }
                });
            }, { ...options, threshold: 0.3 });
            
            this.steps.forEach(step => {
                stepObserver.observe(step);
            });
            
            // Observer for CTA
            const ctaObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        ctaObserver.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.ctaWrapper) {
                ctaObserver.observe(this.ctaWrapper);
            }
        }
        
        setupTimelineAnimation() {
            if (!this.timelineLine) return;
            
            // Animate timeline line on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.timelineLine.style.animation = 'timelineGrow 1.5s ease forwards';
                    }
                });
            }, { threshold: 0.1 });
            
            observer.observe(this.section);
        }
    }
    
    // Add timeline animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes timelineGrow {
            from {
                transform: translateX(-50%) scaleY(0);
                transform-origin: top;
            }
            to {
                transform: translateX(-50%) scaleY(1);
                transform-origin: top;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.apex-how-we-do-it');
        sections.forEach(section => {
            new ApexHowWeDoIt(section);
        });
    });
    
    window.ApexHowWeDoIt = ApexHowWeDoIt;
})();
