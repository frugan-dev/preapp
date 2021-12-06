<?php // To avoid race conditions with the api.js, either include the api.js before your scripts that call grecaptcha ?>
<script src="//www.google.com/recaptcha/api.js?render=<?php echo env('PREAPP_GOOGLE_RECAPTCHA3_PUBLIC_KEY') ?>"></script>
<script>
//https://github.com/google/recaptcha/issues/269
(function(grecaptcha, sitekey) {
	grecaptcha.ready(function() {
	    grecaptcha.execute(sitekey, {action: '<?php echo $this->get('camelCaseDomain') ?>'}).then(function(token) {
            var forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                var fields=form.getElementsByTagName('input');
                for(var j=0;j<fields.length;j++) {
                    var field=fields[j];
                    if('g-recaptcha-response'===field.getAttribute('name')) {
                        field.setAttribute('value', token);
                        break;
                    }
                }
            });
	    });
	});
})(grecaptcha, '<?php echo env('PREAPP_GOOGLE_RECAPTCHA3_PUBLIC_KEY') ?>');
</script>
