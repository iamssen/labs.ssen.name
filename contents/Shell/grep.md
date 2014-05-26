---
primary: 876efbf837

---

# grep : Globally find Regular Expression and Print

검색 할 때 쓴다. 상당히 광범위하게 사용될 수 있는 만큼 옵션도 징그럽게 많다...

정규식(Regular Expression)에 근거하고 있기 때문에 정규식을 어느 정도 알고 있으면 깜샷 날릴 수 있는 여지가 어느정도 있다.


# 기본 구성

	grep [<option>] <검색어> <대상파일>

옵션은 아래와 같다

- `-i` 대소문자를 구분하지 않는다
- `-v` 패턴에 검색되지 않는 행만 출력한다 (즉, 검색되는 것 빼고 출력)
- `-n` 라인 넘버를 보여준다
- `-l` 패턴에 검색되는 파일명만 출력한다 (여러 파일을 검색 할 때 검색되는 파일만 표시하고 싶을 때 사용)
- `-c` 패턴과 일치하는 라인의 갯수만 출력한다
- `-r` 하위 디렉토리 까지 검색한다


# 문자열 출력 스크립트와 함께 사용하기

	# test.coffee
	console.log('hello world')
	console.log('hello ssen')
	console.log('wow world')

위와 같은 Coffeescript 가 있을 때, 이를 grep과 같이 사용할 수 있다

	$ coffee test.coffee
	hello world
	hello ssen
	wow world

	$ coffee test.coffee | grep '^hello'
	hello world
	hello ssen

추가적으로 옵션들을 붙여서 써보자면

	$ coffee test.coffee | grep '^hello'
	hello world
	hello ssen
	$ coffee test.coffee | grep -v '^hello'
	wow world
	$ coffee test.coffee | grep -v '^hellO'
	hello world
	hello ssen
	wow world
	$ coffee test.coffee | grep -i '^hellO'
	hello world
	hello ssen
	$ coffee test.coffee | grep '^hellO'
	$ coffee test.coffee | grep -i '^hellO'
	hello world
	hello ssen
	$ coffee test.coffee | grep -n '^hellO'
	$ coffee test.coffee | grep -n '^hello'
	1:hello world
	2:hello ssen
	$ coffee test.coffee | grep -nv '^hello'
	3:wow world
	$ coffee test.coffee | grep -l '^hello'
	(standard input)

	events.js:72
	        throw er; // Unhandled 'error' event
	              ^
	Error: write EPIPE
	  at errnoException (net.js:901:11)
	  at Object.afterWrite (net.js:718:19)

	$ coffee test.coffee | grep -c '^hello'
	2
	$ coffee test.coffee | grep -s '^hello'
	hello world
	hello ssen

파일명을 출력하는 `-l` 옵션을 빼고는 대부분 정상적으로 작동한다.




