---
primary: 93354465fc

---

# `DataGrid.editable` 을 통한 편집 기능의 분석

기본적으로 `DataGrid.editable` 을 통해서 Excel 처럼 편집이 가능하지만, 이에 대해서는

> 만들다 말았다...

로 정의 할 수 있겠다. 

1. `DataGrid` 의 기본 `DataGridSkin` 과 편집 기능은 상당한 괴리가 있다.
1. `DataGrid` 의 편집 기능으로 쓰일 여러 Component 의 기본 Skin 들이 `DataGrid` 의 모양과 어울리지 않는다.

즉, `DataGrid.editable` 을 실제적으로 사용하기 위해서는 상당한 분량의 `Skin` 작업을 요구하게 된다.

> `DataGrid` 의 Cell 에 들어가서도 어울릴만한 여러 Component Skin 들과 그에 걸맞는 형태의 새로운 `DataGridSkin` 의 구성이 가장 우선시 되고, 이는 상당한 분량의 작업을 요구하게 된다.


# `IGridItemEditor` 와 `rendererIsEditable`

### `rendererIsEditable` 을 위한 Model

`rendererIsEditable` 에 `[Bindable]` 이 걸린 Model 을 Binding 시키면 상당한 문제를 만들어내게 된다.

1. Renderer 에서 편집
1. Model 에서 `PropertyChangeEvent` 발생 시킴
1. DataGrid 에서 Event 수신 후에 갱신
1. **갱신 과정에서 focus 없어짐**

즉, **Keyboard 를 통한 편집 상황에서 focus 가 날라가버리는 문제가 발생**하게 되고, 이건 사용성에 꽤나 심각한 악영향을 미치게 된다.

`GridEditor` 나 여러 내부적인 구조들을 뜯어고쳐서 패치할 수도 있겠지만, 보다 간단하게 해결이 가능하다.

	public var property:String;

	public function setProperty(value:String):void {
		var oldValue:String=property;
		property=value;
		if (hasEventListener(PropertyChangeEvent.PROPERTY_CHANGE)) {
			dispatchEvent(PropertyChangeEvent.createUpdateEvent(this, "property", oldValue, property));
		}
	}

`[Bindable]` 을 걸지 않는 대신, `setter method` 를 통해서 접근하면, `rendererIsEditable` 에서 발생되는 이벤트 순환 문제도 없고, 외부에서 property 를 갱신할 때도 문제가 없다.




