---
primary: 1c2fbec511

---

# 용도

단순히 `tree /dir`와 같은 입력을 통해서 해당 Directory의 파일 구조를 볼 수 있게 해준다.

	ssen@ubuntu:~ » tree Dropbox/Contents
	Dropbox/Contents
	├── 기술 관련 자료들
	│   ├── Books.md
	│   ├── Flash
	│   │   ├── 정리 완료
	│   │   │   ├── 과거 자료들 정리
	│   │   │   │   ├── 정리완료
	│   │   │   │   │   ├── array
	│   │   │   │   │   │   └── VectorSortExample.as
	│   │   │   │   │   ├── BezierPointCubic.as
	│   │   │   │   │   ├── BezierPointQuadratic.as
	│   │   │   │   │   ├── BitmapEx.as
	│   │   │   │   │   ├── BitmapMaterial.as
	│   │   │   │   │   ├── BitmapUtil.as
	│   │   │   │   │   ├── bytesToString.as
	│   │   │   │   │   ├── CalendarBase.as

대충 이와 같은 형태로 작동된다.


# Install

### Mac (brew)

	brew install tree

### Ubuntu (apt-get)

	sudo apt-get install tree

### CentOS (yum)

	sudo yum install tree

