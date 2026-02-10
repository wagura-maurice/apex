<?php 
/**
 * Template Name: About Us Overview
 * About Us Overview Page Template
 * Uses modular component system for clean separation of concerns
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// About Hero Section Component - Fetches data from ACF fields
$hero_data = apex_get_about_hero_data();
apex_render_about_hero($hero_data);
?>

<?php 
// Company Story Component - Fetches data from ACF fields
$company_story_data = apex_get_company_story_data();
apex_render_company_story($company_story_data);
?>

<?php 
// Mission & Vision Component - Fetches data from ACF fields
$mission_vision_data = apex_get_mission_vision_data();
apex_render_mission_vision($mission_vision_data);
?>

<?php 
// Leadership Team Component - Fetches data from ACF fields
$leadership_data = apex_get_leadership_team_data();
apex_render_leadership_team($leadership_data);
?>

<?php 
// Global Presence Component - Fetches data from ACF fields
$global_presence_data = apex_get_global_presence_data();
apex_render_global_presence($global_presence_data);
?>

<?php get_footer(); ?>
