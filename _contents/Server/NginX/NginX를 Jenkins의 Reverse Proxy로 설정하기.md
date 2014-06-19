---
primary: 740c8bb71a
date: '2014-01-31 23:21:16'

---



	server {
		listen 443;
		# listen 80;
		server_name jenkins.remote.com;

		ssl on;
		ssl_certificate /etc/nginx/ssl/server.crt;
		ssl_certificate_key /etc/nginx/ssl/server.key;

		location / {
			auth_basic "Restricted!";
			auth_basic_user_file /etc/nginx/.htpasswd;
			proxy_pass http://localhost:8080;
			proxy_set_header Authorization "";
			#proxy_pass_header Authorization;
		}
	}