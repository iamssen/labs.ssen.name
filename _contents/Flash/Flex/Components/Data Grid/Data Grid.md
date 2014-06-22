---
primary: 4d918c7b9f
date: '2013-08-31 10:38:38'

---

# 구성

- `DataGrid`
- `GridColumn`
- `IGridItemRenderer`
- `IGridItemEditor`



# 기능적 속성들

## show / hide interaction

#### DataGrid

`dataProvider` 에 직접적 데이터를 표현하지 않고, 한 번 Wrapping 시켜서 사용해야 한다.

`mx.collections.GroupingCollection2`, ``

[Tree 형태 Data Grid 작성](Tree 형태 Data Grid 작성.md)

#### GridColumn

`visible` column 을 보이거나 숨길때 사용. 실시간 작동 가능

--------------------------------------------------------------------------------

## Column / Row lock (틀고정)

#### DataGrid

- `lockedColumnCount`
- `lockedRowCount`

--------------------------------------------------------------------------------

## header text 관련 속성들

#### GridColumn

- `headerText`
- `headerRenderer`

#### DataGridSkin

- `columnHeaderGroup : GridColumnHeaderGroup` header 부분을 렌더링한다.
- `IDataGridElement` GridColumnHeaderGroup 을 수정해서 처리하기 어려운 부분이라면


--------------------------------------------------------------------------------

## data 와 column mapping 및 item rendering 관련 속성들

- 접근 방식
	1. formatting
		- text formatting 요소만 있다면 `formatter` 로 처리하는게 좋겠다
	1. style
		- 기본적으로 스타일만 지정된 `itemRenderer` 로 처리하고
		- 조건별 스타일이 필요한 경우는 `itemRendererFunction` 으로 분기하는게 좋겠다
			- 가능하면 공통 처리에 필요한 function 은 `RendererManager.chooseRenderer` 와 같이 global 하게 처리하도록 한다
	1. formatting 과 style 이 복합적으로 필요한 경우
		- 위의 두 가지 사항으로 custom renderer 작성의 필요성이 크게 줄어들긴 한다
		- global level 보다는 module level 에서 작성한다

#### DataGrid
- `columns:IList`
- `dataProvider:IList`
- `itemRenderer:IFactory`

#### GridColumn
- `dataField:String`
- `labelFunction:Function` dataField 보다 디테일한 조정 가능
	- `function(item:Object, column:GridColumn):String`
- `formatter:IFormatter` Cell 내부의 내용을 formatting 한다
- `itemRenderer:IFactory` 
- `itemRendererFunction` 조건에 따라 itemRenderer 를 분기하고 싶을 경우 사용한다
	- `function(item:Object, column:GridColumn):IFactory` 형식으로 지정한다



# 참조 관계

## GridColumn 과 ItemRenderer 에서의 상호 참조

#### DataGrid
selection 관련 항목들을 통해서 참조 가능 (index 를 알아낸 다음 columns 를 통해 접근)

#### GridColumn
- `readonly columnIndex:int`
- `readonly grid:DataGrid`

#### IGridItemRenderer
- `column:GridColumn`
- `readonly columnIndex:int`
- `rowIndex:int`

--------------------------------------------------------------------------------



--------------------------------------------------------------------------------

## row, column size 관련 속성들

#### DataGrid
- `resizeableColumns:Boolean=true`
- `rowHeight:int`
- `variableRowHeight:Boolean`
- `typicalItem:Object` 해당 아이템이 column 의 기준 사이즈가 된다
- width, height 지정 없을 경우, 보여질 column 과 row 를 지정해서 나타내야 할 경우
	- `requestedColumnCount`
	- `requestedMaxRowCount:int`
	- `requestedMinColumnCount:int`
	- `requestedMinRowCount:int`

#### GridColumn
- `width`
- `minWidth`
- `maxWidth`
- `resizeable:Boolean`

--------------------------------------------------------------------------------

## selection 관련 속성들

