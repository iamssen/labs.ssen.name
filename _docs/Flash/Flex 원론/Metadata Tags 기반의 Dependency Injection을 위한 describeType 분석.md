# Files

	package test {

	public class InjectionTarget {
		public var normalProperty:String;

		public function normalMethod(p1:String, p2:String):void {

		}

		[Inject]
		public var simpleInjectionProperty:String;

		[Inject(name="foo")]
		public var namedInjectionProperty:String;


		public function get accessorInjectionProperty():String {
			return null;
		}

		[Inject]
		public function set accessorInjectionProperty(d:String):void {
		}

		[Inject]
		public function simpleInjectionMethod(p1:String, p2:String, p3:String):void {

		}

		[Inject(name="", name="foo", name="")]
		public function namedInjectionMethod(p1:String, p2:String, p3:String):void {

		}
	}
	}


위의 Class를 describeType으로 열어보면 아래와 같은 결과를 받을 수 있다

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


# 실제 코드와 XML 정보의 매칭

	public var normalProperty:String;
	
	<variable name="normalProperty" type="String">
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="59" />
		</metadata>
	</variable>
	
	-------------------------------------

	[Inject]
	public var simpleInjectionProperty:String;

	<variable name="simpleInjectionProperty" type="String">
		<metadata name="Inject" />
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="169" />
		</metadata>
	</variable>

	-------------------------------------

	[Inject(name="foo")]
	public var namedInjectionProperty:String;

	<variable name="namedInjectionProperty" type="String">
		<metadata name="Inject">
			<arg key="name" value="foo" />
		</metadata>
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="236" />
		</metadata>
	</variable>

	-------------------------------------

	public function get accessorInjectionProperty():String {
		return null;
	}

	[Inject]
	public function set accessorInjectionProperty(d:String):void {
	}

	<accessor name="accessorInjectionProperty" access="readwrite" type="String" declaredBy="test::InjectionTarget">
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="290" />
		</metadata>
		<metadata name="Inject" />
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="377" />
		</metadata>
	</accessor>

	-------------------------------------

	public function normalMethod(p1:String, p2:String):void {
	}

	<method name="normalMethod" declaredBy="test::InjectionTarget" returnType="void">
		<parameter index="1" type="String" optional="false" />
		<parameter index="2" type="String" optional="false" />
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="100" />
		</metadata>
	</method>

	-------------------------------------

	[Inject]
	public function simpleInjectionMethod(p1:String, p2:String, p3:String):void {
	}

	<method name="simpleInjectionMethod" declaredBy="test::InjectionTarget" returnType="void">
		<parameter index="1" type="String" optional="false" />
		<parameter index="2" type="String" optional="false" />
		<parameter index="3" type="String" optional="false" />
		<metadata name="Inject" />
		<metadata name="__go_to_definition_help">
			<arg key="pos" value="451" />
		</metadata>
	</method>

	-------------------------------------

	[Inject(name="", name="foo", name="")]
	public function namedInjectionMethod(p1:String, p2:String, p3:String):void {
	}

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




