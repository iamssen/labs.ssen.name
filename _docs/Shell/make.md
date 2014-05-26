# 소개

`Shell Script` 기반의 빌드 도구

원래는 c계열 빌드 도구인듯 싶지만, c언어를 사용하지 않는 나에게는 단순 `Shell Command` 압축기일 뿐이다.

비교가 될만한 여러 녀석들이 있긴 하지만...

- `jake`, `cake`: Javascript 기반이라서 비동기 특성이 있다. 빌드용으로 쓰기엔 무리...
- `ant`: 읽기 더러운 xml...
- `scons`: 너무 고급화 되어서 `Shell Command` 압축용으로 쓰기엔 무리...
- `rake`: 단순하게 쓰기에 좋고, 언어도 `Ruby` 기반이라서 좋긴 하다. 비교를 해보자면
	- 당연히 `make`보다 코드는 더러워진다. `make`의 특성 상, `Shell Command`를 그냥 적는 수준이기 때문에.
	- 다만, 뭔가 연산질을 해야한다면 한결 수월해진다. `Shell Script` 자체가 상당히 익숙해지기 어려운 면이 많기 때문에.
	- 하지만, `Un*x` 계열 System을 쓰게 되는 이상 `make` 말고도 `Shell Script` 작성해야 하는 일은 많다. (니기미...)

참고자료: [make vs rake vs scons vs ant](http://hyperpolyglot.org/build)

이런 특성들에 더해서, Github 같은데만 돌아도 알만한게 너도 나도 죄다 `Makefile`을 쓰고, `Un*x`를 쓰는 이상 `Shell Script`는 결국 마주칠 수 밖에 없기 때문에 결국은 `make`로 되돌아오게 된다. (벗어나려 해도 결국 되돌아오게 되는 개미지옥...)

부차적으로 Eclipse 나 Web Storm 같은 IDE의 빌드 기능을 최대한 이용해보는 수도 있지만, 빌드 구조가 조금만 복잡해져도 다시 `make`가 필요해지게 된다.

참고로 `make`로 대충 쓰기 힘든 수준에 이른다면 그냥 Script 언어를 써서 프로그램을 만드는게 더 낫다.


# 기본 구조

	# {작업}: {먼저 실행 해둬야 하는 작업} {먼저 실행 해둬야 하는 작업}
	task1: task2 task3
		@echo "Task 1"

	task2:
		@echo "Task 2"

	task3:
		@echo "Task 3"


간단하게 위와 같은 구성으로 `Makefile`을 만들었을 때. 대충 사용해 보자면

	$ make task1
	Task 2
	Task 3
	Task 1
	$ make task2
	Task 2
	$ make task3
	Task 3

위와 같이 사용이 가능해진다. 


# 참고 자료들

- [Make 기반 빌드 시스템](http://developinghappiness.com/?page_id=222)


# 변수의 사용

변수는 시스템 전반에 영향을 미치는 환경 변수(environment variable)와 걍 지역 변수가 있다.

둘 모두 `$(name)` 으로 사용이 가능하다.

	local = 'local variable'

	task:
		@echo "print: $(local)"
		@echo "print: $(global)"


# 디렉토리 확인

	task:
		if test -d dir/dir;\
		then @echo "exists directory";\
		else @echo "not exists directory";\
		fi


