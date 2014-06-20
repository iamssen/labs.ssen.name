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
	, gutil = require('gulp-util')
	, sass = require('gulp-ruby-sass')

// ====================================================
// config
// ====================================================
var envs = {
	// service environment variables
	DOMAIN: fs.readFileSync(path.join(__dirname, 'CNAME'), 'utf8').split('\n').join(' '),
	NFD: os.platform().toLowerCase() == 'darwin',
	SITE: path.resolve(__dirname, '_site'),
	LOG_HOME: path.join(__dirname, '_logs'),

	// using system environment variables
	PORT: process.env.PORT || 9888,
	WAS_PORT: process.env.WAS_PORT,
	WAS_WEBAPPS: process.env.WAS_WEBAPPS,
	NGINX_HOME: process.env.NGINX_HOME,
	PROJECT: process.env.JOB_NAME || 'labs.ssen.name',
	VERSION: process.env.GIT_COMMIT || '-1'
}

// test config
if (os.platform().toLowerCase() === 'darwin') {
	envs.DOMAIN = 'localhost'
}

// ====================================================
// functions
// ====================================================
function nfc(str) {
	return (envs.NFD) ? unorm.nfc(str) : str;
}

function makePrimaryHex(length) {
	var arr = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f']
		, result = ''
	for (var i = 0; i < length; i++) {
		result += arr[parseInt(Math.random() * arr.length)]
	}
	return result
}

