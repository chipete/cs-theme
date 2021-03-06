<?php
/**
 * @package WordPress
 * @subpackage cinemasalem
 */

/*
Template Name: Film Detail Template
*/

$equalize	= true;

get_header();

while ( have_posts() ) : the_post();

?>

<div class="container" id="equalize">

    <?php get_sidebar('film'); ?>

    <div class="content_narrow clearfix" id="content">

        <?php if ( ! get_field( 'wpmt_film_hide' ) ) : ?>

        <div class="fd_film">
		
            <div class="fd_trailer">
                <?php if ( get_field( 'wpmt_film_youtube_url' ) ) : ?>
                    <iframe width="640" height="360" src="<?php echo wpmt_get_youtube_embed( get_field( 'wpmt_film_youtube_url' ) ) . '?rel=0&amp;showinfo=0'; ?>" frameborder="0" allowfullscreen></iframe>

                <?php elseif ( get_field( 'wpmt_film_image' ) ) : ?>
                    <?php echo wp_get_attachment_image( get_field( 'wpmt_film_image' ),
                        $size = 'wpmt_image',
                        $icon = false,
                        $attr = array ( 'alt' => get_the_title( $post ), 'title' => get_the_title( $post ) )
                    ); ?>

                <?php else : ?>
                    <?php //echo '<img src="http://placehold.it/640x360?text=Film+Image" id="poster">'; ?>

                <?php endif ?>
	        </div> <!-- end #fd_trailer -->


            <div class="fs_poster">
                <?php

                if ( get_field( 'wpmt_film_poster' ) ) {
                    echo wp_get_attachment_image(get_field('wpmt_film_poster'),
                        $size = 'wpmt_poster',
                        $icon = false,
                        $attr = array('alt' => get_the_title($post), 'title' => get_the_title($post), 'id' => 'poster')
                    );
                }
                else {
                    echo '<img src="http://placehold.it/134x193?text=Film+Poster" id="poster">';
                }

                ?>
            </div> <!-- end #fs_poster -->


            <div class="fd_description">

                <div class="fd_title">
                    <h1><?php the_title(); ?></h1>
                </div>

                <div class="fs_rating">
                    <?php if ( get_field('wpmt_film_genre') ) 		{ the_field('wpmt_film_genre'); } 	                    ?>
                    <?php if ( get_field('wpmt_film_genre')
                        && get_field('wpmt_film_rating') ) 	        { echo " / "; }											?>
                    <?php if ( get_field('wpmt_film_rating') ) 		{ the_field('wpmt_film_rating'); }						?>
                    <?php if ( get_field('wpmt_film_rating')
                        && get_field('wpmt_film_duration') ) 	{ echo " / "; }											    ?>
                    <?php if ( get_field('wpmt_film_duration') ) 	{ the_field('wpmt_film_duration'); echo " mins"; } 		?>
                </div>


                <div class="fd_director">
                    <?php if ( get_field('wpmt_film_directors') )   { echo "Director: " . get_field('wpmt_film_directors') . '<br />'; } ?>
                    <?php if ( get_field('wpmt_film_free') )        { echo '<img src="' . imageurl() . '/btn_free.png" alt="FREE" height="18" style="margin-top:5px" />'; } ?>
                </div>

                <?php //if ( get_field('wpmt_screen_id') == '4' || get_field('wpmt_film_format') == '3D Digital' ) : ?>
                <div class="fs_sr_3d">
                    <?php //if ( get_field('wpmt_screen_id') == '4' ) 			{ echo "Presented in our intimate 18-seat screening room"; } 	?>
                    <?php if ( get_field('wpmt_film_format') == '3D Digital' ) 	{ echo "Presented in Fabulous 3D!"; } 							?>
                </div>
                <?php //endif ?>

                <?php the_field( 'wpmt_film_synopsis' ); ?>

                <?php if ( get_field( 'wpmt_film_rt_rating' ) ) : ?>
                    <div class="fds_rt">
                        <div class="rt_<?php if ( get_field( 'wpmt_film_rt_rating' ) >= 60 ) { echo "fresh"; } else { echo "rotten"; } ?>"> &nbsp; </div>
				  	    <div class="rt_text"><?php if ($tomatometer >= 60) echo '"Certified Fresh" on RottenTomatoes.com'; ?><?php if ($showrt == "1" || $showrt == "2") echo " (" . $tomatometer . "%)"; ?></div>
                        <?php if ( get_field( 'wpmt_film_rt_consensus' ) ) : ?><div class="fclear"><p><?php the_field( 'wpmt_film_rt_consensus' ); ?></p></div><?php endif ?>
                    </div>
				<?php endif ?>

                <?php if ( get_field( 'wpmt_film_reviews' ) ): ?>
                    <div class="fclear"><p><strong>Reviews: </strong></p><?php the_field( 'wpmt_film_reviews' ); ?></div>
                <?php endif ?>

                <div><br />Buy Tickets</div>

                <div class="fs_showtimes">
                    <?php

                    global $post;
                    $backup = clone $post;

                    if ( wpmt_sessions_exist ( get_field( 'wpmt_film_id' ) ) ) {
                        wpmt_display_sessions ( get_field( 'wpmt_film_id' ), 7 );
                        $post = clone $backup;
                        echo '<br /><br /><a href="' . wpmt_get_ticket_server_url() . '">[SEE ALL DATES AND TIMES]</a>';
                    }

                    else {
                        echo "No tickets available at this time";
                        $post = clone $backup;
                    }

                    ?>
                </div>

            </div> <!-- end #fd_description -->


        </div> <!-- end #fd_film -->


        <?php else: ?>

          <div class="post">
            <h2>Team Member Not Found</h2>
            <div class="entry">
              <p>Sorry, that Team member could not be found!</p>
            </div>
          </div>

        <?php endif ?>

    </div> <!-- close content -->

</div><!--close equalize -->

<?php endwhile ?>
<?php get_footer(); ?>