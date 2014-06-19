---
primary: f8477adb87
date: '2013-04-23 18:48:21'

---

# HTTP 1.1 Spec

## Documentation

- [HTTP 1.0, HTTP 1.1 Spec](http://coffeenix.net/doc/network/http_1_0_vs_1_1.html)
- [If-Modified-Since 에 대해](http://kldp.org/node/44139)

## Sample

### Daum

Request

	GET http://www.daum.net/ HTTP/1.1
	Host: www.daum.net
	Proxy-Connection: keep-alive
	Cache-Control: max-age=0
	User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11
	Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
	Accept-Encoding: gzip,deflate,sdch
	Accept-Language: ko-KR,ko;q=0.8,en-US;q=0.6,en;q=0.4
	Accept-Charset: windows-949,utf-8;q=0.7,*;q=0.3
	Cookie: __utma=65144763.157943217.1331689556.1331689556.1331689556.1; __utmz=65144763.1331689556.1.1.utmcsr=clien.career.co.kr|utmccn=(referral)|utmcmd=referral|utmcct=/cs2/bbs/link.php; dtck_seq=180; dtck_refresh=0; TIARA=AMYKB7u5XL-oRm-QKrnKwWX58zFgTPMo1J3dMHQi5dp-Hemni--GQ.IAILEwtiwXq_Q4VJbmZ8A0

Response

	HTTP/1.1 200 OK
	Date: Mon, 19 Mar 2012 06:46:14 GMT
	Server: Apache
	Expires: Sat, 01, Jan 1970 22:00:00 GMT
	Pragma: no-cache
	Cache-Control: no-cache, no-store, must-revalidate
	P3P: CP="ALL DSP COR MON LAW IVDi HIS IVAi DELi SAMi OUR LEG PHY UNI ONL DEM STA INT NAV PUR FIN OTC GOV"
	Vary: Accept-Encoding
	Content-Type: text/html; charset=utf-8
	Content-Length: 47784
	Connection: close
	Content-Encoding: gzip
	Set-Cookie: dtck_seq=181; path=/; expires=Wed, 18-Apr-2012 06:46:14 GMT; domain=www.daum.net

### Node.js Document Site

Request

	GET http://nodejs.org/docs/latest/api/http.html HTTP/1.1
	Host: nodejs.org
	Proxy-Connection: keep-alive
	Cache-Control: max-age=0
	User-Agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.79 Safari/535.11
	Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
	Referer: http://nodejs.org/docs/latest/api/
	Accept-Encoding: gzip,deflate,sdch
	Accept-Language: ko-KR,ko;q=0.8,en-US;q=0.6,en;q=0.4
	Accept-Charset: windows-949,utf-8;q=0.7,*;q=0.3
	Cookie: __utma=212211339.1873282363.1331715866.1331877515.1332114742.6; __utmc=212211339; __utmz=212211339.1331715866.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)
	If-Modified-Since: Sat, 17 Mar 2012 18:08:33 GMT

Response

	HTTP/1.1 304 Not Modified
	Server: nginx
	Date: Mon, 19 Mar 2012 06:50:01 GMT
	Content-Type: text/html
	Last-Modified: Sat, 17 Mar 2012 18:08:33 GMT
	Accept-Ranges: bytes
	Connection: close
	Age: 0


## HTTP 1.1 Spec

- 상용 Head???
	- General Header
		- Date 
			- 현재 시간 
			- `Mon, 19 Mar 2012 06:46:14 GMT` 현재 시간
		- Cache-Control
			- 캐시 여부, 업데이트시간, 내용, 지움 등 컨트롤
			- Request 시에 캐시된 사본을 강제적으로 검증하게 하려면 `Cache-Control: max-age=0` 으로 지정
			- [Cache-Control 에 대해서](http://blog.combel.net/entry/Cache-Control?category=0)
		- Connection
			- 연결 끊기 http1.1 은 연결 지속이 가능? 
			- Response 시에 현재 연결 정보. 보통은 `Connection: close` 
		- Transfer-Encoding
			- Body 의 압축방식
			- [Transfer-Encoding 정보](http://blog.bagesoft.com/917)
		- Upgrade
			- 프로토콜 변경시
			- `Upgrade: HTTP/2.0, SHTTP/1.3, IRC/6.9, RTA/x11`
		- Via
			- 중계서버(프록시, 게이트웨이 등)의 지원프로토이름, 버전, 호스트명
	- Entity Header
		- Allow
		- Content-Encoding
		- Content-Length
		- Content-Type
		- expires
		- Last-Modified
		- Content-Base
		- Content-Language
		- Content-Location
		- Content-MD5
		- Content-Range
		- ETag
- Request
	- Request Line
		- Method
		- Request-URI
		- HTTP-Version
	- Request Header
		- Authorization
		- From
		- If-Modified-Since
		- Refer
		- User-Agent
		- Accept
		- Accept-Charset
		- Accept-Encoding
		- Accept-Language
		- Host
		- If-Match
		- If-None-Match
		- If-Range
		- If-Unmodified-Since
		- Max-Forwards
		- Proxy-Authorization
		- Range
- Response
	- Status Line
		- HTTP-Version
		- Status-Code
		- Respon-Phrase
	- Response Header
		- Location
		- Server
		- WWW-Authenticate
		- Age
		- Proxy-Authenticate
		- Public
		- Retry-After
		- Warning
		- Vary

## HTTP Status

## Multipart form data 의 이어 올리기, 이어 내리기

## Cache Control
