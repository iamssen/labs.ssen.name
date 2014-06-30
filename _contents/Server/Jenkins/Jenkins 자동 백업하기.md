---
primary: 44e256f173
date: '2014-06-30 22:20:13'

---

Jenkins 데이터들을 자동으로 Git에 백업하기
====================================

Jenkins 데이터들은 상당히 중요하다. (_그냥 Server를 수십번 재설치 하다보면 알 수 있다._) 그렇기 때문에 좀 더 강력한 백업을 설정해 놓으면 마음이 편해진다.

만들고자 하는 구성은 아래와 같다.

1. Jenkins [ThinBackup] Plugin을 사용해서 Jenkins 데이터들을 주기적으로 백업한다.
1. Jenkins Job을 만들어서 위에서 만들어진 백업 데이터들을 주기적으로 Git에 Push한다.


Git Backup Setting
====================================

### 저장소 준비하기

우선 Jenkins 백업 데이터들을 Public으로 올리는 미친짓을 할 수 없으므로, [Github] 보다는 [Bitbucket]을 사용하도록 한다.

![](http://files.ssen.name/captures/20140630/2.png)

적당한 Jenkins를 백업할 저장소를 만들어준다.

그리고, 저장소에 적당히 아무런 파일이나 하나 추가해서 Push를 해주도록 한다. (_Git 저장소에 아무런 Commit 이력이 없으면 Jenkins Job 실행시에 문제가 발생하기 때문이다. 그냥 Commit이 하나 이상 있어야하기 때문이니, 아무렇게나 추가하면 된다._)


### Jenkins Job 만들기

저장소가 준비되었으면 Git에 주기적으로 Push를 날려줄 Job을 하나 만든다.

![](http://files.ssen.name/captures/20140630/225539.png)

Git 저장소 연결을 해주고

![](http://files.ssen.name/captures/20140630/230225.png)

매일 22시에 Job이 실행되게 해주고

![](http://files.ssen.name/captures/20140630/230316.png)

간단한 Shell Script를 실행해준다. (_Workspace 내에 모든 변경 사항을 적용한 다음, Commit을 한다._)

![](http://files.ssen.name/captures/20140630/230429.png)

마지막으로 Git Publisher를 사용해서, 자동으로 Git 저장소에 Push를 날리도록 해준다.

위와 같이 설정들을 해두면 이제 "매일 22시에 저장소 내에 모든 변경사항을 자동으로 Commit한 다음, Git Remote 저장소로 Push를 해주게 된다."


[ThinBackup]을 사용한 주기적인 Jenkins 백업
====================================

Jenkins에 자동으로 Git으로 Push를 날려주도록 설정을 해두었다면, 이제 실제 백업을 생성되도록 설정을 해야한다.

Jenkins Plugin Manager에서 [ThinBackup]을 설치한다.

![](http://files.ssen.name/captures/20140630/1.png)

설치가 완료되면 위와 같이 Jenkins 관리에서 [ThinBackup] 항목을 볼 수 있다.

![](http://files.ssen.name/captures/20140630/230839.png)

설정은 그리 복잡하지 않다.

- **Backup directory** : Jenkins Job의 Workspace Directory를 지정해야 한다. (_당연히 제일 중요_)
- Backup schedule for full backups : 전체 백업을 실행할 Cron Schedule 설정 (_매일 0시에 실행됨_)
- Backup schedule for differential backups : 변경 사항만 간단하게 백업 할  Cron Schedule 설정 (_매일 6, 12, 18시에 실행됨_)
- Max number of backup sets : 유지할 최대 백업 갯수 (_어짜피 Git에 저장되기 때문에 줄여도 큰 상관없다._)

나머지는 취향대로 설정하면 된다.

저장을 해두면 이제 지정된 시간에 Jenkins Job 저장소로 백업이 이루어지게 된다.


백업 시나리오 다시 한 번 살펴보기
======================================================

시나리오를 한 번 살펴보자면

1. [ThinBackup]을 통해서 매일 6, 12, 18시에는 간이 백업을 0시에는 전체 백업을 한다.
1. [ThinBackup]이 백업을 하는 Directory는 Jenkins Job의 Workspace이다.
1. 매일 22시에 Jenkins Job이 실행된다.
1. Jenkins Job은 Git Commit과 Push를 자동으로 한다.

위와 같이 설정을 해두면 이제 매일 Jenkins 백업들이 자동으로 만들어지고, 만들어진 백업들은 자동으로 [Bitbucket]의 Remote 저장소로 올라가게 된다.



[Github]: https://github.com
[Bitbucket]: https://bitbucket.org
[ThinBackup]: https://wiki.jenkins-ci.org/display/JENKINS/thinBackup