---
primary: f01d4020c3
date: '2013-05-22 02:12:14'
tags:
- 'Protocol'
- 'REST'
- 'HTTP'

---

REST - Representational State Transfer
==================================================

### URL 설계 규칙

1. URI는 정보의 자원 위치를 표현해야 한다
1. 자원에 대해 어떤 행동을 할지는 HTTP Method (`GET`, `POST` or `PUT`, `PATCH`, `DELETE`)로 표현한다


### HTTP Request Method (_`CRUD` 규칙_)

URI의 자원은 `Collection`과 `Element`로 구성될 수 있다. 

그리고, 자원에 대한 `CRUD`는 `Method`로 표현할 수 있으며, 매칭되는 `Method`들은 아래와 같이 적용될 수 있다.

|URI			|`POST`, `PUT`						|`GET`								|`PATCH`							|`DELETE`					|
|---			|-----								|-----								|-----								|-----						|
|의미 			|Create								|Read								|Update								|Delete						|	
|`/users`		|User 들을 저장할 `Collection`을 만든다	|User `Collection`의 리스트를 가져온다	|User `Collection`의 목록을 수정한다 	|User `Collection`을 삭제한다	|
|`/users/ssen`	|새로운 User `ssen`을 생성한다			|User `ssen`의 정보를 가져온다			|User `ssen`의 정보를 수정한다			|User `ssen`을 삭제한다		|


### HTTP Request Header

REST API 설계 상 주요하게 사용될 수 있는 HTTP Request Header들은 아래와 같다

- `User-Agent` Device, Browser에 대한 정보
- `Accept` 원하는 Response Type을 적는다. (_`text/html`, `application/json`과 같이 받을 데이터 타입을 적는다._)
- `Accept-Language` 원하는 Language Type을 적는다. (_`ko`, `en`과 같이 받을 언어 타입을 적는다._)


### 참고 RESTful API 설계의 5가지 확인 사항

1. API의 endpoint를 여러 목적으로 재활용하지 말라 (자원의 주소를 정확히 표현하라)
1. 모든 요청은 Method의 의미에 맞게 사용하라 (POST 만 사용한다거나 하지 마라)
1. 응답의 상태를 Body에 표현하지 마라. (가능한 HTTP Status Code 를 사용하라)
1. URL에 동사적 표현(Verb)을 사용하지 마라 (상태 조회시에 `/ticket/activate` 보다는 `/ticket/status` 가 명확하다)
1. REST는 RPC 가 아니다. URL 에 호출해야 하는 메서드를 적지 마라.

하지만, 무엇보다 중요한 것은 인간이 이해할 수 있도록 디자인 되는 것이다.

> `URL`을 보고 자원의 특성을 바로 이해하고, 지원 `Method` 를 보고 어떤 작동을 시킬 수 있는지 바로 이해하고, 지원 `Accept`를 보고 어떤 자원을 받을 수 있는지 바로 이해할 수 있도록 해라.
>
> 그냥 쉽게 이야기해서 5분정도 보고 바로 사용 할 수 있도록 하라는 뜻...



HTTP Request
========================================================

### HTTP Method

`Method`를 통해 `Request`가 어떤 의도를 가지는지 분기할 수 있다.

- `GET` Read
- `PUT` Create
- `POST` Create
- `PATCH` Update
- `DELETE` Delete
- `HEAD` GET 과 같지만, 특수하게 `http header` 만 가져오게 된다
- `OPTIONS` 요청한 URL 이 응답할 수 있는 `http method` 가 무엇인지 요청한다

**보안 상 기능을 구현하지 않을 `Method`는 비활성 시키는 것이 좋다.**


### HTTP Request Header : `Accept` (_받고자 하는 Data Type을 적어줌_)

- `Accept "text/html, image/*, *"` 받고자 하는 Type들을 알림 
- `Accept-Language "en, ko"` 받고자 하는 Language를을 알림
- `Accept-Encoding "gzip, compress"` 받고자 하는 Encoding Type들을 알림
- `Accept-Charset "iso8859-5"` 받고자 하는 문자셋을 알림


### HTTP Request Header : `User-Agent` (_Client의 OS, Browser 정보_)

- `User-Agent` 규칙이 뭔가 거지같음... User-Agent 처리를 간단하게 해주는 찾아보면 많다. (_User-Agent를 해석해서 처리하는 것 보다는, CSS `@media`를 사용해서 처리하는 것이 더 좋다._)

