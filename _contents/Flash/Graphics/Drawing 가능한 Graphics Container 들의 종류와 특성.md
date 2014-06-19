---
primary: e802ccf0dd
date: '2013-08-30 20:36:25'

---

# 사용 가능한 Draw Container

- `Shape`, `Sprite`
	- MXML Container 상에 직접 쓸 수 없다
	- 그리고, 난 뒤 size 가 자동 계산된다
	
- `SpriteVisualElement`
	- MXML Container 상에 쓸 수 있다
	- Display Object 기반의 `IVisualElement` 중에서 가장 가볍다
	- size 자동 계산이 되지 않는다 `width`, `height` 를 수동으로 지정해줘야 한다

- `UIComponent`
	- Display Invalidation 처리가 가능하다. `updateDisplayList()` 에서 드로잉이 가능하다.
	- 원론적으로 `SpriteVisualElement` 보다 무겁지만, Display Invalidation 에 의한 렌더링 횟수 감소로 효과를 볼 수도 있다.

- `GraphicElement`
	- Display Object 에 근거하지 않은 `IVisualElement`
	- `IVisualElementContainer` 에다가 그리는 특성을 지닌다.
	- 가장 가볍고 빠르다.
	- 하지만, Graphics 의 부분 갱신이 되지 않는 특징 때문에, 큰 그림을 `GraphicsElement` 로 그릴때 의외의 부하가 발생할 수도 있다.



