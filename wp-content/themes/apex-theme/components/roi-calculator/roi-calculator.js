/**
 * ROI Calculator Component JavaScript
 * Interactive calculation and animations
 * 
 * @package ApexTheme
 * @subpackage Components/ROICalculator
 */

(function() {
    'use strict';
    
    class ApexROICalculator {
        constructor(element) {
            this.section = element;
            this.inputs = element.querySelector('.apex-roi-calculator__inputs');
            this.results = element.querySelector('.apex-roi-calculator__results');
            this.sliders = element.querySelectorAll('.apex-roi-calculator__slider');
            this.valueDisplays = element.querySelectorAll('[data-value-for]');
            this.resultDisplays = element.querySelectorAll('[data-result]');
            
            this.values = {
                customers: 50000,
                transactions: 500000,
                branches: 25,
                staff: 150
            };
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
            this.bindSliderEvents();
            this.calculateROI();
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
            
            if (this.inputs) observer.observe(this.inputs);
            if (this.results) observer.observe(this.results);
        }
        
        bindSliderEvents() {
            this.sliders.forEach(slider => {
                slider.addEventListener('input', (e) => {
                    const metric = e.target.dataset.metric;
                    const value = parseInt(e.target.value);
                    
                    this.values[metric] = value;
                    this.updateValueDisplay(metric, value);
                    this.calculateROI();
                });
            });
        }
        
        updateValueDisplay(metric, value) {
            const display = this.section.querySelector(`[data-value-for="${metric}"]`);
            if (display) {
                display.textContent = this.formatNumber(value);
            }
        }
        
        formatNumber(num) {
            if (num >= 1000000) {
                return (num / 1000000).toFixed(1) + 'M';
            } else if (num >= 1000) {
                return (num / 1000).toFixed(0) + 'K';
            }
            return num.toLocaleString();
        }
        
        calculateROI() {
            const { customers, transactions, branches, staff } = this.values;
            
            // Efficiency gain calculation (simplified model)
            const baseEfficiency = 25;
            const customerFactor = Math.min(customers / 100000, 1) * 10;
            const transactionFactor = Math.min(transactions / 1000000, 1) * 8;
            const efficiency = Math.round(baseEfficiency + customerFactor + transactionFactor);
            
            // Cost savings calculation
            const avgStaffCost = 35000; // Annual cost per staff member
            const efficiencyMultiplier = efficiency / 100;
            const staffSavings = Math.round(staff * avgStaffCost * efficiencyMultiplier * 0.3);
            const operationalSavings = branches * 15000 * efficiencyMultiplier;
            const costSavings = Math.round(staffSavings + operationalSavings);
            
            // Time saved calculation
            const hoursPerTransaction = 0.02; // Average hours saved per transaction
            const timeSaved = Math.round(transactions * hoursPerTransaction * efficiencyMultiplier);
            
            // Payback period calculation
            const implementationCost = 150000 + (branches * 5000);
            const monthlyBenefit = costSavings / 12;
            const payback = Math.max(3, Math.min(18, Math.round(implementationCost / monthlyBenefit)));
            
            // Update displays with animation
            this.animateResult('efficiency', efficiency);
            this.animateResult('cost-savings', costSavings);
            this.animateResult('time-saved', timeSaved);
            this.animateResult('payback', payback);
        }
        
        animateResult(resultId, targetValue) {
            const resultElement = this.section.querySelector(`[data-result="${resultId}"] .apex-roi-calculator__result-number`);
            if (!resultElement) return;
            
            const currentValue = parseInt(resultElement.textContent.replace(/[^0-9]/g, '')) || 0;
            const duration = 500;
            const startTime = performance.now();
            
            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOutCubic = 1 - Math.pow(1 - progress, 3);
                
                const current = Math.round(currentValue + (targetValue - currentValue) * easeOutCubic);
                
                if (resultId === 'cost-savings') {
                    resultElement.textContent = current.toLocaleString();
                } else {
                    resultElement.textContent = current.toLocaleString();
                }
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            };
            
            requestAnimationFrame(animate);
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-roi-calculator-section]');
        sections.forEach(section => {
            new ApexROICalculator(section);
        });
    });
    
    window.ApexROICalculator = ApexROICalculator;
})();
