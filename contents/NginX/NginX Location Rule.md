---
primary: dba5c2aea4

---

# location rule 테스트를 위한 환경

NginX 설정 작업시에 location rule을 테스트 하는 것은 상당히 짜증나는 일이 된다. `nginx.conf` 파일 수정과 NginX 리로딩, 테스트 하고자 하는 경로들에 대한 확인까지 꽤나 거쳐야 하는 작업들이 많아서인데,

`Makefile`을 통해 몇 가지 명령어들을 조합하면 꽤나 간단해지게 된다. (`Makefile` 명령어는 Mac OSX + Homebrew 기준이다.)

	test:
		nginx -s reload
		curl -I -L http://localhost:8080/devlog/Flash/Flex%20Chart/images/ChartAndDataTypes.swf
		curl -I -L http://localhost:8080/devlog/asset::jadetemplate/images/li.document.png

위의 `Makefile` Task를 설명하자면

1. `nginx -s reload` NginX가 설정을 새로 읽어들이게 한다
1. `curl -I -L http://localhos...` 테스트하고자 하는 url의 경로
	- `curl -I -L` 명령은 간단하게 해당하는 url의 header 정보만 출력해준다

이를 `make test`를 통해 실행해보면 아래와 같은 결과를 얻게 된다.

	nginx -s reload
	curl -I -L http://localhost:8080/devlog/Flash/Flex%20Chart/images/ChartAndDataTypes.swf
	HTTP/1.1 200 OK
	Server: nginx/1.4.2
	Date: Wed, 25 Sep 2013 00:47:49 GMT
	Content-Type: application/x-shockwave-flash
	Content-Length: 1134076
	Last-Modified: Tue, 23 Apr 2013 12:00:32 GMT
	Connection: keep-alive
	ETag: "517677e0-114dfc"
	Expires: Thu, 31 Dec 2037 23:55:55 GMT
	Cache-Control: max-age=315360000
	Accept-Ranges: bytes

	curl -I -L http://localhost:8080/devlog/asset::jadetemplate/images/li.document.png
	HTTP/1.1 200 OK
	Server: nginx/1.4.2
	Date: Wed, 25 Sep 2013 00:47:49 GMT
	Content-Type: image/png
	Content-Length: 1221
	Connection: keep-alive
	X-Powered-By: Express
	Accept-Ranges: bytes
	ETag: "1221-1378364862000"
	Cache-Control: public, max-age=0
	Last-Modified: Thu, 05 Sep 2013 07:07:42 GMT

2번 라인의 경우 `expires max;`로 설정된 NginX에서 서비스 되는 파일이어야 하고, 3번 라인의 경우 Node.js 측에서 `express`를 통해 서비스 되는 파일이어야 했다.

2번 라인의 `Expires`를 통해 확인이 가능하고, 3번 라인의 `X-Powered-By: Express`를 통해 확인이 가능하다.

대충 위와 같이 `Makefile`을 통해서 `nginx -s reload` 명령과 동시에 `curl`을 통한 header 정보를 확인하는 Task를 만들어서 사용하면, `nginx.conf`를 수정하고 확인하는 작업을 좀 더 단순화 시킬 수 있다.



# location 선언의 종류

### 1. `location =` 정확하게 일치되는 주소

	location = /path {

	}

보통 단일 주소에 대한 선언을 하기 위해 사용한다.

- `location = /favicon.ico` 보통 뭐 이딴거 라던가
- `location = /404.html` 에러 페이지 라던가
- `location = /` 아예 인덱스 주소를 따로 만들고 싶다던가

뭐 이런식으로 정확하게 주소가 일치하는 단일 주소에 대한 지정을 할 때 사용한다.

`/path`라고 선언했을 경우, `/path/dir...`과 같은 하위 주소를 포함하지 않는다.

### 2. `location ^~` 우선 순위 높음

	location ^~ /path {

	}

우선 순위가 높은 선언이다.

`location /path`라는 선언을 한 뒤에 `location ^~ /path/special`과 같은 예외적 처리가 필요할 때 사용한다.

