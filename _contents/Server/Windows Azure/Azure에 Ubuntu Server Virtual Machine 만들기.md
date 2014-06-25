---
primary: 041d3d5122
date: '2013-09-27 14:26:05'

---

# SSH Key 만들어두기

그냥 비밀번호로 해도 되지만, 왠만하면 SSH Key를 사용해서 접속하는게 더 좋을듯 하니 만들어둔다. (왠지 그러면 더 좋을듯한 느낌이 든다...)

참조 : [How to Use SSH with Linux on Windows Azure](http://www.windowsazure.com/en-us/manage/linux/how-to-guides/ssh-into-linux/?fb=ko-kr)

- `brew install openssl`
- `openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout ssen.key -out ssen.pem`
- 뭐 이것저것 물어보는데 대충 적어준다
- `chmod 600 ssen.key`
- `openssl x509 -outform der -in ssen.pem -out ssen.cer`

> 사실 서버쟁이가 아니라서 이걸로 뭘 어쩐다는건지, 뭔가 더 좋다는건지는 잘 모르겠다.    
> 일단 ssh 접속할 때 비밀번호 입력을 하지 않아서 좋다는데,     
> 어짜피 sudo 열나게 찍어야 하는 Linux의 특성 상, 로그인 비밀번호 하나 없앤다고 무슨 의미인지도 모르겠고...    
> 자동화 Script 같은거 짤 때 도움이 되려나... 


# Azure에 VM 생성하기

대충 SSH Key가 준비되었으면 Azure에 VM을 만들어준다. 사실 Azure 서비스 자체가 워낙 쉽게 잘 만들어져 있는데다가, 한국어 까지 지원해서 설명 따위 필요없이 그냥 대충 쓰다보면 알게 되는 거지만, 좀 설명을 해보자면...

![VM서비스를 gallery에서 골라준다][make-vm-with-gallery]

대충 "새로 만들기"에서 "가상 컴퓨터"를 고르고, "갤러리에서" 옵션을 선택해서 새로운 VM을 만든다.

![우분투를 선택][select-ubuntu]

개인적으로 쓰기 좋은 Ubuntu를 선택해 주고, (이도 저도 Ubuntu가 제일 편하더라...)

![가상 컴퓨터 설정][vm-setting-1]

자신의 서비스에 맞는 가상 컴퓨터를 구성한다.

![SSL인증서 업로드][vm-setting-2]

아까 만들어둔 SSH 인증서 파일을 올려주고,

![비밀번호 지정][vm-setting-3]

비밀번호를 지정해준다.

![클라우드 설정][set-cloud]

클라우드 설정을 해준다. 사용할 도메인 등을 입력하면 끝...

좀 만드는데 시간이 걸리는데, 작업이 완료되면 아래처럼 리스트를 볼 수 있다.

![서비스 리스트][cloud-list]

대충 VM이 만들어지면 보안을 위해 SSH의 외부 port를 바꿔준다.

![SSH Endpoint 변경][change-endpoint]

port 변경이 완료되면 아래처럼 정보를 확인할 수 있다.



# VM에 접속하기 

VM 페이지에서 간단하게 정보들을 확인 한 다음

아까 외부 SSH port를 `8755`로 변경했으니 터미널에서 아래와 같이 접속이 가능.

`ssh -i /your-key-path/ssen.key -p 8755 ssen@ssen.cloudapp.net`

단... OSX 기본 터미널을 사용하거나, iTerm2에서 위처럼 명령어로 접속할 경우 한글이 작살나는 경우가 있으므로, iTerm2에서 Profile을 생성해서 바로 접속하도록 한다. (이상하게 이러면 한글이 작살나지 않더라...)



[make-vm-with-gallery]: http://files.ssen.name/captures/20130927/082749.png
[select-ubuntu]: http://files.ssen.name/captures/20130927/082802.png
[vm-setting-1]: http://files.ssen.name/captures/20130927/082911.png
[vm-setting-2]: http://files.ssen.name/captures/20130927/082946.png
[vm-setting-3]: http://files.ssen.name/captures/20130927/083009.png
[set-cloud]: http://files.ssen.name/captures/20130927/083028.png
[set-endpoint]: http://files.ssen.name/captures/20130927/083438.png
[cloud-list]: http://files.ssen.name/captures/20130927/083551.png
[change-endpoint]: http://files.ssen.name/captures/20130927/084213.png
[define-ssh-info]: http://files.ssen.name/captures/20130927/084229.png