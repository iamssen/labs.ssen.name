---
primary: 2843313d63

---

# Flash Builder 4.7 + Apach Flex SDK 4.10 에서 `[Style(theme="spark")]` 과 같은 속성들이 나오지 않을때

Project 내의 `.actionScriptProperties` 아래와 같이 수정한다

	...
	</compiler>
	<applications>
	...

기존 이와 같은 부분을

	...
	</compiler>
	<theme themeIsDefault="false" themeIsSDK="true" themeLocation="${SDK_THEMES_DIR}/frameworks/themes/Spark"/>
	<applications>
	...

위와 같이 수정해준다.