var gulp = require('gulp')
	, exec = require('done-exec')
	, path = require('path')
	, hogan = require('hogan.js')
	, es = require('event-stream')
	, fs = require('fs')

var envs = {
	DOMAIN: fs.readFileSync(path.join(__dirname, 'CNAME'), 'utf8').split('\n').join(' '),
	PORT: process.env.PORT || 9887,
	ROOT: path.resolve(__dirname),
	NGINX_HOME: process.env.NGINX_HOME || path.join(__dirname, '_nginx'),
	PROJECT: process.env.JOB_NAME || 'files.ssen.name',
	VERSION: process.env.GIT_COMMIT || '-1'
}

function render(envs) {
	function func(file) {
		file.contents = new Buffer(hogan.compile(file.contents.toString('utf8')).render(envs))
		this.emit('data', file)
	}

	return es.through(func)
}

gulp.task('make-server-config', function () {
	gulp.src('./_server-templates/*')
		.pipe(render(envs))
		.pipe(gulp.dest(__dirname))
})

gulp.task('link-nginx-config', function (done) {
	var SITE_ENABLED = path.join(envs.NGINX_HOME, 'sites-enabled')
		, source = path.join(__dirname, 'nginx.conf')
		, linkto = path.join(SITE_ENABLED, envs.PROJECT)

	console.log('[nginx config symlink to]', source, linkto)

	exec('sudo ln -sf "' + source + '" "' + linkto + '"').run(done)
})

gulp.task('config-server', ['make-server-config', 'link-nginx-config'])