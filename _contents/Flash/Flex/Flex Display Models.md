---
primary: 62a8ebbe80
date: '2013-09-03 14:13:56'

---

Flex 의 주요 Display Models
================================================

### `IVisualElement` 구현체들 

|Implementation			|Display Invalidation	|
|------					|------					|
|`GraphicElement`		|Yes					|
|`SpriteVisualElement`	|No						|
|`UIComponent`			|Yes					|

`GraphicsElement`는 `Container`에 `Graphics` Drawing을 할 때 사용되어 지는 `Element`. `DisplayObject`가 아니기 때문에 가볍다.

`SpriteVisualElement`는 `Sprite`를 상속 받았다. 기본 제공되는 `DisplayObject` 기반의 Element 중에서 가장 가볍다.

`UIComponent`는 Display Invalidation이 지원되는 가장 최하위 단위의 `Element`.

### `SkinnableComponent` 과 `Skin` 

Flex4 `Spark Component`의 기본 구조가 된다. `Skin` 구조를 이룬다.

- `SkinnableComponent` 스킨 처리가 가능한 최하 단위 DisplayObject
- `SparkSkin --> Skin --> Group --> UIComponent` Spark Theme에 편승하는 구조라면 `SparkSkin`을 상속 받는게 편하다.


`SkinnableComponent`에서 `[SkinPart]` 들이 모두 들어오는 시점은 아래와 같다.

1. `FlexEvent.PREINITIALIZE` 
1. `getStyle("skinStyle")`
1. `partAdded`
1. `FlexEvent.INITIALIZE` 이 시점부터 [SkinPart] 들이 존재한다
1. `FlexEvent.CREATION_COMPLETE`
1. `Event.ADDED_TO_STAGE`

`FlexEvent.INITIALIZE` 에 기본 구성 요소들이 모두 들어오긴 하지만, `state + includeIn` 조합에 의해 포함되어지지 않는 요소들 역시 있으므로 Event 의 추가 삭제 등은 `partAdded()` 에서 선언되는 것이 좋다.