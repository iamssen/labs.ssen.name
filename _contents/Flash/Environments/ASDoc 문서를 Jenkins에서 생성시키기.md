---
primary: f4607aab82
date: '2014-06-22 04:54:27'
tags:
- Documentation
- ASDoc
- Jenkins
- CI
- NginX
- Build

---


Jenkins CI를 사용한 문서 자동화
===================================

`asdoc` 역시 Command Line Application 이므로, 다양한 활용이 가능하다.

그 중, Jenkins를 사용해서 자동으로 문서를 출력하는 일은 여러 개발자들이 작업하는 상황을 실시간으로 파악하는데 괜찮은 옵션이 되어준다.

부차적으로 `asdoc`의 소스 코드 검증이 `mxmlc`나 `compc`와 같은 실제 Application Compiler들 보다 더 빡세므로, 소스 코드의 품질을 검증하는 단계로도 활용 될 수 있다. (_어이 없지만 실제 컴파일시에 대충 넘어가서 모르던 소스코드의 오류들을 `asdoc` 문서 뽑다가 잡아내는 경우도 많다._)



Ubuntu Server에 Flex SDK 설치
===================================

### SDK 준비하기

CI Server에서 문서를 빌드 하기 위해서는 당연히 Server에 Flex SDK가 있어야 한다.

![](http://files.ssen.name/captures/20140622/042649.png)

<http://flex.apache.org>에 접속해서 최신 버전의 SDK를 일단 컴퓨터에 설치하도록 한다.

![](http://files.ssen.name/captures/20140622/042904.png)

![](http://files.ssen.name/captures/20140622/043100.png)

![](http://files.ssen.name/captures/20140622/043118.png)

Adobe 시절 Flex SDK는 zip 파일로 제공이 되어서 Shell 상에서 `wget`이나 `curl`을 사용해서 다운받은 다음에 압축만 풀면 되었었지만... Apache 부터는 설치 과정이 이렇게 바뀌었다. 고로... Installer를 통해서 설치한 다음 Server에 올리는 이중 작업이 필요하다. (_귀찮긴 하지만 별 수 없다. 더 편한 방법없나 찾아 헤매지 마라. 피곤해진다._)

![](http://files.ssen.name/captures/20140622/043522.png)

설치한 SDK를 이렇게 zip 파일로 압축해 놓는다. (_뭐 `scp` 등을 통해서 디렉토리로 올리는 방식도 있지만... Flex SDK의 구성 파일들이 징그러울 정도로 많은지라 zip으로 압축해서 올린 다음 압축을 풀어주는게 더 효과적이다._)

### Server로 올린 다음 압축 풀기

Server로 올리는 방식이야 여러가지 방식이 있지만, 일반적으로 FTP를 사용해서 올리게 된다. 

일단 Server로 파일 전송도 못하는 Jenkins 관리자가 있을 가능성은 0%에 가까우니... 이 부분은 알아서...

개인적으로는 OSX을 쓰는지라 [scp](/Shell/scp.html)를 사용해서 올리고 있다. 

```sh
$ scp -p 22 4.12.1.zip id@server.com:~/4.12.1.zip
```

일단 Home Directory로 올린 다음 SDK의 위치로 이동을 시킨 다음, 압축을 풀어준다.

```sh
# 경로는 /usr/lib/jvm 의 경로와 비슷하게 /usr/lib/flex-sdk 로 설정
$ sudo mv ~/4.12.1.zip /usr/lib/flex-sdk/4.12.1.zip
$ cd /usr/lib/flex-sdk
$ sudo unzip 4.12.1.zip
```

압축을 다 풀었다면 Jenkins 에서 환경 변수 설정을 해주면 된다.

![](http://files.ssen.name/captures/20140622/045220.png)

이와 같이 설정하면 Jenkins와 Jenkins에서 실행되는 빌드 내에서 `$FLEX_HOME` 환경 변수를 사용할 수 있다.



Jenkins에 Job 생성하기
===================================

![](http://files.ssen.name/captures/20140622/210851.png)

개인적으로 사용하는 구성은 아래와 같다.

1. Github Repository를 설정 (_Github의 public repository 이므로 Credentials 설정은 안한다_)
1. 빌드를 원격으로 유발 (_Github Project Settings 에서 WebHook을 보낼 수 있다_)
1. Execute Shell Command 빌드 (_Source Code 상의 Makefile Task를 실행시키는 역할 정도만 한다_)

위와 같이 설정을 해두면 Github에 `*/master` Branche에 Push가 이루어질 때마다 Jenkins Build가 작동을 하게 된다.

Jenkins Job 생성 자체야 간단하다. (_간단하게 쓰라고 만들어놓은 거니..._)

jenkins Job에서 실행시킬 `Makefile`은 아래와 같이 만들어둔다.

```make
jenkins:
	$FLEX_HOME/bin/asdoc \
	-source-path src \
	-library-path $FLEX_HOME/framework/lib \
	-library-path libs \
	-output asdoc
```

작업이 완료되면 이제 

1. Github Repository에 `*/master` Branche에 Push가 올때 마다
1. Github에서 Jenkins로 Webhook을 날려주고
1. Webhook을 받은 Jenkins는 `make jenkins`를 실행시켜주고,
1. `Makefile:jenkins` Task는 `asdoc`을 실행시켜서 문서를 만들게 된다.



생성된 문서들을 NginX에서 퍼블리싱 하기 
===================================

문서가 생성되기 시작했다면 NginX나 Apache를 사용해서 파일들을 Website에 퍼블리싱 할 수 있다.

아래와 같이 `/etc/nginx/sites-enabled/asdoc.nginxconf` 파일을 만든다.

```nginx
server {
	listen 80;
	server_name docs.ssen.name;

	index index.html index.htm;

	location / {
		root /var/lib/jenkins/jobs/asdoc-test/workspace/asdoc
	}
}
```

1. Jenkins의 기본 Home은 `/var/lib/jenkins`이고,
1. `jobs/job-name` 형태로 Job Directory가 존재한다
1. Job Directory에서 저장소는 `workspace` 가 되고,
1. 문서를 만든 Directory인 `asdoc`을 지정한다

위와 같이 NginX 설정을 만든 다음

```sh
$ sudo service nginx reload
```

를 실행시켜주면 이제 http://docs.ssen.name 에서 문서를 확인 할 수 있게 된다.