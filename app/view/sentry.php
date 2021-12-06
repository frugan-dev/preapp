<script src="//browser.sentry-cdn.com/4.5.1/bundle.min.js"></script>
<!--[if !IE]><!-->
<script>
Sentry.init({
	dsn: '<?php echo env('PREAPP_SENTRY_DSN') ?>',
	environment: '<?php echo env('PREAPP_ENV') ?>',
	debug: <?php echo getenv('PREAPP_DEBUG') ?>,
});	
Sentry.configureScope((scope) => {
	scope.setUser({
		'ip_address': '<?php echo $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'] ?? '' ?>',
	});
	scope.setTag( '<?php echo $this->get('domain') ?>' );
});
</script>
<!--<![endif]-->
