---
primary: 9b7acad8b5
date: '2013-08-30 20:34:32'

---

3D Triangle Drawing
================================================

Skew, Distort 등 공간 왜곡을 구현할 때 사용할 수 있는 `Graphics`의 API 이다. (_`DisplayObject` 기반의 레이어에서는 3D를 그릴 수 있는 가장 쉬운 방식이다. 3차원 좌표를 2차원 좌표로 변환하는 계산이 어려울 뿐이지..._)

### `vertices : Vector.<Number>` 삼각형을 그릴 수 있는 x 또는 y 좌표 쌍을 가지게 된다

삼각형 두개를 합친 사각형 맵은 아래와 같다 

- 0 : top left x
- 1 : top left y
- 2 : top right x
- 3 : top right y
- 4 : bottom left x
- 5 : bottom left y
- 6 : bottom right x
- 7 : bottom right y 
	
### `indices : Vector.<int>` 삼각형을 그려나가는 순서 정보를 가진다. `vertices` 를 참고하는 순서를 지정하게 된다. 

예를 들어 사각형을 그리는데 사용될 수 있는 `[0, 1, 2, 1, 3, 2]`는 

`vertices`의 `[(top left 0, 1), (top right 2, 3), (bottom left 4, 5), (top right 2, 3), (bottom right 6, 7), (bottom left 4, 5)]` 의 순서로 삼각형을 맵핑하라는 의미를 지니게 된다
	
### `uvData : Vector.<Number>` 삼각형의 bitmap x 또는 y 좌표를 지정한다. 

`vertices` 와 1 대 1 로 매치되어서, 해당 x, y 좌표와 bitmap 의 어떤 x, y 좌표를 매칭시킬지를 지정하게 된다

bitmap texture 의 width, height 를 비율적으로 1 로 보고, 각각 맵핑할 좌표를 맵핑한다

	
예제
====================================================

```as3
// triangle setting. top left, top right, bottom left, bottom right
var vertices : Vector.<Number> = new <Number>[0, 0, 80, 20, 0, 100, 80, 80];

// tl --> tr --> dl , tr --> dr --> dl 순서로 삼각형을 그림
var indices : Vector.<int> = new <int>[0, 1, 2, 1, 3, 2];

// vertices 와 1 : 1 매치, bitmapData.width 를 1 로 취급 100분율로 bitmapData 를 맵핑
var uvData : Vector.<Number> = new <Number>[0, 0, 1, 0, 0, 1, 1, 1];

// draw
graphics.beginBitmapFill(bitmapData, null, false, true);
graphics.lineStyle(1, 0x000000);
graphics.drawTriangles(vertices, indices, uvData, TriangleCulling.NONE);
graphics.endFill();
```