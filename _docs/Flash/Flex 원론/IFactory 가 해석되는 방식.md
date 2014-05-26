# 실험과 결과

### 실험 조건

- `keep-generated-actionscript=true` 옵션을 줘서, 산출되는 Actionscript Code 를 보고 작동 원리를 분석했다

### 실험 결과

	<SomeContainer>
		<...>
			<fx:Component>
				<SomeClass a="1" />
			</fx:Component>
		<...>
	</SomeContainer>

과 같은 식으로 선언된 부분은 아래와 같은 새로운 Class 를 작성시키게 된다

	// SomeContainerInnerClass0-generated.as
	public class SomeContainerInnerClass0 extends SomeClass {
		...
		public function SampleInnerClass0() {
			super();
			...
			this.a = 1;
			...
		}
		...
	}

**즉, `constructor` 상에서 선언된 값을 넣어주는 상속된 형태의 새로운 Class 를 생성시켜서 처리한다**

### 결론

1. **작동은 안정적이다.** `<fx:Component>` 에서 선언된 속성을 런타임 시에 밀어넣지 않고 `constructor` 에서 선언하므로 문제 발생 여지가 적다.
1. **부하 가능성은 있다.** `<fx:Component>` 마다 개벌적으로 상속 Class 를 만들기 때문에 리소스의 재활용성은 떨어지게 된다.




# 증명

### 아래와 같은 세가지 파일을 작성

Container.as

	package samples.mxmlFactory {
	import mx.core.IFactory;

	public class Container {
		public var factory:IFactory;
	}
	}

Instance.as

	package samples.mxmlFactory {

	[Style(name="a", inherit="no", type="Number")]
	[Style(name="b", inherit="no", type="Number")]

	public class Instance {
	}
	}

Sample.mxml

	<?xml version="1.0" encoding="utf-8"?>
	<fx:Object xmlns:fx="http://ns.adobe.com/mxml/2009" xmlns:s="library://ns.adobe.com/flex/spark" xmlns:mxmlFactory="samples.mxmlFactory.*">
		<fx:Declarations>
			<mxmlFactory:Container id="type1" factory="samples.mxmlFactory.Instance"/>
			<mxmlFactory:Container id="type2">
				<mxmlFactory:factory>
					<fx:Component>
						<mxmlFactory:Instance a="3"/>
					</fx:Component>
				</mxmlFactory:factory>
			</mxmlFactory:Container>
		</fx:Declarations>
	</fx:Object>

### 출력된 코드들은 아래와 같다 (너무 길어서 주요 부분만 발췌)

Sample-generated.as

	package samples.mxmlFactory
	{

	public class Sample
	    extends Object
	{

	    [Bindable]
	    public var type1 : samples.mxmlFactory.Container;

	    [Bindable]
	    public var type2 : samples.mxmlFactory.Container;

	    public function Sample()
	    {
	        super();

	        // properties
	        _Sample_Container1_i();
	        _Sample_Container2_i();
	    }


	private function _Sample_Container1_i() : samples.mxmlFactory.Container
	{
		var temp : samples.mxmlFactory.Container = new samples.mxmlFactory.Container();
		temp.factory = _Sample_ClassFactory1_c();
		type1 = temp;
		mx.binding.BindingManager.executeBindings(this, "type1", type1);
		return temp;
	}

	private function _Sample_ClassFactory1_c() : mx.core.ClassFactory
	{
		var temp : mx.core.ClassFactory = new mx.core.ClassFactory();
		temp.generator = samples.mxmlFactory.Instance;
		return temp;
	}

	private function _Sample_Container2_i() : samples.mxmlFactory.Container
	{
		var temp : samples.mxmlFactory.Container = new samples.mxmlFactory.Container();
		temp.factory = _Sample_ClassFactory2_c();
		type2 = temp;
		mx.binding.BindingManager.executeBindings(this, "type2", type2);
		return temp;
	}

	private function _Sample_ClassFactory2_c() : mx.core.ClassFactory
	{
		var temp : mx.core.ClassFactory = new mx.core.ClassFactory();
		temp.generator = samples.mxmlFactory.SampleInnerClass0;
		temp.properties = {outerDocument: this};
		return temp;
	}


1. `factory="samples.mxmlFactory.Instance"` 로 작성된 부분은 `ClassFactory` 에 `Instance` 가 들어가고   
2. `<fx:Component>` 로 작성된 부분은 `ClassFactory` 에 상속된 `SampleInnerClass0` 이 들어가는 것을 확인 할 수 있다

---------

SampleInnerClass0-generated.as

	public class SampleInnerClass0 extends samples.mxmlFactory.Instance {

	    [Bindable]
	    public var outerDocument : samples.mxmlFactory.Sample;

	    public function SampleInnerClass0()
	    {
	        super();

	        if (!this.styleDeclaration)
	        {
	            this.styleDeclaration = new CSSStyleDeclaration(null, styleManager);
	        }

	        this.styleDeclaration.defaultFactory = function():void
	        {
	            this.a = 3;
	        };
	    }

1. `<fx:Component>` 내에서 선언된 property `a` 를 `constructor` 상에서 초기화 시켜주는 것을 확인 할 수 있다

