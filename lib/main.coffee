## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
## dependent
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
os =require('os')
path = require('path')
express = require('express')

{Source, MarkdownBinder, DataPublisher, JadeTemplatePublisher} = require('markdown-binder')

port = 9888

for arg in process.argv
	if arg.indexOf('port=') is 0
		port = parseInt(arg.substr(5))

console.log("port is #{port}")

## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
## express
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
app = express()

## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
## markdown binders
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
jadeTemplatePublisher = new JadeTemplatePublisher('SSen')
jadeTemplatePublisher.debug = false
jadeTemplatePublisher.googleAnalyticsId = 'UA-1671969-2'
jadeTemplatePublisher.shareaholicApiKey = '94511b8f3c254a0224f2b9e2c8a38e83'
jadeTemplatePublisher.shareaholicAppId = '105914'
#jadeTemplatePublisher.facebookAppId = '281158822026421'
#jadeTemplatePublisher.primaryHost = 'http://ssen.name'

dataPublisher = new DataPublisher

publishers = [
	dataPublisher
	jadeTemplatePublisher
]

unicodeNormalize = os.platform().toLowerCase() is 'darwin'

labs = new Source(unicodeNormalize, path.join(process.env.DROPBOX, 'Contents', 'labs'))
labsBinder = new MarkdownBinder(labs, publishers, 'SSen의 연구실', 'SSen의 연구실 입니다')
labs.loadSourceDirectory()

## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
## router
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
app.get '*', (req, res, next) ->
	uri = req.params[0]

	# google web master tools
	if uri is '/googlecde4379f06bd686f.html'
		res.send('google-site-verification: googlecde4379f06bd686f.html')
	# /files/* static contents
	else if uri.indexOf('/files') is 0
		res.sendfile(path.join(process.env.DROPBOX, 'Contents', uri.substr(1)))
	# markdown binder
	else
		labsBinder.service(req, res)

## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
## app start
## ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
app.listen(port)

task = ->
	labs.loadSourceDirectory() 

setInterval task, 1000 * 60 * 15

process.on 'uncaughtException', (err) ->
	console.log('Caught exception: ' + err)