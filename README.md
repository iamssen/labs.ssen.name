# [labs.ssen.name]

[![Dependency Status](https://gemnasium.com/iamssen/labs.ssen.name.png)](https://gemnasium.com/iamssen/labs.ssen.name)

SSen의 연구 파일들을 올리는 웹사이트 입니다.

사용되고 있는 기술들은 아래와 같습니다.

- Github: 웹사이트의 소스파일을 호스팅 합니다.
- Jenkins CI: Github의 Web Hook을 받아서 Repository를 갱신하고, Grunt를 실행시킵니다.
- Grunt.js: Mocha Test 및 Node.js 실행, NginX 갱신 등을 담당합니다.
- Node.js + Coffeescript: 기본 Node.js 와 express.js를 통해 웹서비스를 구동합니다.
- NginX: Node.js 웹서비스의 Reverse Proxy 기능을 하고, Static File들을 호스팅 합니다.
- Dropbox Linux Command-line Client: Markdown 문서들과 각 종, 파일들을 동기화 시킵니다.

# Dropbox 동기화에 대한 평가

내용을 담당하는 파일들은 Dropbox를 통해 동기화 되고 있습니다.

장점으로는 Mac과 Windows, Linux 환경을 모두 사용하는 입장에서

- UTF8의 NFD, NFC 문제에서 자유롭다 (즉, 한글 파일명 문제에서 자유롭다)
- 편리한 자동 동기화

이정도 이긴 하지만, 문제는 **가끔가다 동기화가 제대로 되지 않는 (Conflict 문제에서 시작되는듯...)** 문제가 발생합니다.

다만, 현재 시점에서 다양한 OS에서 발생하는 한글 파일명 문제에 대응하기에 마땅한 대안이 없긴 합니다.

# Github, Jenkins, Grunt.js를 사용하는 Test, Build, Deploy 자동화

Github를 향해서 Push만 날려주면 웹사이트의 모든 갱신이 자동으로 이루어지도록... 이라는 목표하에 구성된 조합입니다.

과연 이렇게까지 해야하나... 라는 의문이 들긴 하지만...



[labs.ssen.name]: http://labs.ssen.name