# Flex Component 분석

## container 분석
- s:TileGroup
- s:Panel
- s:TitleWindow


## controls 분석

단순한 xml + image 를 통해서, skin file 들을 generate 시킬 수 있는 도구가 필요할 듯

### display data

- s:DataGroup
	- 상당히 낮은 수준 (DataGroup > GroupBase > UIComponent) 의 API 에 속한다
	- complex 하지 않은 데이터들을 renderer 들을 통해 단순 출력 하는데 도움이 될듯
		- 출력시 selection 에 의한 삭제 등도 간편하다. (데이터만 remove 하면 되니...)
	- scroll 이 끊어지지 않는다. 끊어지는 scroll 의 경우는 List 를 이용해야 한다
	
- s:List
	- skin control
		- Container 외곽을 Custom 해보기
		- Scroll 영역과 Container 영역의 스킨을 분할해보기
		- 망할 이미지 튀지 않게 렌더링 해보기
		- Background 에 이미지 넣어보기
		- Validator 를 통해서 errorSkin 적용해보기
	- layout control
		- Custom 시에 List 와 Renderer 가 분할하는 스킨 영역에 대해서 파악하기
		- Tree 형태로 custom 가능한지 확인
		- 가로로 변경할 수 있는지 확인
	- user control
		- Drag and drop 형식에 대해 정확히 파악하기
		- 쓰기 입력을 시도해보기 (TextInput, CheckBox, ComboBox...)
		- Editable List
			- [List Editable Cell](http://dgrigg.com/blog/2010/06/25/editable-itemrenderer-for-flex-4-spark-list/)
		- Double Click 이벤트를 명확히 해보기
		- 특정 index 로 스크롤링 시키기, 마지막으로 스크롤링 시키기
		- selection, unselection api 와 관련 event 모두 수집
		- invalidation 으로 drawing 컨트롤하기
	- links
		- [List 컴포넌트 개론](http://help.adobe.com/en_US/flex/using/WSc2368ca491e3ff923c946c5112135c8ee9e-7fff.html)
		- [특정 인덱스로 스크롤링](http://invincure.tistory.com/entry/FLEX-Spark-List-control-in-Flex-4-%ED%8A%B9%EC%A0%95-%EC%9D%B8%EB%8D%B1%EC%8A%A4%EB%A1%9C-%EC%8A%A4%ED%81%AC%EB%A1%A4%EB%A7%81)
		- [List 컴포넌트 백그라운드 이미지 넣기](http://dgrigg.com/blog/2010/07/06/flex-spark-list-with-custom-scroll-bar-and-itemrenderer/)
		- [Layout 의 기준 데이터가 되는 typicalItem 1](http://evyatar-flex.blogspot.com/2012/05/reuse-spark-list-by-replacing-its-item.html)
		- [Layout 의 기준 데이터가 되는 typicalItem 2](http://hansmuller-flex.blogspot.com/2011/05/using-datagrid-typicalitem-to-define.html)
		- [List 아이템을 Looping](http://stackoverflow.com/questions/2554075/flex-4-enumerating-spark-list-items)
		- [바닥으로 Scoll 이동 시키기](http://flexponential.com/2011/02/13/scrolling-to-the-bottom-of-a-spark-list/)
		- [Spark Container 의 Layout, Scrolling, Viewports](http://blog.jidolstar.com/568)
		- [invalidation 을 통한 전체 Renderer 리프레시](http://www.jeffryhouser.com/index.cfm/2011/1/25/How-do-you-force-rendereres-to-refresh-in-a-spark-list)
		- [Data Container Drag and Drop 개론](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7cfd.html)
		- [스크롤 대신 상, 하 버튼으로 커스터마이징 시키기](http://flexponential.com/2009/10/09/changing-the-position-of-the-scroll-bars-in-a-spark-list/)
		- [타일리스트 Drag and Drop 시에 애니메이션 적용](http://www.rialitycheck.com/blog/index.cfm/2011/3/3/Animating-Spark-List-Items)
		- [Tree Type List](http://prsync.com/adobe/displaying-tree-like-hierarchical-data-in-a-spark-list-15515/)
		- [List Item Double Click](http://prsync.com/adobe/displaying-tree-like-hierarchical-data-in-a-spark-list-15515/)
		
- s:DataGrid

- mx:AdvancedDataGrid
	- writable
		- 망할 writable 상태 컨트롤이 힘들다.
			- ElasticDataGrid 를 따로 만들어서 사용할 필요가 있다
			- writable 상태에서의 tab key control, validation 이 중요하다 
	- tree
		- Tree 형태 커스텀 시에 짜증이 치밀어오르게 된다.
			- 새로운 control 을 만들기엔 손해가 크다.
			- skin custom 시킬 방식을 확보해두는 것이 좋다
			
- mx:OLAPDataGrid
- mx:ProgressBar

- mx:Tree
	- menu 의 다양한 디자인으로 custom 시에 짜증이 치솟는다
		- 새로운 control 을 만들기엔 손해가 크고, 
		- skin custom 방식을 많이 확보해 두는 것이 좋다
	- 정말 custom 하느니 새로 만들고 말지 싶은 것들을 위해
		- Elastic Tree 를 만들어 두는 것도 나쁘지 않을 듯


### chart

- mx:AreaChart
- mx:BarChart
- mx:BubbleChart
- mx:CandlestickChart
- mx:ColumnChart
	- stacked 형태를 확보할 방식을 찾자
- mx:HLOCChart
- mx:LineChart
- mx:PieChart
- mx:PlotChart

답이 없다. 가능한 다양한 사례들을 확보해두는 것이 최선이다.


### display media

- s:Label
- s:RichText

- s:Image

- mx:SWFLoader

- s:VideoDisplay
- s:VideoPlayer


### trigger

- s:Button
	- icon + label 을 한꺼번에 표현할 때 애매해진다
- s:PopUpAnchor
- s:ToggleButton
- mx:LinkButton
- mx:PopUpButton


### common

- mx:ToolTip (and error tip)
	- 기본 tooltip 과 errortip 의 독립 스타일링
	- drawing 을 자유롭게 할 수 있는 방법 찾기
	- [Error Tip](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7f5c.html)
	- [Error Tip 한글](https://sites.google.com/site/koreanflexdoc/4-0/usingsdk/ws37cb61f8f3397d86-3c9628be12089177f65-8000/ws2db454920e96a9e51e63e3d11c0bf69084-7f3f/ws2db454920e96a9e51e63e3d11c0bf69084-7f5c-1)
	- [Error Tip 좌측으로 넣기)(http://cesaric.com/?p=663)
	- [Tool Tip 스타일링](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7f61.html)
	- [Tool Tip, Error Tip 스타일링](http://www.tonyamoyal.com/2009/05/05/small-tool-tips-for-adobe-flex-validation-errors/)
- mx:Validator
	- 아마도 component 는 errorSkin 상태로 바꾸고, 동시에 errortip 을 띄우게 하는듯...
	- [Validator](http://ria-java.tistory.com/60)
	- [Validator](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7f52.html)
			


### input

- s:TextInput
	- custom component 에서도 validator 결합이 되는지 확인해보기
	- validator, restrict 결합된 mediator 만들어보기
	- Validator + restrict 로 보충하기 (숫자형, 문자형, 특수형)
	- [http://ria-java.tistory.com/60](http://ria-java.tistory.com/60)
	- [http://flexscript.wordpress.com/2008/09/22/flex-creating-custom-validators/](http://flexscript.wordpress.com/2008/09/22/flex-creating-custom-validators/)
	- [http://rduk.tistory.com/47](http://rduk.tistory.com/47)
- s:TextArea
- s:RichEditableText ??? TextArea 형태가 아니다. 안쓰는게 좋겄다...




### choose

- s:CheckBox
- s:RadioButton
	- CheckBox 와 RadioButton 은 가능한 쓰지 않는다.
	- 대신 만들고 있는 List 기반의 Selector 를 사용한다
	
- s:ComboBox ( + TextInput )
	- DropDownList 를 사용해라. "선택 이외의 사용자 입력이 가능하다" 는 상황에서만 사용해라.
	
- s:DropDownList

- mx:DateChooser
	- Skin api 숙지가 필요
	- [Spark Date Chooser 1](http://visualscripts.blogspot.com/2011/10/spark-datefield-and-datechooser.html)
	- [Spark Date Chooser 2](http://blogs.adobe.com/aharui/2010/01/spark_datefield_and_colorpicke.html)
	
- mx:DateField ( + TextInput )
	- 기본 사용자 입력이 가능하게 Custom 해두자
		- TextInput focus 상황에서 tooltip 을 통해 입력 가능한 포맷에 대한 설명
		- 입력 이후 Validate 해서, 검증되면 값 적용, 잘못된 포맷이면 값 지워버리기 ( 3 ~ 4초간 errorTip 띄워주기? )  
	- [사용자 입력 이후 Validate](http://invincure.tistory.com/entry/Flex-DateField-%EC%97%90-%EC%82%AC%EC%9A%A9%EC%9E%90%EA%B0%80-%EA%B0%92%EC%9D%84-%EC%9E%85%EB%A0%A5%ED%95%98%EB%8F%84%EB%A1%9D-%ED%95%98%EA%B3%A0-validate-%ED%95%98%EA%B8%B0)


- mx:Menu
- s:ButtonBar
- s:TabBar
- mx:ColorPicker



### choose number

- s:NumericStepper ( + TextInput )
	- 정수형 숫자일 경우 쓰잘데기 없는 TextInput 작업보다 이걸로 표현하는게 더 나을수도 있다

- s:Slider
- s:Spinner

- s:ScrollBar
- s:Scroller



### layout

- s:Group
- s:Panel
- s:TitleWindow