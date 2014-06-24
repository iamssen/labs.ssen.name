---
primary: ae37ad2f11
date: '2014-06-23 03:16:35'
tags:
- 'mxmlc'
- 'compc'
- 'Node.js'
- 'Build'

---


`mxmlc`, `compc`, `asdoc` 명령어를 좀 더 디테일하게 만들어내고 싶을 때 사용
=========================================================

[flbuild]는 `mxmlc`, `compc`, `asdoc` 명령어를 만들어내는데 도움을 주는 [Node.js] 모듈이다.

일단, Javascript로 제어되기 때문에 필요한 만큼 유연하게 Build 명령어를 만들 수 있고,

`-include-classes` 나 `-exclude-classes` 처럼 일일히 작성하기엔 ~~~어려운~~~귀찮은 명령어들을 Script로 필터링 할 수 있게 해주는 등의 편의 기능들이 추가되어 있다.


`mxmlc` 명령어 만들고, 컴파일 하기
========================================
```js
var Flbuild = require('flbuild')
	, exec = require('done-exec')

// Build Object 생성 
// ---------------------------------------------
var flbuild = new Flbuild()
// $ENV 형태로 사용할 환경 변수를 셋팅한다 
// 값을 입력하지 않으면 시스템 환경 변수를 사용한다
flbuild.setEnv('FLEX_HOME')
flbuild.setEnv('PROJECT_HOME', 'test/project')
flbuild.setEnv('PLAYER_VERSION', 11.9)

// -external-library-path 지정 (포함 시키지 않을 library)
flbuild.addExternalLibraryDirectory('$FLEX_HOME/frameworks/libs/player/$PLAYER_VERSION')
// -library-path 지정 (포함 시킬 library)
flbuild.addLibraryDirectory('$FLEX_HOME/frameworks/libs/')
flbuild.addLibraryDirectory('$FLEX_HOME/frameworks/locale/en_US/')

// -source-path 지정
flbuild.addSourceDirectory('$PROJECT_HOME/src')


// `.swf` Application 생성
// ---------------------------------------------
// 지금까지의 조건들로 Application을 생성한다
var flapp = flbuild.getApplicationCreator()
flapp.createBuildCommand('$PROJECT_HOME/src/App.mxml', '$PROJECT_HOME/app.swf', function(cmd) {
	exec(cmd).run(function() {
		// Application에 종속되는 Module을 만든다
		var flmodule = flbuild.getModuleCreator()
		flmodule.createBuildCommand('$PROJECT_HOME/app.xml', 
									'$PROJECT_HOME/src/modules/Module.mxml', 
									'$PROJECT_HOME/modules/Module.swf', 
									function(cmd) {
										exec(cmd, function() {
											console.log('Complete Build')
										})
									})
	})
})
```

`getApplicationCreator()`의 경우 기본적으로 `.swf`와 포함되어 있는 Class정보를 가진 `.xml`을 같이 만들어내게 된다.

만들어진 Class 정도 `.xml` 파일을 사용해서 `getModuleCreator()`를 사용할 경우 `Module`의 불필요한 용량을 줄일 수 있다.


`compc` 명령어 만들고, 컴파일 하기
==============================================================================

```js
var Flbuild = require('flbuild')
	, exec = require('done-exec')

// Build Object 생성 
// ---------------------------------------------
var flbuild = new Flbuild();
// $ENV 형태로 사용할 환경 변수를 셋팅한다 
// 값을 입력하지 않으면 시스템 환경 변수를 사용한다
flbuild.setEnv('FLEX_HOME')
flbuild.setEnv('PROJECT_HOME', 'test/project')
flbuild.setEnv('PLAYER_VERSION', 11.9)

// -external-library-path 지정 (포함 시키지 않을 library)
flbuild.addExternalLibraryDirectory('$FLEX_HOME/frameworks/libs/player/$PLAYER_VERSION')
// -library-path 지정 (포함 시킬 library)
flbuild.addLibraryDirectory('$FLEX_HOME/frameworks/libs/')
flbuild.addLibraryDirectory('$FLEX_HOME/frameworks/locale/en_US/')

// -source-path 지정
flbuild.addSourceDirectory('$PROJECT_HOME/src')


// `.swc` Library 생성
// ---------------------------------------------
var fllib = flbuild.getLibraryCreator()

// Library에 포함시킬 Class 들을 Script를 사용해서 필터링 할 수 있다
fllib.setFilterFunction(function(file) {
	// mailer.* package의 하위 Class 들만을 포함시킨다
    return file.class.indexOf('mailer.') === 0
})

// 지금까지의 조건들을 바탕으로 `compc` 명령어를 만들어낸다
fllib.createBuildCommand('$PROJECT_HOME/lib.swc', function(cmd) {
	// Command Execute
	exec(cmd).run(function() {
		console.log('Complete Build')
	})
})
```

`getLibraryCreator()`의 경우 `setFilterFunction()`을 지정해서, `-include-classes` 항목을 좀 더 손쉽게 지정 할 수 있게 해준다.






[Node.js]: http://nodejs.org
[flbuild]: https://www.npmjs.org/package/flbuild