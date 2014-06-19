---
primary: acb72cedd0
date: '2014-01-24 03:25:56'

---

[Installing Nginx in Mac OS X Mountain Lion With Homebrew](http://learnaholic.me/2012/10/10/installing-nginx-in-mac-os-x-mountain-lion/)

# NginX 설치

1. `brew install nginx`

서비스 사용 방식

- `nginx` start
- `nginx -s stop` fast shutdown
- `nginx -s quit` graceful shutdown
- `nginx -s reload` reloading configuration file
- `nginx -s reopen`


# NginX 설정 나누기

`brew`에서 설치한 NginX는 설정 파일이 `/usr/local/etc/nginx/nginx.conf`만 존재한다. (Ubuntu처럼 설정이 나뉘어져 있지 않다.)

효율적 관리를 위해서 `include`를 사용해 설정 파일을 나눠주는 것이 좋다.


# NginX를 launch Service로 등록하기

	// TODO