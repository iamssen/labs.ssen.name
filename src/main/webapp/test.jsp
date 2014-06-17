<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
	<title>읽어야 하는 수학책들</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
</head>
<body>
	<pre style="font-family: '_sans';">
		Hello <%= java.net.URLEncoder.encode(request.getParameter("name"), "UTF-8") %>
		Hello <%= java.net.URLDecoder.decode(request.getParameter("name"), "UTF-8") %>
		Hello <%= java.net.URLDecoder.decode(request.getParameter("name"), "EUC-KR") %>
		Hello <%= java.net.URLDecoder.decode(java.net.URLEncoder.encode(request.getParameter("name"), "UTF-8"), "UTF-8") %>
		Hello <%= java.net.URLDecoder.decode(java.net.URLEncoder.encode(request.getParameter("name"), "EUC-KR"), "EUC-KR") %>
		Hello <%= request.getParameter("name") %>
	</pre>
</body>
</html>