CONTENTS = _contents
APP = _app
SOURCE = _source
SITE = _site


# base
# ---------------------------------
clean:
	rm -rf $(SOURCE) $(SITE)

create:
	mkdir -p _logs
	mkdir -p $(SOURCE)
	cp -r $(CONTENTS)/* $(SOURCE)
	cp -r $(APP)/* $(SOURCE)


# build with jenkins
# ---------------------------------
jenkins: clean create
	# build static site
	sudo -E gulp make-jekyll-source
	jekyll build --source $(SOURCE) --destination $(SITE)
	sudo -E gulp config-site
	rm -rf $(SOURCE)

	# build java webapp
	sudo -E sh gradlew buildAndDeployToWebapps

	# server reload
	sudo service nginx reload


# test
# ---------------------------------
test: clean create
	# build static site
	gulp make-jekyll-source
	jekyll build --source $(SOURCE) --destination $(SITE)
	gulp config-site
	rm -rf $(SOURCE)

	# build java webapp
	sh gradlew buildAndDeployToWebapps

	# server reload
	nginx -s reload



