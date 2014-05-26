---
primary: 17b4a2fad1

---

# NginX 설치

CentOS가 사용하는 `yum`에는 기본적으로 `nginx`가 존재하지 않는다. 고로 repository를 추가시켜주는 작업부터 해야한다.

NginX 웹사이트에서 제안하는 방식은 기본적으로 <http://wiki.nginx.org/Install> 처럼 수동으로 `/etc/yum.repos.d/nginx.repo`를 생성시켜주는 방식이지만, 상당히 귀찮은고로 <http://www.cyberciti.biz/faq/install-nginx-centos-rhel-6-server-rpm-using-yum-command/>에서 제안하는 방식을 따르도록 한다.

- `wget http://nginx.org/packages/centos/6/noarch/RPMS/nginx-release-centos-6-0.el6.ngx.noarch.rpm` 그냥 wget으로 rpm 파일을 다운받는 것 뿐이다.
- `rpm -ivh nginx-release-centos-6-0.el6.ngx.noarch.rpm` rpm을 설치한다.
- `ls /etc/yum.repos.d/` 대충 확인해보면 `nginx.repo` 라는 파일이 생성되었음을 확인할 수 있다.
- `yum search nginx` 잘 모르겠으면 yum search를 해보면 nginx가 검색에 조회되는 것을 확인할 수 있다.

`nginx`가 `yum`에 등록되었으면 이제 설치를 하면 된다.

- `sudo yum install nginx` 설치가 진행된다
- `sudo service nginx status` 설치 이후 서비스 상태를 보면 멈춰있다
- `sudo service nginx start` 서비스를 시작한다

NginX 서비스를 시작한 뒤에 `http://localhost`로 접속해서 확인해 본다

NginX 설치 이후, 사용 가능한 명령어는 아래와 같다

- `sudo service nginx start`
- `sudo service nginx restart`
- `sudo service nginx stop`
- `sudo service nginx status`


# 참고한 자료들

- <http://wiki.nginx.org/Install>
- <http://www.cyberciti.biz/faq/install-nginx-centos-rhel-6-server-rpm-using-yum-command/>