/**
 * Leadership Team Component JavaScript
 * Animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/LeadershipTeam
 */

(function() {
    'use strict';
    
    class ApexLeadershipTeam {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-leadership-team__header');
            this.members = element.querySelectorAll('.apex-leadership-team__member');
            
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
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = entry.target.dataset.delay || 0;
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.header) observer.observe(this.header);
            this.members.forEach(member => observer.observe(member));
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-leadership-team-section]');
        sections.forEach(section => {
            new ApexLeadershipTeam(section);
        });
    });
    
    window.ApexLeadershipTeam = ApexLeadershipTeam;
})();
