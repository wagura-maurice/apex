<?php 
/**
 * Template Name: Insights Webinars
 * Webinars & Events Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_webinars_hero_stats_insights-webinars', "50+ | Webinars Hosted\n10K+ | Attendees\n25+ | Expert Speakers\n12 | Annual Events");
$stats_array = [];
foreach (explode("\n", $hero_stats) as $stat_line) {
    $parts = explode(' | ', $stat_line);
    if (count($parts) >= 2) {
        $stats_array[] = [
            'value' => trim($parts[0]),
            'label' => trim($parts[1])
        ];
    }
}

apex_render_about_hero([
    'badge' => get_option('apex_webinars_hero_badge_insights-webinars', 'Webinars & Events'),
    'heading' => get_option('apex_webinars_hero_heading_insights-webinars', 'Learn from Industry Experts'),
    'description' => get_option('apex_webinars_hero_description_insights-webinars', 'Join our webinars, workshops, and events to stay ahead of the curve in financial technology. Connect with peers and learn from industry leaders.'),
    'stats' => $stats_array,
    'image' => get_option('apex_webinars_hero_image_insights-webinars', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200')
]);
?>

<section class="apex-webinars-upcoming">
    <div class="apex-webinars-upcoming__container">
        <div class="apex-webinars-upcoming__header">
            <span class="apex-webinars-upcoming__badge"><?php echo esc_html(get_option('apex_webinars_upcoming_badge_insights-webinars', 'Upcoming Events')); ?></span>
            <h2 class="apex-webinars-upcoming__heading"><?php echo esc_html(get_option('apex_webinars_upcoming_heading_insights-webinars', "Don't Miss Out")); ?></h2>
            <p class="apex-webinars-upcoming__description"><?php echo esc_html(get_option('apex_webinars_upcoming_description_insights-webinars', 'Register for our upcoming webinars and events to learn from industry experts and connect with peers.')); ?></p>
        </div>
        
        <div class="apex-webinars-upcoming__grid">
            <div class="apex-webinars-upcoming__item apex-webinars-upcoming__item--featured">
                <div class="apex-webinars-upcoming__item-badge"><?php echo esc_html(get_option('apex_webinars_featured_badge_insights-webinars', 'Featured Webinar')); ?></div>
                <div class="apex-webinars-upcoming__item-date">
                    <span class="apex-webinars-upcoming__item-day"><?php echo esc_html(get_option('apex_webinars_featured_day_insights-webinars', '15')); ?></span>
                    <span class="apex-webinars-upcoming__item-month"><?php echo esc_html(get_option('apex_webinars_featured_month_insights-webinars', 'FEB')); ?></span>
                </div>
                <div class="apex-webinars-upcoming__item-content">
                    <span class="apex-webinars-upcoming__item-type"><?php echo esc_html(get_option('apex_webinars_featured_type_insights-webinars', 'Live Webinar')); ?></span>
                    <h3><?php echo esc_html(get_option('apex_webinars_featured_title_insights-webinars', 'The Future of Core Banking: Cloud-Native Architecture in 2026')); ?></h3>
                    <p><?php echo esc_html(get_option('apex_webinars_featured_description_insights-webinars', 'Explore how cloud-native core banking systems are revolutionizing the financial services industry. Learn about scalability, security, and cost benefits.')); ?></p>
                    <div class="apex-webinars-upcoming__item-meta">
                        <div class="apex-webinars-upcoming__item-time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span><?php echo esc_html(get_option('apex_webinars_featured_time_insights-webinars', '2:00 PM EAT')); ?></span>
                        </div>
                        <div class="apex-webinars-upcoming__item-duration">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2"/><circle cx="12" cy="12" r="3"/></svg>
                            <span><?php echo esc_html(get_option('apex_webinars_featured_duration_insights-webinars', '60 minutes')); ?></span>
                        </div>
                    </div>
                    <div class="apex-webinars-upcoming__item-speakers">
                        <span>Speakers:</span>
                        <div class="apex-webinars-upcoming__item-speaker-avatars">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Speaker 1">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Speaker 2">
                        </div>
                        <span><?php echo esc_html(get_option('apex_webinars_featured_speakers_insights-webinars', 'Sarah Ochieng, John Kamau')); ?></span>
                    </div>
                    <a href="<?php echo esc_url(get_option('apex_webinars_featured_link_insights-webinars', '#')); ?>" class="apex-webinars-upcoming__item-cta">Register Now - Free</a>
                </div>
            </div>
            
            <div class="apex-webinars-upcoming__item">
                <div class="apex-webinars-upcoming__item-date">
                    <span class="apex-webinars-upcoming__item-day">22</span>
                    <span class="apex-webinars-upcoming__item-month">FEB</span>
                </div>
                <div class="apex-webinars-upcoming__item-content">
                    <span class="apex-webinars-upcoming__item-type">Workshop</span>
                    <h3>Hands-On: Building Custom Integrations with ApexConnect API</h3>
                    <p>A practical workshop for developers looking to integrate third-party services with ApexCore using our API platform.</p>
                    <div class="apex-webinars-upcoming__item-meta">
                        <div class="apex-webinars-upcoming__item-time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span>10:00 AM EAT</span>
                        </div>
                        <div class="apex-webinars-upcoming__item-duration">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2"/><circle cx="12" cy="12" r="3"/></svg>
                            <span>2 hours</span>
                        </div>
                    </div>
                    <a href="#" class="apex-webinars-upcoming__item-cta apex-webinars-upcoming__item-cta--secondary">Register</a>
                </div>
            </div>
            
            <div class="apex-webinars-upcoming__item">
                <div class="apex-webinars-upcoming__item-date">
                    <span class="apex-webinars-upcoming__item-day">05</span>
                    <span class="apex-webinars-upcoming__item-month">MAR</span>
                </div>
                <div class="apex-webinars-upcoming__item-content">
                    <span class="apex-webinars-upcoming__item-type">Panel Discussion</span>
                    <h3>Women in Fintech: Leading Digital Transformation in Africa</h3>
                    <p>Join our panel of women leaders as they discuss their journeys, challenges, and the future of fintech in Africa.</p>
                    <div class="apex-webinars-upcoming__item-meta">
                        <div class="apex-webinars-upcoming__item-time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span>3:00 PM EAT</span>
                        </div>
                        <div class="apex-webinars-upcoming__item-duration">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2"/><circle cx="12" cy="12" r="3"/></svg>
                            <span>90 minutes</span>
                        </div>
                    </div>
                    <a href="#" class="apex-webinars-upcoming__item-cta apex-webinars-upcoming__item-cta--secondary">Register</a>
                </div>
            </div>
            
            <div class="apex-webinars-upcoming__item">
                <div class="apex-webinars-upcoming__item-date">
                    <span class="apex-webinars-upcoming__item-day">12</span>
                    <span class="apex-webinars-upcoming__item-month">MAR</span>
                </div>
                <div class="apex-webinars-upcoming__item-content">
                    <span class="apex-webinars-upcoming__item-type">Live Webinar</span>
                    <h3>Cybersecurity Essentials for Financial Institutions</h3>
                    <p>Learn about the latest threats and best practices for protecting your institution and customers from cyber attacks.</p>
                    <div class="apex-webinars-upcoming__item-meta">
                        <div class="apex-webinars-upcoming__item-time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span>2:00 PM EAT</span>
                        </div>
                        <div class="apex-webinars-upcoming__item-duration">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2"/><circle cx="12" cy="12" r="3"/></svg>
                            <span>60 minutes</span>
                        </div>
                    </div>
                    <a href="#" class="apex-webinars-upcoming__item-cta apex-webinars-upcoming__item-cta--secondary">Register</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="apex-webinars-conference">
    <div class="apex-webinars-conference__container">
        <div class="apex-webinars-conference__content">
            <span class="apex-webinars-conference__badge"><?php echo esc_html(get_option('apex_webinars_conf_badge_insights-webinars', 'Annual Conference')); ?></span>
            <h2 class="apex-webinars-conference__heading"><?php echo esc_html(get_option('apex_webinars_conf_heading_insights-webinars', 'Apex Summit 2026')); ?></h2>
            <p class="apex-webinars-conference__description"><?php echo esc_html(get_option('apex_webinars_conf_description_insights-webinars', 'Join us for our flagship annual conference bringing together 500+ financial technology leaders, innovators, and practitioners from across Africa.')); ?></p>
            
            <div class="apex-webinars-conference__details">
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <div>
                        <strong>Date</strong>
                        <span><?php echo esc_html(get_option('apex_webinars_conf_date_insights-webinars', 'June 15-17, 2026')); ?></span>
                    </div>
                </div>
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <div>
                        <strong>Location</strong>
                        <span><?php echo esc_html(get_option('apex_webinars_conf_location_insights-webinars', 'Kenyatta International Convention Centre, Nairobi')); ?></span>
                    </div>
                </div>
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <div>
                        <strong>Attendees</strong>
                        <span><?php echo esc_html(get_option('apex_webinars_conf_attendees_insights-webinars', '500+ Industry Leaders')); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="apex-webinars-conference__highlights">
                <h4>Conference Highlights:</h4>
                <ul>
                    <?php
                    $highlights = get_option('apex_webinars_conf_highlights_insights-webinars', 
                        "50+ Sessions across 5 tracks\nKeynotes from industry visionaries\nHands-on product workshops\nNetworking events and awards dinner\nExhibition hall with 30+ vendors"
                    );
                    foreach (explode("\n", $highlights) as $highlight) {
                        if (trim($highlight)) {
                            echo '<li>' . esc_html(trim($highlight)) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            
            <div class="apex-webinars-conference__ctas">
                <a href="<?php echo esc_url(get_option('apex_webinars_conf_register_link_insights-webinars', '#')); ?>" class="apex-webinars-conference__cta-primary">Register Early - Save 30%</a>
                <a href="<?php echo esc_url(get_option('apex_webinars_conf_agenda_link_insights-webinars', '#')); ?>" class="apex-webinars-conference__cta-secondary">View Agenda</a>
            </div>
        </div>
        <div class="apex-webinars-conference__image">
            <img src="<?php echo esc_url(get_option('apex_webinars_conf_image_insights-webinars', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600')); ?>" alt="<?php echo esc_attr(get_option('apex_webinars_conf_heading_insights-webinars', 'Conference')); ?>" loading="lazy">
        </div>
    </div>
</section>

<section class="apex-webinars-ondemand">
    <div class="apex-webinars-ondemand__container">
        <div class="apex-webinars-ondemand__header">
            <span class="apex-webinars-ondemand__badge"><?php echo esc_html(get_option('apex_webinars_ondemand_badge_insights-webinars', 'On-Demand Library')); ?></span>
            <h2 class="apex-webinars-ondemand__heading"><?php echo esc_html(get_option('apex_webinars_ondemand_heading_insights-webinars', 'Watch Anytime')); ?></h2>
            <p class="apex-webinars-ondemand__description"><?php echo esc_html(get_option('apex_webinars_ondemand_description_insights-webinars', 'Missed a webinar? Catch up with our library of recorded sessions covering a wide range of topics.')); ?></p>
        </div>
        
        <div class="apex-webinars-ondemand__filters">
            <button class="apex-webinars-ondemand__filter active" data-filter="all">All Topics</button>
            <button class="apex-webinars-ondemand__filter" data-filter="core-banking">Core Banking</button>
            <button class="apex-webinars-ondemand__filter" data-filter="mobile">Mobile Banking</button>
            <button class="apex-webinars-ondemand__filter" data-filter="security">Security</button>
            <button class="apex-webinars-ondemand__filter" data-filter="compliance">Compliance</button>
        </div>
        
        <div class="apex-webinars-ondemand__grid">
            <article class="apex-webinars-ondemand__item" data-category="core-banking">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=400" alt="Core Banking Modernization" loading="lazy">
                    <span class="apex-webinars-ondemand__item-duration">58:32</span>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category">Core Banking</span>
                    <h3>Core Banking Modernization: A Practical Roadmap</h3>
                    <p>Step-by-step guide to planning and executing a successful core banking transformation.</p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span>1,245 views</span>
                        <span>Dec 2025</span>
                    </div>
                </div>
            </article>
            
            <article class="apex-webinars-ondemand__item" data-category="mobile">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400" alt="Mobile Banking UX" loading="lazy">
                    <span class="apex-webinars-ondemand__item-duration">45:18</span>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category">Mobile Banking</span>
                    <h3>Designing Mobile Banking Apps That Users Love</h3>
                    <p>UX best practices and design principles for creating engaging mobile banking experiences.</p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span>982 views</span>
                        <span>Nov 2025</span>
                    </div>
                </div>
            </article>
            
            <article class="apex-webinars-ondemand__item" data-category="security">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400" alt="Fraud Prevention" loading="lazy">
                    <span class="apex-webinars-ondemand__item-duration">52:45</span>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category">Security</span>
                    <h3>AI-Powered Fraud Detection: Real-World Implementation</h3>
                    <p>How to implement machine learning models for real-time fraud detection and prevention.</p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span>1,567 views</span>
                        <span>Oct 2025</span>
                    </div>
                </div>
            </article>
            
            <article class="apex-webinars-ondemand__item" data-category="compliance">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400" alt="Regulatory Compliance" loading="lazy">
                    <span class="apex-webinars-ondemand__item-duration">61:20</span>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category">Compliance</span>
                    <h3>Navigating Regulatory Compliance Across African Markets</h3>
                    <p>Understanding and meeting regulatory requirements when operating in multiple African countries.</p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span>876 views</span>
                        <span>Sep 2025</span>
                    </div>
                </div>
            </article>
            
            <article class="apex-webinars-ondemand__item" data-category="core-banking">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400" alt="Data Migration" loading="lazy">
                    <span class="apex-webinars-ondemand__item-duration">48:55</span>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category">Core Banking</span>
                    <h3>Zero-Downtime Data Migration Strategies</h3>
                    <p>Best practices for migrating customer data without service interruption.</p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span>1,102 views</span>
                        <span>Aug 2025</span>
                    </div>
                </div>
            </article>
            
            <article class="apex-webinars-ondemand__item" data-category="mobile">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400" alt="Agent Banking" loading="lazy">
                    <span class="apex-webinars-ondemand__item-duration">55:10</span>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category">Mobile Banking</span>
                    <h3>Building Successful Agent Banking Networks</h3>
                    <p>Strategies for recruiting, training, and managing agent networks for last-mile delivery.</p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span>789 views</span>
                        <span>Jul 2025</span>
                    </div>
                </div>
            </article>
        </div>
        
        <div class="apex-webinars-ondemand__load-more">
            <button class="apex-webinars-ondemand__load-btn">View All Recordings</button>
        </div>
    </div>
</section>

<section class="apex-webinars-speakers">
    <div class="apex-webinars-speakers__container">
        <div class="apex-webinars-speakers__header">
            <span class="apex-webinars-speakers__badge"><?php echo esc_html(get_option('apex_webinars_speakers_badge_insights-webinars', 'Expert Speakers')); ?></span>
            <h2 class="apex-webinars-speakers__heading"><?php echo esc_html(get_option('apex_webinars_speakers_heading_insights-webinars', 'Learn from the Best')); ?></h2>
            <p class="apex-webinars-speakers__description"><?php echo esc_html(get_option('apex_webinars_speakers_description_insights-webinars', 'Our webinars feature industry experts, thought leaders, and practitioners with deep experience in financial technology.')); ?></p>
        </div>
        
        <div class="apex-webinars-speakers__grid">
            <div class="apex-webinars-speakers__item">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200" alt="Sarah Ochieng">
                <h4>Sarah Ochieng</h4>
                <span>CTO, Apex Softwares</span>
                <p>15+ years in fintech architecture and cloud solutions</p>
            </div>
            <div class="apex-webinars-speakers__item">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200" alt="John Kamau">
                <h4>John Kamau</h4>
                <span>CEO, Apex Softwares</span>
                <p>20+ years leading digital transformation in banking</p>
            </div>
            <div class="apex-webinars-speakers__item">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200" alt="Michael Njoroge">
                <h4>Michael Njoroge</h4>
                <span>COO, Apex Softwares</span>
                <p>Expert in operational excellence and implementation</p>
            </div>
            <div class="apex-webinars-speakers__item">
                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200" alt="Grace Wanjiku">
                <h4>Grace Wanjiku</h4>
                <span>CFO, Apex Softwares</span>
                <p>Financial strategy and sustainable growth expert</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-webinars-newsletter">
    <div class="apex-webinars-newsletter__container">
        <div class="apex-webinars-newsletter__content">
            <h2 class="apex-webinars-newsletter__heading"><?php echo esc_html(get_option('apex_webinars_newsletter_heading_insights-webinars', 'Never Miss an Event')); ?></h2>
            <p class="apex-webinars-newsletter__description"><?php echo esc_html(get_option('apex_webinars_newsletter_description_insights-webinars', 'Subscribe to get notified about upcoming webinars, workshops, and events.')); ?></p>
            
            <form class="apex-webinars-newsletter__form">
                <input type="email" placeholder="<?php echo esc_attr(get_option('apex_webinars_newsletter_placeholder_insights-webinars', 'Enter your email address')); ?>" required>
                <button type="submit"><?php echo esc_html(get_option('apex_webinars_newsletter_button_insights-webinars', 'Subscribe')); ?></button>
            </form>
            
            <p class="apex-webinars-newsletter__note"><?php echo esc_html(get_option('apex_webinars_newsletter_note_insights-webinars', 'We respect your privacy. Unsubscribe at any time.')); ?></p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
