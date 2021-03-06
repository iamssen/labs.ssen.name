---
tags:
  - Protocol
  - REST
  - HTTP
primary: a8858ee31d
date: '2014-06-25 17:57:23'

---


자주 사용되는 HTTP Code
=================================

### 2xx (_Success_)

- `200` 조회 성공 (_`GET`과 같은 조회 요청에 성공_) 
- `201` 작성 성공 (_`PUT`, `POST`, `PATCH`과 같은 작성 요청에 성공_)

### 3xx (_Redirection_)

- `301` 위치가 완전 변경되었음
- `302` 위치가 임시적으로 변경되었음
- `304` 변경되지 않았음 (_수동으로 컨트롤 할 일이 별로 없다. Web Server가 알아서 처리한다._)

### 4xx (_Request Error_)

- `401` 권한 없음 (_로그인이 필요함_)
- `403` 금지된 리소스를 요청 (_퍼미션 오류같이 금지된 요청_)
- `404` 찾을 수 없음

### 5xx (_Server Error_)

- `500` 서버에 이런 저런 오류들 발생 (_쉽게 말해서 뭔가 이상이 생겼는데, 설명하기 어려울 때_)

### 더 자세한 HTTP Code들 참고 

- [Wikipedia HTTP 상태 코드](http://ko.wikipedia.org/wiki/HTTP_%EC%83%81%ED%83%9C_%EC%BD%94%EB%93%9C)