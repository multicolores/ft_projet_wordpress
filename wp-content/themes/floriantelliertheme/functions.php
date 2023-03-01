<?php

add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function my_theme_enqueue_styles()
{
    wp_enqueue_style('style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'insset_scripts', -1);

function insset_scripts()
{
    wp_enqueue_script('jquery-ft', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), '3.6.3', true);
    wp_enqueue_script('ft-projet-handlebars-main', 'https://cdn.jsdelivr.net/npm/handlebars@latest/dist/handlebars.js', array(), '1.0.0', true);
}
