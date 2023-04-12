<?php

add_action('rest_api_init', 'universityLikeRoutes');

function universityLikeRoutes() {
    register_rest_route('university/v1', 'manageLike', array( // Post/Create Route
        'methods' => 'POST',
        'callback' => 'createLike',
        'permission_callback' => '__return_true'
    ));

    register_rest_route('university/v1', 'manageLike', array( // Delete Route
        'methods' => 'DELETE',
        'callback' => 'deleteLike',
        'permission_callback' => '__return_true'
    ));    
}

function createLike($data) {

    if (is_user_logged_in()) {
            $professor = sanitize_text_field($data['professorId']);
            $existQuery = new WP_Query(array(
                                'author' => get_current_user_id(),
                                'post_type' => 'like',
                                'meta_query' => array(
                                                    array(
                                                        'key' => 'liked_professor_id',
                                                        'compare' => '=',
                                                        'value' => $professor
                                                    )
                            )
                            ));
            if($existQuery->found_posts == 0 AND get_post_type($professor) == 'professor') {
                return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish', //Draft by default
                'post_title' => 'PHP generated Like Post Title',
                'meta_input' => array(
                    'liked_professor_id' => $professor
                )
                ));
            } else {
                die('Invalid Professor ID');
            }
    } else {
        die("Only logged in users can like.");
    }
}

function deleteLike($data) {
    $likeId = sanitize_text_field($data['like']);
    if(get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
        wp_delete_post($likeId, true);
        return 'Congrats, dislike executed.';
    } else {
        die('You do not have permission to do that.');
    }
}