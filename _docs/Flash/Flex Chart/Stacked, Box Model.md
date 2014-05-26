# Bar, Column Chart Api

- chart type control `stacked`, `clustered`, `overlaid`, `100%`
	- <http://blog.flexexamples.com/2007/10/11/creating-clustered-stacked-overlaid-and-100-bar-charts-in-flex-3/>
- datatip control
	- <http://blog.flexexamples.com/2007/10/11/creating-clustered-stacked-overlaid-and-100-bar-charts-in-flex-3/>
- box model control
	- padding
	- gutter
	- axis
	- label gap
	- axis label
	- <http://help.adobe.com/en_US/flex/using/WS2db454920e96a9e51e63e3d11c0bf65816-7ff6.html>
- bar data animation

## clustered 와 stacked

	// Data
	[Bindable]
	public var data:IList=new ArrayCollection([
		{Country: "USA", Gold: 35, Silver: 39, Bronze: 29}, 
		{Country: "China", Gold: 32, Silver: 17, Bronze: 3},
		{Country: "Russia", Gold: 27, Silver: 27, Bronze: 38}
	]);

	// Chart
	<s:Panel title="BartChart Staked Sample" width="600" height="400">
		<mx:BarChart showDataTips="true" dataProvider="{data}" width="100%" height="100%">

			<mx:verticalAxis>
				<mx:CategoryAxis categoryField="Country"/>
			</mx:verticalAxis>

			<mx:series>
				<mx:BarSet type="clustered">
					<mx:BarSet type="stacked">
						<mx:BarSeries yField="Country" xField="Gold" displayName="Gold"/>
						<mx:BarSeries yField="Country" xField="Silver" displayName="Silver"/>
						<mx:BarSeries yField="Country" xField="Bronze" displayName="Bronze"/>
					</mx:BarSet>
					<mx:BarSeries yField="Country" xField="Gold" displayName="Gold"/>
					<mx:BarSet type="stacked">
						<mx:BarSeries yField="Country" xField="Silver" displayName="Silver"/>
						<mx:BarSeries yField="Country" xField="Bronze" displayName="Bronze"/>
					</mx:BarSet>
				</mx:BarSet>
			</mx:series>
		</mx:BarChart>
	</s:Panel>

![series](images/Stacked.png)

- `BarSet.type=="clustered"` 는 개별 막대로 보여질 데이터의 그룹임을 표현
- `BarSet.type=="stacked"` 는 하나의 막대 내에서 보여질 데이터의 그룹임을 표현
- 당연히 여러 막대 그룹을 정의하는`clustered` 는 하나의 막대 그룹을 정의하는 `stacked` 를 포함할 수 있으나, 반대의 경우에는 에러가 됨

## Chart 의 Box model

![box model](images/ChartBoxModel.png)

- `A` 는 `paddingLeft`, `paddingRight`, `paddingTop`, `paddingBottom` 의 `padding area`
- `B` 는 `gutterLeft`, `gutterRight`, `gutterTop`, `gutterBottom` 의 `gutter`