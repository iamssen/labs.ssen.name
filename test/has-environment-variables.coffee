assert = require('assert')

describe 'has-environment-variables', ->
	it 'should exists all environment variables', ->
		assert.ok(process.env.DROPBOX)
		assert.ok(process.env.CONTAINER)
		assert.ok(process.env.NGINX_HOME)