---
primary: a2cd6cd717
date: '2014-06-19 14:25:48'

---

install

```sh
brew tap josegonzalez/homebrew-php
brew tap homebrew/dupes
brew install –without-apache –with-fpm –with-mysql php54
ln -sfv /usr/local/opt/php54/*.plist ~/Library/LaunchAgents
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.php54.plist
```

/usr/local/etc/php/5.4/php-fpm.conf

```ini
listen = /tmp/php-fpm.sock
error_log = /Users/{{user}}/Downloads/php-fpm.log
access.log = /Users/ssen/Downloads/$pool.access.log
```

nginx.conf

```
server {
	listen 9888;
	server_name localhost;

    root /Users/ssen/Workspace/labs.ssen.name/_site;
	index index.html index.htm index.php;

	access_log /Users/ssen/Workspace/labs.ssen.name/access.log;
	error_log  /Users/ssen/Workspace/labs.ssen.name/error.log;

	location ~ \.php$ {
		include			/usr/local/etc/nginx/fastcgi_params;

		fastcgi_pass	unix:/tmp/php-fpm.sock;
		fastcgi_index	index.php;
		fastcgi_param	SCRIPT_FILENAME $document_root$fastcgi_script_name;
	}
}
```