### 3. `location ~` 정규식에 맞을 때, `location ~*` 정규식에 맞지 않을 때

	location ~ .+\.(jpg|png|gif)$ {

	}

	location ~* .+\.(jpg|png|gif)$ {

	}

정규식을 사용하는 선언이고, 일반적인 `location /path`보다 순위가 높기 때문에 여러가지 예외를 만들 수 있다.

`location ^~`보다 순위가 낮긴 하지만, 기본적인 `location /path`에 대한 예외처리를 한다는 점에서는 같은 순위로 생각해도 될 듯 싶다. 아무래도 `location ~`로 예외를 선언한 다음, 다시 `location ^~`로 선언을 할 필요는 크게 없을 듯 싶으니까...

### 4. `location /path` 일반 선언

	location /path {

	}

가장 순위가 낮은 선언이다. 순위가 가장 낮기 때문에 큰 틀을 구성하는 선언을 할 때 좋다.

### 조합 예제 : Reverse Proxy + Static File

일반적으로 NginX의 사용법이 php가 아닌 이상, 대부분 Reverse Proxy 용도로 사용을 하게 되고, Reverse Proxy에 대응되는 대부분 플랫폼의 취약점이 느린 Static File 처리 속도임을 생각해보면 아래와 같은 구성이 자주 사용될 수 있다.

	location / {
		# Node.js 혹은 Java 등의 Reverse Proxy
	}

	location ^~ /files {
		# Static File 주소를 예외적으로 처리한다
	}

	location ~ ^/blog/(?!asset::)(.*)\.(jpg|jpeg|gif|png|ico|zip|tgz|gz|rar|bz2|pdf|tar|wav|bmp|rtf|flv|swf)$ {
		# /blog 이하에서
		# /blog/asset:: 으로 시작되지 않는
		# 모든 jpg|jpeg|gif|png... 등의 Static File들을 예외적으로 처리한다
	}

위와 같은 구성을 했을 때 처리되는 형태를 보자면

- `/xxx/yyy`등의 대부분 처리는 Node.js가 하게 되고
- `/files/img.png`와 같은 Static File을 NginX가 처리하게 되고
- `/blog/post`와 같은 처리는 Node.js가 하게 되고
- `/blog/post/img.png`와 같은 처리는 NginX가 하게 된다.



# root와 alias의 차이

location 하위에 Static File Path를 연결하기 위한 방식에는 두 가지가 있다. 

`root`와 `alias`인데... 간단하게 설명하자면

	location /public {
		root $HOME/files
	}

	# http://localhost/public/dir/file.jpg 를 요청할 경우
	# $HOME/files/public/dir/file.jpg 를 찾게 된다.
	# 즉, 선언된 Local Path($HOME/files) + 전체 URL Path(/public/dir/file.jpg) 로 찾게 된다.

	location /public {
		alias $HOME/files
	}

	# http://localhost/public/dir/file.jpg 를 요청할 경우
	# $HOME/files/dir/file.jpg 를 찾게 된다.
	# 즉, 선언된 Local Path($HOME/files) + location에 선언된 Path 이하(/dir/file.jpg) 로 찾게 된다.

이 차이는 location rule을 정규식을 사용할 때 더욱 극명한 차이를 보이게 되는데

	location ~ ^/path/(.*)\.(jpg|jpeg|gif|png)$ {
		root $HOME/files
	}

	# 당연히 들어온 URL Path 전체를 $HOME/files 아래에서 찾게 되지만 

	location ~ ^/path/(.*)\.(jpg|jpeg|gif|png)$ {
		alias $HOME/files/$1.$2
	}

	# 마치 일반적인 프로그래밍의 String.replace()처럼 주소를 찾게 된다.

성능 차이는 잘 모르겠고...;;; Static File의 자원 구성에 따라 차이가 발생하게 될 듯 싶다.

뭐 디자이너들과의 협업 때 발생되는 자원들처럼 `/public` 같은 root 디렉토리 하위에 Static File 자원들을 주소에 맞게 정리해 놓았다면 `root`를 사용하는 것이 좋겠고, 그 외, 대체적인 뭔가 편집이 필요한 상황에서는 `alias`를 쓸 수 밖에 없지 않을까 싶다.




















	
	