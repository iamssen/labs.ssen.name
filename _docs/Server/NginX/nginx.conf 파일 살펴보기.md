# 참고 자료들

- [NginX 환경설정]
- [Outsider님의 NginX 설치]
- [NginX Wiki HttpCoreModule]
- [Tuning NginX for Best Performance]
- [Optimizing NginX for Hish Traffic Loads]
- [가벼운 웹서버 nginx의 설치 및 환경설정 (이미지 서버로 사용하기)]
- [서적:엔진엑스로 운용하는 효율적인 웹사이트]

# `nginx.conf`

	# user www-data;
	# pid /run/nginx.pid;
	worker_processes 1;

	events {
		worker_connections 768;
	}

	http {
		sendfile on;

		tcp_nopush on;
		tcp_nodelay on;

		keepalive_timeout 5;

		include /etc/nginx/mime.types;
		default_type application/octet-stream;

		# access_log /var/log/nginx/access.log;
		# error_log /var/log/nginx/error.log;

		gzip on;
		gzip_disable "msie6";
		# gzip_vary on;
		# gzip_proxied any;
		# gzip_comp_level 6;
		# gzip_buffers 16 8k;
		# gzip_http_version 1.1;
		# gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript;

		include /etc/nginx/conf.d/*.conf;
		include /etc/nginx/sites-enabled/*;
	}

### Worker Process

- `worker_processes` cpu core 갯수를 입력하거나, 구지 성능이 필요없는 경우 그 이하로 설정하면 된다.
- `events.worker_connections` worker process 하나 당 처리 connection
- `user` worker process의 소유자가 된다.
- `pid` process id

동시 접속 가능힌 connection은 `worker_processes * events.worker_connections`가 된다.

그냥 개발용으로 쓰는 경우 (brew로 설치했다거나 할 때)는 보통 `user`와 `pid`는 비활성 되어 있다. 두 항목은 걍 초기값으로 놔두면 될듯...

### 성능 최적화에 관련된 옵션들

- `tcp_nodelay on;`
- `tcp_nopush on;`

OS나 Socket 등의 작동에 영향을 미치는 옵션들인듯 싶다. 복잡하게 생각할 필요없이 그냥 둘 다 `on`으로 설정해놓으면 될듯 싶다. [서적:엔진엑스로 운용하는 효율적인 웹사이트]의 169페이지에 안내되어 있다.

- `keepalive_timeout 65`

Http1.1의 keep-alive에 영향을 미치는 듯 싶다. (Http Request를 받은 이후, 연결을 재사용 시키는 효율성을 위해 다음 요청이 들어올 때 까지 대기해주는 시간)

기초값들은 보통 60정도로 되어있는데, 5정도로 확 줄이는 부류도 있고, 아주 늘려버리는 부류도 있는듯 싶다. 사이트 특성에 따라 혹은 컨텐츠 특성에 따라 설정이 달라질 수 있다는 이야기 같다. (User가 사이트에 얼마나 머무를 것이며, 다음 컨텐츠를 위해 다시 Request 요청을 보낼 것인지에 따라 틀려질 수 있을듯...) 딱히 사이트의 접속 시간이 길지 않다면 짧게 설정해도 될 듯 싶다.

[서적:엔진엑스로 운용하는 효율적인 웹사이트]의 170페이지와 [가벼운 웹서버 nginx의 설치 및 환경설정 (이미지 서버로 사용하기)]를 참고할 수 있다.

- `sendfile on;` 

read(), write() 대신 커널 내부에서 파일 복사를 시켜서 성능이 향상된다는데... 잘 모르겠다. OS의 기능에 얽혀 있는 옵션인듯 싶다. 기본 on으로 되어있고, 걍 놔두면 될듯...

### Mime Type

- `include /etc/nginx/mime.types;` mime type 설정을 include 한다
- `default_type  application/octet-stream;`

NginX가 사용할 Mime Type 설정을 해준다. 그냥 기본값으로 놔두고, 뭐 특수한 Mime 값이 필요할 때나 추가해주면 될듯 싶다.

### Log

- `# access_log /var/log/nginx/access.log;`
- `# error_log /var/log/nginx/error.log;`

말그대로 log 기록해주는건데... 필요하다면 주석을 풀어주면 될듯 싶다.

### Gzip

- `gzip on;`
- `gzip_disable "msie6"` 
- `#...`

gzip 압축 전송에 관련된 내용들인데... 기본값으로 두거나, 필요할 때 열면 될 듯 싶고, 개발때는 딱히 필요없을 듯 싶다. Node.js Reverse Proxy로 사용할 때 등은 딱히 필요없을듯 싶다.

### 기타 설정 가져오기

- `include /etc/nginx/conf.d/*.conf;`
- `include /etc/nginx/sites-enabled/*;`

하위 설정들을 가져온다.


[NginX 환경설정]: http://opentutorials.org/module/384/4526
[Outsider님의 NginX 설치]: http://blog.outsider.ne.kr/792
[NginX Wiki HttpCoreModule]: http://wiki.nginx.org/HttpCoreModule
[Tuning NginX for Best Performance]: http://dak1n1.com/blog/12-nginx-performance-tuning
[Optimizing NginX for Hish Traffic Loads]: http://blog.martinfjordvald.com/2011/04/optimizing-nginx-for-high-traffic-loads/
[가벼운 웹서버 nginx의 설치 및 환경설정 (이미지 서버로 사용하기)]: http://blog.naver.com/PostView.nhn?blogId=belladonnaf&logNo=50108995999
[서적:엔진엑스로 운용하는 효율적인 웹사이트]: http://book.daum.net/detail/book.do?bookid=BOK00019918616BA

