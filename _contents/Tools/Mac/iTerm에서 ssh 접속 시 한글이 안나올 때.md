---
primary: 9562044fd7
date: '2013-12-25 17:51:55'
tags:
- 'OSX'

---

오류
====================================
Mac의 Shell에 접속한 상태에서 `ssh` 명령어를 통해서 Remote Server에 접속을 하면, 경우에 따라 한글이 죄다 깨져버리기도 한다.

아마도, Mac의 nfd 처리를 시작한 상태에서 ssh를 통해 nfc 캐릭터를 읽어들이다보니 발생하는 문제가 아닐까 싶긴 한데,

우회적으로 아예 Mac의 Shell 상태를 경유하지 않고, 초기부터 `ssh`로 접속을 시작하면 문제 해결이 된다.


해결
====================================
1. iTerm2의 `Preferences > Profiles` 에서 새로운 Profile 생성
2. 기존 Command 항목의 `Login shell` 대신 `Command` 를 선택 후에 ssh 접속 코드를 써줌
	- `ssh user@server.com -p 57911`
3. iTerm2에서 새로 만든 Profile을 통해 접속하면 한글이 정상적으로 표시된다.