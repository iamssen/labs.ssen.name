# 여러 function들을 차례로

	express = require('express')

	func1 = (req, res, next) ->
		console.log('function1')
		next()
		
	func2 = (req, res, next) ->
		console.log('function2')
		next()
		
	func3 = (req, res, next) ->
		console.log('function3')
		res.send('hello world')

	app = express()
	app.get('/aaa', func1, func2, func3)

	app.listen(9901)

`app.get()`에는 여러 `function(req, res, next)`들을 차례로 이어붙일 수 있다. 실제 마지막 서비스가 이루어지기 이전에 보안 등의 처리가 가능하다.

