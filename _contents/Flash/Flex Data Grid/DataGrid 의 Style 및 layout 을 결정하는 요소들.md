---
primary: 8e3d57a60e
date: '2013-09-01 08:25:35'

---

# `DataGridSkin` 의 색상과 같은 style 적 요소들

기본적인 모양새는 `DataGridSkin` 이 결정하게 된다.

특이점은 `Skin` 시스템이 가지는 형태라기 보다는, 일종의 형태를 그려내는데 필요한 여러 `part` 들의 집합체적 성격을 가진다. 그렇기에 내부적으로 `IFactory` 형태의 `[SkinPart]` 들이 많은 편이다.

### `IFactory` 형태의 `[SkinPart]` 들 분석

Factory 형태의 `[SkinPart]` 들은 `headerRenderer` 를 제외하고는 모두 `GraphicElement` 형태를 가지게 된다. 화면을 그려내기 위한 작은 `GraphicElement` 의 집합이라고 볼 수 있다.

- Header 렌더링
	- `headerRenderer` 말그대로 Renderer 이다. Header 를 그려내는데 사용된다.
- Cell 을 그려내는데 필요한 요소들
	- `alternatingRowColorsBackground` cell 의 background 를 그린다.
		- use style `alternatingRowColors`
		- default `<Rect><SolidColor>`
- Indicator (selection, hover, caret 등 사용자 반응의 표현) 들을 그리는 요소들
	- `caretIndicator` mouse 의 마지막 click selection 위치인 caret 을 그린다. 
		- use style `caretColor`
		- default `<Rect><SolidColorStroke>`
	- `selectionIndicator` selection 된 cell, row 의 background color 를 그린다. 
		- use style `selectionColor`
		- default `<Rect><SolidColor>`
	- `hoverIndicator` mouse 의 roll over 를 그린다.
		- use style `rollOverColor`
		- default `<Rect><SolidColor>`
	- `dropIndicator` 아마도 drag and drop 시에 외곽선을 그려주는 역할일듯 (테스트 안해봤음)
		- default `<Rect><SolidColorStroke>`
	- `editorIndicator` rendererIsEditable 이 걸린 column 에 edit focus 가 들어갈때 배경색을 그려준다
		- default `<Rect><SolidColor>`
- Separator (구분선) 을 그려내는 요소들. 모두 `Stroke` 요소들이다.
	- `headerColumnSeparator` header 내부의 column 간 구분선
	- `columnSeparator` column 간 구분선
	- `rowSeparator` row 간 구분선
	- `lockedColumnsSeparator` column 잠금선
	- `lockedRowsSeparator` row 잠금선

### `IGridVisualElement`

기본적으로 `alternatingRowColorsBackground` 나 여러 `indicator` 와 같은 구성 요소들은 `IVisualElement` 만 구현해내도 된다.

추가적으로 part 가 `DataGrid` 의 속성을 읽어서 어떤 작동을 하길 원한다면 (ex. style 처리와 같은...) `IGridVisualElement` 를 구현하면 된다.

	public function prepareGridVisualElement(grid:Grid, rowIndex:int, columnIndex:int):void {
		// TODO
		// grid.dataGrid
	}

`IGridVisualElement` 를 구현하면 위와 같은 method 를 구현하게 되는데, `grid.DataGrid` 로 참조를 읽어서 여러 `DataGrid` 의 속성을 구현해낼 수 있다.

### css style 요소의 테마를 포함시킬 것인가?

기본 `DataGridSkin` 은 spark theme 의 편의성을 위해서 각 part 들에 `IGridVisualElement` 를 구현시켜서 `DataGrid` 의 style 요소들을 받아들여 렌더링 하게 된다.

하지만, custom 한 `DataGridSkin` 을 작성하고자 한다면 딱히 이 부분까지는 고려할 필요는 없다. 주의할 것은 `IGridVisualElement` 를 구현하지 않은 `DataGridSkin` 을 만든다면, `DataGrid` 의 여러 style 속성들 (예를 들어 `backgroundColor`) 같은 것들은 모두 무효화 되게 된다.


# `DataGridSkin` 의 layout 구성적 요소들

각 종, `part` 들을 배제하고 나면 남는 것은 아래와 같은 구성이다.

	<VGroup>
		<GridColumnHeaderGroup id="columnHeaderGroup" />
		<Group>
			<Rect>
				<fill/>
			</Rect>
			<VGroup>
				<Line id="headerSeparator" />
				<Scroller>
					<Grid id="grid">
						<gridView>
							<Component>
								<GridView>
									<GridLayer name="backgroundLayer"/>
									<GridLayer name="selectionLayer"/>
									<GridLayer name="editorIndicatorLayer"/>
									<GridLayer name="rendererLayer"/>
									<GridLayer name="overlayLayer"/>
								</GridView>
							</Component>
						</gridView>
					</Grid>
				</Scroller>
			</VGroup>
		</Group>
	</VGroup>
	<Rect id="border">
		<stroke />
	</Rect>

`id` 를 기재한 요소들이 중요한 기능적 요소들이고, 나머지들은 그냥 layout 을 구성하는 것 들인데, 사용자의 요구에 따라 

- if `DataGrid` 외곽선 바깥에 scrollbar 를 배치하고 싶다거나
- if 각 종, `GridLayer` 들의 순서를 바꿀 필요가 있다거나
- if 하단에 cell 들의 합산을 추가하고 싶다거나...

뭐 이런 각 종, Custom 처리를 하고 싶으면 그냥 layout 자체를 바꿔버리면 된다.


### `IGridVisualElement`

내부적으로 `IGridVisualElement` 를 구현한 요소를 추가할 경우, 

	function prepareGridVisualElement(grid:Grid, rowIndex:int, columnIndex:int):void {
	}

해당 요소는 위와 같은 코드를 통해 초기하 되게 된다.

- 하단에 합산 처리를 넣고 싶다거나...
- 뭔가 DataGrid 에 추가적인 요소들을 낑궈넣고 싶다면

이 interface 를 구현한 요소를 추가시킨 component 를 layout 에 넣어주면 된다.


이와 관련된 문서는 [DataGrid 에 확장 요소 넣기](DataGrid 에 확장 요소 넣기.md) 에서 이어가도록 하겠다.