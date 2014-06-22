---
primary: 9aaad803e6
date: '2013-08-30 11:32:01'
tags:
- 'Documentation'
- 'Flex SDK'
- 'ASDoc'

---

`$FLEX_HOME/bin/asdoc`
==========================================

Flex SDK에 포함되어 있으며 `/** */` 주석을 문서화 시켜주는 유일무이한 솔루션이다.

사용 시, 사람을 상당히 피곤하게 만드는 문제점들이 많은 편이고, 특이하게도 실제 어플리케이션을 만드는 `mxmlc`나 `compc` 같은 컴파일러들 보다 소스코드의 검증을 더 빡세게 한다. (_같이 일하는 개발자가 못미더울 경우 `asdoc`으로 문서를 만들면 소스코드 검증이 되는 효과가..._)

Command Line 어플리케이션 이므로 Shell(Batch) Script나 Makefile에 명령을 포함시키거나, Script의 `exec` command를 사용해서 실행시킬 수 있다. 고로, Jenkins와 같은 CI 에 통합해서 사용하면 꽤 괜찮다. (_위에도 말했지만 `asdoc`의 소스코드 검증이 괴랄하게 빡세므로 소스코드 검증효과도 있다...;;;_)



`asdoc` arguments
==========================================

### 기초적인 사용법

```sh
# asdoc의 path를 지정해줘야 한다
/FLEX-SDK-PATH/bin/asdoc 
	# 문서에 포함할 Source Directory
	-source-path /project/src
	# 문서화 시킬 Source 들이 의존하는 라이브러리들의 경로 지정 
	# 매우 중요하다... 의존하는 라이브러리들이 모자라는 순간 에러를 뿜어낸다
	# FLEX SDK 상의 라이브러리들을 포함시키는 것을 잊어서는 안된다
	-library-path /project/libs
	-library-path /FLEX-SDK-PATH/framework/libs
	-library-path /FLEX-SDK-PATH/framework/libs/mx
	-library-path /FLEX-SDK-PATH/framework/libs/player/11.9
	# HTML 문서들을 만들 Directory
	-output /project/asdoc
```

최초 `asdoc`에 대한 정확한 지식없이 접근하다가 만나게 되는 최초의 문제점들은 보통 필요한 `-library-path` 들을 정확히 지정하지 못해서 생기는 경우가 많다.

### 그 외, 옵션들

- 여러가지 텍스트 입력
	- `-window-title "브라우저의 제목이 됩니다"`
	- `-main-title "문서의 제목이 됩니다"`
	- `-footer "문서 하단에 표시됩니다"`
	- `-package com.app.package "특정 package(namespace)를 설명하는 제목이 됩니다"`
- Path
	- `-source-path /project/src` 문서에 포함할 소스 디렉토리 경로 지정
	- `-examples-path /examples/src` @includeExample 로 포함시킬 소스들의 디렉토리 지정
	- `-library-path /project/libs` 소스가 의존하는 swc 라이브러리들의 디렉토리 경로 지정 **(중요 : 에러의 주요 원인이 된다)**
	- `-output /output/asdoc` 문서들을 출력시킬 디렉토리 지정 
- 포함시킬 소스들을 지정
	- `-doc-sources /project/src/doc/sources` 문서화 시킬 소스들 지정 (소스 디렉토리의 일부분만 문서화 시키고 싶을때)
	- `-doc-classes com.adobe.Class1 com.adobe.Class2 com.adobe.Class3` 문서에 포함 시킬 Class들 지정
	- `-exclude-classes com.adobe.Class1 com.adobe.Class2` 문서에서 포함 시키지 않은 Class들 지정
- 빌드 옵션들
	- `-keep-xml=false|true` true 일 경우 .xml 파일을 삭제하지 않고 남긴다
	- `-skip-xsl=false|true` false 일 경우 .html 파일들을 만들지 않는다
- 자세한 사항들은 <http://help.adobe.com/en_US/flex/using/WSd0ded3821e0d52fe1e63e3d11c2f44bc36-7ffa.html> 문서에서 확인



`asdoc` Build Script 작성
================================================

### Windows 용 asdoc.bat 파일

```bat
set FLEX_HOME=C:\FLEX\SDK\PATH

deltree /y project\asdoc

%FLEX_HOME%\bin\asdoc.bat ^
# Windows Batch의 경우 한 줄 명령어의 내려쓰기는 ^를 사용한다
-source-path project\src ^
-library-path project\libs ^
-library-path %FLEX_HOME%\framework\libs ^
-library-path %FLEX_HOME%\framework\libs\mx ^
-library-path %FLEX_HOME%\framework\libs\player\11.9 ^
-output project\asdoc
```

### Un*x 계열 (OSX, Linux) 용 asdoc.sh 파일

```sh
export FLEX_HOME=/FLEX/SDK/PATH

rm -rf /project/asdoc

$FLEX_HOME/bin/asdoc \
-source-path project/src \
-library-path project/libs \
-library-path $FLEX_HOME/framework/libs \
-library-path $FLEX_HOME/framework/libs/mx \
-library-path $FLEX_HOME/framework/libs/player/11.9 \
-output project/asdoc
```

### Ant 사용 asdoc.xml 파일

Ant의 경우 Flash Builder에 기본으로 Ant Task가 포함되어 있기 때문에 Flash Builder 상에서 사용하길 원한다면 사용할 만하지만... 그뿐이다. Build Script로서 Ant 자체가 유연함이 좋지는 않으므로 어차피 Command Line 기반의 명령어에 익숙해지게 되는게 좋다.

