---
primary: 39b8b75afa
date: '2013-08-30 20:26:30'

---

# TweenLite 의 Easing function 구성

`func(t:Number, b:Number, c:Number, d:Number):Number`

- `t` 는 현재 시간
- `b` 는 시작 값
- `c` 는 증가량 (`b` 에서 얼마만큼 변할 것인가)
- `d` 는 전체 시간

`b`, `c`, `d` 는 고정 값이고, `t` 만이 변동 값이 된다. 다른 고정값들의 조건 내에서 `t` 시점의 값을 알려주게 된다.

# Easing function 들의 움직임 

<div class="unpadding">
	<embed src="EasingCatalog.swf" width="100%" height="800" />
</div>
