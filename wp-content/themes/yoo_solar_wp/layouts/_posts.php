
<?php 

$warp = Warp::getInstance();

if (!$warp["config"]->get("fp_grid_status", 1)) {
	include($warp['path']->path('warp:systems/wordpress/layouts/_posts.php'));
	return;
}

echo '<div class="items grid-block">';

while (have_posts()) {
	the_post();

	echo '<div class="grid-box">'.$this->render('_post').'</div>';

}

echo '</div>';

?>

<script type="text/javascript">

	window.GRIDALICIOUS_IN_USE = true;
	
	jQuery(function($){
		$('.items.grid-block').gridalicious({ 
			selector: '.grid-box', 
			width: <?php echo $warp["config"]->get("fp_grid_colwidth", 300);?>,
			gutter: <?php echo $warp["config"]->get("fp_grid_gutter", 10);?>,			
			animate: (<?php echo $warp["config"]->get("fp_grid_animation", 0);?>) ? true:false,
			animationOptions: {
				speed: <?php echo $warp["config"]->get("fp_grid_speed", 200);?>,
				duration: <?php echo $warp["config"]->get("fp_grid_duration", 300);?>
			}
		});
	});
</script>