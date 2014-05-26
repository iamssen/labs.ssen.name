# Flex Alert with Spark Component

	<?xml version="1.0" encoding="utf-8"?>
	<s:SkinnablePopUpContainer xmlns:fx="http://ns.adobe.com/mxml/2009" xmlns:s="library://ns.adobe.com/flex/spark" xmlns:mx="library://ns.adobe.com/flex/mx">
		<fx:Script>
			<![CDATA[
				import mx.core.FlexGlobals;
				import mx.managers.PopUpManager;

				import spark.components.Application;

				[Bindable]
				public var message:String;

				[Bindable]
				public var title:String;

				private static var alert:Alert;
				private static var app:Application;

				public static function show(message:String, title:String):void {
					if (!alert) {
						alert=new Alert;
						app=FlexGlobals.topLevelApplication as Application;
					}
					alert.message=message;
					alert.title=title;
					alert.open(app, true);

					PopUpManager.centerPopUp(alert);
				}
			]]>
		</fx:Script>

		<s:Panel title="{title}">
			<s:layout>
				<s:VerticalLayout paddingTop="35" paddingBottom="25" paddingLeft="40" paddingRight="40" gap="25" horizontalAlign="center" verticalAlign="middle"/>
			</s:layout>

			<s:Label text="{message}" maxWidth="500" fontFamily="pfsquareReg" fontSize="13" color="0x000000"/>
			<s:Button label="OK" click="close()" width="88" height="26"/>
		</s:Panel>
	</s:SkinnablePopUpContainer>

Spark 에서는 Alert, Confirm, Prompt 와 같은 알림 처리를 모두 [SkinnablePopUpContainer] 를 통해 처리할 수 있다.

- `open()` 팝업 형태로 연다
- `close()` 팝업을 닫는다

## Mission

1. `ssen.displaykit` 에 간단하게 Alert, Confirm 을 기본 기능을 비롯한 여러 Selector 를 만들어놓자.
1. `Selector` 라는 Button 을 통해서 UI 공간이 충분할 경우엔 DropdownList 형태로 열고, 공간이 좁을 경우엔 [SkinnablePopUpContainer] 형태로 여는 방식을 생각해보자


[SkinnablePopUpContainer]: http://help.adobe.com/en_US/flex/using/WS67cd75b2532ad652-1abb110512d5bda966d-8000.html