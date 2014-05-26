jenkins: build
	sudo -E gulp config-server
	sudo service nginx reload

build: clean copy
	sudo -E gulp make-source
	jekyll build --source _source --destination _site

clean:
	rm -rf _source _site

copy:
	cp -r contents _source

test: clean copy
	gulp make-source
	jekyll build --source _source --destination _site

