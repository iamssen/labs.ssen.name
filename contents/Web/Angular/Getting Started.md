---
primary: f94212ed71

---

# Directives

- text binding
	- `ng-bind` 
	- `ng-bind-html`
	- `ng-bind-template`
- 

## `ng-bind`

기본적인 model - view binding은 아래와 같이 처리 가능하다

	<body ng-app>
		<input type="text" ng-model="user.name"/>
		<h3>Echo : {{usr.name}}</h3>
	</body>

`ng-bind`는 아래와 같은 사용을 가능하게 해준다

	<body ng-app>
		<input type="text" ng-model="user.name"/>
		<h3>Echo : <span ng-bind="user.name"/></h3>
	</body>