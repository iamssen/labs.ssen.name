# 19/06/2014

- Server
	- Windows Azure
	- Ubuntu 12 LTS
	- Nginx (Static File Hosting & Tomcat Reverse Proxy)
	- Tomcat7 (Spring4 Web App Container)
	- Redis (Content Search)
- Deploy
	- Github (Source Repository & Webhook Trigger)
	- Jenkins (Webhook Receiver & Build Script Trigger)
- Build
	- **Master** : Makefile (Shell Script Executer)
	- **Slave** : Jekyll on Ruby (Static Website Generator)
	- **Slave** : Gulp.js on Node.js (Markdown Source Auto Tagging & Search Data Parsing, Redis Push...)
	- **Slave** : Gradle (Spring Web App Build & Deploy War To Tomcat Container)
- Apps
	- Search Engine
		- Make `search.xml` by Jekyll
		- Parse `search.xml` And Push To Redis by Gulp.js
		- Redis + Lua Script by Spring Data Redis
		- REST Service by Spring Framework4 (JSON or HTML)
		- Thymeleaf Template Engine for Spring Framework
	- Jekyll Customizing
		- Markdown Primary Key Tagging by Node.js (for Disqus Comment and Others...)
		- Markdown Title, Date, Layout Auto Tagging by Node.js
		- Jekyll Category and List Generation by Ruby Script (Jekyll Plugin)
		- Jekyll Page Tag Collecte And Make Page by Ruby Script (Jekyll Plugin)

## First Time Using

- Tomcat7
- Java
- Spring Framework4
- Spring Data
- Jekyll
- Gradle
- Thymeleaf
- Ruby
