---
primary: b9622c0df1
date: '2014-02-16 23:05:11'

---

# Directory 정보 확인하기

`ls -al` 명령어를 통해 현재 Directory의 리스트를 확인 가능하다.

	drwx------+    9 ssen  staff    306  2 16 20:01 Downloads
	drwx------@   66 ssen  staff   2244  2 15 16:00 Library
	drwxr-xr-x@   14 ssen  staff    476  1 25 01:34 Links
	drwxr-xr-x@    6 ssen  staff    204  9 24 03:01 Make

위와 같은 형태가 된다.


# `drwxrwxrwx`

### 앞의 1개의 문자는 항목의 종류를 의미한다

- `-` file
- `d` directory
- `l` symbolic link

일반적으로 위의 3가지를 발견할 수 있으며, `c`(character special), `b`(block special), `p`(fipo), `s`(socket) 도 있다고 하는데 본적이 없다...

### 뒤의 9개는 `rwx` 3개가 붙어있는 형태가 된다.

- `r` 읽을 수 있음
- `w` 쓸 수 있음
- `x` 실행할 수 있음

이라는 의미가 되며, 순차적으로

- `rwx------` 소유자가 읽고, 쓰고, 실행할 수 있음
- `---rwx---` 접근이 허락된 그룹이 읽고, 쓰고, 실행할 수 있음
- `------rwx` 그 외, 모든 기타 사용자들이 읽고, 쓰고 실행할 수 있음

이라는 구성이 된다. 이렇게 **소유자, 그룹, 기타**에 대한 `rwx` 권한이 된다.

### `rwx`는 숫자로 표현될 수 있다

- `r = 4`
- `w = 2`
- `x = 1`

이라는 값을 가지며, 이를 더해서 숫자로 표현 가능하다. (도대체 왜 이렇게 한거야?)

- `rwx = 7` 맘대로
- `rw- = 6` 읽고, 쓸 수는 있지만 실행은 불가
- `r-x = 5` 읽고, 실행 할 수는 있지만 쓸 수는 없다
- `r-- = 4` 읽을 수만 있다
- `--- = 0` 아무것도 못한다

이를 다시 **소유자, 그룹, 기타**로 조합해 보자면

- `777` 모두가 맘대로
- `755` 소유주만 맘대로이고, 그 외에는 읽기와 실행만 가능
- `744` 소유주만 맘대로이고, 그 외에는 읽기만 가능
- `700` 소유주만 사용 가능

이라는 구성이 된다




# `owner   group`

다시 돌아가서 `ls -al`을 보자면

	drwxr-xr-x@    6 ssen  staff    204  9 24 03:01 Make

중반부에 나와있는 `ssen  staff`가 보인다.

1. 첫 번째의 `ssen`은 `owner` 즉, 파일의 소유주를 말하며 
2. 두 번째의 `staff`는 `group` 즉, 파일에 접근을 허락받은 사용자들의 그룹을 말한다

앞의 `rwxrwxrwx` 권한과 맞물려서 사용될 수 있다. 쉽게 이야기해서

- `rwx------`는 첫 번째의 `owner`에 대한 권한이 되며
- `---rwx---`는 두 번째의 `group`에 대한 권한이 되며
- `------rwx`는 지정되지 않은 모든 사용자에 대한 권한이 된다





# `chmod`, `chown`, `chgrp`

권한과 소유주, 그룹에 대한 확인이 가능하다면 당연히 그 권한과 소유주, 그룹에 대한 변경도 가능하다.

### `chmod` `rwxrwxrwx` 권한을 바꾸고 싶을 때

`chmod`는 위에서 언급한 `777` 형태의 소유권한 표현을 사용한다.

- `chmod 777 dir` dir 이라는 폴더에 누구나 접속하게 해준다
- `chmod -R 777 dir` -R 옵션을 붙이면 폴더 하위의 항목들까지 몽땅 바꾼다
- `chmod 700 dir` dir 이라는 폴더에 아무도 접속할 수 없게 만든다.

### `chgrp` `group`을 바꾸고 싶을 때

`chgrp`는 `group`을 바꾼다

- `chgrp developers test.js` test.js 파일에 대한 그룹을 developers로 지정한다
- `chgrp -R developers src` src 디렉토리와 하위 모든 항목들의 그룹을 developers로 지정한다

### `chown` `owner`를 바꾸고 싶을 때

`chown`는 기본적으로 `owner`를 바꾸지만, `group`도 같이 변경할 수 있다

- `chown arthur excalibur` 엑스칼리버의 주인을 아서로 바꾼다
- `chown ssen:developers test.js` test.js 파일의 소유자를 ssen으로 하면서, developers를 그룹으로 지정한다
- `chown ssen:developers src` src 디렉토리와 하위 모든 항목들의 소유자를 ssen으로 하면서, developers를 그룹으로 지정한다
- `chown -R ssen:developers docs --from=seoyeon:officeworkers` docs 디렉토리와 하위 디렉토리의 항목들 중이 소유자가 seoyeon, 그룹이 officeworkers로 되어있는 것들만 소유자 ssen, 그룹 developers로 변경한다






# `useradd`, `groupadd`, `usermod`

이제 권한과 소유자, 그룹에 대해서 알고, 항목의 권한, 소유자, 그룹을 바꿀 수 있게 되었다면...

당연히 사용자와 그룹을 만들 수 있어야 한다.

### `useradd` 새로운 사용자를 만들고 싶을 때

	useradd 







# 참고한 자료들

- <http://www.cyberciti.biz/faq/howto-linux-add-user-to-group/>
- <http://www.cyberciti.biz/faq/linux-set-change-password-how-to/>
- <http://linuxg.net/2-ways-to-change-a-users-login-shell/>
- <http://hybridego.net/entry/chown-%EC%86%8C%EC%9C%A0%EC%9E%90-%EC%86%8C%EC%9C%A0%EA%B7%B8%EB%A3%B9-%EB%B3%80%EA%B2%BD%ED%95%98%EA%B8%B0>
- <http://linux.101hacks.com/sysadmin-tasks/assign-new-group-to-use/>