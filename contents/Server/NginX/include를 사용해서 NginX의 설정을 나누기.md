---
primary: 82e535cafb

---

# include 방식

NginX의 대다수 설정은 `nginx.conf`에서 시작되어서 상세한 설정들이 include되어서 나뉘어지게 된다.

`mime.types`나 `site-enabled/*`같은 것들을 보면 알기 쉽다. include는 

1. `include /dir/some.file`과 같이 단일 파일도 가져올 수 있고
1. `include /dir/*`과 같이 어떤 디렉토리 내부의 모든 파일을 가져올 수도 있다.

# OS환경에 대한 설정과 Site작동에 대한 설정을 나눠보기

NginX 기본설정도 그렇고, 강의에서도 그렇고 기본적으로 안내되는 설정 방식은

1. `nginx.conf` 에서 `include site-enabled/*`로 불러주고
1. `site-enabled/*`에 `server {}`로 되어 있는 Virtual Host 파일들을 만들기

방식으로 Host를 관리하라고 한다...

하지만, 보통의 경우 `location` rule 관리는 소스 저장소에서 하는 것이 더 편하고, 이걸 `site-enabled/*`에서 선언하다가는 **작업용 컴퓨터와 실제 서버에서 매 번 설정을 해줘야 하는 이중작업이 발생하게 된다.**

- `/etc/nginx/site-enabled/` 
	- `website` nginx virtual host 설정 파일 (OS에 대한 설정을 한다)
- `/home/web/` git으로 가져온 web service 저장소
	- `config/` 설정 파일들을 넣는 디렉토리 
		- `locations` Location 설정 파일 (Service에 대한 location 설정을 한다)

위와 같이 역할을 나눠놓으면 `location` 변경에 의한 작업을 위해 virtual host 설정 파일을 건드릴 필요는 없어지게 된다.

### /etc/nginx/site-enabled/website

	server {
		set $HOMEDIR /home/web;
		set $DROPBOX /home/Dropbox;
		set $NODE_PORT 9642;

		listen 80;
		server_name localhost;

		include /home/web/config/locations;
	}

`set`을 통해 OS의 환경을 셋팅해 준 다음, `include`를 통해서 `locations`파일을 불러오도록 해준다.

### /home/web/config/locations

	location ^~ /public {
		alias $HOMEDIR/public;
		autoindex off;
		expires max;
	}

	location ^~ /files {
		root $DROPBOX/Contents;
		autoindex off;
		expires max;
	}

	location ~ ^/(inbox|devlog|labs|career|todo)/(?!asset::)(.*)\.(jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|pdf|tar|wav|bmp|rtf|flv|swf)$ {
		root $DROPBOX/Contents;
		autoindex off;
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

깔끔하게 OS 환경에 관련된 부분들을 떼어내고 설정이 가능하다.

작업용 컴퓨터에서 작업을 하던, 서버에 올리던 단지 virtual host 설정 파일에서 환경 변수만 바꿔주면 잘 작동이 된다.
