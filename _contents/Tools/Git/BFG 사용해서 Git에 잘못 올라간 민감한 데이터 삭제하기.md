---
primary: ebbc014e5c
date: '2014-07-01 21:42:11'

---

잘못 올라가버린 데이터
========================================
Github 등의 Public Repository Service를 사용하다보면 파일을 잘못 올려서 상당히 곤란해질때가 많다.

뭐 올려버린 Build 파일에 Server Password가 포함되어 있다거나, (_고소미를 쳐먹을 수 있는 종류의_) 대외비 자료가 올라가버렸다거나...

이런 자료들은 단순히 삭제하고 다시 Commit 한다고 끝나지는 않는다. (_어쨌든 Commit 이력을 되돌려버리면 복구할 수 있으니..._)

이런 대략 난감한 상황을 해결하는 방법이다.


Install [BFG]
========================================

```sh
$ brew install bfg
```

Homebrew를 사용해서 설치한다. (_[BFG] 링크에 가보면 알 수 있겠지만, Java로 만들어진 녀석이기 때문에 걍 jar 파일을 다운받아서 사용해도 된다._)



[BFG]를 사용해서 Commit 수정하기
========================================

### 지워야 할 파일들이 없는 상태의 Commit으로 만들기

현재(_최신의_) Commit에 지워야 할 파일들이 포함되어 있는 경우, Protected Commit으로 판단되어서 작동이 되질 않는다.

(_내가 정확히 이해하고 있는건지 잘 모르겠지만..._) [BFG]는 Commit Log상의 자료를 지워줄 수는 있지만, 현재 Workspace 상의 물리적인 자료는 지워주지 못한다.

하여튼... 골치 아픈 오류를 만나기 싫거나, 이미 [BFG] 작업을 진행하다 Protected Commits 오류를 만났다면 이와 같이 지워야 할 파일들이 없는 상태의 최신 Commit을 만들어주면 된다.


### Repository Clone 하기

> `--mirror` Repository로 작업한다. 기존 Workspace Directory에서 삽질하지 말 것...

```sh
$ git clone --mirror git@github.com:username/repository.git
$ bfg --delete-folders privateDirectory repository.git # 기존 Commit Log에서 privateDirectory를 삭제한다.
$ cd repository.git
$ git reflog expire --expire=now --all
$ git gc --prune=now --aggressive
$ git push
```

위와 같이 하면 일단 Remote Repository 상에서 `privateDirectory`에 대한 내용들이 삭제되어 있는 것을 확인할 수 있다.

`--delete-folders` 말고도 몇 가지 삭제 대상 옵션들이 있다.

- `--delete-folders <Directory Name>` 같은 이름을 가진 디렉토리들을 삭제 
- `--delete-files <File Name>` 같은 이름을 가진 파일들을 삭제
- `--strip-biggest-blobs <File Size : 128K, 1M...>` 해당 Size 이상의 파일들을 삭제

> 문제는 이게 경로를 포함한 디렉토리, 파일 이름들을 지원하지 않는 것 같다는 것 이다. (_내가 잘못 알고 있는건지 모르겠지만, 안됨_)
>
> 예를 들어 `index.html`처럼 여기저기 존재할 수 있는 파일들 이라면 상당히 난감해진다.

### Local 상의 자료를 되돌리기

Remote상의 Commit들은 정리를 했지만, Fetch를 받아보면 새로 만들어진 Remote Commit들과 기존 Local Commit들이 엉키게 된다. (_[BFG]는 기존 Commit들을 수정하는게 아닌, 새로운 Commit을 만들어서 교환해 버린다._)

뭐 대충 `--hard` 옵션을 사용해서 Reset해 버리던가, 아니면 Workspace를 아예 지워버리고 새로 Clone 하던가 하면 된다.

어쨌든 기존의 Local Commit들을 다시 Remote로 Push하는 멍청한 짓만 안하면 된다.


[BFG]: http://rtyley.github.io/bfg-repo-cleaner/