#### DataGrid
- `selectionMode:String=none|singleRow|singleCell|multipleRows|multipleCells`
	- `none` selection 되지 않는다
	- `singleRow` 한 줄씩만 selection 된다
	- `multipleRows` ctrl + click 을 통해 여러 줄이 selection 된다
	- `singleCell` 한 cell 만 selection 된다
	- `multipleCells` 여러 cell 들이 selection 된다
- get selection
	-  singleCell, multipleCells 전용 
		- `selectedCell:CellPosition` selectionMode cell 전용
		- `selectedCells:Vector.<CellPosition>` 
	- singleRow, multipleRows 전용
		- `selectedIndex:int`
		- `selectedIndices:Vector.<int>`
		- `selectedItem:Object`
		- `selectedItems:Vector.<Object>`
- `preserveSelection:Boolean=true` sort 시에 selection 표시가 유지되게 한다
	- `selectionMode` 가 singleRow, singleCell 일 때만 정상적으로 작동된다
- `requireSelection:Boolean` 반드시 한 개 이상 선택된 항목이 있게 한다

#### IGridItemRenderer
- `selected:Boolean`

--------------------------------------------------------------------------------

## dataTip 관련 속성들

#### DataGrid
- `showDataTips:Boolean`
- `dataTipField`
- `dataTipFunction`

#### GridColumn
- `showDataTips:Boolean` dataTip 을 보여주기 위해서는 활성화가 필수적이다
- `dataTipField` showDataTips 필요, 특정 field 를 지정해서 보여준다
- `dataTipFormatter` dataTipField 에 영향을 미친다. dataTipFunction 에는 영향을 미치지 않는다 
- `dataTipFunction`
	- `function(item:Object, column:GridColumn):String` 형식으로 지정한다
- <del>!!! 문제점이 dataTip 을 보여주는 위치가 너무 거지 같다는 것... 조절 가능한지 알아보자</del>
	- dataTip 의 생성 로직 및 위치 조절
		- 관여되는 class 는 `spark.components.gridClasses.GridItemRenderer` 
			- dataTip 위치의 조절 
				1. `GridItemRenderer#constructor` 에서 tooltip event 를 걸게 된다
				1. `static mx_internal toolTipShowHandler(event:ToolTipEvent):void` 에서 위치 등을 조절
				1. 이 부분은 상당히 커스텀하기 까다롭게 되어 있다.
			- toolTip 의 생성
				1. `GridItemRenderer#updateDisplayList` 에서 `initializeRendererToolTip` 를 매 번 호출
				1. `GridColumn.showDataTips` 항목을 읽어서 `toopTip` 항목을 조절해주게 된다
		- **위치 조절이 거지 같이 되어 있다. dataTip 이 필요하다면 그냥 copy 해서 renderer 를 새로 만드는게 좋을듯 싶다**

--------------------------------------------------------------------------------

## sorting 관련 속성들

#### DataGrid
- `sortableColumns:Boolean`
- `multiColumnSortingEnabled:Boolean` true 일 경우, ctrl + click 을 통해서 우선 순위 sorting 을 할 수 있게 한다	

#### GridColumn
- `DataGrid` 상위에서 설정
	- `sortableColumns:Boolean`
- **`ArrayCollection` 에서만 작동한다. `ArrayList` 에서는 작동하지 않는다**
- `sortable`
- `sortCompareFunction`
	- 기본적으로는 문자 내부의 숫자를 a1, a10, a2 형태로 정렬시킨다
	- 하지만, 이 옵션을 사용할 경우 substr 등을 통해서 a1, a2, a10 형태로 정렬이 가능하다
	- `function(a:Object, b:Object, column:GridColumn):int` return 값은 array sort 와 같다 (0, 1, -1)
- `sortDescending:Boolean` header 를 클릭해서 정렬시. 최초 클릭시에 내림차순(높은 값부터 보여주고 싶다면) true 로 설정한다

--------------------------------------------------------------------------------

## editable 관련 속성들

#### DataGrid
- `editable:boolean`
- `editorColumnIndex:int` ???
- `editorRowIndex:int` ???
- `itemEditor`
- `imeMode`
- `editorActivationMouseEvent:GridItemEditorMouseEvent`

