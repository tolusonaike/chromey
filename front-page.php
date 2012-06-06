<?php
/*
Template Name: Featured page (front-page.php)
.
Take a look at the functions.php for this theme to see how the random content is included.
.
*/
?>
<?php get_header() ?>

	<div id="container" class="feature">
		<div id="content">		
		  <div id="sub-feature">

            <div id="front-block-1" class="front-block block">
		<img class="feat-img" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/onebit/onebit_20.png" alt="about us"/>
              <h3>About chromey</h3>
             
              <p>Chromey is a Thematic child theme for wordpress.</p>
              <p>It combines a lot of the commonly used design elements such as: GRADIENT, texture noise, metallic grays, plump icons, insets, and colorful high contrast images. 
              </p>
              <p>Maecenas fringilla mi nec diam. Donec iaculis lacus sed dolor. Ut varius quam varius nunc. Nunc ut metus. </p>
              <p><a href="<?php echo get_option('home') ?>/about/" rel="nofollow">Read more at my about page</a></p>
            </div><!-- #front-block-1 .front-block .block-->
	    

            <div id="front-block-2" class="front-block block">
		<img class="feat-img" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/onebit/onebit_10.png" alt="about us"/>
              <h3>Recent blog items</a></h3>
               
              <ul id="recent-items">
              <?php
                  $recentPosts = new WP_Query();
                  $recentPosts->query('showposts=5');
              ?>
              <?php while ($recentPosts->have_posts()) : $recentPosts->the_post(); ?>
                  <li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></li>
              <?php endwhile; ?>
                    <li class="more-items"><a href="<?php echo get_option('home') ?>/blog/page/2/">More recent items <span>»</span></a></li>
              </ul>
            </div><!-- #front-block-2 .front-block .block-->
            
            	<div id="front-block-3" class="front-block block">
		<img class="feat-img" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/onebit/onebit_24.png" alt="Latest blog entry"/> 
              <h3>Contact us</h3>
              
              <ul >
		<li><img  class="socialize" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/mono-icons/phone32.png" alt="twitter"/> 1-800-999-9999</li>
		<li><img  class="socialize" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/mono-icons/mail32.png" alt="twitter"/> customerservice@chromy.com</li>
		<li><img  class="socialize" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/mono-icons/home32.png" alt="twitter"/> 1234 lemington str</li>
		<li><a href=""><img  class="socialize" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/dryicons/twitter.png" alt="twitter"/> twitter</a></li>
		<li><a href=""><img  class="socialize" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/dryicons/facebook.png" alt="facebook"/> facebook</a></li>
		<li><a href=""><img  class="socialize" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/dryicons/flickr.png" alt="flickr"/> flickr</a></li>
		<li><a href=""><img  class="socialize" src="<?php echo dirname( get_bloginfo('stylesheet_url') ) ?>/includes/iconset/dryicons/youtube.png" alt="youtube"/> youtube</a></li>
	            
	      </ul>
            </div><!-- #front-block-1 .front-block .block-->
            
          
          </div><!-- #sub-feature -->         
		</div><!-- #content -->
	</div><!-- #container .feature -->

<?php get_footer() ?>
