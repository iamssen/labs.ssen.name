---
primary: 98d8b3cdd7
date: '2013-03-28 12:00:02'

---

Sort Compare Functions
===================================

`Function`을 사용해서 배열의 정렬 조건을 좀 더 유연하게 설정할 때 필요하다.

`Vector.sort()`보다 `Array.sortOn()`이 더 빠르다.


숫자형 정렬 1...10
===================================

```as3
function func(a:int, b:int):int {
	return a - b;
}
```

숫자형 정렬 10...1
===================================

```as3
function func(a:int, b:int):int {
	return b - a;
}
```
	
문자형 정렬 a...z
===================================

```as3
function func(a:String, b:String):int {
	var a1:int;
	var b1:int;
	var i:int = 0;
	while (true) {
		a1 = a.charCodeAt(i);
		b1 = b.charCodeAt(i);
		if (a1 - b1 != 0) {
			return a1 - b1;
		} else if (a1 + b1 > 0) {
			i++;
		} else {
			return 0;
		}
	}
	return 0;
}
```

문자형 정렬 z...a
===================================

```as3
function func(a:String, b:String):int {
	var a1:int;
	var b1:int;
	var i:int = 0;
	while (true) {
		a1 = a.charCodeAt(i);
		b1 = b.charCodeAt(i);
		if (b1 - a1 != 0) {
			return b1 - a1;
		} else if (a1 + b1 > 0) {
			i++;
		} else {
			return 0;
		}
	}
	return 0;
}
```

랜덤 정렬
===================================

```as3
function func(a:int, b:int):int {
	return MathUtils.rand(-1, 1);
}	
```