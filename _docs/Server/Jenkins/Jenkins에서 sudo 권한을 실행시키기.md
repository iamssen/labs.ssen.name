# Jenkins에서 `sudo` 권한이 필요한 명령어 실행시키기

일단 확인을 좀 더 쉽게 하기 위해서 간단한 테스트용 job을 만들고, 아래와 같이 Execute shell을 설정해준다

![Execute shell][execute-shell]

실행을 시켜보면 아래와 같은 Console 결과가 떨어지게 된다.

	Started by user anonymous
	Building in workspace /var/lib/jenkins/workspace/test
	[test] $ /bin/sh -xe /tmp/hudson6281119536679894390.sh
	+ echo jenkins
	jenkins
	+ sudo echo 'Hello World'
	sudo: sorry, you must have a tty to run sudo
	Build step 'Execute shell' marked build as failure
	Finished: FAILURE

문제점은 크게 두 가지로 나눌 수 있는데

1. 현재 설정이 `sudo` 명령어를 실행하는데 tty(tele type) 접속이 반드시 필요하다는 것이고
1. Jenkins가 `sudo` 명령어를 실행 할 권한을 가지고 있지 않다는 것 이다. (현재 메세지는 그냥 너 tty가 아니라서 sudo 실행 못해 정도인 것 같지만...)


# 뚫어보기 전에 Jenkins에 왜 `sudo` 권한이 필요한가?

뭐 Maven은 안써서 잘 모르겠지만, 기본적으로 Makefile이던, Shell Script이던, 심지어는 Grunt로 build를 할 때면 언제나 "쬐끔 더 편하게 할 수 없을까?" 라는 문제에 직면하게 된다.

	make createNginXVirtualHostFile # NginX에서 사용할 파일을 만들어준다.
	sudo make exportNginXVirtualHostFile # NginX site-enabled/ directory로 옮겨준다.
	sudo service nginx reload # NginX가 설정을 다시 읽어오도록 한다

예를 들자면 위와 같은 류의 작업에서 첫 번째야 그럭저럭 별 문제없지만, 두 번째 NginX 설정 파일을 옮겨주는 작업이나, 세 번째 NginX를 재가동 시켜주는 작업등에는 `sudo` 권한이 필요하다.

위와 같이 전반적인 작업을 자동화 시켜주면 매우 편리하겠지만, 문제는 Jenkins에 `sudo` 권한을 준다거나, 그를 위해 필요한 `tty` 필수 요구 사항을 풀어버리면 보안에 예측하기 힘든 리스크가 생긴다는게 아닐까 싶다. 보안에 대해서 잘 모르기에 애매하지만, 언제나 편리와 보안은 등가 교환되는 면이 있으니...

구지 `sudo` 권한을 뚫어서까지 자동화 해줘야 할 정도로 작업이 빡시냐? 라는게 중요한 문제이지 않을까 싶다. (뭐 Git Push만 하면 Hook을 타고 지가 알아서 NginX 멈추고, 빌드하고, 다시 실행시키고 한다면 얼마나 편하긴 하겠냐만...)


# Jenkins에 `sudo` 권한 주기

### CentOS

CentOS의 경우에는 `/etc/sudoers` 파일에 모든 내용이 다 적혀있는 편이다. 그래서 편집만 하면 된다

- `sudo nano /etc/sudoers` 명령어로 `sudoers` 파일에 대한 수정을 시작한다
- 뭐 내용이 주르륵 나오는데 우선 `Defaults requiretty`를 찾아서 주석처리(#) 한다.
- 파일의 마지막 부분에 추가시켜준다. `jenkins ALL=(ALL) NOPASSWD: ALL`

### Ubuntu

Ubuntu의 경우에는 CentOS에 비하면 `/etc/sudoers` 파일이 굉장히 휑하다... (이래도 되나 싶을 정도로...) 설정들을 `/etc/sudoers.d/`라는 디렉토리에 분산시켜놓은 다음에 include 해놓은 구성인데 CentOS처럼 `/etc/sudoers`에 그냥 적어도 되지만 구색을 맞춰주는 차원에서 `/etc/sudoers.d`에 새 설정을 추가하도록 한다.

- `sudo su`로 root로 진입한다
- `cd /etc/sudoers.d`로 이동
- `sudo nano jenkins`로 새 설정 파일을 만든다
- `jenkins ALL=(ALL) NOPASSWD: ALL`를 입력해주고 편집에서 나온다
- `chmod 0440 jenkins`로 파일의 권한을 바꾼다
- `exit`로 root에서 나온다


다시 위에서 만들었던 Jenkins job을 실행시켜보면 아래와 같이 정상적인 Console 결과가 떨어지게 된다.

	Started by user anonymous
	Building in workspace /var/lib/jenkins/workspace/test
	[test] $ /bin/sh -xe /tmp/hudson6355458021182114475.sh
	+ echo jenkins
	jenkins
	+ sudo echo 'Hello World'
	Hello World
	Finished: SUCCESS






[execute-shell]: ../../../files/captures/20140120/154921.png

