---
primary: 68766333b5
date: '2013-08-31 12:58:46'
tags:
- 'Eclipse'
- 'Flash Builder'

---

Eclipse의 성능 올리기
======================================================

### Java Runtime Option 주기 (_그리 큰 효과는 없다_)

Eclipse에 플러그인 형태로 설치한 경우 `eclipse.ini` 파일을 수정하고,   
순수 Flash Builder 일 경우엔 Application Directory의 `Adobe Flash Builder 4.7.ini` 파일을 수정한다.

`-Xms`, `-Xmx`, `-XX:MaxPermSize` 와 같은 메모리 관련 설정을 적당히 올린다.


### 불필요한 플러그인들 끄기

![](/files/captures/20140622/215537.png)

위와 같이 Eclipse 설정에 들어가면 실행 시키지 않아도 되는 플러그인들을 해제 할 수 있다.

불필요하다 싶은 것들은 죄다 꺼버린다.



Compiler 성능 올리기
=========================================================

### `mxmlc`, `compc` (_그리 큰 효과는 없다_)

Flex SDK에 있는 `build.properties` 파일을 열어보면 `jvm.args = ...` 이 적혀진 라인이 있다. 

`-Xms`, `-Xmx` 등을 적당히 올려준다.


### Library Project 사용

최소 Font는 Library Project를 사용해서 컴파일 해야 한다.

```mxml
<!--- FontAssetLoader.mxml -->
<?xml version="1.0" encoding="utf-8"?>
<fx:Object xmlns:fx="http://ns.adobe.com/mxml/2009" xmlns:s="library://ns.adobe.com/flex/spark">
	<fx:Style>
		@font-face {
			src: url("font.ttf");
			fontFamily: "someFont";
		}
	</fx:Style>
</fx:Object>
```

위와 같이 Library Project에서 `Style`을 포함하는 코드를 하나 만들고,

```mxml
<s:Application xmlns:fx="http://ns.adobe.com/mxml/2009" xmlns:mx="library://ns.adobe.com/flex/mx" xmlns:s="library://ns.adobe.com/flex/spark">
	<fx:Declations>
		<ns:FontAssetLoader/>
	</fx:Declations>
</s:Application>
```

이와 같이 사용하면 성능 문제 없이 Font를 Embeding 시킬 수 있다. (_Font 종류 별로 몇 개 만들어 놓으면 요긴하게 쓸 수 있다._)




Debug 실행 속도 올리기
=================================================

### Web Browser가 아닌 Flash Player로 띄우기

Unit Test니 어쩌니 하지만... 그건 어디까지나 데이너나 로직에 해당하는 이야기이고, UI에 관련된 작업을 할 때는 어쩔 수 없이 어플리케이션을 실행 시키면서 테스트 할 수 밖에 없다.

코드 한 줄 고치고, 실행하고, 다시 코드 한 줄 고치고, 실행하고... 를 반복하는 상황에서 디버깅을 실행 속도가 급격하게 느린 Web Browser 통해 하는 것은 그다지 바람직하지 못하다.

![](/files/captures/20140623/010923.png)

"Debug Configuration"에서 위와 같이 "Use Default" 체크를 푼 다음, 실행할 파일의 확장자를 `.swf`로 바꿔주면 Flash Player로 실행되게 된다.

![](/files/captures/20140623/011222.png)

Flash Player 창 사이즈 조절은 위와 같이 "Project Properties"에서 `-default-size 500 400`과 같은 식으로 지정해주면 된다.

이와 같은 식으로 작업을 할 때 문제가 되는 로직들이 몇 가지 생긴다.

1. Website 내에서 Service에 접근할 때. URL을 찾지 못하는 문제
1. `ExternalInterface` 처럼 Javascript에 접근할 때

```as3
var req:String;
var url:String=FlexGlobals.topLevelApplication.url;
if (url.indexOf("file://") === 0) {
	req = "http://data.com/data.do";
} else {
	req = "/data.do";
}
```

1번의 문제는 위와 같은 식으로 현재 실행 되고 있는 URL을 확인해서 처리 할 수 있다. Flash Player를 통해서 실행되는 경우 Protocol은 `file://`이 된다.

```as3
if (ExternalInterface.available) {
	// TODO
}
```

2번의 문제는 위와 같이 `ExternalInterface.available`을 통해서 간단하게 처리 가능하다. (_물론... 위와 같은 코드들을 `View`, `Model` 구분없이 뒤죽박죽 섞어 놓으면 돌이킬 수 없는 스파게티 소스가 되겠지만..._)







