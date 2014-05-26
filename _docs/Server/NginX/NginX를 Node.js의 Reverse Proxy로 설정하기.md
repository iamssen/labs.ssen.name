# 참고 자료들

- [HARDENING NODE.JS FOR PRODUCTION PART 2: USING NGINX TO AVOID NODE.JS LOAD](http://blog.argteam.com/coding/hardening-node-js-for-production-part-2-using-nginx-to-avoid-node-js-load/)

# NginX를 단순 Reverse Proxy로 사용하기

주력 개발이 Node.js라고 할지라도 기본적으로 Node.js의 앞단에 NginX가 서있으면 장점이 많다. (실제 Node.js 개발자 마저도 이를 추천하고 있고...)

1. 일단 NginX에서 한 번 털고 들어오므로 보안에 좋다.
1. Static File을 NginX에 위임할 경우 보다 괜찮은 성능을 보여준다.

부분적으로 라우팅을 따주는게 아니라, 데이터 전반은 Node.js에 위임하고, Static File들만 NginX가 호스팅 하도록 예외를 만들어주겠다 싶으면 큰 설정은 필요가 없다.

	server {
		set $HOMEDIR /home/ssen.name/ssen.name;
		set $DROPBOX /data/Dropbox;
		set $NODE_PORT 9878;

		listen 80;
		server_name localhost;

		location ^~ /public {
			alias $HOMEDIR/public;
			autoindex off;
			expires max;
		}

		location ^~ /files {
			alias $DROPBOX/Contents/files;
			autoindex off;
			expires max;
		}

		location ~ ^/devlog/(?!asset::)(.*)\.(jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|pdf|tar|wav|bmp|rtf|flv|swf)$ {
			alias $DROPBOX/Contents/devlog/$1.$2;
			expires max;
		}

		location / {
			proxy_redirect off;
			proxy_set_header X-Real-IP $remote_addr;
			proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
			proxy_set_header Host $http_host;
			proxy_set_header X-NginX-Proxy true;
			proxy_set_header Connection "";
			proxy_http_version 1.1;

			proxy_pass http://127.0.0.1:$NODE_PORT;
		}
		
	}

부분별로 살펴보자면

1. `location /` 전체적으로는 Node.js에게 위임한다
1. `location ~ ^/devlog/(?!asset::)(.*)\.(jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|pdf|tar|wav|bmp|rtf|flv|swf)$`
	- `/devlog/` 하단 주소에서 Static File만을 NginX가 처리하도록 한다.
	- 기본적으로 Node.js가 Static File을 처리해주고 있긴 하지만, NginX가 중간에 가로채서 처리하는 것이 성능 상 더 좋다
1. `location ^~ /public`, `location ^~ /files` Static File 저장소들을 NginX가 처리하도록 선언해준다

일반적인 경우에는 `location /`와 `lcoation ^~ /public` 조합만으로 처리가 가능하긴 하다. 정규식으로 처리한 부분은 좀 특수한 동작 (Node.js 서비스와 Static File 경로가 겹치는 경우)의 처리를 위해 선언한 부분이고...

### 코드에 주석을 달아보자면

	server {
		# 환경 변수들을 set
		set $HOMEDIR /home/ssen.name/ssen.name;
		set $DROPBOX /data/Dropbox;
		set $NODE_PORT 9878;

		# 80 포트로 서비스를 시작하고
		listen 80;
		# 걍 모든 도메인을 전부 처리한다. (특정 도메인만 처리하고 싶다면 해당 도메인을 적어주면 된다)
		server_name localhost;

		# 순위가 높은 선언을 사용해서 아래의 location / 의 예외를 작성해줌
		# /public 으로 시작하는 주소들을 잡아서
		location ^~ /public {
			# $HOMEDIR/public 디렉토리 아래의 파일들을 사용해서 호스팅 한다
			alias $HOMEDIR/public;
			# /public/dir 에 대해 /public/dir/index.html 을 보여주거나,
			# 자동으로 list를 보여줄 필요는 없으므로 autoindex를 꺼준다
			autoindex off;
			# 웹 브라우저가 캐시를 최대한 사용하도록 처리 (Http 헤더에 "이건 변할 일이 없는 자료란다"라고 알려주게 됨)
			expires max;
		}

		location ^~ /files {
			alias $DROPBOX/Contents/files;
			autoindex off;
			expires max;
		}

		# 순위가 좀 높은 정규식을 사용하는 prefix 선언을 사용해서 아래의 location / 의 예외를 작성해줌
		# ~ 정규식에 맞으면
		# ^/devlog/ 로 시작하는
		# (?!asset::) asset:: 을 포함하지 않는
		# (.*) 모든 경로 --> $1 캡쳐
		# \. 쩜 찍고
		# (jpg|jpeg...)$ 이런 파일 확장자로 끝나는 것들 --> $2 캡쳐
		location ~ ^/devlog/(?!asset::)(.*)\.(jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|pdf|tar|wav|bmp|rtf|flv|swf)$ {
			# 캡쳐된 $1, $2 문자열을 사용해서 파일을 찾아 보내준다
			alias $DROPBOX/Contents/devlog/$1.$2;
			# 웹 브라우저가 캐시를 최대한 사용하도록 처리 (Http 헤더에 "이건 변할 일이 없는 자료란다"라고 알려주게 됨)
			expires max;
		}

		# 순위가 가장 낮은 location 선언 (prefix가 없음)
		location / {
			# Reverse Proxy 설정 관련...
			proxy_redirect off;
			proxy_set_header X-Real-IP $remote_addr;
			proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
			proxy_set_header Host $http_host;
			proxy_set_header X-NginX-Proxy true;
			proxy_set_header Connection "";
			proxy_http_version 1.1;

			# proxy pass... 뭐 대충 말 그대로 매칭된 url을 http://127.0.0.1:9878로 보낸다는 뜻 
			proxy_pass http://127.0.0.1:$NODE_PORT;
		}
		
	}









