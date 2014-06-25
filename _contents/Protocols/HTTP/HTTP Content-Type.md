---
tags:
- 'Protocol'
- 'REST'
- 'HTTP'

---


Content Type
========================================================

### 규칙

```
text/html
text/xml
application/json
application/javascript
audio/mpeg
```

기본 `$media-type/$file-type` 형태로 구성된다

```
text/xml+xslt
application/json+github
```

추가적으로 `$media-type/$file-type+$protocol-type`과 같이 Protocol Type을 적어줄 수 있다. (_하지만, 왠만해서 이렇게까지 해줄 필요는 거의 없고, XML 기반 파일들을 보낼 때 적어줄 일이 많다. 워낙 XML 기반 Type들이 많은지라..._)




### 자주 사용되는 `Content-Type`

- 일반적으로 REST 서비스 구성시에 알아둬야 하는 Plain Text 기반 `Content-Type`
	- `text/html` HTML
	- `text/css` CSS
	- `text/javascript` Javascript
	- `text/xml` XML
	- `application/json` JSON
- HTTP Request를 수동으로 쓸 때 알아둬야 하는 `Content-Type`
	- `multipart/form-data` 파일 업로드 할 때 사용된다

사실 이 타입들 이외에는 Web Server에서 Static File로 날리기 때문에 알아둘 필요가 거의 없다.