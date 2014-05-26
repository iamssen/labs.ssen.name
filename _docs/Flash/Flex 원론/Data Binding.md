# Watch Binding

## `{ }` 를 사용하기
	<s:Label text="{instance.property}" />
	<s:Label text="{instance.method()}" />
	
	<fx:CurrencyFormatter id="usdFormatter" precision="2" currencySymbol="$" alignSymbol="left" />
	<s:Label text="usdFormatter.format(instance.property)}" />
	

## fx:Binding
	<fx:Binding source="source.property" destination="instance.property" />

## BindingUtils
	// bindProperty() : ChangeWatcher
	// ChangeWatcher.unwatch();
	BindingUtils.bindProperty(instance, "property", source, "property");


## 양방향 링크
	<!-- t1, t2 가 동일하게 적용된다 -->
	<s:TextInput id="t1" text="@{t2.text}" />
	<s:TextInput id="t2" />


## event dispatch type 설정
	[Bindable(event="fooEvent")]
	private function get foo():String {
		return "foo";
	}
	
	private function fooChange():void {
		dispatchEvent(new Event("fooEvent"));
	}


`{this.foo}` 를 통해 바인딩

## method 연결
	public function update(value:String):void {
		trace(value);
	}
	<s:TextInput id="txt" text="setter" />
	
	// bindSetter() : ChangeWatcher
	BindingUtils.bindSetter(update, txt, "text");


`id="txt"` 가 변경될 시에 `update()` 가 호출된다.




# bindSetter 를 통해서 Binding 을 Event Listener 처럼 활용하기

참고 : <http://www.codeproject.com/KB/applications/FlexDataBindingTricks.aspx?display=Print>

## 도트 경로 사용하기
	// instance.a.b.c 가 바인딩 설정 된다.
	// 그룹 감지가 아님...
	BindingUtils.bindSetter(method, instance, ["a", "b", "c"]);

## getter method 설정
	var reciver:Function = function (host:Object):String {
		return "hello" + host["prop1"]+host["prop2"]+host["prop3"]+host["prop4"];
	}
	
	BindingUtils.bindSetter(arrayedSetter, this, {name:"prop1", getter:reciver});
	BindingUtils.bindSetter(arrayedSetter, this, {name:"prop2", getter:reciver});
	BindingUtils.bindSetter(arrayedSetter, this, {name:"prop3", getter:reciver});
	BindingUtils.bindSetter(arrayedSetter, this, {name:"prop4", getter:reciver});
	
	---
	
	private function arrayedSetter(...values):void
	{
		trace("arrayedSetter", values);
	}
	



# `[Bindable]` 이 compiler 에서 해석되는 방식

기본 `[Bindable] public var property:String;` 같이 선언된 variable 은 `mxmlc` 나 `compc` 같은 compiler 에 의해서 아래와 같은 구조로 재해석된다.

original
	
	[Bindable]
	public var property:String;

generated

	private var _property:String;

	public function get property():String {
		return _property;
	}

	public function set property(value:String):void {
		var oldValue:String = _property;
		_property = value;
		if (hasEventListener("propertyChange")) {
			dispatchEvent(PropertyChangeEvent.createUpdateEvent(this, "property", oldValue, value));
		}
	}

여기서 `PropertyChangeEvent` 가 매우 중요한데, DataGrid 의 GridItemRenderer 와 같은 특수한 Component 들의 경우, Binding 된 property 의 갱신에 있어서 `PropertyChangeEvent` 만을 바라보는 경우가 있다.

---------

즉, 자주 사용하는 `[Bindable("varChanged")]` 같은 형태가 있는데,

	private var _var:String;

	[Bindable("varChanged")]
	public function get var():String {
		return _var;
	}

	public function set var(value:String):void {
		_var=value;
		dispatchEvent(new Event("varChanged"));
	}

이 경우처럼 만들어진 `[Bindable("event")]` 은 DataGrid 와 같은 몇 몇 Component 들에서 작동이 안되는 경우가 발생한다.

> 그렇기 때문에 getter / setter 로 만들어야 하는 경우라도    
> compiler 의 작동 그대로를 흉내내 주기 위해   
> `PropertyChangeEvent` 를 사용해 주는 것이 좋다.

#### 코딩 편의성

하지만, 위와 같이 코딩을 하려면 상당한 피로도가 발생하게 되는데, 아래와 같은 Code Template 을 Flash Builder 나 기타 IDE 에 등록해 놓고 사용하는 것이 유용하다.

	//---------------------------------------------
	// ${name}
	//---------------------------------------------
	private var _${name} : ${type};

	/** ${name} */
	[Bindable]
	${public} function get ${name}() : ${type}
	{
	    return _${name};
	}
	${public} function set ${name}(value : ${type}):void
	{
		var oldValue : ${type} = _${name};
		_${name} = value;
		// TODO
		if (hasEventListener(PropertyChangeEvent.PROPERTY_CHANGE)) {
			dispatchEvent(PropertyChangeEvent.createUpdateEvent(this, "${name}", oldValue, _${name}));
		}
	}${cursor}








