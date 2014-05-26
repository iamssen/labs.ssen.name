---
primary: 90ba6890bd

---

# Install

NginX나 Apache등 여러 어플리케이션에서 사용하는 간단한 인증 시스템. 설치나 사용법 등이 상당히 간단하다.

### Cent OS

	sudo yum install httpd-tools

### Ubuntu

	sudo aptitude install apache2-utils


# Use

- `sudo htpasswd -c .htpasswd user` 새로운 `.htpasswd` 파일을 만들면서 `user`라는 새로운 유저를 추가한다
- `sudo htpasswd .htpasswd user2` 기존 `.htpasswd` 파일에 `user1`라는 새로운 유저를 추가한다 (이미 있는 유저면 password를 수정한다)
- `sudo htpasswd -D .htpasswd user` 기존 `.htpasswd` 파일에서 `user`라는 유저를 삭제한다

별달리 큰 사용법은 없다. 단순하다.

# 참고한 자료들

- <http://httpd.apache.org/docs/2.2/programs/htpasswd.html>