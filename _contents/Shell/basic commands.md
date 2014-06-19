---
primary: a59ccfc285
date: '2014-01-14 15:59:12'

---

# globbing

- <http://tldp.org/LDP/abs/html/globbingref.html>
- <http://www.linuxjournal.com/content/bash-extended-globbing>
- `*.jpg` all jpg
- `AIR?.jpg` ? is some 1 character
- `src/**/*.as` 하위 모든 디렉토리
- `{a,b,c}` a and b and c
- `file{1..5}` file1 ~ file5


# [cp] : copy file or directory

- `cp source_file target_file`
	- `cp source.jpg target.jpg`
- `cp source_file ... target_directory`
	- `cp source.jpg target`
	- `cp dir/**/source*.jpg target`
	- `cp dir/{sourceA,sourceB}.jpg target`
	- `cp dir/source[1234] target`
	- `cp dir/source{1..4} target`
- `cp -r source_directory ... target_directory`
	- `cp -r source target`
	- `cp -r source/*kit target`
	
# cpio

- `cd src && find . -type f -iname '*.js' | cpio -pdm ../lib` src 디렉토리 내의 모든 js 파일들을 찾아서 lib 디렉토리 내부로 디렉토리 구조까지 합해서 복사한다
	
# [mv] : move, rename file or directory

- `mv source target`
	- `mv source.jpg raname.jpg` rename
	- `mv source.jpg target/moved.jpg` move
	- `mv source/*.jpg target` move multiple

# [rm], rmdir : remove file or directory

- `rm target`
	- `rm target.jpg` remove single file
	- `rm target/**/*.jpg` remove multiple files
	- `rm -r target/**/*kit` remove multiple directory
- `rmdir target` `rm -r` 과 유사하지만 디렉토리 내의 파일들은 삭제되지 않는다.
	
# mkdir : make directory

- `mkdir name`
	- `mkdir dir`
	- `mkdir -p a/b/c/d` 필요한 상위 디렉토리들까지 한꺼번에 만든다 
	

	
	
[cp]: http://ko.wikipedia.org/wiki/Cp_(%EC%9C%A0%EB%8B%89%EC%8A%A4)
[mv]: http://ko.wikipedia.org/wiki/Mv
[rm]: http://ko.wikipedia.org/wiki/Rm_(%EC%9C%A0%EB%8B%89%EC%8A%A4)