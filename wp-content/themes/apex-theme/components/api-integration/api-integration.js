/**
 * API Integration Component JavaScript
 * Animations and copy functionality
 * 
 * @package ApexTheme
 * @subpackage Components/APIIntegration
 */

(function() {
    'use strict';
    
    class ApexAPIIntegration {
        constructor(element) {
            this.section = element;
            this.info = element.querySelector('.apex-api-integration__info');
            this.preview = element.querySelector('.apex-api-integration__preview');
            this.copyBtns = element.querySelectorAll('[data-copy-code]');
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
            this.bindCopyEvents();
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
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.info) observer.observe(this.info);
            if (this.preview) observer.observe(this.preview);
        }
        
        bindCopyEvents() {
            this.copyBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const codeBlock = btn.closest('.apex-api-integration__code-sample').querySelector('code');
                    if (codeBlock) {
                        this.copyToClipboard(codeBlock.textContent, btn);
                    }
                });
            });
        }
        
        copyToClipboard(text, btn) {
            navigator.clipboard.writeText(text).then(() => {
                const originalText = btn.innerHTML;
                btn.innerHTML = `
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Copied!
                `;
                btn.style.color = '#22c55e';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.color = '';
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-api-integration-section]');
        sections.forEach(section => {
            new ApexAPIIntegration(section);
        });
    });
    
    window.ApexAPIIntegration = ApexAPIIntegration;
})();
