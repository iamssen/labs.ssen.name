---
primary: 9aaad803e6
date: '2013-08-30 11:32:01'

---

# `asdoc` 컴파일러

- [Using the ASDoc tool](http://help.adobe.com/en_US/flex/using/WSd0ded3821e0d52fe1e63e3d11c2f44bc36-7ffa.html)

## 기본

- `asdoc`
- `-source-path /project/src` 문서에 포함할 소스 디렉토리 경로 지정
- `-examples-path /examples/src` @includeExample 로 포함시킬 소스들의 디렉토리 지정
- `-doc-sources /project/src/doc/sources` 문서화 시킬 소스들 지정 (소스 디렉토리의 일부분만 문서화 시키고 싶을때)
- `-library-path /project/libs` 소스가 의존하는 swc 라이브러리들의 디렉토리 경로 지정 **(중요 : 에러의 주요 원인이 된다)**
- `-window-title "SSen MVC Framework ASDoc"` 문서 제목
- `-main-title "SSen MVC Framework ASDoc"` 문서 제목
- `-output /output/asdoc` 문서들을 출력시킬 디렉토리 지정 
	
## 특수한 작동을 하는 Parameter 들

- `-keep-xml=false|true` true 일 경우 .xml 파일을 삭제하지 않고 남긴다
- `-skip-xsl=false|true` false 일 경우 .html 파일들을 만들지 않는다



# Actionscript ASDoc 주석 작업

- [ASDoc Tags](http://help.adobe.com/en_US/flex/using/WSd0ded3821e0d52fe1e63e3d11c2f44bc36-7ff6.html)
- [Using ASDoc @see Tags](http://help.adobe.com/en_US/flex/using/WSd0ded3821e0d52fe1e63e3d11c2f44bc36-7ff8.html)

## 기본 주석

- `@private` 문서 상에 요소가 나타나지 않게 한다.
- `@inheritDoc` 상속 관계에 있는 class 나 구현 관계에 있는 interface 의 주석을 사용하도록 지정한다
- `@see ${reference}` 해당 요소에 대한 참조를 추가한다.
- `@includeExample ${file}` 예제 코드를 추가한다. (includeExample 로 불러오는 file 은 utf-8 이면 한글이 깨진다. euc-kr 로 해야한다???)
- `@param ${parameter name} ${description}` method 의 parameter 를 설명한다.
- `@throws ${package.errors.ErrorClass} ${description}` 실행시 발생 가능한 Error 를 설명한다.
- `@return ${description}` method 의 return value 를 설명한다.

## `@see` Tag 사용 방식 

- resource selector 
	- `@see http://ssen.name ${description}` website
	- `@see example.html ${description}` local file
- api selector
	- class and class members
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
	- package members
		- `@see fl.test.#variable ${description}`
		- `@see fl.test.#metod() ${description}`
	

