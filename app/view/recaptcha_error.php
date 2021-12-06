<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bulma@0.7.2/css/bulma.min.css">
	<style>
	body {
		padding: 1rem;
	}
  	</style>
	
</head>
<body>

	<div class="notification is-danger">
		<?php echo _('SPAM blocked!') ?>
	</div>
	
	<small class="is-size-7"><?php printf(_('%1$s to home page.'), '<a href="'.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'">'._('Go back').'</a>') ?></small>
	
</body>
</html>