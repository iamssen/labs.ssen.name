var parseString = require('xml2js').parseString
	, fs = require('fs')
	, path = require('path')
	, S = require('string')
	, redis = require('redis').createClient()
	, async = require('async')

var NS = 'labs:pages'

/*
 NS (Hash) {path : content}
 hset NS path value

 @path /dir/title.html
 @content escaped html body
 */

function log() {
	var args = ['[push-to-redis]']
	for (var i = 0; i < arguments.length; i++) {
		args.push(arguments[i])
	}
	console.log.apply(null, args)
}

module.exports = function (file, done) {

	function existsHash(callback) {
		log('existsHash')
		redis.keys(NS, function (err, keys) {
			callback(err, keys.length > 0)
		})
	}

	function deleteHash(exists, callback) {
		log('deleteHash', exists)

		if (exists) {
			redis.del(NS, function (err) {
				callback(err)
			})
		} else {
			callback()
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

	async.waterfall([existsHash, deleteHash, readArticles], function (err, articles) {
		if (err) {
			done(err)
			return
		}

		async.eachSeries(articles, function (article, callback) {
			var title = article.title[0]
				, id = decodeURIComponent(article.url[0])
				, url = article.url[0]
				, content = S(S(article.content[0]).stripTags().s).unescapeHTML().s
				, searchText = title + '\n' + content

			redis.hset(NS, url, searchText.toLowerCase(), function (err) {
				log(err, url, title)
				callback(err)
			})
		}, function (err) {
			redis.quit()
			done(err)
		})
	})
}