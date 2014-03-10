fs = require('fs')
randomport = require('randomport')
Hogan = require('hogan.js')
forever = require('forever')
path = require('path')

module.exports = (grunt) ->

	$ = grunt.template.process

	# ====================================================
	# load npm tasks
	# ====================================================
	grunt.loadNpmTasks('grunt-contrib-copy')
	grunt.loadNpmTasks('grunt-contrib-clean')
	grunt.loadNpmTasks('grunt-mocha-test')
	grunt.loadNpmTasks('grunt-shell')

	# ====================================================
	# config npm tasks
	# ====================================================
	grunt.initConfig
		copy:
			'to-container':
				files: [
					{
						expand: true,
						src: ['lib/*'],
						dest: '<%= CONTAINER %>/<%= PROJECT %>/<%= VERSION %>',
						filter: 'isFile'
					}
				]
		clean:
			'current-build':
				options:
					force: true
				src: [
					'<%= NGINX_HOME %>/sites-enabled/<%= PROJECT %>'
					'<%= CONTAINER %>/<%= PROJECT %>/<%= VERSION %>'
				]

		mochaTest:
			options:
				require: ['coffee-script', 'should']
			src: ['test/**/*.coffee']

		shell:
			'reload-nginx-server':
				command: 'sudo service nginx reload'
			'reload-nginx-local':
				command: 'nginx -s reload'

	# ------------------------------------
	# get environment variables
	# ------------------------------------
	grunt.registerTask 'get-envs', (subtask) ->
		done = @async()

		grunt.config.set('WORKSPACE', __dirname)
		grunt.config.set('NGINX_HOME', process.env.NGINX_HOME)
		grunt.config.set('CONTAINER', process.env.CONTAINER)
		grunt.config.set('DROPBOX', process.env.DROPBOX)

		if subtask is 'local'
			grunt.config.set('DOMAIN', 'localhost')
			grunt.config.set('PROJECT', 'labs.ssen.name')
			grunt.config.set('BRANCH', 'origin/master')
			grunt.config.set('VERSION', '1')
			grunt.config.set('PORT', 9888)
		else if subtask is 'jenkins'
			grunt.config.set('DOMAIN', 'labs.ssen.name')
			grunt.config.set('PROJECT', process.env.JOB_NAME)
			grunt.config.set('BRANCH', process.env.GIT_BRANCH)
			grunt.config.set('VERSION', process.env.GIT_COMMIT)
			grunt.config.set('PORT', 80)

		randomport 13000, 18000, (port) ->
			grunt.config.set('NODE_PORT', port)
			done()

	# kill server
	grunt.registerTask 'kill', ->
		pidFile = $('<%= CONTAINER %>/<%= PROJECT %>/pid')
		if grunt.file.exists(pidFile)
			done = @async()

			pid = grunt.file.read((pidFile), {encoding:'utf8'})

			forever.list false, (error, list) ->
				if error?
  					throw new Error('kill failed')
 +				else if not list? or list.length is 0
 +					grunt.file.delete(pidFile, {force:true})

				for index in [0..list.length-1]
					proc = list[index]
					if pid is proc.pid.toString()
						emitter = forever.stop(index)
						emitter.on 'stop', (proc) ->
							done()
							console.log("kill process #{index}")
							console.log(proc)

	# start server
	grunt.registerTask 'start', ->
		options =
			command: 'coffee'
			pidFile: $('<%= CONTAINER %>/<%= PROJECT %>/pid')
			logFile: $('<%= CONTAINER %>/<%= PROJECT %>/<%= VERSION %>.log')
			options: [ $('port=<%= NODE_PORT %>') ]

		forever.startDaemon($('<%= CONTAINER %>/<%= PROJECT %>/<%= VERSION %>/lib/main.coffee'), options)
		console.log($('<%= CONTAINER %>/<%= PROJECT %>/<%= VERSION %>/lib/main.coffee'), options)

	# make nginx.conf
	grunt.registerTask 'create-nginx-conf', ->
		data =
			DOMAIN: grunt.config.get('DOMAIN')
			DROPBOX: grunt.config.get('DROPBOX')
			NODE_PORT: grunt.config.get('NODE_PORT')
			PORT: grunt.config.get('PORT')

		template = Hogan.compile(grunt.file.read('deploy/nginx.conf.template', {encoding:'utf8'}))
		conf = $('<%= CONTAINER %>/<%= PROJECT %>/nginx.conf')
		grunt.file.write(conf, template.render(data), {encoding:'utf8'})
		console.log('exists', grunt.file.exists(conf))

	# link nginx.conf
	grunt.registerTask 'link-nginx-conf', ->
		srcpath = $('<%= CONTAINER %>/<%= PROJECT %>/nginx.conf')
		dstpath = $('<%= NGINX_HOME %>/sites-enabled/<%= PROJECT %>')
		fs.symlinkSync(srcpath, dstpath)

	# link node_modules
	grunt.registerTask 'link-node-modules', ->
		srcpath = $('<%= WORKSPACE %>/node_modules')
		dstpath = $('<%= CONTAINER %>/<%= PROJECT %>/<%= VERSION %>/node_modules')
		fs.symlinkSync(srcpath, dstpath)

	# ====================================================
	# test
	# ====================================================
	grunt.registerTask 'trace', ->
		console.log(grunt.config.get('WORKSPACE'))
		console.log(grunt.config.get('NGINX_HOME'))
		console.log(grunt.config.get('CONTAINER'))
		console.log(grunt.config.get('DROPBOX'))
		console.log(grunt.config.get('DOMAIN'))
		console.log(grunt.config.get('PROJECT'))
		console.log(grunt.config.get('BRANCH'))
		console.log(grunt.config.get('VERSION'))
		console.log(grunt.config.get('PORT'))

	# ====================================================
	# tasks
	# ====================================================
	# jenkins task
	grunt.registerTask 'jenkins', ->
		tasks = [
			'get-envs:jenkins'
			'trace'
			'mochaTest'
			'jenkins-release'
		]

		grunt.task.run(tasks)

	grunt.registerTask 'jenkins-release', ->
		if grunt.config.get('BRANCH').lastIndexOf('/master') > -1
			tasks = [
				'kill'
				'clean:current-build'
				#'coffee:compile-lib'
				'copy:to-container'
				'link-node-modules'
				'start'
				'create-nginx-conf'
				'link-nginx-conf'
				'shell:reload-nginx-server'
			]

			grunt.task.run(tasks)

	# local task
	grunt.registerTask 'default', ->
		tasks = [
			'get-envs:local'
			'trace'
			'mochaTest'
			'kill'
			'clean:current-build'
			#'coffee:compile-lib'
			'copy:to-container'
			'link-node-modules'
			'start'
			'create-nginx-conf'
			'link-nginx-conf'
			'shell:reload-nginx-local'
		]

		grunt.task.run(tasks)
