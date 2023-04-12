<?php
get_header();
?>

<?php
while (have_posts()) {
    the_post();
    pageBanner();
    ?>
    <div class="container container--narrow page-section">
        

        <div class="generic-content">
            <div class="row group">
                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>
                <div class="two-thirds">
                    <?php 
                        $likeCount = new WP_Query(array(
                            'post_type' => 'like',
                            'meta_query' => array(
                                                array(
                                                    'key' => 'liked_professor_id',
                                                    'compare' => '=',
                                                    'value' => get_the_ID()
                                                )
                            )
                            ));
                            wp_reset_postdata(); 

                            $existStatus = 'no';
                            $likeData = 0;

                            if(is_user_logged_in()) {
                                $existQuery = new WP_Query(array(
                                'author' => get_current_user_id(),
                                'post_type' => 'like',
                                'meta_query' => array(
                                                    array(
                                                        'key' => 'liked_professor_id',
                                                        'compare' => '=',
                                                        'value' => get_the_ID()
                                                    )
                            )
                            ));
                            
                            if ($existQuery->found_posts) {
                                $existStatus = 'yes';
                                $likeData = $existQuery->posts[0]->ID;
                                // print_r($likeData); // Debug code
                            }
                            }
                            wp_reset_postdata(); 
                    ?>
                    <span class="like-box" data-like="<?php $likeData ?>" data-professor="<?php the_ID(); ?>" data-exists="<?php echo $existStatus; ?>">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $likeCount->found_posts; ?></span>
                    </span>
                    <?php the_content(); ?>
                </div>
            </div>
        </div>
        <?php

            $relatedPrograms = get_field('related_programs');
            // print_r($relatedPrograms); // - Use this command to test variables
            if ($relatedPrograms) {
                    echo '<hr class="section-break">';
                    echo '<h3 class="headline headline--small"><b>'.get_the_title().'</b> teaches the following subject(s): </h2>';
                    echo '<ul class="link-list min-list">';
                    foreach($relatedPrograms as $program) { ?>
                        <li><a href="<?php echo get_the_permalink($program); ?>"> <?php echo get_the_title($program); ?></a></li>
                <?php }
                echo '</ul>';
            } ?>
    </div>

    <?php
}
get_footer();
?>