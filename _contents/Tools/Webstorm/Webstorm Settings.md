---
primary: 01f0feb7ee
date: '2013-07-08 12:59:14'

---

# Open "iterm2"

iterm2 open script save to `~/somedirectory/oepn.iterm.scpt`

	on run argv
		set cdTo to item 1 of argv
		tell application "iTerm"
			activate
			make new terminal
			tell the first terminal
				try
					launch session "Default Session"
				on error
					display dialog "There was an error creating a new tab in iTerm." buttons {"OK"}
				end try
				tell the last session
					try
						write text "cd " & cdTo
					on error
						display dialog "There was an error cding to the requested path." buttons {"OK"}
					end try
				end tell
			end tell
		end tell
		return
	end run

Settings > External Tools

- Open Project Root Directory
	- Options 
		- uncheck all
	- Tool settings
		- program `/usr/bin/osascript`
		- parameters `~/somedirectory/open.iterm.scpt '$ProjectFileDir$'`
- Open Parent Directory of Edit File
	- Options
		- uncheck all
	- Tool settings
		- program `/usr/bin/osascript`
		- parameters `~/somedirectory/open.iterm.scpt '$FileDir$'`

## Open [dkw](http://dev.naver.com/projects/dkw) on Windows

- Open Project Root Directory
	- Options
		- uncheck all
	- Tool settings
		- program `C:\Program Files\dkw\dkw.exe`
		- parameters `"chdir=$ProjectFileDir$"`
- Open Parent Directory of Edit File
	- Options
		- uncheck all
	- Tool settings
		- program `C:\Program Files\dkw\dkw.exe`
		- parameters `"chdir=$FileDir$"`
		