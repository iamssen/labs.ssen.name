---
primary: 4ed3de85d2
date: '2014-02-23 19:37:22'

---


Flash Metadata Tag
=============================

Flash와 Flex에서 사용되는 `[Bindable]`과 같은 Metadata Tag 형식은 두 가지 형태로 사용된다.

1. `mxmlc`에 의해 컴파일 타임에 소스를 Source To Source 컴파일을 하는데 사용되고 (_`[Bindable]`과 같이 Flex SDK에 기본 정의되어 있는 Metadata Tag들에만 해당한다. 예외적으로 더 추가하고 싶다면 Flex SDK를 수정하면 된다..._)
1. 런타임 시에 `describeType()`을 통해 Type의 정보를 XML 형태로 읽어서 사용한다.

이 중, Custom Metadata Tag 로직을 만드는데 사용되는 방식은 두 번째이다.



Sample File
=============================================

```as3
package test {

public class InjectionTarget {

	// [Inject]가 없는 Variable
	public var normalProperty:String;

	// [Inject]가 없는 Method
	public function normalMethod(p1:String, p2:String):void {

	}

	// 단순한 [Inject]가 있는 Variable
	[Inject]
	public var simpleInjectionProperty:String;

	// name 옵션을 가진 [Inject]가 있는 Variable
	[Inject(name="foo")]
	public var namedInjectionProperty:String;

	// 단순 [Inject]가 있는 Setter
	public function get accessorInjectionProperty():String {
		return null;
	}

	[Inject]
	public function set accessorInjectionProperty(d:String):void {
	}

	// 단순 [Inject]가 있는 Method
	[Inject]
	public function simpleInjectionMethod(p1:String, p2:String, p3:String):void {

	}

	// name 옵션을 가진 [Inject]가 있는 Method
	[Inject(name="", name="foo", name="")]
	public function namedInjectionMethod(p1:String, p2:String, p3:String):void {

	}
}
}
```

위의 `Class`를 `describeType()`에 넣어보면 아래와 같은 형식의 XML Data를 얻을 수 있다. (_길어서 간략화 시킨거다... 전부가 아님..._)

```xml
<type name="test::InjectionTarget" base="Class" isDynamic="true" isFinal="true" isStatic="true">
	<extendsClass type="Class" />
	<extendsClass type="Object" />
	<accessor name="prototype" access="readonly" type="*" declaredBy="Class" />
	<factory type="test::InjectionTarget">
		<extendsClass type="Object" />
		
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="29" />
		</metadata>
	</factory>
</type>
```

이 XML Data를 사용해서 `[Inject]` 정보를 분석해본다



실제 코드와 XML 정보의 매칭
==================================================

```as3
public var normalProperty:String;
```

```xml
<variable name="normalProperty" type="String">
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="59" />
	</metadata>
</variable>
```

기본 `var`는 `<variable/>`로 표현된다.

-------

```as3
[Inject]
public var simpleInjectionProperty:String;
```

```xml
<variable name="simpleInjectionProperty" type="String">
	<metadata name="Inject" />
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="169" />
	</metadata>
</variable>
```

`[Inject]`는 `<metadata name="Inject" />`로 표현된다.

-----

```as3
[Inject(name="foo")]
public var namedInjectionProperty:String;
```

```xml
<variable name="namedInjectionProperty" type="String">
	<metadata name="Inject">
		<arg key="name" value="foo" />
	</metadata>
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="236" />
	</metadata>
</variable>
```

`[Inject(name="foo")]`와 같은 Metadata의 Option은 `<arg key="name" value="foo" />`로 표현된다.

-------

```as3
public function get accessorInjectionProperty():String {
	return null;
}

[Inject]
public function set accessorInjectionProperty(d:String):void {
}
```

```xml
<accessor name="accessorInjectionProperty" access="readwrite" type="String" declaredBy="test::InjectionTarget">
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="290" />
	</metadata>
	<metadata name="Inject" />
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="377" />
	</metadata>
</accessor>
```

`function set accessorInjectionProperty(d:String):void {}`와 같은 Setter는 `<accessor />`로 표현된다. Variable과 마찬가지로 `<metadata name="Inject" />`가 붙는다. (_중요하다. Actionscript에서 Variable과 Getter / Setter의 Accessor는 다르게 취급된다._)

------

```as3
public function normalMethod(p1:String, p2:String):void {
}
```

```xml
<method name="normalMethod" declaredBy="test::InjectionTarget" returnType="void">
	<parameter index="1" type="String" optional="false" />
	<parameter index="2" type="String" optional="false" />
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="100" />
	</metadata>
</method>
```

`function normalMethod(p1:String, p2:String):void`는 `<method />`로 표현된다.

Parameter는 이름은 알 수 없으며, `<parameter index="1" type="String" />`를 통해서 `index`와 `type`을 가지고 표현된다.

-----

```as3
[Inject]
public function simpleInjectionMethod(p1:String, p2:String, p3:String):void {
}
```

```xml
<method name="simpleInjectionMethod" declaredBy="test::InjectionTarget" returnType="void">
	<parameter index="1" type="String" optional="false" />
	<parameter index="2" type="String" optional="false" />
	<parameter index="3" type="String" optional="false" />
	<metadata name="Inject" />
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="451" />
	</metadata>
</method>
```

마찬가지로 `<method />` 내부에 `<metadata name="Inject" />`를 가지고 있다.

-------

```as3
[Inject(name="", name="foo", name="")]
public function namedInjectionMethod(p1:String, p2:String, p3:String):void {
}
```

```xml
<method name="namedInjectionMethod" declaredBy="test::InjectionTarget" returnType="void">
	<parameter index="1" type="String" optional="false" />
	<parameter index="2" type="String" optional="false" />
	<parameter index="3" type="String" optional="false" />
	<metadata name="Inject">
		<arg key="name" value="" />
		<arg key="name" value="foo" />
		<arg key="name" value="" />
	</metadata>
	<metadata name="__go_to_definition_help">
		<arg key="pos" value="575" />
	</metadata>
</method>
```



