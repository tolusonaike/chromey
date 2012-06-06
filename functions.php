<?php

//////////////////////////////////////  Add Post Thumbnail Support  //////////////////////////////////////////////

// Make backwards compatible prior to WordPres v2.9
if ( function_exists( 'add_theme_support' ) ) {
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 590, 350, true ); // Normal post thumbnails
add_image_size( 'featured-post-thumbnail', 960, 350 ); // Permalink thumbnail size
//add_image_size( 'post-thumbnail', 600, 350 ); // Permalink thumbnail size
}

//////////////////////////////////////  actions to remove /////////////////////////////////////////////////////////////////////////

function remove__actions() {

remove_action('thematic_header','thematic_blogtitle',3);
remove_action('thematic_header','thematic_blogdescription',5);
//remove_action('thematic_indexloop', 'thematic_index_loop');
}
add_action('init', 'remove__actions');

//////////////////////////////////////  theme logo /////////////////////////////////////////////////////////////////////////


function thematic_logo_image() {
        echo '<div id="logo-image"><a href="'.get_option('home').'"><img src="'.get_bloginfo('stylesheet_directory').'/logo.png" /></a></div>';
    }
add_action('thematic_header','thematic_logo_image',4);



////////////////////////////////// coda javascripts ////////////////////////////////////////
function chromey_css_browser_script($content) {
  
  $content .= "\t";
  $content .= '<script src="'. get_bloginfo('stylesheet_directory') .'/js/jquery.easing.1.3.js" type="text/javascript"></script>';
  $content .= '<script src="'. get_bloginfo('stylesheet_directory') .'/js/jquery.coda-slider-2.0.js" type="text/javascript"></script>';
  $content .= '<script src="'. get_bloginfo('stylesheet_directory') .'/js/custom.js" type="text/javascript"></script>';
  $content .= "\n\n";
  
  return $content;
}

////////////////////////////////////// coda CSS Style  ///////////////////////////////////////////

function chromey_inverted_stylesheet($content) {
  
  $content .= "\t";
  $content .= '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/css/coda-slider-2.0.css' . '" />';
  $content .= "\n\n";
  
  return $content;
}

add_filter('thematic_create_stylesheet', 'chromey_inverted_stylesheet');




add_filter('thematic_head_scripts', 'chromey_css_browser_script');

////////////////////////////////////////// Add a search form to the header  ////////////////////////////////////////
function chromey_searchform() {


    if (!is_page_template('front-page.php') ){
       get_search_form();
    }
}

 


add_action('thematic_header','chromey_searchform',7);
 

////////////////////////////////////////// Customize the search form  ////////////////////////////////////////
function chromey_search_form($form) {
    $form = '<form method="get" id="searchform" action="' . get_option('home') . '/" >
            <label class="hidden" for="s">' . __('Search:') . '</label>
            <div>';
    if (is_search()) {
        $form .='<input type="text" value="' . attribute_escape(apply_filters('the_search_query', get_search_query())) . '" name="s" id="s" />';
    } else {
        $form .='<input type="text" value="To search, type and hit enter" name="s" id="s"  onfocus="if(this.value==this.defaultValue)this.value=\'\';" onblur="if(this.value==\'\')this.value=this.defaultValue;"/>';
    }
    $form .= '<input type="submit" id="searchsubmit" value="'.attribute_escape(__('Search')).'" />
            </div>
            </form>';
    return $form;
}
add_filter('get_search_form', 'chromey_search_form');

////////////////////////////////////////// Filter to create the time url title displayed in Post Header
function chromey_time_title() {

  $time_title = 'H:i:s';
	
	return $time_title;
} 
add_filter('thematic_time_title', 'chromey_time_title');

