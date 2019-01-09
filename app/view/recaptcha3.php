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
  	/* https://www.w3schools.com/howto/howto_css_loader.asp */
	.loader {
	  border: 5px solid hsl(0, 0%, 86%);
	  border-top: 5px solid hsl(204, 86%, 53%);
	  border-radius: 50%;
	  width: 30px;
	  height: 30px;
	  animation: spin 2s linear infinite;
	}	
	@keyframes spin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
	}
  	</style>
  
</head>
<body>

	<div class="notification">	
		<div class="media">
			<div class="media-left">
				<div class="loader"></div>
			</div> 
			<div class="media-content">
				<?php echo _('SPAM check, please wait..') ?>
			</div>
		</div>
	</div>

	<form method="post" action="" name="form">
		<input type="hidden" name="preapp_postdata" value="<?php echo base64_encode($postdata) ?>">
		<input type="hidden" name="g-recaptcha-response">
	</form>
	
	<small class="is-size-7"><?php printf(_('%1$s and try again if the trial lasts too long.'), '<a href="javascript:history.back()">'._('Go back').'</a>') ?></small>
  
  	<script src="//www.google.com/recaptcha/api.js?render=<?php echo env('PREAPP_GOOGLE_RECAPTCHA3_PUBLIC_KEY') ?>"></script>
	<script>
	//https://github.com/google/recaptcha/issues/269
	(function(grecaptcha, sitekey) {
		grecaptcha.ready(function() {
		    grecaptcha.execute(sitekey, {action: 'homepage'}).then(function(token) {
				var fields=document.form.getElementsByTagName('input');
				for(var j=0;j<fields.length;j++) {
					var field=fields[j];
					if('g-recaptcha-response'===field.getAttribute('name')) {
						field.setAttribute('value', token);
						
						document.form.submit();
						break;
					}
				}
		    });
		});
	})(grecaptcha, '<?php echo env('PREAPP_GOOGLE_RECAPTCHA3_PUBLIC_KEY') ?>');
	</script>
</body>
</html>