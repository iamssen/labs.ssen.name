CONTENTS = _contents
APP = _app
SOURCE = _source
SITE = _site

# build with jenkins
# ---------------------------------
jenkins: clean create
	sudo -E gulp before-jekyll
	jekyll build --source $(SOURCE) --destination $(SITE)
	sudo -E gulp after-jekyll
	sudo -E sh gradlew buildAndDeployToWebapps
	sudo service nginx reload


# base
# ---------------------------------
clean:
	rm -rf $(SOURCE) $(SITE)

create:
	mkdir -p _logs
	mkdir -p $(SOURCE)
	cp -r $(CONTENTS)/* $(SOURCE)
	cp -r $(APP)/* $(SOURCE)


# test
# ---------------------------------
test: clean create
	echo $(WAS_WEBAPPS)

	gulp before-jekyll
	jekyll build --source $(SOURCE) --destination $(SITE)
	gulp after-jekyll
	sh gradlew buildAndDeployToWebapps
	nginx -s reload

