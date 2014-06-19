---
primary: 90fe19103c
date: '2014-01-06 06:42:34'

---

# Chrome 오류
몇 몇 이유로 웹 브라우저와 앱을 연결하는 몇 가지 Protocol이 작동하지 않는 상황들이 있다.    
일반적으로 Chrome에서 해당 Protocol을 맨 처음 작동을 시킬 때 거부를 눌렀거나 했을 경우 발생한다.

문제는 다시 재질문을 하지도 않고, Setting 에서도 관련 항목을 찾기가 힘들다.

# Local State 위치
- `~/Library/Application Support/Google/Chrome/Local State` Mac
- `~/.config/google-chrome/Local State` Linux
- `C:\Users\${USERNAME}\AppData\Local\Google\Chrome\Local State` Windows

위의 파일에서 아래와 같은 라인을 찾음

	"protocol_handler": { 
		"excluded_schemes": { 
			"afp": true, 
			"data": true, 
			"disk": true, 
			"disks": true, 
			"file": true, 

작동되지 않는 Protocol이 있는지 확인하고, 있으면 Chrome을 종료한 뒤에, 해당 라인을 지우거나 `false`로 고친 다음 앱을 재실행 시키면 해당 Protocol에 대한 질문을 한다.
