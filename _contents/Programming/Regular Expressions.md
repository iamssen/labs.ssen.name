---
primary: ea49173341
date: '2013-05-05 22:51:33'

---

정규식 참고
===============================================================

- [msdn 정규식 flag 소개](http://msdn.microsoft.com/ko-kr/library/yd1hzczs.aspx)
- [정규식 특수문자 소개](http://blog.naver.com/PostView.nhn?blogId=yonga&logNo=150004198246)
- [as3 RegExp](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/RegExp.html)
- [adobe help 정규식](http://help.adobe.com/ko_KR/as3/dev/WS5b3ccc516d4fbf351e63e3d118a9b90204-7ea7.html)


정규식 검색
===============================================================

### Flag

- `g` (_global match_)
	- 내려쓰기를 무시
	- 검출되는 전체를 Replace
- `i` (_ignore case_)
	- 대소문자 무시
- `m` (_multiline_)
	- `^`, `$` 옵션이 붙었을때, 내려쓰기를 포함해서 검색
	- `"aaa\nbbb\nccc".match(/^bbb/) // null`
	- `"aaa\nbbb\nccc".match(/^bbb/m) // bbb`
	

### OR

```as3
var str:String = "강아지는 멍멍멍\n고양이는 깽깽깽\n까마귀는 깍깍깍";
trace(str.match(/강아지|까마귀/g));

// 강아지,까마귀
```
	
### 특수 문자

- 띄어쓰기 인접 검색
	- `\b` 띄어쓰기와 인접한 문자열을 찾는다
		- `trace("macpro".match(/\bmac/)); // mac`
		- `trace("applemacpro".match(/\bmac/)); // null`
		- `trace("never".match(/er\b/)); // er`
		- `trace("verb".match(/er\b/)); // null`
	- `\B` 띄어쓰기와 인접하지 않은 문자열을 찾는다
- 숫자형 검색
	- `\d` 숫자로 된 문자열 `[0-9]`
	- `\D` 숫자가 아닌 문자열 `[^0-9]`
- 공백문자 검색
	- `\n` 줄바꿈 문자 `\x0d`, `\cM`
		- `trace("aaa\nbbb\nccc".match("bb\nc")); // bb\nc`
	- `\t` 탭 문자 `\x09` `\cl`
	- `\f` 용지 공급 문자 (정상작동 케이스를 찾지 못함) `\x0c` `\cL`
	- `\r` 캐리지 리턴 문자 (정상작동 케이스를 찾지 못함) `\x0d` `\cM`
		- 개행에 있어서 유닉스는 LF (Line Feed) 를 사용하고, 윈도우는 CR/LF (Carriage Return) 을 사용
		- OS 차이인지 뭔지 확인이 안됨... 왠만한 경우 피할 것
	- `\v` 세로 탭 문자 (정상작동 케이스를 찾지 못함) `\x0b` `\cK`
	- `\s` 위에 나열된 모든 공백문자를 찾는다 `[\f\n\r\t\v]`
	- `\S` 모든 공백이 아닌 문자를 찾는다 `[^ \f\n\r\t\v]`
- 문자 그룹
	- `\w` 밑줄을 포함한 모든 알파벳 문자를 찾는다 `[A-Za-z0-9_]`
	- `\W` 알파벳이 아닌 문자를 찾는다 `[^A-Za-z0-9_]`
	- `[가-힣]` 한글 문자열 범위 (언어 지원에 따라 안될 수 있음, 그럴 경우 `\uac00-\ud7a3` 로 시도해 볼 수 있음)
		- `trace("aaa다람쥐bbbccc나나나ddd".match(/[가-힣]+/g)); // 다람쥐, 나나나`

### 수량

- `{n}` 정확하게 n개
- `{n,}` n개 이상
- `{n,m}` n개 이상, m개 이하
- `*` 0개 이상 `{0,}`
- `+` 1개 이상 `{1,}`
- `?` 0 또는 1개 `{0,1}`
- `.` `\n` 을 제외한 단일 문자
- `+?`, `{}?` none-greedy pattern 검색 가능 범위 내에서 최소를 찾음
	- `trace("aaabbbccc".match(/b+/)); // bbb`
	- `trace("aaabbbccc".match(/b+?/)); // b`
	- `trace("aaabbbccc".match(/b{2,3}/)); // bbb`
	- `trace("aaabbbccc".match(/b{2,3}?/)); // bb`
		
### 캡쳐

- `()`
	- `trace("winxp, win98, winvista, win7, win8".match(/win(xp|98|vista)/g));`
		- `> winxp, win98, winvista`
- `(?:)`
	- `trace("winxp, win98, winvista, win7, win8".match(/win(?:xp|98|vista)/g));`
		- `> winxp, win98, winvista`
- `(?=)` 캡쳐 그룹 미포함, 캡쳐의 조건이 맞을 경우
	- `trace("winxp, win98, winvista, win7, win8".match(/win(?=xp|98|vista)/g));`
		- `> win, win, win`
- `(?!)` 캡쳐 그룹 미포함, 캡쳐의 조건이 맞지 않을 경우 
	- `trace("winxp, win98, winvista, win7, win8".match(/win(?!xp|98|vista)/g));`
		- `> win, win`



정규식의 검색 순서
===============================================================
	
### 정규식에 옵션이 없는 경우 첫번째만 검출된다

```as3	
var str:String="aaabbbcccaaabbbcccaaabbbccc\naaabbbccc\ndddaaabbbccc";

trace(str.replace(/aabb/, "####"));

// a####bcccaaabbbcccaaabbbccc
// aaabbbccc
// dddaaabbbccc
```

### 정규식에 global 옵션이 있는 경우 전체가 검출된다

```as3	
var str:String="aaabbbcccaaabbbcccaaabbbccc\naaabbbccc\ndddaaabbbccc";

trace(str.replace(/aabb/g, "####"));

// a####bccca####bccca####bccc
// a####bccc
// ddda####bccc
```
	
### match를 통해 검출을 목록화 시키고, loop 를 통한 처리가 가능하다

```as3
var str:String="aaabbbcccaaabbbcccaaabbbccc\naaabbbccc\ndddaaabbbccc";

// match 를 통해 목록화 시키고, loop + replace 를 통해 순차적 변경이 가능하다
var matchs:Array=str.match(/aabb/g);

var f:int=-1;
var fmax:int=matchs.length;
while (++f < fmax) {
	str=str.replace(matchs[f], "#" + f + "##");
}

trace(str);

// a#0##bccca#1##bccca#2##bccc
// a#3##bccc
// ddda#4##bccc
```
	
### Markdown Header와 같이 라인의 전방 기준으로 라인을 검출할 때는 아래처럼 `mg` 옵션을 써서 처리가 가능하다

```as3
reg = /^\#{1,6}.*/mg
str = '# A\n## AA\n### AA BB'

console.log(str.match(reg))

// ["# A", "## AA", "### AA BB"]
```


