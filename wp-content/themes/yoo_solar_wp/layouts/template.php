<?php
/**
* @package   yoo_solar
* @author    YOOtheme http://www.yootheme.com
* @copyright Copyright (C) YOOtheme GmbH
* @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
*/

// get template configuration
include($this['path']->path('layouts:template.config.php'));
	
?>
<!DOCTYPE HTML><!--WEBMONITOR ROOFINGBRAND-->
<html lang="<?php echo $this['config']->get('language'); ?>" dir="<?php echo $this['config']->get('direction'); ?>">

<head>

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script type="text/javascript" src="wp-scripts/jquery.sticky.js"></script>
  <script>
    $(window).load(function(){
      $("#rb-sticky").sticky({ topSpacing: 0 });
    });
  </script>
  <script>
var $root = $('html, body');
$('a').click(function() {
    $root.animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 500);
    return false;
});
  </script>
<?php echo $this['template']->render('head'); ?>
<link href='http://fonts.googleapis.com/css?family=Rye' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="wp-scripts/smoothscroll.js"></script>
</head>

<body id="dorsey-top" class="page <?php echo $this['config']->get('body_classes'); ?>" data-config='<?php echo $this['config']->get('body_config','{}'); ?>'>

	<?php if ($this['modules']->count('absolute')) : ?>
	<div id="absolute">
		<?php echo $this['modules']->render('absolute'); ?>
	</div>
	<?php endif; ?>

	<div id="block-header">

		<?php if ($this['modules']->count('toolbar-l + toolbar-r') || $this['config']->get('date')) : ?>
		<div id="block-toolbar">
			<div class="wrapper <?php if($this['config']->get('block-toolbar')) echo 'max-width'.$this['config']->get('block-toolbar'); ?>">

				<div id="toolbar" class="clearfix">	
					<?php if ($this['modules']->count('toolbar-l') || $this['config']->get('date')) : ?>
					<div class="float-left">
					
						<?php if ($this['config']->get('date')) : ?>
						<time datetime="<?php echo $this['config']->get('datetime'); ?>"><?php echo $this['config']->get('actual_date'); ?></time>
						<?php endif; ?>
					
						<?php echo $this['modules']->render('toolbar-l'); ?>
						
					</div>
					<?php endif; ?>
						
					<?php if ($this['modules']->count('toolbar-r')) : ?>
					<div class="float-right"><?php echo $this['modules']->render('toolbar-r'); ?></div>
					<?php endif; ?>
				</div>
				
			</div>
		</div>
		<?php endif; ?>

		<?php if ($this['modules']->count('logo + menu + search')) : ?>
		<div id="block-headerbar">
			<div class="wrapper <?php if($this['config']->get('block-headerbar')) echo 'max-width'.$this['config']->get('block-headerbar'); ?>">

				<header id="header" class="clearfix">

					<?php if ($this['modules']->count('logo')) : ?>	
					<a id="logo" href="<?php echo $this['config']->get('site_url'); ?>"><?php echo $this['modules']->render('logo'); ?></a>
					<?php endif; ?>

					<?php if ($this['modules']->count('menu + search')) : ?>
					<div id="menubar">
						
						<?php if ($this['modules']->count('menu')) : ?>
						<?php uberMenu_easyIntegrate(); ?>
						<?php endif; ?>

						<?php if ($this['modules']->count('search')) : ?>
						<div id="search"><?php echo $this['modules']->render('search'); ?></div>
						<?php endif; ?>
						
					</div>
					<?php endif; ?>	

				</header>

			</div>
		</div>
		<?php endif; ?>

	</div>

	<?php if ($this['modules']->count('top-a')) : ?>
	<div id="block-top-a">
		<div class="wrapper <?php if($this['config']->get('block-top-a')) echo 'max-width'.$this['config']->get('block-top-a'); ?>">

			<section id="top-a" class="grid-block"><?php echo $this['modules']->render('top-a', array('layout'=>$this['config']->get('top-a'))); ?></section>
	
		</div>
	</div>
	<?php endif; ?>

	<?php if ($this['modules']->count('top-b + innertop + innerbottom + sidebar-a + sidebar-b') || $this['config']->get('system_output')) : ?>
	<div id="block-main">
		<div class="wrapper <?php if($this['config']->get('block-main')) echo 'max-width'.$this['config']->get('block-main'); ?>">
			
			<?php if ($this['modules']->count('breadcrumbs')) : ?>
			<section id="breadcrumbs"><?php echo $this['modules']->render('breadcrumbs'); ?></section>
			<?php endif; ?>

			<?php if ($this['modules']->count('top-b')) : ?>
			<section id="top-b" class="grid-block"><?php echo $this['modules']->render('top-b', array('layout'=>$this['config']->get('top-b'))); ?></section>
			<?php endif; ?>
			
			<?php if ($this['modules']->count('innertop + innerbottom + sidebar-a + sidebar-b') || $this['config']->get('system_output')) : ?>
			<div id="main" class="grid-block">

				<div id="maininner" class="grid-box">

					<?php if ($this['modules']->count('innertop')) : ?>
					<section id="innertop" class="grid-block"><?php echo $this['modules']->render('innertop', array('layout'=>$this['config']->get('innertop'))); ?></section>
					<?php endif; ?>

					<?php if ($this['config']->get('system_output')) : ?>
					<section id="content" class="grid-block"><?php echo $this['template']->render('content'); ?></section>
					<?php endif; ?>

					<?php if ($this['modules']->count('innerbottom')) : ?>
					<section id="innerbottom" class="grid-block"><?php echo $this['modules']->render('innerbottom', array('layout'=>$this['config']->get('innerbottom'))); ?></section>
					<?php endif; ?>

				</div>
				
				<?php if ($this['modules']->count('sidebar-a')) : ?>
				<aside id="sidebar-a" class="grid-box"><?php echo $this['modules']->render('sidebar-a', array('layout'=>'stack')); ?></aside>
				<?php endif; ?>
				
				<?php if ($this['modules']->count('sidebar-b')) : ?>
				<aside id="sidebar-b" class="grid-box"><?php echo $this['modules']->render('sidebar-b', array('layout'=>'stack')); ?></aside>
				<?php endif; ?>

			</div>
			<?php endif; ?>

		</div>
	</div>
	<?php endif; ?>

	<?php if ($this['modules']->count('bottom-a + bottom-b')) : ?>
	<div id="block-bottom">
		<div class="wrapper <?php if($this['config']->get('block-bottom')) echo 'max-width'.$this['config']->get('block-bottom'); ?>">

			<?php if ($this['modules']->count('bottom-a')) : ?>
			<section id="bottom-a" class="grid-block"><?php echo $this['modules']->render('bottom-a', array('layout'=>$this['config']->get('bottom-a'))); ?></section>
			<?php endif; ?>
			
			<?php if ($this['modules']->count('bottom-b')) : ?>
			<section id="bottom-b" class="grid-block"><?php echo $this['modules']->render('bottom-b', array('layout'=>$this['config']->get('bottom-b'))); ?></section>
			<?php endif; ?>

		</div>
	</div>
	<?php endif; ?>

	<?php if ($this['modules']->count('footer + debug') || $this['config']->get('warp_branding') || $this['config']->get('totop_scroller')) : ?>
	<div id="block-footer">
		<div class="wrapper <?php if($this['config']->get('block-footer')) echo 'max-width'.$this['config']->get('block-footer'); ?>">

			<footer id="footer">

				<?php if ($this['config']->get('totop_scroller')) : ?>
				<a id="totop-scroller" class="smoothScroll" href="#dorsey-top"></a>
				<?php endif; ?>

				<?php
					echo $this['modules']->render('footer');
					$this->output('warp_branding');
					echo $this['modules']->render('debug');
				?>

			</footer>
			
		</div>
	</div>
	<?php endif; ?>

	<?php echo $this->render('footer'); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-50304696-1', 'dorseysunlimitedconstruction.com');
  ga('send', 'pageview');

</script>
</body>
</html>