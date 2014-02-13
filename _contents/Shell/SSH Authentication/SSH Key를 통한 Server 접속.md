---
primary: 01a687ca19

---

# [SSH Key 생성](ssh-keygen.md)

우선적으로 SSH Key를 생성 해야 한다.

# ssh-copy-id

간단하게 ssh key를 Server측에 심는 방법으로는 `ssh-copy-id`가 있다.

Mac의 경우 Homebrew를 통해 간단하게 설치가 가능하다

	brew install ssh-copy-id

설치가 완료되었으면 아래와 같이 공개키를 전달한다

	ssh-copy-id -i ~/.ssh/you_rsa.pub id@remote.com -p 22

몇 가지 중요한 사항들을 살펴보자면

- `ssh-copy-id` 명령어
- `-i ~/.ssh/you_rsa.pub` 전달할 공개키
- `id@remote.com` 전달할 Server에서의 아이디와 도메인 (혹은 IP)
- `-p 22` 전달할 Server의 SSH port (기본은 22)

이렇게 하면 `~/.ssh/you_rsa.pub` 공개 키 파일이 `remote.com`에 `~/.ssh/authroized_keys`로 저장되게 된다.

이와 같은 작업이 끝이 난 다음엔

	ssh -p 22 id@remote.com

과 같이 비밀번호를 제외한 상태에서 `remote.com`에 접속이 가능해진다.

## 예외적인 에러 상황에서 수동으로 `authrozied_keys`를 생성 시키기 (예를 들어 [fish]를 사용할 때)

[fish]를 사용할 경우 `ssh-copy-id`의 명령어 중 `&&`가 에러를 발생시키게 된다. ([fish]에서는 `&&`를 사용한 명령어의 연결이 허락되지 않는다.)

이와 같은 에러의 경우 수동으로 `authrozied_keys`를 생성시킬 수가 있다.

1. Local에서 `cat ~/.ssh/you_rsa.pub | pbcopy` 와 같이 공개키의 내용을 클립보드에 복사한다.
1. Remote Server에 접속한다
1. `sudo nano ~/.ssh/authrozied_keys` 로 파일을 수동 생성한다.
1. nano 편집기에서 복사했던 공개키의 내용을 붙여넣기 해준다. (편집기 탈출 및 저장은 `ctrl+x`)

위와 같이 `authrozied_keys`를 수동으로 생성시켜줘도 된다.


# 참고한 자료들

- <http://www.thegeekstuff.com/2008/11/3-steps-to-perform-ssh-login-without-password-using-ssh-keygen-ssh-copy-id/>




[fish]: ../Shell/fish.md