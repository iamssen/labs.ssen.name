---
primary: b45452fae8
date: '2014-01-25 03:13:13'

---

# Install

- `sudo wget -O /etc/yum.repos.d/jenkins.repo http://pkg.jenkins-ci.org/redhat/jenkins.repo`
- `sudo rpm --import http://pkg.jenkins-ci.org/redhat/jenkins-ci.org.key`
- `sudo yum install jenkins`

# Services

- `sudo service jenkins start`
- `sudo service jenkins stop`
- `sudo service jenkins restart`
- `sudo service jenkins status`

# 참고한 자료들

- <https://wiki.jenkins-ci.org/display/JENKINS/Installing+Jenkins+on+RedHat+distributions>