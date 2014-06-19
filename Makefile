CONTENTS = _contents
APP = _app
SOURCE = _source
SITE = _site
TEMPLATES = src/main/resources/templates

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
	# fucking rvm load
	/bin/sh -c "source $(HOME)/.rvm/scripts/rvm"

	# npm dependency
	sudo npm install
	sudo npm update

	# build static site
	sudo -E gulp make-jekyll-source
	jekyll build --source $(SOURCE) --destination $(SITE)
	sudo -E gulp config-site
	cp $(SITE)/search.html $(TEMPLATES)/search.html
	rm -rf $(SOURCE)

	# build java webapp
	sudo -E gradle buildAndDeployToWebapps

	# server reload
	sudo service nginx reload


# test
# ---------------------------------
test: clean create
	# build static site
	gulp make-jekyll-source
	jekyll build --source $(SOURCE) --destination $(SITE)
	gulp config-site
	cp $(SITE)/search.html $(TEMPLATES)/search.html
	rm -rf $(SOURCE)

	# build java webapp
	sh gradlew buildAndDeployToWebapps

	# server reload
	nginx -s reload




# dev test
devtest:
	echo $(TEST_VAR)
	node sample.js
	echo $(TEST_VAR)


