<?php
get_header();
?>

<?php
while (have_posts()) {
    the_post();
    pageBanner();
    ?>
<div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i
                    class="fa fa-home" aria-hidden="true">
                </i> All Campuses</a>
            <span class="metabox__main">
                <?php the_title() ?>
            </span>
        </p>
    </div>
    <div class="generic-content">
        <?php
            the_content();
            ?>
        <div class="acf-map">
            <?php
            $mapLocation = get_field('map_location');
            ?>
            <div class="marker" data-lat="<?php echo $mapLocation['lat'] ?>"
                data-lng="<?php echo $mapLocation['lng'] ?>">
                <h5>
                    <?php the_title(); ?>
                </h5>
                <p>
                    <?php echo $mapLocation['address']; ?>
                </p>
            </div>
        </div>
    </div>
    <?php
            $relatedPrograms = new WP_Query(
                array(
                    'post_type' => 'program',
                    'posts_per_page' => -1, // -1 lists all posts
                    'orderby' => 'title', // default is by post_date
                    // 'orderby' => 'rand', // random ordering
                    'order' => 'ASC', // default is DESC
                    'meta_query' => array(
                    array (
                        'key' => 'related_campus',
                        'compare' => 'LIKE',
                        'value' => '"'.get_the_ID().'"'
                    )
                    )
                )
                );
                if ($relatedPrograms->have_posts()) {
                    echo '<hr class="section-break">';
                    echo '<h2 class="headline headline--medium">Programs Available At This Campus:</h2>';
                    echo '<ul class="min-list link-list">';
                    while ($relatedPrograms->have_posts()) {
                        $relatedPrograms->the_post();
                    ?>
    <li class="">
        <a class="" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </li>
    <?php
                    }
                    echo '</ul>';
                }
                wp_reset_postdata();            
            ?>
</div>
<?php

}
get_footer();
?>