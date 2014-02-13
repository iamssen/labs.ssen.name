---
primary: f3043c41d6

---

# Flex Tooltip Component Customization

```xml
<?xml version="1.0" encoding="utf-8"?>
<s:BorderContainer xmlns:fx="http://ns.adobe.com/mxml/2009" xmlns:s="library://ns.adobe.com/flex/spark" xmlns:mx="library://ns.adobe.com/flex/mx" implements="mx.core.IToolTip"
				   backgroundColor="0xffffff" backgroundAlpha="0.9" borderColor="0x12478d">
	<fx:Script>
		<![CDATA[
			import mx.events.ToolTipEvent;

			import flashx.textLayout.conversion.TextConverter;
			import flashx.textLayout.elements.TextFlow;

			[Bindable]
			private var tlf:TextFlow;

			private var _text:String;

			public function get text():String {
				return _text;
			}

			public function set text(value:String):void {
				_text=value;

				var format:String=(value.indexOf("<") > -1) ? TextConverter.TEXT_FIELD_HTML_FORMAT : TextConverter.PLAIN_TEXT_FORMAT;
				tlf=TextConverter.importToFlow(value, format);
			}

			public static function create(borderColor:uint, text:String, event:ToolTipEvent):void {
				var tip:HtmlTooltip=new HtmlTooltip;
				tip.setStyle("borderColor", borderColor);
				tip.text=text;

				event.toolTip=tip;
			}
		]]>
	</fx:Script>
	<s:RichText textFlow="{tlf}" left="10" right="10" top="10" bottom="10" fontSize="11" color="0x000000"/>
</s:BorderContainer>
```

기본 Plain Text 형식과 HTML 형식 모두를 지원하도록 Custom

- 초기화 `ToolTipManager.toolTipClass=HtmlTooltip` 으로 초기화
- 기본 사용 `toolTip="Plain Text"` 또는 `toolTip='<b>Html</b><br />Text'`
- 좀 더 확장된 기능이 요구되는 경우에는 `toolTipCreate="HtmlTooltip.create(borderColor, text, event)"` 형태로 사용한다
