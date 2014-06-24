---
primary: e246512eff
date: '2013-09-03 14:44:35'

---

Display Invalidation
====================================

Display Invalidation은 Flex의 주요 개념 중 하나이다.

```as3
var color:uint;

function changeColor(value:uint):void {
	color = value;
	render();
}

function render():void {
	graphics.clear();

	graphics.beginFill(color);
	graphics.drawRect(0, 0, 100, 100);
	graphics.endFill();
}
```

일반적으로 Flash에서 사용되는 Graphics Drawing Code는 위와 같다.

이 중에서 가장 성능 부하가 큰 코드는 `render()`가 된다.

근데, 이 `render()`가 `changeColor()`가 실행될 때 마다 실행되는 것은 확실히 쓰잘데기 없는 성능의 낭비가 된다.

```as3
var color:uint;

function changeColor(value:uint):void {
	color = value;
	invalidateDisplayList();
}

function updateDisplayList(w:Number, h:Number):void {
	render();
}

function render():void {
	graphics.clear();

	graphics.beginFill(color);
	graphics.drawRect(0, 0, 100, 100);
	graphics.endFill();
}
```

위의 코드에서 `updateDisplayList()`는 실제 화면이 그려지는 시점(RENDER)에 실행되게 된다. 즉, `changeColor()`를 몇 번을 실행하던 `render()`는 화면이 그려지는 시점에 딱 한 번만 실행되게 된다.

이와 같이 불필요한 성능의 낭비를 줄이기 위해서 사용하게 되는 것이 Display Invalidation이다.



Flex 의 Display Invalidation
====================================

Flex는 `invalidate()` 의 개념을 좀 더 세분화 시켜놓았다.

1. `invalidateDisplayList()` 화면의 구성원을 변경했으니 이후에 처리하라
1. `invalidateSize()` 화면의 사이즈를 변경했으니 이후에 처리하라 
1. `invalidateProperties()` 값을 변경했으니 이후에 처리하라
1. `invalidateSkinState()` Skin의 현재 상태가 변경되었으니 이후에 처리하라

뭐 대표적인 `invalidate` 메서드 들은 위와 같고, 몇몇 특수한 형태의 추가적인 형태의 invalidation도 존재한다. 

하지만 의미는 **"무언가 변경했으니 차후에 처리해달라"** 에서 크게 벗어나지는 않는다.

각각의 무효화 처리 이후 실행되는 함수들은 아래와 같다.

- `invalidateDisplayList()` --> `updateDisplayList()` --> `UPDATE_COMPLETE`
- `invalidateSize()` --> `measure()` --> `UPDATE_COMPLETE`
- `invalidateProperties()` --> `commitProperties()` --> `UPDATE_COMPLETE`
- `invalidateSkinState()` --> `commitProperties()`, `getCurrentSkinState()` --> `UPDATE_COMPLETE`

마지막에 있는 `UPDATE_COMPLETE`는 Event인데, 여러모로 상태 구분이 모호하고, 뭔가 변경되는 상황들을 뭉뚱그려서 처리하고 싶을 때 사용하면 된다. (_하지만 의미 없는 렌더링 성능을 소모할 가능성이 있으므로 신중하게 사용하는 것이 좋다._)


### 참고 

- [About creating advanced Spark components](http://help.adobe.com/en_US/flex/using/WS460ee381960520ad-2811830c121e9107ecb-7fff.html)

