# Azure Instance 생성

# ssh public key 올리기

우선 기존 서버 ssh 기록을 지워야 한다

```sh
cd ~/.ssh
subl .
```

1. `config`의 Server Host를 지워준다 (다른 곳에 잠깐 둔다)
1. `known_hosts`의 Host 기록을 지워준다
1. `*_rsa.pub`의 public key 내용을 복사
1. ssh로 Server에 접속

```sh
cd ~/.ssh
sudo nano authorized_keys
# 복사해둔 public key의 내용을 붙여넣어 준다
```

1. `known_hosts`의 Host 기록을 다시 지워준다
1. ssh client로 접속해본다. 암호 요구 없이 접속되면 성공

# fish 설치

```sh
$ wget http://fishshell.com/files/2.1.0/linux/Ubuntu/fish_2.1.0-1~precise_amd64.deb
$ sudo dpkg -i fish_2.1.0-1~precise_amd64.deb
$ which fish
/usr/bin/fish
$ chsh -s /usr/bin/fish
$ sudo su
$ chsh -s /usr/bin/fish
```

# Git 설치

```sh
$ sudo aptitude install git
```

# nginx 설치

```sh
$ sudo aptitude update
$ aptitude show nginx 

# version이 너무 낮으면 아래처럼 repository를 추가
$ sudo add-apt-repository ppa:nginx/stable
$ sudo aptitude update
$ aptitude show nginx

$ sudo aptitude install nginx
```

nginx에 htpassword를 설정해준다

```sh
$ sudo aptitude install apache2-utils
$ cd /etc/nginx
$ sudo htpasswd -c .htpasswd admin
$ sudo htpasswd .htpasswd webhook
```

# jenkins 설치

```sh
$ sudo aptitude update
$ aptitude show jenkins

# version이 너무 낮으면 아래처럼 repository를 추가
$ wget -q -O - http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | sudo apt-key add -
$ sudo sh -c 'echo deb http://pkg.jenkins-ci.org/debian binary/ > /etc/apt/sources.list.d/jenkins.list'
$ sudo aptitude update
$ aptitude show jenkins

$ sudo aptitude install jenkins
```

nginx에 jenkins proxy를 설정해준다

```sh
$ cd /etc/nginx/sites-enabled
$ sudo nano jenkins.ssen.name
$ sudo service nginx reload
```

jenkins.ssen.name config

```nginx
server {
	listen 80;
	server_name jenkins.ssen.name "";

	location / {
		auth_basic "Restricted!";
		auth_basic_user_file /etc/nginx/.htpasswd;
		proxy_pass http://localhost:8080;
		proxy_set_header Authorization "";
	}
}
```

### No password

```sh
$ sudo su
$ cd /etc/sudoers.d
$ sudo nano jenkins

# jenkins ALL=(ALL) NOPASSWD: ALL

$ chmod 0440 jenkins
$ exit
```

### 보안설정
<http://jenkins.ssen.name> 으로 접속해보면 보안설정을 하라는 말이 나온다.

이미 `.htpasswd`를 통해서 보안 설정을 했으므로 _Configure Global Security_에 들어가서 _Enable security_에 체크하고, _Matrix-based security_의 _Anonymous_ 항목에 _Administer_를 체크해준다.

### E-mail Notification
_시스템 설정_에 들어가서 _E-mail로 알려줌_ 항목에 SMTP 서버 설정을 해준다.

### Environment Variables
_시스템 설정_에 들어가서 _Global properties_ 의 _Environment variables_ 항목들을 입력해준다.

### SSH Key
_Manage Credentials_에 들어가서 ssh private key를 올려준다.

### Plugins
_Plugin Manager_에 들어가서 필요한 플러그인들을 설치하고, 업데이트를 해주고, 사용 안할 플러그인들을 비활성 시켜준다.

만일 설치 가능한 플러그인이 하나도 없으면 _고급_에 우하단에 있는 "지금확인" 버튼을 눌러주면 된다.


# JDK 설치

```sh
$ aptitude show software-properties-common

# 설치가 안되어 있으면 
$ sudo aptitude install software-properties-common

$ sudo add-apt-repository ppa:webupd8team/java
$ sudo aptitude update
$ sudo aptitude install oracle-java7-installer
```

> java8은 tomcat7에서 문제가 생긴다.

jenkins JAVA_HOME 설정

```sh
$ sudo su jenkins
$ cd ~
$ sudo nano .bashrc
# export JAVA_HOME=/usr/lib/jvm/java-7-oracle
```

# Tomcat7 설치

```sh
$ aptitude search tomcat
$ sudo aptitude install tomcat7

$ cd /etc/default
$ sudo nano tomcat7
# JAVA_HOME 주석을 해제하고, 값을 /usr/lib/jvm/java-7-oracle 로 변경 

$ cd /etc/tomcat7
$ sudo nano server.xml
# <Connector port="8080"... 의 port를 9090으로 변경
# 만약 URIEncoding="UTF-8" 없으면 추가

$ sudo service tomcat7 restart
$ curl -I -L http://localhost:9090
```

nginx 에 추가

```sh
$ cd /etc/nginx/sites-enabled
$ sudo nano tomcat.ssen.name
$ sudo service nginx reload
```

tomcat.ssen.name config

```nginx
server {
	listen 80;
	server_name tomcat.ssen.name "";

	location / {
		auth_basic "Restricted!";
		auth_basic_user_file /etc/nginx/.htpasswd;
		proxy_pass http://localhost:9090;
		proxy_set_header Authorization "";
	}
}
```

# Redis 설치

```sh
$ aptitude show python-software-properties

# 설치가 안되어 있으면
$ sudo aptitude install python-software-properties

$ sudo add-apt-repository -y ppa:rwky/redis
$ sudo aptitude update
$ sudo aptitude install redis-server
```


# Node.js 설치

```sh
$ sudo add-apt-repository ppa:chris-lea/node.js
$ sudo aptitude update
$ aptitude show nodejs
$ sudo aptitude install nodejs
$ node --version
$ npm --version
```

# Gulp.js 설치

```sh
$ npm install -g gulp
```

# Ruby 설치

```sh
$ aptitude show ruby-rvm

# 버전이 졸라 낮다... Fuck...

$ sudo su jenkins
$ cd ~
$ \curl -L https://get.rvm.io | bash -s stable
$ source ~/.rvm/scripts/rvm
$ rvm --version

$ nano .bashrc
# 아래 문구를 추가
# if test -f $HOME/.rvm/scripts/rvm; then
# 	[ "$(type -t rvm)" = "function" ] || source $HOME/.rvm/scripts/rvm
# fi
$ source .bashrc

$ cat .bash_profile
# source $HOME/.rvm/scripts/rvm 관련 문구가 있다면 삭제 해준다

$ rvm list known
$ rvm install 2.1 
$ rvm use 2.1 --default
$ ruby --version
$ gem --version
```


# Jekyll 설치 (Ruby, Node.js 필요)

```sh
$ gem install jekyll
$ jekyll --version
```




# files.ssen.name

Jenkins 추가 

- git repository <https://github.com/iamssen/files.git>
- 빌드를 원격으로 유발
- 빌드 execute shell
	- `make jenkins`


