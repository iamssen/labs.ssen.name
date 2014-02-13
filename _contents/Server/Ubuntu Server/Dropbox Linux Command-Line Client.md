---
primary: 486c0029ed

---

> 실제 사용하는 계정이 아니라, 서버로 사용할 별도의 계정을 하나 만들고,   
> 디렉토리를 공유하는 방식으로 사용하는 것이 좋다.   
> **공유하지 않을 디렉토리를 비활성 시키는 기능이 상당히 불편하기 때문인데**   
> 공유하는 방식으로 사용하면 서버측에 어떤 디렉토리를 포함시킬지에 대해 Dropbox 웹사이트에서 컨트롤이 가능해진다.

# Dropbox 설치하기

1. `cd ~`
1. <https://www.dropbox.com/install?os=lnx> 에서 OS에 맞는 명령어로 설치
1. `.dropbox-dist/dropboxd` 를 실행시켜서 안내에 따라 계정을 활성화 시킨 후에 `Ctrl + C` 로 빠져나옴


# Dropbox를 system startup때 실행시키기

1. `sudo nano /etc/init.d/dropbox` 로 편집시작
1. [링크](http://www.dropboxwiki.com/tips-and-tricks/install-dropbox-in-an-entirely-text-based-linux-environment)에 적혀 있는 Ubuntu 관련 스크립트를 붙여넣은 뒤에, User 항목에 자신의 Ubuntu 계정 아이디를 적어줌
1. `sudo chmod +x /etc/init.d/dropbox`
1. `sudo update-rc.d dropbox defaults`
1. `sudo service dropbox start`

daemon 등록 이후에 아래 명령어들 사용 가능

- `sudo service dropbox start`
- `sudo service dropbox stop`

참고 문서

- [Install Dropbox In An Entirely Text-Based Linux Environment](http://www.dropboxwiki.com/tips-and-tricks/install-dropbox-in-an-entirely-text-based-linux-environment)
- [init.d 시스템 이벤트 만들기](init.d 시스템 이벤트 만들기.md)

# Dropbox cli script

1. <https://www.dropbox.com/install?os=lnx> 에서 python script 링크 확인 (아래 주소 변경 가능성 있으니...)
1. `wget -O dropbox.py "https://www.dropbox.com/download?dl=packages/dropbox.py"` 
1. `chmod 755 dropbox.py`

위의 스크립트들을 사용해서 아래 명령어들 사용 가능

- `~/dropbox.py status` 상태 확인
- `cd ~/Dropbox` 이후 `~/dropbox.py exclude add Images` 싱크에서 제외할 폴더들 추가 (왠만하면 공유 디렉토리 기능을 사용하고 이 기능은 쓰지 마라...)