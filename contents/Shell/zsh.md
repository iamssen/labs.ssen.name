---
primary: f309786b7b

---

# Defrecated

- 현재는 [zsh]보다는 [fish]를 더 추천


# [zsh] : Z Shell

`Un*x`의 기본 Shell인 `bash`보다 한결 사용하기 편한 Shell이다.

Tab Assist 기능이나 Git 저장소 정보 보여주기, [oh-my-zsh]를 통한 플러그인 및 테마 지원 등 상당히 많은 기능을 지원한다.


# Install

### Mac (brew)

- `brew install zsh` 설치
- `chsh -s /usr/local/bin/zsh` Shell 바꾸기
- `sudo su` root 진입
- `chsh -s /usr/local/bin/zsh` root Shell 바꾸기
- `exit` root 에서 나가기
- `curl -L https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh | sh` [oh-my-zsh] 설치

### Ubuntu (apt-get)

- `sudo apt-get install zsh` 설치
- `chsh -s /usr/local/bin/zsh` Shell 바꾸기
- `sudo su` root 진입
- `chsh -s /usr/local/bin/zsh` root Shell 바꾸기
- `exit` root 에서 나가기
- `curl -L https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh | sh` [oh-my-zsh] 설치



[fish]: fish.md
[zsh]: http://www.zsh.org
[oh-my-zsh]: https://github.com/robbyrussell/oh-my-zsh