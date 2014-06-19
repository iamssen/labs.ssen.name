---
primary: d8c7401970
date: '2013-09-25 01:28:40'

---

# Node.js 설치

1. `sudo apt-get install python-software-properties python g++ make`
1. `sudo add-apt-repository ppa:chris-lea/node.js`
	- 작동이 안될 경우 `sudo apt-get install software-properties-common`
1. `sudo apt-get update` 새로운 repository 추가로 인해서 update 해줘야 함
1. `sudo apt-get install nodejs`

repository를 추가하는 이유는?

1. `nodejs`와 `npm`을 따로 설치한다
1. 실행 command 가 `nodejs` 가 된다. (`node`로 실행되지 않는다.)

위의 이유 때문에 보통 chris-lea의 package 를 사용하는듯 싶다. (아마도?)



# Node.js 설치 후 확인

1. `node --version`
1. `sudo npm install -g coffee-script` npm 설치 테스트
1. `sudo npm install -g mocha`
1. `sudo npm install -g forever`
1. `node` console을 실행해본다

위와 같이 설치한 `coffee` 같은 명령어들이 실행되지 않을 경우엔 일단 `npm` 설치 메세지를 확인해서, 설치된 경로를 본다.

보통 `/usr/bin/coffee -> ...`와 같은 메세지가 나오면 따로 설정이 필요없이 실행이 가능할테고, 아닌 경우엔 

`sudo nano ~/.zshrc` PATH 에 `:/usr/local/share/npm/bin` 와 같은 식으로 npm global path의 경로를 추가시켜주면 된다.
