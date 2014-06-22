---
primary: 5b2dcbe36d
date: '2013-04-23 21:13:52'

---

# Chart.series

기본적으로 `Series` 객체는 논리적 모델이 아닌, `DisplayObject` 이므로 여러 Chart 에서 공용으로 사용하긴 힘들다. 이 문제는 하나의 `SeriesControl` 을 작성해서 여러 `Chart` 를 조정하는 것을 어렵게 한다.

# StackedSeries Error

간단하게 설정되어 있는 `Series` 들을 `Array` 에 묶어서 `Chart` 에 넣어주는 것 만으로 `Series` 에 대한 설정은 간단하게 처리할 수 있다. 하지만, 문제점은 `StackedSeries` 가 **추가, 삭제 이후 렌더링이 정상적으로 되질 않는** 문제점을 가지고 있다.

> 이 문제는 현재까지 시도해본 invalidation 말고, 다른 시도를 통해 해결 가능한지 알아볼 필요가 있다.

# 논리적 Series Factory Model 만들기

	<SeriesModel id="model">
		<ColumnSeriesModel xfield="" yfield="" labelField="" visible="false" />
		<!-- Stacked Model 은 최상위 SeriesModel 에만 추가 가능하다 -->
		<StackedColumnModel visible="true">
			<ColumnSeriesModel />
			<ColumnSeriesModel />
		</StackedColumnModel>
		...
	</SeriesFactoryModel>

	<!-- 여러 Chart 에서 공유가 가능하다 -->
	<mx:ColumnChart series={model.activatedSeries} />
	<mx:ColumnChart series={model.activatedSeries} />
	
	<!-- Legend + CheckBox List -->
	<SeriesActivator model="{model}" />
	
	<!-- Legend -->
	<SeriesLegend model="{model}" />

논리적 Model 을 기준으로 해서 확장 Component 들을 구성하면 꽤 괜찮은 구성이 될 것 같다.