#### GridColumn
- `editable:Boolean`
- `itemEditor`
- `rendererIsEditable:Boolean` editable 로 설정된 DataGrid 내에서 cell 에 focus 가 들어 갔을때, itemEditor 가 뜨지 않게 해준다.
- `imeMode` 특정 언어권 문자로 타이핑 되도록 설정
- `editorActivationMouseEvent:GridItemEditorMouseEvent`






# 시점 특징들

#### DataGrid

#### IGridItemRenderer

`UIComponent` 를 상속받은 경우, `updateDisplayList` 는 `data` 나 `column` 이 바뀔때는 일어나지 않는다   
기본적인 `itemRenderer` 가 새로 만들어진 뒤 `prepare` 이전 시점 초기화 시나, `column` 의 사이즈를 바꿀때 주로 일어난다   
즉, 기본적인 layout 구성의 틀을 바꿀때 이외에는 `updateDisplayList` 는 발생되지 않는다.

- 거의 매 순간 들어오는 항목들
	- `set hovered(value:Boolean)`
	- `set selected(value:Boolean)`
	- `set showsCaret(value:Boolean)`
- prepare 이전 시점에 추가적으로 들어오는 항목들
	- `set rowIndex(value:int)`
	- `set column(value:GridColumn)`
	- `set label(value:String)`
	- `set data(value:Object)`
- drawing 시점들
	- `discard(willBeRecycled:Boolean):void`
		- `DataGrid` 의 `removeElement` 상황에서는 발생되지 않는다
		- `Column.itemRenderer` 를 통해 교체 해줄때 true parameter 를 가지고 발생된다
		- 즉... 망할 dispose 구간이 없다
			- 그러므로 `bitmap` 같은걸 사용해서 성능에 예민한 경우 `removeElement` 시점에 `column.itemRenderer=null` 을 한 번 쳐주고 가면 좋을듯 싶다.
	- `prepare(hasBeenRecycled:Boolean):void`
		- 안정적이다... updateDisplayList 와 각 종, property 에 대한 적용이 다 끝난 뒤에 발생된다
		- 겁나 자주 발생된다... 매번 그려대다간 cpu over 는 기본이다
	- `discard` 가 딱히 안정적이지는 않은듯 싶다. graphics drawing 시점에 있어서 `prepare` 이후에 발생해서 공백을 만들어 버리는 에러도 발생을 한다

--------------------------------------------------------------------------------

--------------------------------------------------------------------------------

# Style 편집

- color ???
	- `borderColor`
	- `caretColor`
	- `symbolColor`
	- `selectionColor`
	- `rollOverColor`
- scroll ???
	- `horizontalScrollPolicy`
	- `verticalScrollPolicy`

## `DataGridSkin` 각 part 들 분석

- `caretIndicator` mouse 의 마지막 click selection 위치인 caret 을 그린다. 
	- implement `spark.components.gridClasses.IGridVisualElement`
	- use style `caretColor`
	- `<Rect><SolidColorStroke>`
- `selectionIndicator` selection 된 cell, row 의 background color 를 그린다. 
	- implement `spark.components.gridClasses.IGridVisualElement`
	- use style `selectionColor`
	- `<Rect><SolidColor>`
- `hoverIndicator` mouse 의 roll over 를 그린다.
	- implement `spark.components.gridClasses.IGridVisualElement`
	- use style `rollOverColor`
	- `<Rect><SolidColor>`
- ??? `dropIndicator` 아마도 drag and drop 시에 외곽선을 그려주는 역할일듯
	- implement `flash.display.DisplayObject`
	- `<Rect><SolidColorStroke>`
- `editorIndicator` 
	- `rendererIsEditable` 이 걸린 column 에 edit focus 가 들어갈때 배경색을 그려준다
	- implement `mx.core.IVisualElement`
	- `<Rect><SolidColor>`
	
- alternatingRowColorsBackground
- headerRenderer
- columnSeparator
- headerColumnSeparator
- lockedColumnsSeparator
- lockedRowsSeparator
- rowSeparator

## `DataGrid` 해킹

- row, column merge 가능하게 확장해보기
- renderer 재사용 문제에 대한 분석 및 해결 방안