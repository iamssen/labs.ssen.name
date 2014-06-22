---
primary: 1b11c58386
date: '2013-08-30 09:17:30'

---



`mxmlc`, `compc` 의 Commanline Message 를 영문으로 보이기
=================================================

1. Flex SDK 에 있는 `mxmlc`, `compc` 실행 스크립트를 Text Editor 로 연다 
1. `VMARGS="...` 라고 된 라인을 찾아서 마지막 부분에 `-Duser.language=en -Duser.country=US` 를 추가

처리를 완료하면 command line message 들이 모두 영문으로 출력됨




`-default-size 1000 800` swf size size 지정
=================================================

- project properties 에서 **Flex Compiler / HTML Wrapper** 의 체크를 해제 했을때 뜨는 flash player 의 size 가 된다
- `Application` 에서 `minWidth`, `minHeight` 를 없애줘야 한다





`keep-generated-actionscript=true|false` 컴파일된 `.as` 남기기
=================================================

- 컴파일 된 actionscript code 를 남겨놓는다
- 디버깅, 역분석 등에 유용함

	


`compc` 참고 자료들
=================================================
- <http://livedocs.adobe.com/flex/3/html/compilers_22.html#250507>
- <http://www.docsultant.com/site2/articles/flex_cmd.html>
- `-library-path` swc 에 포함될 library path



참고 자료들
=================================================

- [About the application compiler options](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7a92.html)
