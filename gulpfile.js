var gulp = require('gulp')
	, es = require('event-stream')
	, fs = require('fs')
	, unorm = require('unorm')
	, os = require('os')
	, path = require('path')
	, yaml = require('yamljs')
	, moment = require('moment')
	, exec = require('done-exec')
	, hogan = require('hogan.js')

var envs = {
	DOMAIN: fs.readFileSync(path.join(__dirname, 'CNAME'), 'utf8').split('\n').join(' '),
	PORT: process.env.PORT || 9888,
	ROOT: path.resolve(__dirname, '_site'),
	NGINX_HOME: process.env.NGINX_HOME || path.join(__dirname, '_nginx'),
	PROJECT: process.env.JOB_NAME || 'labs.ssen.name',
	VERSION: process.env.GIT_COMMIT || '-1',
	NFD: os.platform().toLowerCase() == 'darwin'
}

function nfc(str) {
	return (envs.NFD) ? unorm.nfc(str) : str;
}

function tagging() {
	function func(file) {
		var fpath = file.path
			, extension = path.extname(fpath).toLowerCase()
			, stat = fs.statSync(fpath)
			, mtime = stat.mtime.getTime()

		var info = {
			realpath: fpath,
			path: nfc(fpath).replace(/\\/g, '/'),
			// relative_path: nfc(path.relative(@top, fpath)).replace(/\\/g, '/'),
			base: nfc(path.dirname(fpath)).replace(/\\/g, '/'),
			// relative_base: nfc(path.relative(@top, path.dirname(fpath))).replace(/\\/g, '/'),
			name: nfc(path.basename(fpath, extension)),
			extension: extension,
			atime: stat.atime,
			mtime: stat.mtime,
			ctime: stat.ctime
		}

		var body = file.contents.toString('utf8')
			, reg = /^(-{3}(?:\n|\r)([\w\W]+?)-{3})?([\w\W]*)*/
			, results = reg.exec(body)
			, frontmatter
			, hasFrontmatter = results[2] != null

		if (hasFrontmatter) {
			frontmatter = yaml.parse(results[2])
		} else {
			frontmatter = {}
		}

		if (frontmatter['title'] == null) frontmatter['title'] = info.name
		if (frontmatter['date'] == null) frontmatter['date'] = moment(info.mtime).format('YYYY-MM-DD HH:mm:ss')
		if (frontmatter['layout'] == null) frontmatter['layout'] = 'page'

		if (hasFrontmatter) {
			body = body.replace(results[1], '----\n' + yaml.stringify(frontmatter) + '\n----')
		} else {
			body = '----\n' + yaml.stringify(frontmatter) + '\n----' + '\n\n' + body
		}

		file.contents = new Buffer(body)

		this.emit('data', file)
	}

	return es.through(func)
}

function makePrimaryHex(length) {
	var arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f']
		, result = ''
	for (var i = 0; i < length; i++) {
		result += arr[parseInt(Math.random() * arr.length)]
	}
	return result
}

function makePrimaryKeys() {
	function func(file) {
		var body = file.contents.toString('utf8')
			, reg = /^(-{3}(?:\n|\r)([\w\W]+?)-{3})?([\w\W]*)*/gm
			, results = reg.exec(body)
			, frontmatter
			, hasFrontmatter = results[2] != null

		console.log(results)

		if (hasFrontmatter) {
			frontmatter = yaml.parse(results[2])
		} else {
			frontmatter = {}
		}

		if (frontmatter['primary'] == null) {
			frontmatter['primary'] = makePrimaryHex(10)
		}

		if (hasFrontmatter) {
			body = body.replace(results[1], '---\n' + yaml.stringify(frontmatter) + '\n---')
		} else {
			body = '---\n' + yaml.stringify(frontmatter) + '\n---' + '\n\n' + body
		}

		file.contents = new Buffer(body)

		console.log(body)

		this.emit('data', file)
	}

	return es.through(func)
}

gulp.task('test', function() {
	gulp.src('./_docs/Server/Java/*.md')
		.pipe(makePrimaryKeys())
});

function render(envs) {
	function func(file) {
		file.contents = new Buffer(hogan.compile(file.contents.toString('utf8')).render(envs))
		this.emit('data', file)
	}

	return es.through(func)
}

gulp.task('make-primary-keys', function() {
	gulp.src('./_docs/**/*.md')
		.pipe(makePrimaryKeys())
		.pipe(gulp.dest('_docs'))
})

gulp.task('clone-to-source', function(){
	gulp.src('./_docs/**/*.md')
		.pipe(tagging())
		.pipe(gulp.dest('_source'))
})

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

gulp.task('make-source', ['make-primary-keys', 'clone-to-source'])
gulp.task('config-server', ['make-server-config', 'link-nginx-config'])