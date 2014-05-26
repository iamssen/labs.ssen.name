---
primary: d2cdd6db63

---

# 차트 모양 컨트롤

## References

### Style
- [Using strokes with chart controls](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7c65.html#WS2db454920e96a9e51e63e3d11c0bf65816-7ff2)
- [Formatting axis lines](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf65816-7ff4.html)
- [Applying chart styles](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf65816-7fff.html#WS2db454920e96a9e51e63e3d11c0bf65816-7ff9)
- [Setting padding properties](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf65816-7ff6.html)
- [Using multiple axes](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7c4f.html)
- [Using multiple data series](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7c6c.html)
- [Stacking Chart](http://livedocs.adobe.com/flex/3/html/help.html?content=charts_displayingdata_11.html)
- [Using filters with chart controls](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7e69.html)

### Label
- [Defining axis labels](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7c24.html#WS2db454920e96a9e51e63e3d11c0bf69084-7c4e)

### Interaction

- [Selecting chart items](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7bfd.html)

## Cheat Sheet

- Common
	- `Chart.showDataTips`, `Chart.showAllDataTips`
	- [Box Model](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf65816-7ff6.html)
		- `Chart.paddingLeft`, `Chart.paddingRight`, `Chart.paddingTop`, `Chart.paddingBottom`
		- `Chart.gutterLeft`, `Chart.gutterRight`, `Chart.gutterTop`, `Chart.gutterBottom`
		- `AxisRenderer.labelGap`
- Axis (PieChart 를 제외한 모든 Axis 기반의 Chart 들에 공통적으로 사용되는 Axis 에 관련된 모양들) 
	- [Axis Line](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf65816-7ff4.html)
		- `AxisRenderer.showLine`
		- `AxisRenderer.axisStroke`
	- [Axis Tick](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf69084-7c19.html)
		- `AxisRenderer.tickStroke`
		- `AxisRenderer.minorTickStroke`
		- `AxisRenderer.tickPlacement`
		- `AxisRenderer.minorTickPlacement`
		- `AxisRenderer.tickLength`
	- Axis Background Line
	- Axis Value Label
		- `AxisRenderer.labelAlign`
	- Axis Title Label
- Axis Chart Box Model
	- Padding
	- Gutter
- Legend
	- Legend Icon
	- Legend Label
- Area
- Line
	- `LineSeries.itemRenderer`
	- `LineSeries.stroke`
	- `LineSeries.lineStroke`
	- `LineSeries.fill`
	- `LineChart.seriesFilters`
- Bubble
- Bar
	- `BarSeries.stroke`
	- `BarSeries.fill`
- Column
	- `ColumnSeries.labelField`, `ColumnSeries.labelFunction(item:ChartItem, series:Series):String`
	- `ColumnSeries.stroke`
	- `ColumnSeries.fill`, `ColumnSeries.fills`, `ColumnSeries.fillFunction(item:ChartItem, index:Number):IFill`
- Plot
- Candlestick
- Pie
	- links
		- [Using pie charts](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf6568f-8000.html)
	- Pie Wedge
		- `PieChart.explodeRadius`, `PieSeries.perWedgeExplodeRadius` [파이 간 간격이 얼마나 벌어지게 할지 여부](http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf6568f-8000.html#WS2db454920e96a9e51e63e3d11c0bf6568f-7ff1)
		- `PieChart.innerRadius`
	- Pie Wedge Label
		- `PieChart.labelField`, `PieChart.labelFunction(field:Sring, index:Number, item:Object, percentValue:Number):String` Pie Data Field
		- `PieChart.labelPosition = none | callout | inside | outside | insideWithCallout`
			- `calloutGap`
			- `calloutStroke`
			- `insideLabelSizeLimit`
	- Pie Wedge Color
		- `PieChart.selectionMode`
		- `PieSeries.fills`
		- `PieChart.filters`, `PieSeries.filters`
	- Pie Wedge Selecting
	
## Classes

- [ChartBase](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/chartClasses/ChartBase.html)
	- [CartesianChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/chartClasses/CartesianChart.html)
		- [AreaChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/AreaChart.html)
		- [LineChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/LineChart.html)
		- [BarChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/BarChart.html)
		- [ColumnChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/ColumnChart.html)
		- [BubbleChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/BubbleChart.html)
		- [PlotChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/PlotChart.html)
		- [CandlestickChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/CandlestickChart.html)
		- [HLOCChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/HLOCChart.html)
	- [PolarChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/chartClasses/PolarChart.html)
		- [PieChart](http://help.adobe.com/ko_KR/FlashPlatform/reference/actionscript/3/mx/charts/PieChart.html)
		
	
	