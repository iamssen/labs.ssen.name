---
primary: 00066940d6

---

# [htpasswd]

우선 [htpasswd]에 대한 이해가 필요하다.

# 인증 파일 생성

- `cd /etc/nginx` 우선 nginx 설정 공간으로 이동
- `sudo htpasswd -c .htpasswd myid` .htpasswd 파일을 만들면서 myid라는 계정을 하나 생성한다. (password를 물어보는데 적어준다)
- `sudo htpasswd .htpasswd userid` .htpasswd 파일에 userid라는 계정을 추가한다.
	- 중요하다. 멍청하게 `-c` 옵션을 계속 줘서 파일이 덮어쓰기가 되어버린걸 모르고 몇 시간 삽질의 원인이 되어버림...

# 인증을 사용하기

만들어진 인증 파일을 적용하는 것은 간단하다. 기존 Site 설정에

	server {
		...
		location / {
			auth_basic "Login시에 보여줄 메세지";
			auth_basic_user_file /etc/nginx/.htpasswd;
			...
		}
	}

위와 같이 `auth_basic`과 `auth_basic_user_file`만 적용시켜주면 해당 location에는 인증이 적용되게 된다.

	sudo service nginx restart

참고로 nginx를 재가동 시켜야 적용된다.





[htpasswd]: ../Shell/htpasswd.md