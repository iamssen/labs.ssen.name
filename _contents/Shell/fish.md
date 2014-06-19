---
primary: 5511dcd67f
date: '2014-01-25 00:05:37'

---

# [fish] : Friendly Interactive Shell

1. man page나 log 등을 활용해서 **꽤 강력한 수준의 자동완성 기능을 지원** 해준다.
1. 기존 Shell 들에 비해서, 공식 웹사이트(<http://fishshell.com>)에 [fish tutorial]과 같은 문서를 제공하는 등 가이드가 탄탄하다.
1. [zsh]의 장점이던, [oh-my-zsh]와 같은 [oh-my-fish]가 있다.


# Install

기본 설치 과정 및 [oh-my-fish] 설치까지 모두 진행한다

### Mac (brew)

- `brew install fish` 설치
- `chsh -s /usr/local/bin/fish` Shell 바꾸기
- `sudo su` root 진입
- `chsh -s /usr/local/bin/fish` root Shell 바꾸기
- `exit` root 에서 나가기
- `curl -L https://github.com/bpinto/oh-my-fish/raw/master/tools/install.sh | sh` [oh-my-fish] 설치

### Ubuntu (apt-get)

- `wget http://fishshell.com/files/2.1.0/linux/Ubuntu/fish_2.1.0-1~precise_amd64.deb` 다운로드
- `sudo dpkg -i fish_2.1.0-1~precise_amd64.deb` 설치
- `chsh -s /usr/local/bin/fish` Shell 바꾸기
- `sudo su` root 진입
- `chsh -s /usr/local/bin/fish` root Shell 바꾸기
- `exit` root 에서 나가기
- `curl -L https://github.com/bpinto/oh-my-fish/raw/master/tools/install.sh | sh` [oh-my-fish] 설치

원래는 아래의 방식대로 해도 되지만, 뭔가 자동 설치 버전에서는 문제가 많이 생기더라. (`source` command가 없다던가 하는 뭐 그런...) 하도 이상하게 뭐가 안되길래 그냥 다운로드 받아서 설치해버렸음 [참조 자료](http://hackercodex.com/guide/install-fish-shell-mac-ubuntu/)

- `sudo apt-get install fish` 설치
- `chsh -s /usr/local/bin/fish` Shell 바꾸기
- `sudo su` root 진입
- `chsh -s /usr/local/bin/fish` root Shell 바꾸기
- `exit` root 에서 나가기
- `curl -L https://github.com/bpinto/oh-my-fish/raw/master/tools/install.sh | sh` [oh-my-fish] 설치

### CentOS (yum)

기본적으로 yum에는 fish가 없기 때문에 reposotory를 추가해주고 나서 진행해야 한다. 설치 참고는 <http://fishshell.com/files/2.1.0/linux/> 에서 할 수 있다.

- `yum search fish` fish.x86_64를 발견할 수 없다
- `sudo yum-config-manager --add-repo http://fishshell.com/files/linux/RedHat_RHEL-6/fish.release:2.repo` yum repository 추가
- `yum search fish` fish.x86_64가 추가된 것을 확인할 수 있다
- `sudo yum install fish` 설치
- `chsh -s /usr/local/bin/fish` Shell 바꾸기
- `sudo su` root 진입
- `chsh -s /usr/local/bin/fish` root Shell 바꾸기
- `exit` root 에서 나가기
- `curl -L https://github.com/bpinto/oh-my-fish/raw/master/tools/install.sh | sh` [oh-my-fish] 설치


# Config

[fish]의 설정에서 중요한 항목들은 아래 두 가지 이다.

- `~/.config/fish/config.fish`
- `~/.oh-my-fish/`

bash와 큰 차이가 없던 [zsh]와는 다르게 [fish]는 사소한 부분들에서 꽤 차이를 보이게 된다. (편리할 수도 편리하지 않을 수도 있다.)

## Environment Variables

일단 가장 큰 문제는 기존 `export VAR = ...`과 같은 방식으로 선언하던 환경 변수 설정 부터가 다르다는 것...

기초적인 환경 변수들은 `~/.config/fish/config.fish`에서 선언 가능하며 선언 방식은 아래와 같다.

	set -x FLEX_SDK /Users/ssen/Data/settings/Apache\ Flex\ SDK\ 4.9.0/bin
	set -x PATH /usr/local/bin /usr/local/share/npm/bin $FLEX_SDK $PATH
	set -x DROPBOX $HOME/Dropbox

선언 방식의 차이라면

1. `export` 대신 `set -x`를 사용
1. `PATH`와 같은 다중 선언이 필요한 경우 `/usr/local/bin:$PATH`와 같은 식으로 :를 사용해서 연결하지 않고, `/usr/local/bin $PATH`와 같이 띄어쓰기를 통해서 선언하게 된다







[fish tutorial]: http://fishshell.com/docs/current/tutorial.html
[fish]: http://fishshell.com
[zsh]: zsh.md
[oh-my-fish]: https://github.com/bpinto/oh-my-fish
[oh-my-zsh]: https://github.com/robbyrussell/oh-my-zsh