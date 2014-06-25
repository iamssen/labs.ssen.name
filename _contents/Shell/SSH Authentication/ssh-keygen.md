---
primary: 891f2a0190
date: '2014-01-15 16:11:45'

---

# SSH Key 생성

	$ ssh-keygen -t rsa -C "your@email.com"
	Generating public/private rsa key pair.
	Enter file in which to save the key (/Users/you/.ssh/id_rsa): /Users/you/.ssh/you_rsa
	Enter passphrase (empty for no passphrase):
	Enter same passphrase again:
	Your identification has been saved in /Users/you/.ssh/you_rsa.
	Your public key has been saved in /Users/you/.ssh/you_rsa.pub.

생성은 간단하다. 

- `ssh-keygen -t rsa -C "your@email.com"` 이메일을 입력하고 생성을 시작한다.
- `Enter file in which to save the key (/Users/you/.ssh/id_rsa): /Users/you/.ssh/you_rsa`
	- 이 부분에서 별도로 `/Users/you/.ssh/you_rsa`와 같이 입력을 해주지 않으면 기본 `id_rsa`로 생성이 된다.
	- 필요에 따라 파일 이름을 직접 입력해 주는 것이 좋다.
- 그 외에는 그냥 enter만 눌러주면 되고, 생성이 완료된다.

생성이 완료되면 아래와 같은 파일들이 만들어지게 된다

	$ ls ~/.ssh
	you_rsa    you_rsa.pub

`you_rsa` 파일은 비밀키이고, `you_rsa.pub` 파일은 공개키가 된다. 쉽게 설명하자면

- `you_rsa` 열쇠
- `you_rsa.pub` 자물쇠

가 된다. 

ssh key를 통한 자동 로그인은 `you_rsa.pub`라는 자물쇠를 여러 서버에 설치하고, 해당 서버들에 `you_rsa`라는 열쇠 하나로 열고 다니는 행동을 의미하게 된다.


# 열쇠와 자물쇠의 문제

`you_rsa`라는 열쇠와 `you_rsa.pub`라는 자물쇠가 만들어졌으니 이제 이 것을 어떻게 사용할지가 문제가 된다.

1. `you_rsa.pub`라는 자물쇠를 각 서버에 어떻게 설치 할 것인가?
1. `you_rsa`라는 열쇠 뿐만 아니라 `me_rsa`와 같은 열쇠가 더 있을때, 어떤 서버에 어떤 열쇠를 써야 하는지를 알 수 있을 것인가?

### 공개키의 설치

첫 번째의 문제는 의외로 간단한 해결이 가능하다. 일반적으로 서비스에는 ssh public key를 설치할 수 있는 장치가 마련되어 있기 때문이다.

![Bitbucket Add SSH Key][register-public-key]

예를 들어 위의 Bitbucket의 경우에도 ssh public key를 등록할 수 있는 메뉴가 있다. 이 부분에 만들어진 `you_rsa.pub`의 Text를 붙여넣으면 자물쇠의 설치가 완료된다.

### 열쇠의 구분

"서버에 맞게 어떤 열쇠를 쓸 것인가?"는 일단 수동으로 지정을 해주어야 한다.

	$ sudo nano ~/.ssh/config

위의 명령어 (혹은 vi 이던, subl 이던 입맛에 맞는 텍스트 편집 수단을 동원해서) config 파일을 만든다.

	Host bitbucket.org
		IdentityFile ~/.ssh/you_rsa

	Host github.com
		IdentityFile ~/.ssh/you_rsa

위와 같은 식으로 Host 별로 어떤 ssh private key를 사용할지를 지정해준다.

### 테스트

열쇠의 구분과 자물쇠의 설치가 끝났다면 대충 확인할 방법이 필요하다.

	$ ssh -T git@bitbucket.org

위와 같이 해보면 정상적인 접속 혹은 에러에 대한 메세지가 출력이 되게 된다.


# 에러 상황

SSH Key의 관리 차원에서 Key들을 Dropbox 같은데 놔두고 사용하다 새로운 컴퓨터에서 Key를 사용하고자 하는 경우 가끔 퍼미션 에러가 발생한다.

	chmod 700 ~/.ssh
	chmod 600 ~/.ssh/id_rsa
	chmod 644 ~/.ssh/id_rsa.pub  
	chmod 644 ~/.ssh/authorized_keys
	chmod 644 ~/.ssh/known_hosts

각 파일들에 대한 퍼미션을 위와 같이 조절해주면 정상적으로 작동하게 된다.


# 참고한 자료들

- <https://help.github.com/articles/generating-ssh-keys>
- <https://confluence.atlassian.com/display/BITBUCKET/Set+up+SSH+for+Git>
- <http://opentutorials.org/module/432/3742>



[register-public-key]: http://files.ssen.name/captures/20140115/145014.png
