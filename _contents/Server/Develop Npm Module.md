---
primary: 1613d3e7b7

---

# 구성도

- 작업 흐름 관리, 버전 관리 : [Git] + [Git-flow] + [SourceTree]
- 개발툴 : [Webstorm]
- 저장소 : [Github]
- 통합 서버 : [Travis-ci]

# Travis Npm api_key 설정

	brew install ruby
	subl ~/.config/fish/config.fish # $PATH에 /usr/local/opt/ruby 추가
	gem install travis-lint
	gem install travis
	travis encrypt --add

- <http://docs.travis-ci.com/user/deployment/npm/>
- <https://github.com/travis-ci/travis#readme>
- <http://blog.travis-ci.com/2013-10-02-continuous-deployment-pypi-npm-and-more/>



[Git]: https://github.com
[Git-flow]: VCS/git-flow.md
[SourceTree]: http://www.sourcetreeapp.com
[Github]: https://github.com
[Travis-ci]: https://travis-ci.org