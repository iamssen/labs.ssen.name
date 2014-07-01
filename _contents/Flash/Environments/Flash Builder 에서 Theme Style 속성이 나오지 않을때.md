---
primary: 5a83b10133
date: '2013-08-30 11:37:04'
tags:
- 'Flash Builder'
- 'Flex SDK'

---

Flash Builder 4.7 + Apach Flex SDK 4.10 에서 `[Style(theme="spark")]` 과 같은 속성들이 나오지 않을때
==========================================

Flex SDK 4.6을 마지막으로 업데이트가 이루어지고 있지 않은 Flash Builder 4.7 에서 최신의 Apache Flex SDK 들을 통해 컴파일을 하다보면 Style에 관련된 코드 힌트들이 먹통이 되곤 한다.

Project 내의 `.actionScriptProperties` 아래와 같은 부분은 찾는다.

```xml
</compiler>
<applications>
```

기존 이와 같은 부분에

```xml
</compiler>
<theme themeIsDefault="false" themeIsSDK="true" themeLocation="${SDK_THEMES_DIR}/frameworks/themes/Spark"/>
<applications>
```

위와 같이 `<theme/>` 관련 설정을 한 줄 추가해준다.