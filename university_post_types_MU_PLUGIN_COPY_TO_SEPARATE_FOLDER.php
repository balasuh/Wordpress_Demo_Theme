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
            'menu_icon' => 'dashicons-calendar'
        )
    );

    // Program Post Type

    register_post_type(
        'program',
        array(
            'show_in_rest' => true,
            'supports' => array('title'),
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
            'show_in_rest' => true,
            //rest API Route turned on
            //block editor turned off for now
            'supports' => array('title', 'editor', 'thumbnail'),
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

    // Campus Post Type

    register_post_type(
        'campus',
        array(
            'show_in_rest' => true,
            'supports' => array('title', 'editor', 'excerpt'),
            'rewrite' => array('slug' => 'campuses'),
            'has_archive' => true,
            'public' => true,
            'labels' => array(
                'name' => 'Campuses',
                'add_new_item' => 'Add New Campus',
                'edit_item' => 'Edit Campus',
                'all_items' => 'All Campuses',
                'singular name' => 'Campus'
            ),
            'menu_icon' => 'dashicons-location-alt'
        )
    );


}

add_action('init', 'university_post_types');
?>