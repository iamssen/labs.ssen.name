---
primary: 52cdbc5729
date: '2013-09-21 05:32:53'

---

# ssh

vmware 에서 test 구동시에 iterm 으로 ssh 접속해서 사용하는 것이 더 편함. 기본 ssh 접속이 안될때

- `sudo apt-get install openssh-server`
- `sudo nano /etc/ssh/ssh_config` 로 port 열어줌
- `/etc/init.d/ssh restart`

# apt commands

- `apt-cache search {keyword}` 패키지 찾기
- `apt-get install {package name}` 패키지 설치
- `apt-get remove {package name}`
	- `apt-get --purge remove {package name}` 설정 파일들까지 모두 삭제시
- `apt-get reinstall {package name}`
- apt-get install 로 받은 deb file 의 위치 `/var/cache/apt/archive`
- `apt-get clean` 위의 cache 들 비우기
- `apt-cache show {package name}`
- `apt-get update` 소스 리스트 업데이트
- `apt-get upgrade` 설치된 패키지들 업그레이드
- `apt-get -s dist-upgrade` 의존성 검사 수행하면서 업그레이드
- `dpkg -l` 설치된 deb 패키지들 리스트 보기

# language setting

- `sudo locale-gen ko_KR.UTF-8`
- `sudo nano /etc/default/locale` 파일 에서 `LANG="ko_KR.UTF-8"` 로 수정

# install zsh

- `sudo apt-get install zsh` zsh 설치
- `sudo apt-get install curl` curl 설치 필요
- `sudo apt-get install git` git 설치 필요
- `sudo curl -L https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh | sudo sh`
- `sudo chsh -s /bin/zsh`
- `cat /etc/passwd`
- `sudo su` 
- `chsh -s /bin/zsh {cat /etc/passwd 로 찾아낸 계정 아이디}`

# install bittorrent sync

- `uname -m` 으로 cpu type 알아내기
- <http://labs.bittorrent.com/experiments/sync.html> 에서 linux 패키지들 확인
- `wget http://btsync.s3-website-us-east-1.amazonaws.com/btsync_x64.tar.gz`
- `tar xzpf btsync_x64.tar.gz`
- `./btsync --dump-sample-config > btsync.conf` sync config 를 새로 만듬. password 설정 등 해줌
- `nano btsync.conf` 에서 home folder 위치와 id, password 등을 설정
- `./btsync --config btsync.conf` BitTorrent Sync forked to background. 라는 메세지 나옴
- `ifconfig` 로 확인 뒤에 `ip:8888/gui` 로 접속

오류가 많다. 사용하지 않는 것이 좋다.

# install Dropbox

실제 사용하는 계정이 아니라, 서버로 사용할 별도의 계정을 하나 만들고,   
디렉토리를 공유하는 방식으로 사용하는 것이 좋다.   
**공유하지 않을 디렉토리를 비활성 시키는 기능이 상당히 불편하기 때문인데**   
공유하는 방식으로 사용하면 서버측에 어떤 디렉토리를 포함시킬지에 대해 Dropbox 웹사이트에서 컨트롤이 가능해진다.

### dropbox 설치하기
- `cd ~`
- <https://www.dropbox.com/install?os=lnx> 에서 OS에 맞는 명령어로 설치
- `.dropbox-dist/dropboxd` 를 실행시켜서 안내에 따라 계정을 활성화 시킨 후에 `Ctrl + C` 로 빠져나옴

### dropbox를 system startup때 실행시키기
- [Install Dropbox In An Entirely Text-Based Linux Environment](http://www.dropboxwiki.com/tips-and-tricks/install-dropbox-in-an-entirely-text-based-linux-environment)에서 OS에 맞는 스크립트 찾아서 따라하기
- Ubuntu 설치를 요약...
	- `sudo nano /etc/init.d/dropbox` 로 편집시작
	- 링크에 적혀 있는 Ubuntu 관련 스크립트를 붙여넣은 뒤에, User 항목에 자신의 Ubuntu 계정 아이디를 적어줌
	- `sudo chmod +x /etc/init.d/dropbox`
	- `sudo update-rc.d dropbox defaults`
	- `sudo service dropbox start`

daemon 등록 이후에 아래 명령어들 사용 가능

- `sudo service dropbox start`
- `sudo service dropbox stop`

### dropbox cli script
- <https://www.dropbox.com/install?os=lnx> 에서 python script 링크 확인 (아래 주소 변경 가능성 있으니...)
- `wget -O dropbox.py "https://www.dropbox.com/download?dl=packages/dropbox.py"` 
- `chmod 755 dropbox.py`

위의 스크립트들을 사용해서 아래 명령어들 사용 가능

- `dropbox.py status` 상태 확인
- `cd ~/Dropbox` 이후 `~/dropbox.py exclude add Images` 싱크에서 제외할 폴더들 추가 (왠만하면 공유 디렉토리 기능을 사용하고 이 기능은 쓰지 마라...)


# Node.js 설치

- `sudo apt-get update`
- `sudo apt-get install python-software-properties python g++ make`
- `sudo add-apt-repository ppa:chris-lea/node.js`
	- 작동이 안될 경우 `sudo apt-get install software-properties-common`
- `sudo apt-get update`
- `sudo apt-get install nodejs`
- `node --version`
- `sudo nano ~/.zshrc` PATH 에 `:/usr/local/share/npm/bin` 추가 시켜줌
- `sudo npm install -g coffee-script`
- `sudo npm install -g mocha`

# install Redis

- `sudo apt-get install redis-server`
- `sudo apt-cache showpkg redis-server`
- `sudo cp /etc/redis/redis.conf ~/redis.conf` redis config file copy
- `sudo redis-server ~/redis.conf` 우선 conf file 에서 demonize option 이 yes 로 되어 있는지 확인

# get website application from git and install, run

- `git clone http://...git` ssen.name 을 git 으로 가져온다
- `screen` 지속적인 실행을 위해 screen mode 로 진입
	- screen 이 없을 경우 `sudo apt-get install screen`
- `sudo npm install --production` production mode 로 module 들을 install
- `sudo -E node server.js` process.env 를 읽기 위해 `-E` 를 붙여서 실행

# screen commands

- `$ screen -list` 스크린 리스트 보기
- `$ screen -r 16546.pts-1.ssenbuntu` 스크린 재접속
- `$ screen -d` or `ctrl + d` or `ctrl + a, d` 스크린 나오기
- `ctrl + a, w` 윈도우 리스트 보기
- `ctrl + a, "` 윈도우 선택
- `ctrl + a, c` 새 윈도우 만들기
- `ctrl + a, a` 바로 전 윈도우로 이동
- `ctrl + a, 숫자` 해당 윈도우로 이동
- `exit` 윈도우 닫기

# nginx install

- `sudo add-apt-repository ppa:nginx/stable`
- `sudo apt-get update`
- `sudo apt-get install nginx`

만일 문제가 발생할 경우

- `echo "deb http://ppa.launchpad.net/nginx/stable/ubuntu lucid main" > /etc/apt/sources.list.d/nginx-$nginx-lucid.list`
- `sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys C300EE8C`
- `sudo apt-get update`
- `sudo apt-get install nginx`

서비스의 실행, 정지 등은

- `service nginx start`
- `service nginx restart`
- `service nginx stop`










