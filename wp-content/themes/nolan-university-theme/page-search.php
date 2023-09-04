<?php

    get_header();

    while(have_posts()) {
        the_post(); 
        pageBanner();
        ?>
        


        <div class="container container--narrow page-section">
            <?php
                $the_parent = wp_get_post_parent_id(get_the_ID());
                if($the_parent) { ?>
                    <div class="metabox metabox--position-up metabox--with-home-link">
                        <p>
                        <a class="metabox__blog-home-link" href="<?php echo get_permalink($the_parent) ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($the_parent) ?></a> <span class="metabox__main"><?php the_title() ?></span>
                        </p>
                    </div>   
            <?php } ?>
            

            <?php 
            $testArray = get_pages(array(
                'child_of' => get_the_ID(),
            ));

            if ($the_parent || $testArray) { ?>
            <div class="page-links">
                <h2 class="page-links__title"><a href="<?php echo get_permalink($the_parent); ?>"><?php echo get_the_title($the_parent); ?></a></h2>
                <ul class="min-list">
                    <?php
                        $findChildrenOf = $the_parent ? $the_parent : get_the_ID();

                        wp_list_pages(array(
                            'title_li' => NULL,
                            'child_of' => $findChildrenOf,
                            'sort_column' => 'menu_order'
                        ));
                    ?>
                </ul>
            </div>
            <?php } ?>

            <div class="generic-content">
               <?php get_search_form(); ?>
            </div>
        </div>
    <?php }

    get_footer();

?>