// Add a custom page leader
// Basically adding the title to a fluid block just after the header
// including a random feature item on the home page
function chromey_pageleader() { ?>
    <?php global $id, $post, $authordata; ?>
    <div id="leader">
	
	    <?php if (is_single()) { ?>           
		<div class="entry-meta">
		    <div class="month"><?php the_time('M') ?></div>
		    <div class="day"><?php the_time('d') ?></div>
		</div><!-- .entry-meta -->
	    <?php } ?>

        <div id="leader-container">
	    
<?php if (is_page() && !is_front_page()) { ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
	    
<?php } elseif (is_404()) { ?>
            <h1 class="entry-title">Not Found</h1>
<?php } elseif (is_page_template('front-page.php') ) { ?>
     <div class="coda-slider" id="coda-feat-slider">
<?php
    /*
    Feature content slider can be static and/or dynamic.
    
    For static content, set variable "$panels" and create a page using the naming convention "feature-front-x.php"
    
    */
    
    $panels = 3;
    for ($i = 1; $i <= $panels; $i++) {
    include "includes/feature-front-$i.php"; 
    }
    
      /*
    For dynamic content add posts to "featured" category
    */
    
    $show =3;
    $featured_posts = new WP_Query();
    $featured_posts->query(array(
    'showposts' => $show,
    'category_name' => 'featured'
    ));
    
    if (!empty($featured_posts)) {
			
	while ($featured_posts->have_posts()) : $featured_posts->the_post();  ?>

	    <div class="panel">
		<div id="feature-info" >
		
	    <div class="excerpt">
		<a href="<?php the_permalink() ?>">
<?php
		$excerpt = the_excerpt();
		if (empty($excerpt))
		{
			$excerpt = explode(" ",strrev(substr(strip_tags(the_content), 0, 105)),2);
			$excerpt = strrev($excerpt[1]);
			$excerpt.= "...";
		}
		else {
		       if(strlen($excerpt) > 105){
			   $excerpt = explode(" ",strrev(substr(strip_tags($excerpt), 0, 105)),2);
			   $excerpt = strrev($excerpt[1]);
			   $excerpt.= "...";
		       }
		   
		}
			
			echo $excerpt;
?>		</a>
	    </div>
	        <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('featured-post-thumbnail') ?></a>
		</div><!-- #dynamic-feature-info -->
	      
	    </div><!-- #dynamic-feature -->
 					 
<?php
	endwhile;
}?>
    </div><!-- #coda-slider -->
    <div id="coda-nav-1" class="coda-nav">
       	<ul>
<?php
	    for ($i = 1; $i <= $panels; $i++) 
		echo '<li class="tab'.$i.'"><a href="#'.$i.'"> &nbsp;</a></li>';
	    
	    rewind_posts(); 
	    while ($featured_posts->have_posts()) : $featured_posts->the_post();
		$i = 100;
		echo '<li class="tab'.$i.'"><a href="#'.$i.'"></a></li>';
		$i++;
	    endwhile;
?>
        </ul>
       </div><!-- #coda-nav -->

<?php
} elseif (is_home()) { ?>
            <h1 class="entry-title"><?php bloginfo('description') ?></h1>
<?php } elseif (is_category()) { ?>
            <h1 class="page-title">Category Archives: <span><?php single_cat_title() ?></span></h1>  
<?php } elseif (is_month()) { ?>
	
            <h1 class="page-title">Monthly Archives:  <span><?php  get_the_time('F Y') ?></span></h1> 
           
<?php } elseif (is_search()) {?>
            <h2 class="entry-title"><?php _e('Search Results for:', 'thematic') ?> <span id="search-terms"><?php echo wp_specialchars(stripslashes($_GET['s']), true); ?></span></h2>            
<?php } elseif (is_single()) { ?>
	    <h1 class="entry-title"><?php the_title(); ?></h1>
<?php } ?>
	    
        </div><!-- #leader-container -->
    </div><!-- #leader -->
<?php }
add_action ('thematic_belowheader','chromey_pageleader',2);


// Add a custom post header
// A lot of this involves removing the title from where I no longer need it
function chromey_postheader() {
    global $post; 

    if (is_page() || is_404() || is_single()) {
        echo '<div class="entry-thumbnail">'.get_the_post_thumbnail() .'</div>';           
    } else { ?>
		<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'thematic'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
		<?php if ($post->post_type == 'post') { ?>
		<div class="entry-meta">
          	<span class="author vcard"><?php _e('By ', 'thematic') ?><a class="url fn n" href="<?php get_author_link(true, $authordata->ID, $authordata->user_nicename); ?>" title="<?php __('View all posts by ', 'thematic') . the_author(); ?>"><?php the_author() ?></a></span>
			<span class="meta-sep"> | </span>
			<span class="entry-date"><abbr class="published" title="<?php get_the_time('Y-m-d\TH:i:sO'); ?>"><?php the_time('F jS, Y') ?></abbr></span>
		</div><!-- .entry-meta -->
		<?php echo '<div class="entry-thumbnail">'.get_the_post_thumbnail() .'</div>'; } ?>
    <?php }
}
add_filter ('thematic_postheader', 'chromey_postheader');


// Add a custom post header
// A lot of this involves removing the title from where I no longer need it
function chromey_thematic_page_title() {
 if (is_category() || is_month()) {
    $content ='';
    }
    return $content;
}


add_filter ('thematic_page_title', 'chromey_thematic_page_title');
 
/////////////////////////////////////////// custom footer  /////////////////////////////////////
function my_footer($thm_footertext) {
$thm_footertext = ' ';
$thm_footertext .= '      

     <a rel="chromey" title="chromey by tolu sonaike" href="http://www.tolusonaike.com/chromey" class="wp-link">chromey</a> by
     <a rel="Tolu Sonaike"  title="Tolu Sonaike" href="http://www.tolusonaike.com" class="wp-link">Tolu Sonaike</a>.
     Built on the <a rel="designer" title="Thematic Theme Framework" href="http://themeshaper.com/thematic/" class="theme-link">Thematic Theme Framework</a>.     
     Powered by <a rel="generator" title="WordPress" href="http://WordPress.org/" class="wp-link">WordPress</a>.';

return $thm_footertext;
}
add_filter('thematic_footertext', 'my_footer');

?>
