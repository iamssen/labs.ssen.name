# Install

	sudo aptitude install jenkins 

이걸로 설치하면 망한다. 버전이 1.4xx로 낮다. 플러그인들이 왕창 작동하지 않는 불상사가 발생한다.

<https://wiki.jenkins-ci.org/display/JENKINS/Installing+Jenkins+on+Ubuntu> 이 url을 참고해서 설치해야 한다.

- `wget -q -O - http://pkg.jenkins-ci.org/debian/jenkins-ci.org.key | sudo apt-key add -`
- `sudo sh -c 'echo deb http://pkg.jenkins-ci.org/debian binary/ > /etc/apt/sources.list.d/jenkins.list'`
- `sudo aptitude update`
- `sudo aptitude install jenkins`

# Services

- `sudo service jenkins start`
- `sudo service jenkins stop`
- `sudo service jenkins restart`
- `sudo service jenkins status`


