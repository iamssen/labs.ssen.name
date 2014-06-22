---
primary: d8a5c9122f
date: '2013-06-18 15:19:34'

---

# ColumnChart data label 처리

	<mx:verticalAxis>
		<mx:LinearAxis maximum="{maximumValue}"/>
	</mx:verticalAxis>

data 를 밀어넣어 주면서 data 의 최고값 이상을 계산해서 maximum 으로 넣어주면 위쪽이 잘리지 않게 된다

	private function getMaximum(data:IList):int {
		var max:int=0;
		var obj:Object;
		var f:int=data.length;

		while (--f >= 0) {
			obj=data.getItemAt(f);
			if (obj.value > max) {
				max=obj.value;
			}
		}

		max+=(max / 4);

		return max;
	}

대충 최고값의 1/4 정도를 더 올려주면 잘리는 현상은 없어진다