```xml
<?xml version="1.0" encoding="utf-8"?> 
<project name="ASDoc Builder" basedir=".">
	<!-- Windows 라면 C:/FLEX/SDK/PATH -->
	<property name="FLEX_HOME" value="/FLEX/SDK/PATH"/>
	<target name="doc"> 
		<delete dir="project/asdoc" failOnError="false" includeEmptyDirs="true" />
		<mkdir dir="project/asdoc" />

		<exec executable="${FLEX_HOME}/bin/asdoc" dir="${basedir}">
			<arg line="-source-path project/src" />
			<arg line="-library-path $FLEX_HOME/framework/libs" />
			<arg line="-library-path $FLEX_HOME/framework/libs/mx" />
			<arg line="-library-path $FLEX_HOME/framework/libs/player/11.9" />
			<arg line="-output project/asdoc" />
		</exec>
	</target> 
</project>
```

### Node.js를 사용한 Build Script 작성

Build 자동화 자체가 복잡해지게 될 경우 Script 작성을 고려해보게 된다. Javascript를 통해서 Command Line 명령을 만들고 실행시키는 방식이다. (_Script 작성을 통한 유연한 Build를 원할 경우에 상당한 도움이 된다._)

```js
var exec = require('done-exec')

var cmds = [
	'/FLEX/SDK/PATH/bin/asdoc'
	, '-source-path project/src'
	, '-library-path project/libs'
	, '-library-path /FLEX/SDK/PATH/framework/libs'
	, '-library-path /FLEX/SDK/PATH/framework/libs/mx'
	, '-library-path /FLEX/SDK/PATH/framework/libs/player/11.9'
	, '-output project/asdoc'
]

exec(cmds.join(' '))
	.run(function() {
		console.log('complete build asdoc.')
	})
```




`/** */` 주석
========================================================

### 기본 주석

- `@private` 문서 상에 요소가 나타나지 않게 한다.
- `@inheritDoc` 상속 관계에 있는 class 나 구현 관계에 있는 interface 의 주석을 사용하도록 지정한다
- `@see ${reference}` 해당 요소에 대한 참조를 추가한다.
- `@includeExample ${file}` 예제 코드를 추가한다. (includeExample 로 불러오는 file 은 utf-8 이면 한글이 깨진다. euc-kr 로 해야한다???)
- `@param ${parameter name} ${description}` method 의 parameter 를 설명한다.
- `@throws ${package.errors.ErrorClass} ${description}` 실행시 발생 가능한 Error 를 설명한다.
- `@return ${description}` method 의 return value 를 설명한다.
- 더 자세한 내용들은 <http://help.adobe.com/en_US/flex/using/WSd0ded3821e0d52fe1e63e3d11c2f44bc36-7ff6.html>에서 확인 가능


### `@see` Tag 사용 방식 

`@see`는 API에 참고할 수 있는 자료들의 위치를 지정하는데 사용되며, 다른 API 위치나 URL 등이 있다.

- HTML Resource
	- `@see http://ssen.name ${description}` Website
	- `@see example.html ${description}` Local File
- Api Selector
	- Class and Class Members
		- `@see #variable ${description}`
		- `@see #method() ${description}`
		- `@see #event:change ${description}`
		- `@see #style:paddingLeft ${description}`
		- `@see #effect:creationCompleteEffect ${description}`
		- `@see Class#variable ${description}`
		- `@see Class#method() ${description}`
		- `@see Class#event:change ${description}`
		- `@see Class#style:paddingLeft ${description}`
		- `@see Class#effect:creationCompleteEffect ${description}`
		- `@see fl.test.Class#variable ${description}`
		- `@see fl.test.Class#method() ${description}`
		- `@see fl.test.Class#event:change ${description}`
		- `@see fl.test.Class#style:paddingLeft ${description}`
		- `@see fl.test.Class#effect:creationCompleteEffect ${description}`
	- Package Members
		- `@see fl.test.#variable ${description}`
		- `@see fl.test.#metod() ${description}`
- 더 자세한 내용들은 <http://help.adobe.com/en_US/flex/using/WSd0ded3821e0d52fe1e63e3d11c2f44bc36-7ff8.html>에서 확인 가능
	





`asdoc`을 사용할 때 만날 수 있는 특이한 문제점들
========================================================

### 주석의 문장 규칙이 상당히 괴랄한 편이다.

- 주석이 리스트에 표현될 때, 첫번째 `.` 마침표 이후로는 표시가 안된다.
- 내려쓰기를 무시해 버리며, HTML 형태의 `<br/>`을 무시(제거)해 버린다. 내려쓰기를 사용하고 싶다면 `<p></p>` 블록을 사용하는게 좋다.

### 문서 컴파일 할 때 규칙이 상당히 깐깐하다.

- `mxmlc` 나 `compc` 에서도 대충 넘어가는 부분을 에러로 잡는다. (_이 부분은 간혹 장점이 되기도 한다. 뭔가 코드를 깐깐하게 검증하고 싶을 때, `asdoc`을 한 번 돌려보면 컴파일 할 때는 몰랐던 상당수의 숨은 오류들을 찾을 수 있다._)
- `swc` Library 의존성에 민감하다. 특히 SDK 상의 Library들을 작동으로 인식하지 않는다. (_Flex SDK 내부의 라이브러리를 일일히 신경쓸 일이 별로 없는 경우가 많으므로, 가끔 당혹스러울 때가 있다._)
