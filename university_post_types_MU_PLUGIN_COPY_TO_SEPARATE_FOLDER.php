<?php

function university_post_types()
{
    register_post_type(
        'event',
        array(
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
}

add_action('init', 'university_post_types');
?>