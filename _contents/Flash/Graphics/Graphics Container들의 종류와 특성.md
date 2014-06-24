---
primary: e802ccf0dd
date: '2013-08-30 20:36:25'

---

사용 가능한 Graphics Drawing Container
========================================

|Types					|Display Invalidation	|Flex		|Weight		|
|-------				|---------				|-------	|--------	|
|`Shape`				|No						|No			|Light		|
|`Sprite`				|No						|No			|Normal		|
|`SpriteVisualElement`	|No						|Yes		|Normal		|
|`UIComponent`			|Yes					|Yes		|Heavy		|
|`GraphicElement`		|Yes					|Yes		|Light		|

### `Shape`, `Sprite`

- Flex의 `VisualElementContainer` 상에서 쓸 수 없다. (_`UIComponent`나 `SpriteVisualElement`로 한 번 감싸야 한다_)
- Size가 자동 계산된다
	

### `SpriteVisualElement`

- Flex의 `VisualElementContainer` 상에서 쓸 수 있다.
- `DisplayObject` 기반의 `IVisualElement` 중에서 가장 가볍다
- Size 자동 계산이 되지 않는다. `width`, `height` 를 수동으로 지정해줘야 한다


### `UIComponent`

- Display Invalidation 처리가 가능하다. `updateDisplayList()`에서 드로잉 처리를 하면 성능 향상에 도움이 된다.
- `SpriteVisualElement`보다 무겁지만, **Display Invalidation에 의한 렌더링 최적화 효과**를 볼 수 있다.


### `GraphicElement`

- `DisplayObject`가 아닌 `IVisualElement`이다. `Graphics` 기반이다.
- `IVisualElementContainer`에다가 드로잉 처리를 한다. (_이래서 빠르다._)
- 가장 가볍고 빠르다. 하지만, `Graphics`의 부분 갱신이 되지 않는 특징 때문에, Size가 큰 그림을 그릴때 의외로 더 무거울 수 있다.



