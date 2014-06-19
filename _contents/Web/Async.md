---
primary: 4709d75c1e
date: '2013-07-10 12:45:29'

---

# [Async.js]

javascript 의 비동기 로직을 좀 더 손쉽게 작성할 수 있게 해주는 library

Node.js와 Browser 에서 모두 사용 가능한 **Javascript 언어를 보강하는** 형태의 라이브러리이다.

install `npm install async`

[Async.js]: https://github.com/caolan/async

# Control Flow 의 선택

- 같은 task 를 반복 실행한다
	- 조건에 의해 실행을 멈춘다
		- `whilst(function test, function task, function callback = null) : void`
	- 특정 숫자만큼 반복 실행한다
		- task 들을 일괄 실행한다
			- `times(int loop, function task, function callback = null) : void`
		- task 들을 순차적으로 실행한다 (부하 분산)
			- `timesSeries(int loop, function task, function callback = null) : void`
- 다른 task 들을 실행한다
	- task 간에 의존성이 있다 (즉 task1 의 실행 결과가 task2 에 영향을 미친다)
		- `waterfall([function] tasks, function callback = null) : void`
	- task 간에 연계가 없다
		- task 들을 순차적으로 실행한다 (부하 분산)
			- `series([function] tasks, function callback = null) : void`
		- task 들을 일괄 실행한다 (비동기 작업 일괄 실행 후 수집)
			- 부하 걱정이 없다
				- `parallel([function] tasks, function callback = null) : void`
			- 부하 걱정이 조금 있어서 실행 갯수 제한을 둔다
				- `parallelLimit([function] tasks, int limit, function callback = null) : void`
- 비동기 형태의 계산기를 만든다
	- `compose(function...) : function`

## whilst(function test, function task, function callback = null)

Closure

- `@test = function() : boolean`
- `@task = function(callback) : void`
	- `@callback = function(error) : void`
- `@callback = function(error) : void`

Sample

	f = 0
	fmax = 4

	test = ->
		++f < fmax
	task = (callback) ->
		timeout 100, ->
			callback()

	async.whilst test, task, (error) ->
		console.log('complete', error) 

Console Log

	complete undefined

## times(int loop, function task, function callback = null)

Closure

- `@task = function(int current, function next) : void`
	- `@next = function(error, * result) : void`
- `@callback = function(error, [*] results) : void`

Sample

	task = (current, next) ->
		console.log(current, getTimer())
		timeout 100, ->
			next(null, "value#{current}")

	async.times 4, task, (error, results) ->
		console.log(error, results)

Console Log

	0 1373420408136
	1 1373420408138
	2 1373420408138
	3 1373420408139
	null [ 'value0', 'value1', 'value2', 'value3' ]

## timesSeries(int loop, function task, function callback = null)

구성은 `times` 랑 동일하다

다만, task 들이 일괄 실행되는 `times` 와 다르게, 순차적으로 실행됨을 확인할 수 있다

Console Log

	0 1373420497804
	1 1373420497919
	2 1373420498029
	3 1373420498136
	null [ 'value0', 'value1', 'value2', 'value3' ]

## waterfall([function] tasks, function callback = null)

task1 에서 뽑아낸 데이터로 task2 를 실행시키는 형태의 작업을 할때 유리하다

Closure

- `@tasks = [function(function callback) : void]`
	- `@callback = function(error, * result) : void`
- `@callback = function(error, * result) : void`

Sample

	tasks = []
	tasks.push (callback) ->
		console.log('1', new Date().getTime())
		timeout 100, -> callback(null, 'a')
	tasks.push (str, callback) ->
		console.log('2', new Date().getTime())
		timeout 100, -> callback(null, str + 'b')
	tasks.push (str, callback) ->
		console.log('3', new Date().getTime())
		timeout 100, -> callback(null, str + 'c')

	async.waterfall tasks, (err, result) ->
		console.log('waterfall', result)

Console Log

	1 1373423682924
	2 1373423683026
	3 1373423683133
	waterfall abc

## series([function] tasks, function callback = null)

Clouser

- `@tasks = { function(callback) : void }`
	- `@callback = function(error, * result) : void`
- `@callback = function(error, {result}) : void`

Sample

	tasks =
		one: (callback) ->
			timeout 100, ->
				console.log('1', new Date().getTime())
				callback(null, 1)
		two: (callback) ->
			timeout 100, ->
				console.log('2', new Date().getTime())
				callback(null, 2)
		three: (callback) ->
			timeout 100, ->
				console.log('3', new Date().getTime())
				callback(null, 3)

	async.series tasks, (err, result) ->
		console.log('series', result)

Console Log

	1 1373423974581
	2 1373423974695
	3 1373423974808
	series { one: 1, two: 2, three: 3 }

혹은 아래와 같이 Array 형태로 구성 할 수도 있다. 다만, 이 경우에는 명시적인 result 를 받기가 어렵기 때문에 단순 iteration 이 필요한 경우에 사용하는 것이 좋다 (Cakefile 의 exec 구성 같은 경우)

	tasks = []
	tasks.push (callback) -> timeout 100, callback
	tasks.push (callback) -> timeout 100, callback
	tasks.push (callback) -> timeout 100, callback
	tasks.push (callback) -> timeout 100, callback

	async.series tasks, (err, result) ->
		console.log('series', result)

		# series [ undefined, undefined, undefined, undefined ]

## parallel([function] tasks, function callback = null)

구성은 `series` 와 동일하다. 다만, 실행 시점을 보면 모든 task 들이 일괄 실행되는 것을 확인할 수 있다.

Sample

	async.parallel tasks, (err, result) ->
		console.log('parallel', result)

Console Log

	1 1373424144986
	2 1373424144993
	3 1373424144993  // 세개의 task 가 일괄 실행된다
	parallel { one: 1, two: 2, three: 3 }

## parallelLimit([function] tasks, int limit, function callback = null)

역시 `series` 와 동일하다. 실행 시점을 보면 task 들이 limit 로 넣은 갯수만큼 끊어서 실행되는 것을 확인할 수 있다.

Sample

	async.parallelLimit tasks, 2, (err, result) ->
		console.log('parallelLimit', result)

Console Log

	1 1373424329082
	2 1373424329090 // 여기까지 limit = 2 개의 task 만 끊어서 실행된다
	3 1373424329199
	parallelLimit { one: 1, two: 2, three: 3 }

## compose(function...) : function

다른 Control Flow 들과는 틀리게 숫자 계산을 위한 비동기 계산식을 만드는 역할을 가지고 있다

Closure

- `@functions = function(int n, function callback) : void`
	- `@callback = function(error, int result)`
- `return function = function(error, int result) : void`

Sample

	add1 = (n, callback) ->
		console.log(n, '+ 1', n + 1, new Date().getTime())
		timeout 100, -> callback(null, n + 1)

	mul3 = (n, callback) ->
		console.log(n, '* 3', n * 3, new Date().getTime())
		timeout 100, -> callback(null, n * 3)

	# (mul3, add1) = add1 > mul3 순서로 계산이 진행된다
	calc = async.compose(mul3, add1)

	calc 4, (err, result) ->
		console.log('compose', err, result)

Console Log

	4 '+ 1' 5 1373424677734
	5 '* 3' 15 1373424677850
	compose null 15
