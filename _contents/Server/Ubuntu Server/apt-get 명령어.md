---
primary: 253197cbab
date: '2013-09-24 21:01:05'

---

# update
- `apt-get update` 소스 리스트 업데이트 (apt 작업 시작 전에 항상 업데이트 해주는게 좋다)


# upgrade

- `apt-get upgrade` 설치된 패키지들 업그레이드
- `apt-get -s dist-upgrade` 의존성 검사 수행하면서 업그레이드


# search and install

- `apt-cache search {keyword}` 패키지 찾기
- `apt-get install {package name}` 패키지 설치
- `apt-get remove {package name}`
	- 설정 파일들까지 모두 삭제 하려 할때는 `apt-get --purge remove {package name}`
- `apt-get reinstall {package name}` 재설치
- `/var/cache/apt/archive` apt-get install 로 받은 deb file 의 위치 
- `apt-get clean` 위의 cache 들 비우기
- `apt-cache show {package name}`
- `dpkg -l` 설치된 deb 패키지들 리스트 보기