---
primary: da8732fbaf

---

# REST - Representational State Transfer

- URI 는 정보의 자원 위치를 표현해야 한다
- 자원에 대해 어떤 행동을 할지는 HTTP Method (GET, POST, PATCH, DELETE) 로 표현한다

URI 의 자원은 Collection 과 Element 로 구성될 수 있으며, 그에 대한 Method 규칙은 아래와 같이 적용될 수 있다

|URI			|POST							|GET							|PATCH							|DELETE						|
|---			|-----							|-----							|-----							|-----						|
|/users			|user 들을 저장할 collection을 만든다	|user collection 의 리스트를 가져온다	|user collection 의 목록을 수정한다 	|user collection 을 삭제한다	|
|/users/ssen	|새로운 user ssen 을 생성한다		|user ssen 의 정보를 가져온다		|user ssen 의 정보를 수정한다		|user ssen 을 삭제한다			|

REST API 설계 상 주요하게 사용될 수 있는 HTTP Request header 들은 아래와 같다

- `User-Agent` 사용자의 Device 를 분석해서 그에 맞는 Contents 를 구성할 여지가 된다
- `Accept` 사용자가 원하는 정보를 지정할 수 있는 여지가 된다 (ex. html 을 원할때와 단순 api 로서 작동할 때)
- `Accept-Language` 다국어 처리에 대한 여지가 된다

## 참고 RESTful API 설계의 5가지 확인 사항

- API 의 endpoint 를 여러 목적으로 재활용하지 말라 (자원의 주소를 정확히 표현하라)
- 모든 요청은 Method 의 의미에 맞게 사용하라 (POST 만 사용한다거나 하지 마라)
- 응답의 상태를 Body 에 표현하지 마라. (가능한 HTTP Status Code 를 사용하라)
- URL 에 동사적 표현(Verb)을 사용하지 마라 (상태 조회시에 `/ticket/activate` 보다는 `/ticket/status` 가 명확하다)
- REST 는 RPC 가 아니다. URL 에 호출해야 하는 메서드를 적지 마라.

하지만, 무엇보다 중요한 것은 인간이 이해할 수 있도록 디자인 되는 것이다.

> URL 을 보고 자원의 특성을 바로 이해하고, 지원 Method 를 보고 어떤 작동을 시킬 수 있는지 바로 이해하고, 지원 Accept 를 보고 어떤 자원을 받을 수 있는지 바로 이해할 수 있도록 해라.


# Request

## HTTP Method

method 를 통해 request 가 어떤 의도를 가지는지 분기할 수 있다

- `GET` Read
- `POST` Create
- `PATCH` Update
- `DELETE` Delete
- `HEAD` GET 과 같지만, 특수하게 `http header` 만 가져오게 된다
- `PUT` POST 와 유사
- `OPTIONS` 요청한 URL 이 응답할 수 있는 `http method` 가 무엇인지 요청한다

보안 상 기능을 구현하지 않을 method 는 비활성 시키는 것이 좋다


## "Accept" Client 의 사용 가능한 상황을 알리기

- `Accept "text/html, image/*, *"` client 가 받을 수 있는 type 들을 알림 
- `Accept-Language "en, ko"` client 의 사용 언어를 알림
- `Accept-Encoding "gzip, compress"` client 가 받을 수 있는 encoding type 을 알림
- `Accept-Charset "iso8859-5"` client 가 받을 수 있는 문자셋을 알림

일반적인 경우 `Accept` 는 REST api 에서 되돌려 받을 return type 의 지정으로 사용 가능하고, `Accept-Language` 의 경우엔 다국어 처리의 기준으로 사용될 수 있다.

## 브라우저 정보

- `User-Agent` Device 의 종류, Browser 의 종류 등을 알리는 정보

# Response

## Cache Control

Static file 과 같이 Cache 에 저장될 수 있는 정보들을 보낼때 의미가 있다

- `Last-Modified "Tue, 11 Jul 2000 18:23:51 GMT"` 마지막 수정 시간을 알린다

# File Upload, Download 시에 사용 가능한 HTTP 정보들

<>

# HTTP Status Code

<evernote:///view/2127944/s20/d9e60981-e470-49a6-8cea-d912f8c25aed/d9e60981-e470-49a6-8cea-d912f8c25aed/>