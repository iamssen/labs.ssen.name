var parseString = require('xml2js').parseString
	, fs = require('fs')
	, path = require('path')
	, S = require('string')
	, elasticsearch = require('elasticsearch')
	, async = require('async')

var INDEX = 'labs'
var TYPE = 'pages'

function log() {
	var args = ['[push-to-elasticsearch]']
	for (var i = 0; i < arguments.length; i++) {
		args.push(arguments[i])
	}
	console.log.apply(null, args)
}

module.exports = function (file, done) {
	var ec = new elasticsearch.Client({
		host: 'localhost:9200',
//		log: 'trace',
		keepAlive: false
	})

//	done()
//	return

	function existsType(callback) {
		log('existsType')
		ec.indices.existsType({
			index: INDEX,
			type: TYPE
		}, function (err, exists, status) {
			callback(err, exists)
		})
	}

	function deleteType(exists, callback) {
		log('deleteType', exists)
		if (exists) {
			ec.indices.deleteMapping({
				index: INDEX,
				type: TYPE
			}, function (err, response) {
				if (err) {
					callback(err)
				} else {
					callback(null)
				}
			})
		} else {
			callback(null)
		}
	}

	function readArticles(callback) {
		log('readArticles')

		if (fs.existsSync(file)) {
			parseString(fs.readFileSync(file, 'utf8'), function (error, result) {
				if (error) {
					callback(error)
					return
				} else {
					var articles = result.xml.articles[0].article
					callback(null, articles)
				}
			})
		} else {
			callback(new Error('undefined search.xml'))
		}
	}

	async.waterfall([existsType, deleteType, readArticles], function (err, articles) {
			if (err) {
				done(err)
				return
			}

			async.eachSeries(articles, function (article, callback) {
				var title = article.title[0]
					, id = decodeURIComponent(article.url[0])
					, url = article.url[0]
					, content = S(S(article.content[0]).stripTags().s).unescapeHTML().s

				ec.create({
					index: INDEX,
					type: TYPE,
					id: id,
					body: {
						title: title,
						url: url,
						content: content
					}
				}, function (err, response, status) {
					log(status, response._id)
					callback(err)
				})
			}, function (err) {
				done(err)
			})
		}
	)
}