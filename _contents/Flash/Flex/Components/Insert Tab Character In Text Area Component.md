---
primary: 2ffbd72837
date: '2013-03-28 12:00:02'

---

# spark

	protected function ta_keyFocusChangeHandler(event:FocusEvent):void
	{
		event.preventDefault();
		ta.insertText("\t");
	}
	----
	<s:TextArea id="ta" keyFocusChange="ta_keyFocusChangeHandler(event)"/>

# mx

	<mx:TextArea width="300" height="300">
		<mx:keyFocusChange>
			event.preventDefault();
			this.textField.replaceSelectedText("\t");
		</mx:keyFocusChange>
	</mx:TextArea>