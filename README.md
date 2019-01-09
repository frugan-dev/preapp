# PreApp

PreApp is a simple PHP application that uses [auto_prepend_file](http://php.net/manual/it/ini.core.php#ini.auto-prepend-file) and [auto_append_file](http://php.net/manual/it/ini.core.php#ini.auto-append-file) directives.

### Modules

- ObfuscateEmai
- ReCaptcha3
- MinifyHtml
- NoJoomlaAdmin
- NoOpenCartAdmin
- NoWpAdmin
- NoWpLogin

### Installation

Edit .user.ini:

```
auto_prepend_file = /var/www/domain.ltd/private/PreApp/prepend.php
auto_append_file = /var/www/domain.ltd/private/PreApp/append.php
```

or .htaccess:

```
php_value auto_prepend_file /var/www/domain.ltd/private/PreApp/prepend.php
php_value auto_append_file /var/www/domain.ltd/private/PreApp/append.php
```

or vhosts.conf:

```
<VirtualHost *:80>
	...
	php_admin_value auto_prepend_file /var/www/domain.ltd/private/PreApp/prepend.php
	php_admin_value auto_append_file /var/www/domain.ltd/private/PreApp/append.php
</VirtualHost>
```

### Resources

##### Email

- http://alistapart.com/article/gracefulemailobfuscation

##### Compression

- https://gist.github.com/hengkiardo/4023901

##### PHP

- https://www.electrictoolbox.com/php-automatically-append-prepend/

##### SPAM

- https://github.com/kornelski/Sblam
- http://www.spamhelp.org/software/listings/server-side/

### License

MIT
