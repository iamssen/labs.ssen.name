# 구조들 간 속도 차이

|test			|ds_fp9_debug.swc	|ds_fp9.swc	|
|----			|----------------	|----------	|
|queue enqueue	|34					|23			|
|stack push		|39					|16			|
|deque pushBack	|27					|14			|
|deque pushFront|27					|15			|
|array push		|7					|7			|
|array unshift	|1176				|1183		|
|dll append		|63					|32			|
|dll prepend	|61					|32			|
|queue dequeue	|29					|14			|
|stack pop		|21					|12			|
|deque popBack	|22					|13			|
|deque popFront	|22					|14			|
|array pop		|6					|7			|
|array shift	|442				|435		|
|dll removeTail	|38					|21			|
|dll removeHead	|39					|22			|

- 전방 입출력이 필요한 경우 Array 보다는 Linked List 가 효율적일 수 있다
- 큰 차이는 아니지만, 일반적인 Linked List 보다는 Queue, Stack, Deque 등이 좀 더 빠르다. 유형이 맞다면 사용 하는 것이 좋다.

# 데이터 구조들

## Queue (선입선출)

뚫려있는 파이프의 한 쪽면은 넣을수만 있고, 다른 한쪽면은 뺄 수만 있는 형태의 구조

- [example](Queue__Example.as)
- [de.polygonal.ds.Queue](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Queue.html)
- [de.polygonal.ds.ArrayedQueue](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/ArrayedQueue.html)
- [de.polygonal.ds.LinkedQueue](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/LinkedQueue.html)
- `enqueue(v:T):void`
- `dequeue():T` with remove
- `peek():T`
- `back():T`

## Stack (후입선출)

한 쪽이 막혀있는 파이프의 한 쪽면에 넣게 되면, 마지막에 들어간 값을 최우선으로 뺄 수 밖에 없는 형태의 구조

- [example](Stack__Example.as)
- [de.polygonal.ds.Stack](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Stack.html)
- [de.polygonal.ds.ArrayedStack](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/ArrayedStack.html)
- [de.polygonal.ds.LinkedStack](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/LinkedStack.html)
- `push(v:T):void`
- `pop():T` with remove
- `top():T`

## Deque (후입선출 + 양방향)

뚫려있는 파이프의 양옆으로 구슬을 집어넣고, 빼낼때도 양옆으로 마지막에 들어간 구슬을 빼낼 수 있는 형태의 구조

- [example](Deque__Example.as)
- [de.polygonal.ds.Deque](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Deque.html)
- [de.polygonal.ds.ArrayedDeque](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/ArrayedDeque.html)
- [de.polygonal.ds.LinkedDeque](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/LinkedDeque.html)
- `pushBack(v:T):void`
- `back():T`
- `popBack():T` with remove
- `pushFront(v:T):void`
- `front():T`
- `popFront():T` with remove

## Heap (순위 우선 내보내기)

각 항목들을 순위 매겨서 순위가 높은 것들 부터 우선적으로 내보내준다

- [example](Heap__Example.as)
- [de.polygonal.ds.Heap](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Heap.html)
- [de.polygonal.ds.Heapable](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Heapable.html) > [de.polygonal.ds.Comparable](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Comparable.html)
- `add(h:Heapable):void`
- `top():Heapable`
- `bottom():Heapable`
- `pop():Heapable` with remove

## Array2, Array3 (Grid 형 배열)

x, y 혹은 x, y, z 형태의 다차원 배열을 컨트롤 할 수 있다

표준적인 x, y grid 혹은 x, y, z grid 로 써도 큰 무리가 없을듯 싶다

- [example](Array2__Example.as)
- [de.polygonal.ds.Array2](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Array2.html)
- `set(x:int, y:int, v:T):void`
- `get(x:int, y:int):T`
- `getH():int`
- `getV():int`
- `setH(h:int):void`
- `setV(v:int):void`

## Map (Dictionary 와 유사)

key id 로 값을 저장하고, 찾는다

Dictionary 와 유사한 형태 이므로 큰 문제는 없다.

당연히 Dictionary 가 더 빠르지만, `size()` 와 같이 **크기를 요구하는 작업 이거나**, `iterator()` 나 `toKeyArray()` 와 같은 **명확한 순서를 요구하는 작업시에 쓸만하다**

- [example](Map__Example.as)
- [de.polygonal.ds.Map](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/Map.html)
- [de.polygonal.ds.HashMap](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/HashMap.html)
- `set(k:String, v:T):void`
- `get(k:String):T`
- `has(k:String):Boolean`
- `remap(k:String, v:T):void`

## Tree

Tree 형태의 데이터를 작업하는데 꼭 필요한 수준

- [example](Tree__Example.as)
- [de.polygonal.ds.TreeBuilder](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/TreeBuilder.html)
- [de.polygonal.ds.TreeNode](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/TreeNode.html)

## LinkedList

Array 랑 기능적 면에서 큰 차이가 있지는 않다. (즉, Array 로도 되는 작업들 이라는 것)

단, `unshift()` 와 `shift()` 와 같은 **전방 항목에 대한 편집을 필요로 할 경우 Array 보다 상당한 속도를 보여준다.**

그리고, `insertBefore()` 나 `insertAfter()` 와 같은 **특정 위치 대비 항목 추가** 와 같은 기능이나, `shiftUp()`, `popDown()` 과 같은 **node 의 이동 기능들** 은 작업에 유용함을 준다.

- [example](LinkedList__Example.as)
- [de.polygonal.ds.SLL](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/SLL.html)
- [de.polygonal.ds.SLLNode](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/SLLNode.html)
- [de.polygonal.ds.DLL](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/DLL.html)
- [de.polygonal.ds.DLLNode](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/DLLNode.html)

# Pooling

## ObjectPool 

new 에 들어가는 비용과 gabage collection 비용을 아껴야 할 만큼 instance 가 과격하게 많이 사용되는 경우 사용할 수 있다

- [example](ObjectPool__Example.as)
- [de.polygonal.ds.pooling.ObjectPool](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/pooling/ObjectPool.html)

## LinkedObjectPool

id 기반으로 돌려야 하는 ObjectPool 과 다르게 object 단위로 사용이 가능하다

좀 더 편하게 쓸 수 있다

- [example](LinkedObjectPool__Example.as)
- [de.polygonal.ds.pooling.LinkedObjectPool](http://polygonal.github.com/ds/doc/types/de/polygonal/ds/pooling/LinkedObjectPool.html)