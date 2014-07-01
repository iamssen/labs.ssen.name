---
primary: 63b87a2004
date: '2014-01-14 17:13:39'
tags:
- 'Alfred'
- 'OSX'

---

문제점 : Mac의 기본 스크린캡쳐는 이름 바꾸기가 더럽게 힘들다
====================================

Mac의 스크린캡쳐 이름 지정은 `/System/Library/CoreServices/SystemUIServer.app/Contents/Resources/ko.lproj/ScreenCapture.strings`을 수정해서 바꿀 수 있지만 문제는 이 스크린캡쳐 이름 이라는게 `%@ %@ %@` 뭐 이딴 식으로 지정되어 있고, 이 인자들이 기본 Locale에 영향을 받기 때문에 사용자가 원하는대로 컨트롤을 하기가 힘들다.

그래서 왠만하면 비활성 시키고 `screencapture` 명령어를 사용하는 것이 더 좋다.


해결 방법 : Alfred Workflow로 `screencapture` 사용하기
====================================

> Alfred Workflow 기능은 Alfred 2.0 + Powerpack 유저만 사용 가능하다. (유료) 
>
> 1. Alfred Workflow의 **Hot Key Trigger**로 단축키를 감지하는 역할을 하고
> 1. Alfred Workflow의 **Script Action**으로 특정한 파일 이름으로 저장되도록 `screencapture`를 실행시키게 된다.
> 
> Alfred Workflow에서는 **Hot Key Trigger**와 **Script Action** 기능을 사용하는 것 뿐이고, 이는 Automator 등 여러가지 우회할 수 있는 방법이 있긴 할듯 싶다.

### 기본 기능들 비활성 

![스크린샷 단축키 비활성화][disable-screencapture-hotkey]

우선 환경설정에서 스크린샷 단축키를 빼준다. (뭐 겹치지 않는 다른 단축키를 사용할 예정이라면 딱히 뺄 필요는 없다)

### Alfred Workflow 제작

![Alfred 환경설정에서 워크플로우 탭 선택][alfred-preferences-workflows]

![새 워크플로우 만들기][make-new-blank-workflow]

`Alfred Preferences / Workflows`에 들어가서 새로운 Workflow를 만든다. (좌측 하단 + 버튼을 눌러서 만든다)

![워크플로우 이름 입력][workflow-name]

Workflow 이름은 아무렇게나 지정하면 되고...

![단축키 트리거 만들기][add-hotkey]

우측 상단에 있는 + 버튼을 눌러서 새로운 Hot Key Trigger를 만든다. (뭐 단축키 눌러서 실행되는 Workflow 이니깐...)

![단축키 설정][set-hotkey]

![단축키의 실행방식 선택][change-hotkey-type]

스크린샷을 찍을 때 사용할 단축키를 입력해주고, 단축키 위에서 오른쪽 클릭을 해서 Trigger behaviour를 `Pass through modifier keys`로 바꿔준다.

![스크립트 생성][add-run-script]

![Bash스크립트 추가][set-bash-script]

다시 우측 상단에 있는 + 버튼을 눌러서 Script Action을 만들어준다.

```sh
export ymd=$(date +%Y%m%d)
export hms=$(date +%H%M%S)
export content_home=/Users/ssen/Dropbox/Contents/
export screen_home=/Users/ssen/Dropbox/Contents/files/captures
mkdir -p $screen_home/$ymd
screencapture -i $screen_home/$ymd/$hms.png
python -c "import os.path; print os.path.relpath('$screen_home/$ymd/$hms.png', '$content_home')" | pbcopy
```

대충 설명하자면 뭐 이런 의미를 가진 Script이다.

- `export ymd=$(date +%Y%m%d)` 현재 년도를 $ymd에 저장
- `export hms=$(date +%H%M%S)` 현재 시간을 $hms에 저장
- `export content_home=/Users/ssen/Dropbox/Contents/` 상대 경로 지정의 최상위
- `export screen_home=/Users/ssen/Dropbox/Contents/files/captures` 이미지들이 저장될 위치
- `mkdir -p $screen_home/$ymd` 
	- `mkdir -p` 디렉토리를 만든다
	- `$screen_home/$ymd` {이미지 저장 경로}/{년월일} 경로의 디렉토리
- `screencapture -i $screen_home/$ymd/$hms.png`
	- `screencapture -i` 스크린캡쳐를 실행
	- `$screen_home/$ymd/$hms.png` 만들어질 이미지는 {이미지 저장 경로}/{년월일}/{시간}.png 로 저장된다
- `python -c "import os.path; print os.path.relpath('$screen_home/$ymd/$hms.png', '$content_home')" | pbcopy`
	- `python -c "import os.path; print os.path.relpath('$screen_home/$ymd/$hms.png', '$content_home')"` 
		- {이미지 저장 경로} - {상대 경로 최상위}의 경로를 출력
	- `| pbcopy` 출력된 문자를 클립보드에 저장한다

![단축키와 스크립트 연결하기][wire-hotkey-and-script]

마지막으로 만들어진 두 개의 액션 (Hot Key Trigger와 Script Action)을 이어준다.

위와 같이 해놓으면 이제 기존 스크린캡쳐 작업과 동일한 방식으로 **내가 원하는 위치에 원하는 이름으로** 스크린캡쳐를 생성시킬 수 있게 된다.


[disable-screencapture-hotkey]: http://files.ssen.name/captures/20130927/081034.png
[alfred-preferences-workflows]: http://files.ssen.name/captures/20130927/080135.png
[make-new-blank-workflow]: http://files.ssen.name/captures/20130927/080157.png
[workflow-name]: http://files.ssen.name/captures/20130927/080213.png
[add-hotkey]: http://files.ssen.name/captures/20130927/080249.png
[set-hotkey]: http://files.ssen.name/captures/20130927/080303.png
[change-hotkey-type]: http://files.ssen.name/captures/20130927/080321.png
[add-run-script]: http://files.ssen.name/captures/20130927/080341.png
[set-bash-script]: http://files.ssen.name/captures/20130927/080425.png
[wire-hotkey-and-script]: http://files.ssen.name/captures/20130927/080509.png