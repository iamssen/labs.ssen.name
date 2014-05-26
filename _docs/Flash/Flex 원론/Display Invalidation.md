# Display Invalidation 무효화 처리

Display Invalidation은 Flex의 주요 개념 중 하나이다.

Flex의 근간이 되는 Flash에서 처리되는 보편적인 Display Rendering 구조는 아래와 같다.

1. 상태 변경
1. 렌더링

문제는 렌더링 처리는 보통 **엄청난 무게감**을 가지는 녀석들이라는 것이다.

Flex는 내부적으로 Data Binding 같은 개발자 편의를 많이 수용하고 있기 때문에, 기본적으로 상태 변경 자체가 자주 일어나게 된다. 이 상태 변경 때마다 Flash처럼 렌더링 질을 하다간 프로그램의 성능은 보장할 수가 없다.

Display Invalidation 에 대한 기본적인 과정은 아래와 같다.

1. property 등의 변경 시에 변경된 데이터를 저장한 다음, `invalidate()` 메서드를 호출한다.
1. `invalidate()` 에서는 두 가지 상황을 감시한다
	- display가 added 되어 있으면 `Event.RENDER` 를 기다린다.
	- display가 added 되어 있지 않으면 `Event.ADDED_TO_STAGE` 를 기다린다.
1. 위에서 처럼 처리를 하게 되면 몇 번의 property 변경이 일어나던지 간에, 실제적인 렌더링은 `Event.RENDER` 에서 한 번만 일어나게 된다.

이와 같이 `Event.RENDER` 와 같은 **모니터가 변경된 화면을 그리게 되는 순간** 에 실제 그림을 그려내도록 미루는 것을 Display Invalidation의 기본적인 개념이다.


# Flex 의 Display Invalidation

Flex 는 `invalidate()` 의 개념을 좀 더 세분화 시켜놓았다.

1. `invalidateDisplayList()` 화면의 구성원을 변경했으니 이후에 처리하라
1. `invalidateSize()` 화면의 사이즈를 변경했으니 이후에 처리하라 
1. `invalidateProperties()` 값을 변경했으니 이후에 처리하라
1. `invalidateSkinState()` Skin의 현재 상태가 변경되었으니 이후에 처리하라

뭐 대표적인 `invalidate` 메서드 들은 위와 같고, 몇몇 특수한 형태의 추가적인 형태의 invalidation도 존재한다. 하지만 의미는 "무언가 변경했으니 차후에 처리해달라" 에서 크게 벗어나지는 않는다.

각각의 무효화 처리에 대응되는 내부적 메서드들은 아래와 같다

- `invalidateDisplayList()` --> `updateDisplayList()` --> `UPDATE_COMPLETE`
- `invalidateSize()` --> `measure()` --> `UPDATE_COMPLETE`
- `invalidateProperties()` --> `commitProperties()` --> `UPDATE_COMPLETE`
- `invalidateSkinState()` --> `commitProperties()`, `getCurrentSkinState()` --> `UPDATE_COMPLETE`

마지막에 있는 `UPDATE_COMPLETE`는 Event인데, 여러모로 상태 구분이 모호하고, 뭔가 변경되는 상황들을 뭉뚱그려서 처리하고 싶을 때 사용하면 된다. 하지만 의미 없는 렌더링 성능을 소모할 가능성이 있으므로 신중하게 사용하는 것이 좋다.

### 참고 

- [About creating advanced Spark components](http://help.adobe.com/en_US/flex/using/WS460ee381960520ad-2811830c121e9107ecb-7fff.html)

