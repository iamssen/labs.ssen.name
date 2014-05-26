# NginX 설치

기본 Static File Hosting을 NginX 에 맡기고, 동적 영역을 Node.js가 처리하는 구성으로 가고 싶은 경우에 추가한다.

1. `sudo apt-get install nginx`
1. `sudo service nginx start`
1. 서버의 ip 확인 후에 port 80 으로 접속해본다

위와 같이 기본 설치를 완료할 경우, 아래와 같은 명령어 사용이 가능.

- `sudo service nginx start`
- `sudo service nginx restart`
- `sudo service nginx stop`
- `sudo service nginx status`

설정 파일은

- `/etc/nginx/nginx.conf`
- `/etc/nginx/sites-available/default`

로 나뉘게 되는데, 기본적인 라우팅 선언은 `/etc/nginx/sites-available/default` 에서 할 수 있다.



# NginX 설정 구조

### 기본 설정의 파악

- `/etc/init.d/nginx`
	- `/etc/nginx/nginx.conf` 선언하고 있다
- `/etc/nginx/nginx.conf`
	- `/run/nginx.pid`를 불러오는데, 이 파일은 단순히 숫자만 떨렁 적혀있다. 뭐지?
	- include `/etc/nginx/mime.types` mimetype들을 선언하고 있는 파일
	- access log `/var/log/nginx/access.log`
	- error log `/var/log/nignx/error.log` 에러 로그가 어디에 찍히고 있는지 확인
	- include `/etc/nginx/conf.d/*.conf`
	- include `/etc/nginx/site-enabled/*` site-enabled 디렉토리의 site 설정들을 읽어들인다 (중요)

중요한 축을 담당하는 설정들은 `/etc/init.d/nginx` --> `/etc/nginx/nginx.conf` --> `/etc/nginx/site-enabled/*`로 이어지게 된다. 기본적으로 크게 건드릴 것 없이 `/etc/nginx/site-enabled/`에 있는 기본 `default`만 변경하거나, 삭제하고 새로운 설정을 넣어주면 된다.
