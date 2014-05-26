# curl

- `curl http://example.com/index.html > save.html` 출력을 저장
- `curl http://example.com/sample.jpg -o save.jpg` 파일 다운로드
- `curl http://example.com/sample[1-5].jpg -o save#1.jpg` 여러 파일 다운로드
- `curl http://example.com/{a,b,c}.jpg -o #1.jpg` 여러 파일 다운로드
- `curl ftp://example.com/sample.jpg -u user:password -o save.jpg` ftp 다운로드
