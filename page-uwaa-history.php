<?php get_header();


use \UWAA\View\ThumbnailBrowser\Thumbnail\UWAAHistory;  

 ?>


<div class="uw-hero-image about"></div>

<div class="container uw-body">

  <div class="row">

    <div class="col-md-8 uw-content" role='main'>

        <!-- <a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr( get_bloginfo() ) ?>"><h2 class="uw-site-title"><?php bloginfo(); ?></h2></a> -->
      <h2 class="uw-site-title">About the UWAA</h2>

       <?php include(locate_template( 'partials/sidebar-page-breadcrumbs.php')); ?>

      <div id='main_content' class="uw-body-copy">

        <?php
          // Start the Loop.
          while ( have_posts() ) : the_post();

            /*
             * Include the post format-specific template for the content. If you want to
             * use this in a child theme, then include a file called called content-___.php
             * (where ___ is the post format) and that will be used instead.
             */
            get_template_part( 'content', 'page' );

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) {
              comments_template();
            }

          endwhile;
        ?>

      

      

    </div>

    <div class="row">
       <?php
      

      $thumbnailRow = new \UWAA\View\ThumbnailBrowser\ThumbnailBrowser;

      $thumbnailRow->makeThumbnails(new UWAAHistory(basename(get_permalink() ) ) );



      ?>

    </div>

    </div>

    <div class="col-md-4 uw-sidebar">
    <?php 
        uw_sidebar_menu();
        dynamic_sidebar( 'about_sidebar' ); 
    ?>
    </div>

  </div>

</div>

<?php get_footer(); ?>
