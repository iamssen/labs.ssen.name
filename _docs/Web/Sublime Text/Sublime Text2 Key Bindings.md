# 단축키 설정

Preferences > Key Bindings - User (`.sublime-keymap`)

	[
		{ "keys": ["alt+up"], "command": "swap_line_up" },
		{ "keys": ["alt+down"], "command": "swap_line_down" },
		{ "keys": ["super+d"], "command": "run_macro_file", "args": {"file": "Packages/Default/Delete Line.sublime-macro"} },
		{ "keys": ["super+shift+f"], "command": "show_panel", "args": {"panel": "replace"} },
	
		{ "keys": ["super+/"], "command": "plain_tasks_complete","context": [{ "key": "selector", "operator": "equal", "operand": "text.todo" }] },
		{ "keys": ["super+shift+/"], "command": "plain_tasks_cancel", "context": [{"key": "selector", "operator": "equal", "operand": "text.todo" }] },
		{ "keys": ["super+space"], "command": "auto_complete" },
		{ "keys": ["super+space"], "command": "replace_completion_with_auto_complete", "context":
			[
				{ "key": "last_command", "operator": "equal", "operand": "insert_best_completion" },
				{ "key": "auto_complete_visible", "operator": "equal", "operand": false },
				{ "key": "setting.tab_completion", "operator": "equal", "operand": true }
			]
		}
	]