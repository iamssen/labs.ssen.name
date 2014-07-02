VMWare 접속을 금지하는 정부 민원 사이트에서 VMWare 감추기
================================================================
가끔 정부 민원 사이트에서 VMWare는 안되네 어쩌네 하면서 지랄을 할 때가 있다. (_농담 아니라 죽여버리고 싶어진다..._)

그럴때를 위한 우회 방법

1. `.vmwarevm` 패키지 파일 내부로 들어간다.
2. `.vmx` 파일을 찾아서 텍스트 에디터로 연다.
3. 마지막 줄에 아래와 같은 내용들을 추가한다.

```properties
isolation.tools.getPtrLocation.disable = “TRUE”
isolation.tools.setPtrLocation.disable = “TRUE”
isolation.tools.setVersion.disable = “TRUE”
isolation.tools.getVersion.disable = “TRUE”
monitor_control.disable_directexec = “TRUE”
monitor_control.disable_chksimd = “TRUE”
monitor_control.disable_ntreloc = “TRUE”
monitor_control.disable_selfmod = “TRUE”
monitor_control.disable_reloc = “TRUE”
monitor_control.disable_btinout = “TRUE”
monitor_control.disable_btmemspace = “TRUE”
monitor_control.disable_btpriv = “TRUE”
monitor_control.disable_btseg = “TRUE”
```

저장을 한 다음 VM을 실행시켜보면 제대로 된다.

> VM이 약간 이상해지게 된다. (_비활성 시키는 기능들이 많아서 그런듯 하다..._) 정부 사이트 이용이 끝났으면 다시 지워주는 것이 좋다.