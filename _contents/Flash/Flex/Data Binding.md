---
primary: 19f0bfc4d3
date: '2013-08-31 15:49:14'

---

Data Binding
=========================================

### `{ }`

```mxml
<s:Label text="{instance.property}" />
<s:Label text="{instance.method()}" />

<fx:CurrencyFormatter id="usdFormatter" precision="2" currencySymbol="$" alignSymbol="left" />
<s:Label text="usdFormatter.format(instance.property)}" />
```

가장 기본적인 Data Binding 형태다.


### fx:Binding (_왠만해서 쓸 일이 없다. 보기도 빡세다._)

```mxml
<fx:Binding source="source.property" destination="instance.property" />
```

### BindingUtils

```as3
BindingUtils.bindProperty(instance, "property", source, "property");

// 해석해보자면 아래와 같다.
// <instance property="{source.property}" />

// 수동으로 구현하는 Binding이기 때문에 해제 역시 수동으로 해주는 것이 좋다.
// bindProperty() : ChangeWatcher // bindProperty()는 ChageWatcher를 반환한다
// ChangeWatcher.unwatch(); // ChangeWatcher.unwatch()는 Data Binding 을 위해 작동하는 EventListener를 해제한다
```

Script에 의해서 동적으로 Binding이 구현되어야 하는 경우 쓸 수 있다.


### Twoway Binding (_== Writable Binding_)

```mxml
<!-- t1, t2 가 동일하게 적용된다 -->
<s:TextInput id="t1" text="@{t2.text}" />
<s:TextInput id="t2" />
```

설명을 하자면 위와 같지만... (_`t2`를 수정하면 `t1`에도 적용이 된다._)

```mxml
<fx:Script>
	<![CDATA[
		var model:Model;
	]]>
</fx:Script>

<s:TextInput text="@{model.text}"/>
```

실제로는 이렇게 사용되어질 수 있다. 즉, `TextInput`과 같은 사용자의 입력이 즉각적으로 반영되길 원할 때 사용되어질 수 있다.

즉, 기본 Data Binding이 읽기 전용 이라면, `@` 마크는 쓰기를 하고 싶을 때 쓸 만하다.

단, 주의 할 것은... Component에 따라서 안정적이지 않게 작동되는 경우가 있다.


### Property Change 시에 method 실행 (_사용하지 않는 편이 좋다_)

```mxml
<fx:Script>
	<![CDATA[
		public function update(value:String):void {
			trace(value);
		}

		// bindSetter() : ChangeWatcher
		BindingUtils.bindSetter(update, txt, "text");
	]]>
</fx:Script>

<s:TextInput id="txt" />
```

위와 같이 구성하면 `txt.text`가 변경될 때마다 `update()`가 실행되게 된다.

왠만하면 사용하지 않는 편이 좋다. (_Data Binding 자체가 EventListener에 의해 작동되는데, 이 EventListener가 또다른 method를 실행시키는 것은 괴상한 구조가 될 수 있다._) Data Binding을 위해 dispatch 되는 Event가 있으므로, EventListener로 처리하는게 좋다.


### 도트 경로 사용하기

```as3
// instance.a.b.c 가 바인딩 설정 된다.
// 그룹 감지가 아님...
BindingUtils.bindSetter(method, instance, ["a", "b", "c"]);
```

## getter method 설정
	
```as3
var reciver:Function = function (host:Object):String {
	return "hello" + host["prop1"]+host["prop2"]+host["prop3"]+host["prop4"];
}

BindingUtils.bindSetter(arrayedSetter, this, {name:"prop1", getter:reciver});
BindingUtils.bindSetter(arrayedSetter, this, {name:"prop2", getter:reciver});
BindingUtils.bindSetter(arrayedSetter, this, {name:"prop3", getter:reciver});
BindingUtils.bindSetter(arrayedSetter, this, {name:"prop4", getter:reciver});

private function arrayedSetter(...values):void
{
	trace("arrayedSetter", values);
}
```