// ====================================================
// pipe plugins
// ====================================================
// auto tagging to markdown file
// - title
// - date
// - layout
// - categories
function tagging() {
	function func(file) {
		var fpath = file.path
			, extension = path.extname(fpath).toLowerCase()
		// , stat = fs.statSync(fpath)
		// , mtime = stat.mtime.getTime()
			, SOURCE_TOP = path.join(__dirname, '_source')
			, CONTENTS_TOP = path.join(__dirname, '_contents')

		var info = {
			realpath: fpath,
			path: nfc(fpath).replace(/\\/g, '/'),
			relative_path: nfc(path.relative(CONTENTS_TOP, fpath)).replace(/\\/g, '/'),
			base: nfc(path.dirname(fpath)).replace(/\\/g, '/'),
			relative_base: nfc(path.relative(CONTENTS_TOP, path.dirname(fpath))).replace(/\\/g, '/'),
			name: nfc(path.basename(fpath, extension)),
			extension: extension
//			atime: stat.atime,
//			mtime: stat.mtime,
//			ctime: stat.ctime
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

		console.log('[tagging]', frontmatter['primary'], info.relative_path)

		if (frontmatter['title'] == null) frontmatter['title'] = info.name
		if (frontmatter['date'] == null) frontmatter['date'] = moment(info.ctime).format('YYYY-MM-DD HH:mm:ss')
		if (frontmatter['layout'] == null) frontmatter['layout'] = 'article'

		// frontmatter['relative_path'] = info.relative_path
		// frontmatter['relative_base'] = info.relative_base
		// frontmatter['realpath'] = info.realpath
		// frontmatter['url'] = '/' + info.relative_base + '/' + info.name + '.html'
		frontmatter['categories'] = info.relative_base.split('/')

		if (hasFrontmatter) {
			body = body.replace(results[1], '---\n' + yaml.stringify(frontmatter) + '\n---')
		} else {
			body = '---\n' + yaml.stringify(frontmatter) + '\n---' + '\n\n' + body
		}

		file.contents = new Buffer(body)
		// file.path = path.join(SOURCE_TOP, '_posts', moment(info.mtime).format('YYYY-MM-DD-') + frontmatter['primary'] + '.md')

		this.emit('data', file)
	}

	return es.through(func)
}

// auto primary key tagging to markdown file
// - primary
function makePrimaryKeys() {
	function func(file) {
		// console.log('# make primary keys', file.path)
		var body = file.contents.toString('utf8')
			, reg = /^(-{3}(?:\n|\r)([\w\W]+?)-{3})?([\w\W]*)*/gm
			, results = reg.exec(body)
			, frontmatter
			, hasFrontmatter = results[2] != null
			, fpath = file.path
			, stat = fs.statSync(fpath)

		if (hasFrontmatter) {
			frontmatter = yaml.parse(results[2])
		} else {
			frontmatter = {}
		}

		if (!frontmatter['primary'] || !frontmatter['date']) {
			if (!frontmatter['primary']) {
				frontmatter['primary'] = makePrimaryHex(10)
			}

			if (!frontmatter['date']) {
				frontmatter['date'] = moment(stat.mtime).format('YYYY-MM-DD HH:mm:ss')
			}

			if (hasFrontmatter) {
				body = body.replace(results[1], '---\n' + yaml.stringify(frontmatter) + '\n---')
			} else {
				body = '---\n' + yaml.stringify(frontmatter) + '\n---' + '\n\n' + body
			}

			// save file directly
			fs.writeFileSync(fpath, body, {encoding:'utf8'})

			file.contents = new Buffer(body)
		}

		this.emit('data', file)
	}

	return es.through(func)
}

// mustache rendering
function renderMustache(envs) {
	function func(file) {
		file.contents = new Buffer(hogan.compile(file.contents.toString('utf8')).render(envs))
		file.path = gutil.replaceExtension(file.path, '')

		this.emit('data', file)
	}

	return es.through(func)
}

// ====================================================
// tasks
// ====================================================
//gulp.task('add-primary-key-to-markdown-if-not-exists', function () {
//	gulp.src('_contents/**/*.md')
//		.pipe(makePrimaryKeys())
//		.pipe(gulp.dest('_contents'))
//})
//
//gulp.task('copy-markdown-to-jekyll-source-directory-with-tagging', function () {
//	gulp.src('_contents/**/*.md')
//		.pipe(tagging())
//		.pipe(gulp.dest('_source'))
//})

gulp.task('build-mustache-templates', function () {
	gulp.src('./**/*.mustache')
		.pipe(renderMustache(envs))
		.pipe(gulp.dest('.'))
})

gulp.task('symlink-nginx-config', function (done) {
	var SITE_ENABLED = path.join(envs.NGINX_HOME, 'sites-enabled')
		, source = path.join(__dirname, 'nginx.conf')
		, linkto = path.join(SITE_ENABLED, envs.PROJECT)

	console.log('[nginx config symlink to]', source, linkto)

	var sudo = (os.platform().toLowerCase() === 'darwin') ? '' : 'sudo '
	exec(sudo + 'ln -sf "' + source + '" "' + linkto + '"').run(done)
})

gulp.task('push-data-to-search-engine', function (done) {
	require('./push-to-redis')(path.join(envs.SITE, 'search.xml'), done)
	// require('./push-to-elasticsearch')(path.join(envs.SITE, 'search.xml'), done)
	// done()
})

// ------------------------------------
// runnable tasks
// ------------------------------------
gulp.task('make-jekyll-source', function() {
	gulp.src('_contents/**/*.md')
		.pipe(makePrimaryKeys())
		.pipe(tagging())
		.pipe(gulp.dest('_source'))
})
//gulp.task('make-jekyll-source', ['add-primary-key-to-markdown-if-not-exists', 'copy-markdown-to-jekyll-source-directory-with-tagging'])
gulp.task('config-site', ['push-data-to-search-engine', 'build-mustache-templates', 'symlink-nginx-config'])

// ------------------------------------
// develop tasks
// ------------------------------------
gulp.task('copy-assets', function () {
	gulp.src('_contents/assets/**/*')
		.pipe(gulp.dest('_site/assets/'))
})

gulp.task('copy-scss', function () {
	gulp.src('_contents/assets/*.scss')
		.pipe(sass({ loadPath: '_contents/assets/' }))
		.pipe(gulp.dest('_site/assets/'))
})

gulp.task('compile', function (done) {
	exec('make test-compile').run(done)
})

gulp.task('watch', function () {
	gulp.watch('_contents/**/*', ['compile'])
})

gulp.task('test', ['push-to-elasticsearch', 'timeout-test'])