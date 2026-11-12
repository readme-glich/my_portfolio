<?php if( ! defined( 'ABSPATH' ) ) exit;

/*******************************
* Enqueue scripts and styles.
********************************/
 
function music_star_anima_scripts() {
	if( !get_theme_mod( 'music_star_header_animation' ) ) {
		wp_enqueue_style( 'music_star-anima-css', get_template_directory_uri() . '/include/letters/anime.css');
		wp_enqueue_script( 'music_star-anima-js', get_template_directory_uri() . '/include/letters/anime.min.js', array( 'jquery' ), true);
	}
		
}

add_action( 'wp_enqueue_scripts', 'music_star_anima_scripts' );



function music_star_letter_anime () { 
	if( !get_theme_mod( 'music_star_header_animation' ) ) {
	?>
	<script>
		jQuery('.ml2').each(function(){
		  jQuery(this).html(jQuery(this).text().replace(/\S/g, "<span class='letter'>$&</span>"));
		});
		anime.timeline({loop: false})
		.add({
			targets: '.ml2 .letter',
			scale: [4,1],
			opacity: [0,1],
			translateZ: 0,
			easing: "easeOutExpo",
			duration: 550,
			delay: function(el, i) {
			  return <?php if(get_theme_mod('header_letter_speed')): echo esc_html(get_theme_mod('header_letter_speed')); else: echo "70"; endif; ?>*i;
		}
		})
	</script>
	<?php }
}

add_action('wp_footer','music_star_letter_anime');