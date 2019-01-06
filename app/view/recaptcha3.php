<!doctype html>
<html>
<head>

	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
  
  	<style>
  	.loader-wrapper {
  		line-height: 30px;
  	}
  	/* https://www.w3schools.com/howto/howto_css_loader.asp */
	.loader {
	  border: 5px solid #f3f3f3;
	  border-top: 5px solid #3498db;
	  border-radius: 50%;
	  width: 20px;
	  height: 20px;
	  animation: spin 2s linear infinite;
	  float: left;
	  margin-right: 1rem;
	}	
	@keyframes spin {
	  0% { transform: rotate(0deg); }
	  100% { transform: rotate(360deg); }
	}
  	</style>
  
</head>
<body>

	<div class="loader-wrapper">
		<div class="loader"></div> <?php echo _('SPAM check, please wait..') ?>
	</div>

	<form method="post" action="" name="form">
		<input type="hidden" name="preapp_postdata" value="<?php echo base64_encode($postdata) ?>">
		<input type="hidden" name="g-recaptcha-response">
	</form>
  
  	<script src="//www.google.com/recaptcha/api.js?render=<?php echo env('PREAPP_GOOGLE_RECAPTCHA3_PUBLIC_KEY') ?>"></script>
	<script>
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