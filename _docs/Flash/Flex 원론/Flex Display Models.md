# Flex 의 주요 Display Models

### `IVisualElement`, `IVisualElementContainer` 

Flex4 의 display 최하 단위

- `GraphicElement` container 에 graphics drawing 을 할 때 사용되어 지는 element. display object 가 아니기 때문에 가볍다.
- `SpriteVisualElement` sprite 를 상속 받았다. 기본 제공되는 display object 기반의 element 중에서 가장 가볍다.
- `UIComponent` display invalidation 이 지원되는 가장 최하위 단위의 element

### `SkinnableComponent` 과 `Skin` 

Flex4 spark component 의 기본 구조가 된다. Skin 구조를 이룬다.

- `SkinnableComponent` 스킨 처리가 가능한 최하 단위 display object
- `SparkSkin --> Skin --> Group --> UIComponent` spark theme 에 편승하는 구조라면 SparkSkin 을 상속 받는게 편하다.


# Display Invalidation 구조

[Display Invalidation](Display Invalidation.md)


# Skinnable Component 에서 [SkinPart] 들이 모두 들어오는 시점

1. `FlexEvent.PREINITIALIZE` 
1. `getStyle("skinStyle")`
1. `partAdded`
1. `FlexEvent.INITIALIZE` 이 시점부터 [SkinPart] 들이 존재한다
1. `FlexEvent.CREATION_COMPLETE`
1. `Event.ADDED_TO_STAGE`

`FlexEvent.INITIALIZE` 에 기본 구성 요소들이 모두 들어오긴 하지만, `state + includeIn` 조합에 의해 포함되어지지 않는 요소들 역시 있으므로 Event 의 추가 삭제 등은 `partAdded()` 에서 선언되는 것이 좋다.