Data Binding의 원리
=================================

### `[Bindable]`이 해석되는 방식

Data Binding은 기본적으로 `getter / setter`와 `Event`에 의한 구현이다.

```as3
[Bindable]
public var proeprty:String;
```

이와 같은 형태의 코드는 아래와 같이 변환된다.

```as3
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
```

`[Bindable]`이 붙으면 `mxmlc`에 의해서 `PropertyChangeEvent`를 Dispatch하는 `getter / setter`로 변환이 된다.


### `{}`이 구현되는 방식

Binding 되는 아래와 같은 코드는

```mxml
<s:TextInput id="input" text={obj.variable} />
```

실제는 아래와 같이 변환되어 구현되게 된다. (_코드 구성은 실제 좀 다르지만 맥락 상은 같다_)

```as3
obj.addEventListener(PropertyChangeEvent.CHANGE, propertyChanged);

private function propertyChanged(event:PropertyChangeEvent):void {
	input.text = event.value;
}
```

### Data Binding을 이해할 때 중요한 개념들

1. Data Binding은 `EventListener`에 의한 구현이다. **남발 하다가는 Garbage Collection 문제가 생겨 Memory 누수가 발생할 수 있다.**
1. 기본적으로 Actionscript에는 Data Binding이라는 기능이 없다. `[Bindable]`이나 `{}`과 같은 기능들을 구현하기 위해 `mxmlc` 컴파일러는 `.as`나 `.mxml` 파일을 한 번 해석해서 실제 작동 가능한 Actionscript를 만들게 된다. (_그렇기 때문에 실제 우리가 개발시에 사용하는 `.as`나 `.mxml`은 사실 Source To Source Compiler Language 라고 볼 수 있다._)

이 해석 과정을 좀 더 정확히 알고 싶다면 `mxmlc`의 Compiler Argument에 `keep-generated-actionscript=true` 옵션을 붙여보면 된다. 기본적으로는 감춰지게 되는 `mxmlc`에 의해 만들어진 순수한 Actionscript 파일을 볼 수 있다.



`[Bindable("someEventType")]` 형태의 위험성
====================================================================

`[Bindable]`의 옵션 중에서 `[Bindable("someEventType")]`과 같은 형태가 있다. 

```as3
<fx:Script>
	<![CDATA[
		[Bindable("someEventType")]
		private var str:String;

		private function dispatchStr():void {
			dispatchEvent(new Event("someEventType"));
		}
	]]>
</fx:Script>

<s:TextInput text="{str}"/>
```

이런 식으로 사용되기 위해서인데, `TextInput`이 "someEventType"이라는 `Event`를 알게 되는 것은 `mxmlc` 컴파일 시점에서 이다. **즉, 컴파일 시에 "someEventType"을 알게 되고, 런타임 시에 "someEventType"을 알 수 있는 방법은 없다는 이야기 이다.**

뭐 어려운 이야기 할 필요 없고, 이 방식은 `DataGrid`와 같이 런타임 시에 Binding 관계를 설정하는 Component 들에서는 작동하지 않는다는 이야기가 된다.

```as3
<fx:Script>
	<![CDATA[
		[Bindable]
		private var str:String;

		private function dispatchStr():void {
			dispatchEvent(PropertyChangeEvent.createUpdateEvent(this, "str", null, str));
		}
	]]>
</fx:Script>

<s:TextInput text="{str}"/>
```

그래서 가능한한 이와 같이 `[Bindable]`의 기본 `Event`인 `PropertyChangeEvent`를 사용해 주는 것이 좋다.

하지만, 위와 같이 코딩을 하려면 상당한 피로도가 발생하게 되는데, 아래와 같은 Code Template 을 Flash Builder 나 기타 IDE 에 등록해 놓고 사용하면 유용하다.

```as3
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
```







