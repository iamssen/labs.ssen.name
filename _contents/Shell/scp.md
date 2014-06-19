---
primary: 2c22f67156
date: '2014-01-26 18:31:31'

---

# scp : Secure Copy

	# scp {옵션} {원본 위치} {사본 위치}

	# Remote Server로 보낼 때
	scp -P 3872 ~/file.tar id@remote.com:~/save.tar

	# Remote Server에서 받을 때
	scp -P 3872 id@remote.com:~/save.tar ~/save2.tar

일단 [SSH Key를 통한 Server 접속](../SSH Authentication/SSH Key를 통한 Server 접속.md)이 가능한 상태여야 한다. (이미 SSH Key가 설정된 상태라서 없어도 되는건지 확인이 안되네...;;;)

옵션을 살펴보자면

- `-P 24552` SSH Port를 지정
- `-p` Preserve 원본 파일의 수정시간, 사용시간, 권한 등을 유지한채 보낸다
- `-r` Recursive 하위 폴더/파일 모두 복사한다


# Remote Path 지정

	id@remote.com:~/save.tar

대충 구성을 살펴보자면

- `id@` Remote Server에서 사용되는 id를 지정한다
- `remote.com` Remote Server의 Domain 또는 IP Address
- `:~/save.tar` : 이후로 Remote Server의 Path를 지정한다


# `-r` 디렉토리 통째로 보내기 / 받기

	# 보낼 때 
	scp -P 3872 -r ~/directory id@remote.com:~/directory

	# 받을 때
	scp -P 3872 -r id@remote.com:~/directory ~/directory

`-r` 옵션을 붙이면 지정한 디렉토리를 통째로 보내거나 받게 된다.


# Glob

뭔가 룰이 어정쩡 하지만 대충 Globbing이 되긴 된다.

	scp -P 3872 -r ~/directory/*.jpg id@remote.com:~/directory

위와 같이 하면 `~/directory` 내의 모든 jpg 파일들이 Remote Server의 `~/directory`로 복사되게 된다.

다만, 주의 할 점은 Remote Server 상에 `~/directory`가 만들어져 있어야 한다는 점이다. (없으면 No such file or directory 라는 메세지를 보내고 전송이 실패하게 된다.)



# Error `scp: ambiguous target`

- `scp file.txt user@ip_address:"/file path/"` 이런 형태에서 에러가 지속적으로 발생한다면
- `scp file.txt user@ip_address:"/file\ path/"` 이런 형태로 `\` 처리를 해주도록 한다


# Flex SDK 등 큰 디렉토리 보내기

`scp -r` 옵션으로 디렉토리를 통째로 보내는 방법이 없는 것은 아니지만, 세월아 네월아 하게 된다. (겁내 오래걸림)

- `tar cvf flex-sdk-4.11.0.tar 'Apache Flex SDK 4.11.0'`과 같이 압축부터 하고
- `scp -P 3872 flex-sdk-4.11.0.tar id@remote.com:~/flex-sdk-4.11.0.tar`로 보내고
- `sudo mkdir /usr/lib/flex-sdk` Flex SDK를 넣을 디렉토리를 하나 만들고
- `sudo mv ~/flex-sdk-4.11.0.tar /usr/lib/flex-sdk/flex-sdk-4.11.0.tar`로 보내주고
- `cd /usr/lib/flex-sdk`
- `sudo tar xvf flex-sdk-4.11.0.tar`로 풀어준다



# 참고한 자료들

- <http://dinggur.tistory.com/94>