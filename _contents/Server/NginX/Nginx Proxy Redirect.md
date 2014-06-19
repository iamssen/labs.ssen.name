---
primary: 73e5b27d01
date: '2014-06-19 14:25:48'

---

```nginx
server {
	listen 9889;
	server_name localhost;

	index index.html index.htm index.jsp;

	location / {
		proxy_pass		http://localhost:8080/test-gradlexxx/;
		proxy_redirect	http://localhost:8080/test-gradlexxx/ /;
	}
}
```