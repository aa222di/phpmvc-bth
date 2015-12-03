<!doctype html>
<html class='no-js' lang='<?=$lang?>'>
<head>
<meta charset='utf-8'/>
<title><?=$title . $title_append?></title>
<?php if(isset($favicon)): ?><link rel='icon' href='<?=$this->url->asset($favicon)?>'/><?php endif; ?>
<?php foreach($stylesheets as $stylesheet): ?>
<link rel='stylesheet' type='text/css' href='<?=$this->url->asset($stylesheet)?>'/>
<?php endforeach; ?>
<!-- Google fonts -->
<link href='https://fonts.googleapis.com/css?family=Oswald:400,700,300' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Josefin+Slab:300italic,300,600italic,600' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

<?php if(isset($style)): ?><style><?=$style?></style><?php endif; ?>
<script src='<?=$this->url->asset($modernizr)?>'></script>
</head>

<body>

<div id='wrapper'>
	
	<?php if ($this->views->hasContent('topnav')) : ?>
	<div class='top'>
		<div class='wrap'>
			<?php $this->views->render('topnav')?>
		</div>
	</div>
	<?php endif; ?>

	<header id='header'>
		<div class="wrap">
			<div class="logo">
				<?php if(isset($header)) echo $header?>
				<?php $this->views->render('header')?>
			</div>

			<?php if ($this->views->hasContent('navbar')) : ?>
				<div id='navbar' class='main-menu'>
					<?php $this->views->render('navbar')?>
				</div>
			<?php endif; ?>
		</div>
	</header>
		<?php if(isset($pageheader)) echo $pageheader?>
		<?php $this->views->render('pageheader')?>
	<div class="wrap">
		<?php if($this->views->hasContent('aside')) {
				$class = 'column-9';
			}
			else {
				$class = 'column-12';
			}?>
		<main id='main' class="<?=$class?>">
				<?php if(isset($main)) echo $main?>
				<?php $this->views->render('main')?>
		</main>
		<?php if($this->views->hasContent('aside')):?>
			<aside id="aside">
					<?php if(isset($aside)) echo $aside?>
					<?php $this->views->render('aside')?>
			</aside>
		<?php endif;?>
	</div>


	<footer id='footer'>
	<?php if(isset($footer)) echo $footer?>
	<?php $this->views->render('footer')?>
	</footer>

</div>

<?php if(isset($jquery)):?><script src='<?=$this->url->asset($jquery)?>'></script><?php endif; ?>

<?php if(isset($javascript_include)): foreach($javascript_include as $val): ?>
<script src='<?=$this->url->asset($val)?>'></script>
<?php endforeach; endif; ?>

<?php if(isset($google_analytics)): ?>
<script>
  var _gaq=[['_setAccount','<?=$google_analytics?>'],['_trackPageview']];
  (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
  g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
  s.parentNode.insertBefore(g,s)}(document,'script'));
</script>
<?php endif; ?>

</body>
</html>
