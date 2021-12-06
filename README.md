[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

# PreApp

PreApp is a simple PHP application that uses [auto_prepend_file](http://php.net/manual/it/ini.core.php#ini.auto-prepend-file) and [auto_append_file](http://php.net/manual/it/ini.core.php#ini.auto-append-file) directives.

### Modules

- ObfuscateEmail
- ReCaptcha2Invisible
- ReCaptcha3
- ReCaptcha3Ajax
- ReCaptcha3AjaxHtml
- MinifyHtml
- NoJoomlaAdmin
- NoOpenCartAdmin
- NoWpAdmin
- NoWpLogin
- Polyfill
- Sentry

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

### Changelog

See auto-[CHANGELOG](CHANGELOG.md) file.

### Contributing

For your contributions please use the [git-flow workflow](https://danielkummer.github.io/git-flow-cheatsheet/).

### Support

<!-- 
https://www.buymeacoffee.com/brand 
https://stackoverflow.com/a/26138535/3929620
https://github.com/nrobinson2000/donate-bitcoin
https://bitcoin.stackexchange.com/a/48744
https://github.com/KristinitaTest/KristinitaTest.github.io/blob/master/donate/Bitcoin-Protocol-Markdown.md
-->
[<img src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" width="200" alt="Buy Me A Coffee">](https://buymeacoff.ee/frugan)

### Usefull links

- http://alistapart.com/article/gracefulemailobfuscation
- https://gist.github.com/hengkiardo/4023901
- https://www.electrictoolbox.com/php-automatically-append-prepend/
- https://recaptcha-demo.appspot.com
- https://tehnoblog.org/google-no-captcha-invisible-recaptcha-first-experience-results-review/
- https://github.com/kornelski/Sblam
- http://www.spamhelp.org/software/listings/server-side/

### License

(ɔ) Copyleft 2021 [Frugan](https://about.me/frugan)
[GNU GPLv3](https://choosealicense.com/licenses/gpl-3.0/), see [COPYING](COPYING) file.
