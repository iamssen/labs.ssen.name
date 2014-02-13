---
primary: 952fab070f

---

# OSX에 Tomcat 설치

```sh
brew install tomcat

# tomcat7 로 설치 된다
```

Gradle 설치

```sh
brew install gradle

gradle -v
```

# Ubuntu 에 Tomcat 설치

```sh
sudo aptitude update
sudo aptitude install tomcat7
```

Ubuntu Tomcat7의 디렉토리 구조들

```sh
$ tree /etc/tomcat7/
/etc/tomcat7/
├── Catalina
│   └── localhost
├── catalina.properties
├── context.xml
├── logging.properties
├── policy.d
│   ├── 01system.policy
│   ├── 02debian.policy
│   ├── 03catalina.policy
│   ├── 04webapps.policy
│   └── 50local.policy
├── server.xml
├── tomcat-users.xml
└── web.xml

$ tree /usr/share/tomcat7/
/usr/share/tomcat7/
├── bin
│   ├── bootstrap.jar
│   ├── catalina.sh
│   ├── catalina-tasks.xml
│   ├── configtest.sh
│   ├── daemon.sh
│   ├── digest.sh
│   ├── setclasspath.sh
│   ├── shutdown.sh
│   ├── startup.sh
│   ├── tomcat-juli.jar -> ../../java/tomcat-juli.jar
│   ├── tool-wrapper.sh
│   └── version.sh
├── defaults.md5sum
├── defaults.template
└── lib
    ├── annotations-api.jar -> ../../java/tomcat-annotations-api-7.0.26.jar
    ├── catalina-ant.jar -> ../../java/catalina-ant-7.0.26.jar
    ├── catalina-ha.jar -> ../../java/tomcat-catalina-ha-7.0.26.jar
    ├── catalina.jar -> ../../java/tomcat-catalina-7.0.26.jar
    ├── catalina-tribes.jar -> ../../java/catalina-tribes-7.0.26.jar
    ├── commons-dbcp.jar -> ../../java/commons-dbcp.jar
    ├── commons-pool.jar -> ../../java/commons-pool.jar
    ├── el-api.jar -> ../../java/tomcat-el-api-2.2.jar
    ├── jasper-el.jar -> ../../java/tomcat-jasper-el-7.0.26.jar
    ├── jasper.jar -> ../../java/tomcat-jasper-7.0.26.jar
    ├── jsp-api.jar -> ../../java/tomcat-jsp-api-2.2.jar
    ├── servlet-api.jar -> ../../java/tomcat-servlet-api-3.0.jar
    ├── tomcat-api.jar -> ../../java/tomcat-api-7.0.26.jar
    ├── tomcat-coyote.jar -> ../../java/tomcat-coyote-7.0.26.jar
    ├── tomcat-i18n-es.jar -> ../../java/tomcat-i18n-es-7.0.26.jar
    ├── tomcat-i18n-fr.jar -> ../../java/tomcat-i18n-fr-7.0.26.jar
    ├── tomcat-i18n-ja.jar -> ../../java/tomcat-i18n-ja-7.0.26.jar
    └── tomcat-util.jar -> ../../java/tomcat-util-7.0.26.jar

$ tree /usr/share/tomcat7-root/
/usr/share/tomcat7-root/
└── default_root
    ├── index.html
    └── META-INF
        └── context.xml

$ tree /var/cache/tomcat7/
/var/cache/tomcat7/
├── Catalina
│   └── localhost
│       └── _
└── catalina.policy

$ tree /var/lib/tomcat7/
/var/lib/tomcat7/
├── common
│   └── classes
├── conf -> /etc/tomcat7
├── logs -> ../../log/tomcat7
├── server
│   └── classes
├── shared
│   └── classes
├── webapps
│   └── ROOT
│       ├── index.html
│       └── META-INF
│           └── context.xml
└── work -> ../../cache/tomcat7

$ tree /var/log/tomcat7/
/var/log/tomcat7/
├── catalina.2014-06-11.log
├── catalina.2014-06-12.log
├── catalina.out
├── localhost.2014-06-11.log
├── localhost.2014-06-12.log
├── localhost_access_log.2014-06-11.txt
└── localhost_access_log.2014-06-12.txt
```