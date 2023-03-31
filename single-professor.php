<?php
get_header();
?>

<?php
while (have_posts()) {
    the_post();
    ?>
    <div class="page-banner">
        <div class="page-banner__bg-image"
            style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>)">
        </div>
        <div class="page-banner__content container container--narrow">
            <h2 class="page-banner__title">
                <?php echo the_title(); ?>
                </h1>
                <div class="page-banner__intro">
                    <p>Don't forget to replace me later.</p>
                </div>
        </div>
    </div>
    <div class="container container--narrow page-section">
        


        <div class="generic-content">
            <?php
            the_content();
            ?>
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