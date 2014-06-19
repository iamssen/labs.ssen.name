---
primary: caa74c78e1
date: '2013-09-24 03:31:35'

---

# 참고한 자료들

- [Install Dropbox In An Entirely Text-Based Linux Environment](http://www.dropboxwiki.com/tips-and-tricks/install-dropbox-in-an-entirely-text-based-linux-environment#opensuse)


# init.d script의 생성 및 등록

1. `sudo nano /etc/init.d/${name}` script 생성
1. `sudo chmod +x /etc/init.d/${name}` script에 권한 부여
1. `sudo update-rc.d ${name} defaults` script 등록
	- `sudo update-rc.d -f ${name} remove` script 등록 제거
	- [update-rc.d 등록 및 삭제](http://pmguda.com/733)


# init.d script의 구조

	#! /bin/sh

	func1() {
		// TODO
	}

	func2() {
		// TODO
	}

	case "$1" in
		func1)
			func1
			;;
		func2)
			func2
			;;
		func3|func4)
			func1
			func2
			;;
		*)
			echo "Usage: /etc/init.d/${name} {func1|func2|func3|func4}"
			exit 1
	easc

	exit 0

간단하게 `${name}`에 해당하는 서비스를 만들고, 해당 서비스에 명령어들을 `func1|func2|func3|func4`의 세가지를 부여했을때이다.

`update-rc.d`인지 `init.d`인지 잘 모르겠으나 하여튼 구현해줘야 하는 기본 function들은

1. `start)`
1. `stop)`
1. `restart)`
1. `reload)`
1. `force-reload)`
1. `status)`

의 다섯가지 인듯 싶고, 예외의 command가 들어왔을 때 보여줄 메세지를 출력하기 위해 `*)`를 구현해주는 듯 싶다.



# init.d script test

System 시작, 종료 시에 `echo` 메세지를 확인할 수 없기 때문에 `mkdir -p`를 사용해서 확인한다

	#! /bin/sh

	HOMEDIR=/home/ssen

	case "$1" in
		start)
			mkdir -p $HOMEDIR/start
			;;
		stop)
			mkdir -p $HOMEDIR/stop
			;;
		restart|reload|force-reload)
			mkdir -p $HOMEDIR/restart
			;;
		status)
			mkdir -p $HOMEDIR/status
			;;
		*)
			echo "Usage: /etc/init.d/test {start|stop|restart|reload|force-reload|status}"
	esac

	exit 0

작성후에 확인을 해본다

1. `sudo nano /etc/init.d/testscript` script 작성
1. `sudo chmod +x /etc/init.d/testscript` script 권한 부여
1. `sudo update-rc.d testscript defaults` script 등록
1. `sudo reboot` 리부팅 해서 디렉토리가 생성 되는지 확인
1. `sudo rmdir start stop` 으로 확인된 디렉토리들 지워줌
1. `sudo update-rc.d -f testscript remove` script 등록 제거
1. `sudo reboot` 리부팅 해서 디렉토리가 생성 안되는지 확인



