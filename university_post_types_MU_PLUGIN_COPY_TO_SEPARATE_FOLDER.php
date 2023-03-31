<?php

function university_post_types()
{

    // Event Post Type
    register_post_type(
        'event',
        array(
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'rewrite' => array('slug' => 'events'),
            'has_archive' => true,
            'public' => true,
            'labels' => array(
                'name' => 'Events',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events',
                'singular name' => 'Event'
            ),
            'menu_icon' => 'dashicons-location-alt'
        )
    );

    // Program Post Type

    register_post_type(
        'program',
        array(
            'show_in_rest' => true,
            'supports' => array('title', 'editor'),
            'rewrite' => array('slug' => 'programs'),
            'has_archive' => true,
            'public' => true,
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs',
                'singular name' => 'Program'
            ),
            'menu_icon' => 'dashicons-awards'
        )
    );

    // Professor Post Type

    register_post_type(
        'professor',
        array(
            'show_in_rest' => false, //block editor turned off for now
            'supports' => array('title', 'editor'),
            // 'rewrite' => array('slug' => 'professors'), //Porfessors are not going to have an arhive
            // 'has_archive' => true, //Porfessors are not going to have an arhive
            'public' => true,
            'labels' => array(
                'name' => 'Professors',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professors',
                'singular name' => 'Professor'
            ),
            'menu_icon' => 'dashicons-welcome-learn-more'
        )
    );
}

add_action('init', 'university_post_types');
?>