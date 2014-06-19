---
primary: 5be16893f3
date: '2014-01-14 16:00:54'

---

# [fswatch]

**Mac에서만 사용 가능한** 작고 사용하기 간단한 File Watcher.

Mac OS의 FSEvents API를 사용하기 때문에 다른 OS에서는 안된다.

- `fswatch $dir "$command"` $dir이 변경되면 문자열로 된 $command가 실행된다
- `fswatch $dir1:dir2 "$command"` $dir1 또는 $dir2이 변경되면 문자열로 된 $command가 실행된다

# [Makefile]과 함께 사용하기

### `src`가 변경될 때 다시 시작하기

	# 최초 watcher를 시작한다
	watch: build start
		fswatch src "make reload"
		@echo "=========================== start watch"

	# 디렉토리 변경이 감지되면 실행될 task
	reload: stop build start
		@echo "---------------- reloaded"

	build:
		# build source

	start:
		# server start

	stop:
		# server stop

Coffeescript처럼 Compile이 필요한 언어와 Node.js처럼 실행이 필요한 서버가 맞물렸을 때 사용할만 하다.

src의 소스가 수정될 때 마다 서버를 정지시키고, 소스를 빌드하고, 다시 서버를 실행시키는 작업을 한다.

[fswatch]: https://github.com/alandipert/fswatch
[Makefile]: ../Shell/make.md