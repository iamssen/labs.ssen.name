<%
String test_name = request.getParameter("name");

if (test_name == null) {
	test_name = "World";
}

%>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<title></title>
</head>
<body>
Hello <%= test_name %>
</body>
</html>