<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>

	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css"/>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"/>
	<link rel="stylesheet" type="text/css" href="/assets/layout.css"/>
	
	
	<link rel="stylesheet" type="text/css" href="/assets/nav.css"/>
	
	<link rel="stylesheet" type="text/css" href="/assets/search.css"/>
	
	<link rel="stylesheet" type="text/css" href="/assets/list.css"/>
	
	<link rel="stylesheet" type="text/css" href="/assets/copyright.css"/>
	
	

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
	<script src="/assets/layout.js"></script>
	
	
	<script src="/assets/list.js"></script>
	
	
</head>
<body>

<nav id="nav" class="navbar navbar-default navbar-static-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#nav-menus">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Labs</a>
		</div>

		<div class="collapse navbar-collapse" id="nav-menus">
			<ul class="nav navbar-nav">
				<li><a href="/tags">Tags</a></li>
				<li><a onclick="moveto('list')">List</a></li>
			</ul>
			<form class="navbar-form navbar-right" role="search" action="/search.php" method="get">
				<div class="form-group">
					<input name="q" type="text" class="form-control">
				</div>
				<input type="submit" class="btn btn-default" value="Search"/>
			</form>
		</div>
	</div>
</nav>
<div id="search">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
<?php
require '../vendor/autoload.php';

if (isset($_GET['q'])) {
	// query string
	$qo = htmlspecialchars($_GET['q']);
	echo '<p>'.$qo.'</p>';

	$words = explode(' ', $qo);
	echo '<pre>'.print_r($words).'</pre>';

	/*foreach ($words as $i => $word) {
		if (strtolower($word) == 'and') {
			$words[$i] = 'AND';
		} else if (strtolower($word) == 'or') {
			$words[$i] = 'OR';
		} else {
			$words[$i] = '*' + $word + '*';
		}
	}*/

	$q = join(' ', $words);

	// elastic search request
	$params['index'] = 'labs';
	$params['type'] = 'pages';
	// $params['body']['query']['query_string']['default_operator'] = 'AND';
	// $params['body']['query']['query_string']['fields'] = ['title', 'content'];
	// $params['body']['query']['query_string']['query'] = $q;

	$params['body']['query']['fields'] = ['title', 'content'];
	$params['body']['query']['query']['match']['text']['query'] = $q;
	$params['body']['query']['query']['match']['text']['operator'] = 'and';

	$ec = new Elasticsearch\Client();
	$hits = $ec->search($params)['hits']['hits'];

	if (count($hits) > 0) {
?>
				<h1>Search Result for "<?php echo $qo; ?>"</h1>
				<hr />
				<ul id="search-list">
<?php
		foreach ($hits as $hit) {
			$title = $hit['_source']['title'];
			$url = $hit['_source']['url'];

			echo '<li><a href="'.$url.'">'.$title.'</a></li>';
		}
?>
				</ul>
<?php
	} else {
?>
				<h1>No Search Results for "<?php echo $qo; ?>"</h1>
<?php
	}
?>
<?php
} else {
?>
				<h1>Undefined Keyword "?q="<br/><small>“I don’t know who you are. I don’t know what you want. I will find you, and I will kill you.</small></h1>
<?php
}
?>
			</div>
		</div>
	</div>
</div>
<div id="list">
	<div class="container-fluid">

		<div id="list-tags" class="row">
			<div class="col-md-12">
				<p class="text-center">
					
					<a href="/tags/#a" class="btn btn-default">
						<i class="fa fa-tags"></i> &nbsp;&nbsp;a
						<small class="badge">2</small>
					</a>
					
					<a href="/tags/#b" class="btn btn-default">
						<i class="fa fa-tags"></i> &nbsp;&nbsp;b
						<small class="badge">1</small>
					</a>
					
				</p>
			</div>
		</div>

		<hr/>

		<div id="list-pages" class="row">
			<div id="list-pages-tree" class="col-md-6" page-primary-id="">
				<h3>Documents</h3>
				<hr/>
				<ul><li class='tree-node tree-node-open' branche-id='/Flash'><a>Flash</a><ul><li class='tree-node tree-node-open' branche-id='/Flash/Environments'><a>Environments</a><ul><li class='tree-leaf' primary-id='c199cc6471'><a href='/Flash/Environments/Flash%20Builder%20%E1%84%89%E1%85%A5%E1%86%BC%E1%84%82%E1%85%B3%E1%86%BC%20%E1%84%90%E1%85%B2%E1%84%82%E1%85%B5%E1%86%BC.html'>Flash Builder 성능 튜닝</a></li><li class='tree-leaf' primary-id='2843313d63'><a href='/Flash/Environments/Flash%20Builder%20%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20Theme%20Style%20%E1%84%89%E1%85%A9%E1%86%A8%E1%84%89%E1%85%A5%E1%86%BC%E1%84%8B%E1%85%B5%20%E1%84%82%E1%85%A1%E1%84%8B%E1%85%A9%E1%84%8C%E1%85%B5%20%E1%84%8B%E1%85%A1%E1%86%AD%E1%84%8B%E1%85%B3%E1%86%AF%E1%84%84%E1%85%A2.html'>Flash Builder 에서 Theme Style 속성이 나오지 않을때</a></li><li class='tree-leaf' primary-id='d68303506e'><a href='/Flash/Environments/asdoc.html'>asdoc</a></li><li class='tree-leaf' primary-id='5d821fa03b'><a href='/Flash/Environments/mxmlc,%20compc.html'>mxmlc, compc</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Flash/Flex Chart'><a>Flex Chart</a><ul><li class='tree-leaf' primary-id='efa79d1545'><a href='/Flash/Flex%20Chart/BarSeries%E1%84%8B%E1%85%A6%20%E1%84%8E%E1%85%AE%E1%84%80%E1%85%A1%E1%84%8C%E1%85%A5%E1%86%A8%E1%84%8B%E1%85%B5%E1%86%AB%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%E1%84%83%E1%85%B3%E1%86%AF%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%80%E1%85%B3%E1%84%85%E1%85%B5%E1%84%80%E1%85%B5.html'>BarSeries에 추가적인 요소들을 그리기</a></li><li class='tree-leaf' primary-id='71bd287856'><a href='/Flash/Flex%20Chart/Chart%20Data.html'>Chart Data</a></li><li class='tree-leaf' primary-id='ac7fba868c'><a href='/Flash/Flex%20Chart/Chart%20Series%20%E1%84%8B%E1%85%B4%20%E1%84%89%E1%85%B5%E1%86%AF%E1%84%89%E1%85%B5%E1%84%80%E1%85%A1%E1%86%AB%20%E1%84%8E%E1%85%AE%E1%84%80%E1%85%A1,%20%E1%84%89%E1%85%A1%E1%86%A8%E1%84%8C%E1%85%A6.html'>Chart Series 의 실시간 추가, 삭제</a></li><li class='tree-leaf' primary-id='d2cdd6db63'><a href='/Flash/Flex%20Chart/Chart%20Style.html'>Chart Style</a></li><li class='tree-leaf' primary-id='f1cdb2f455'><a href='/Flash/Flex%20Chart/ColumnChart%20Data%20Label%20%E1%84%8E%E1%85%A5%E1%84%85%E1%85%B5.html'>ColumnChart Data Label 처리</a></li><li class='tree-leaf' primary-id='1a640bd2d1'><a href='/Flash/Flex%20Chart/Stacked,%20Box%20Model.html'>Stacked, Box Model</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Flash/Flex Component'><a>Flex Component</a><ul><li class='tree-leaf' primary-id='acdbdf91fd'><a href='/Flash/Flex%20Component/Flex%20Components.html'>Flex Components</a></li><li class='tree-leaf' primary-id='8aafff9a76'><a href='/Flash/Flex%20Component/Flex%20Popup%20on%20Spark%20SkinnablePopUpContainer.html'>Flex Popup on Spark SkinnablePopUpContainer</a></li><li class='tree-leaf' primary-id='9e7dd47924'><a href='/Flash/Flex%20Component/Flex%20Spark%20Label.html'>Flex Spark Label</a></li><li class='tree-leaf' primary-id='f3043c41d6'><a href='/Flash/Flex%20Component/Flex%20Tooltip.html'>Flex Tooltip</a></li><li class='tree-leaf' primary-id='e1ea3230a4'><a href='/Flash/Flex%20Component/Flex%20Tree.html'>Flex Tree</a></li><li class='tree-leaf' primary-id='3f19f4521d'><a href='/Flash/Flex%20Component/Insert%20Tab%20Character%20In%20Text%20Area%20Component.html'>Insert Tab Character In Text Area Component</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Flash/Flex Data Grid'><a>Flex Data Grid</a><ul><li class='tree-leaf' primary-id='c6ad6d735b'><a href='/Flash/Flex%20Data%20Grid/Data%20Grid.html'>Data Grid</a></li><li class='tree-leaf' primary-id='93354465fc'><a href='/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%85%E1%85%B3%E1%86%AF%20Excel%20%E1%84%8E%E1%85%A5%E1%84%85%E1%85%A5%E1%86%B7%20Customizing%20%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>DataGrid 를 Excel 처럼 Customizing 하기</a></li><li class='tree-leaf' primary-id='477aa3dc7a'><a href='/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%8B%E1%85%A6%20%E1%84%92%E1%85%AA%E1%86%A8%E1%84%8C%E1%85%A1%E1%86%BC%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%20%E1%84%82%E1%85%A5%E1%87%82%E1%84%80%E1%85%B5.html'>DataGrid 에 확장 요소 넣기</a></li><li class='tree-leaf' primary-id='821725f4be'><a href='/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%8B%E1%85%B4%20Style%20%E1%84%86%E1%85%B5%E1%86%BE%20layout%20%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%80%E1%85%A7%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%92%E1%85%A1%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%E1%84%83%E1%85%B3%E1%86%AF.html'>DataGrid 의 Style 및 layout 을 결정하는 요소들</a></li><li class='tree-leaf' primary-id='950823900e'><a href='/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%8B%E1%85%B4%20%E1%84%80%E1%85%AE%E1%84%89%E1%85%A5%E1%86%BC%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%E1%84%83%E1%85%B3%E1%86%AF.html'>DataGrid 의 구성 요소들</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Flash/Flex 원론'><a>Flex 원론</a><ul><li class='tree-leaf' primary-id='b76ec32aed'><a href='/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Data%20Binding.html'>Data Binding</a></li><li class='tree-leaf' primary-id='68ede0f0f6'><a href='/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Display%20Invalidation.html'>Display Invalidation</a></li><li class='tree-leaf' primary-id='5a2e511ac2'><a href='/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Flex%20Display%20Models.html'>Flex Display Models</a></li><li class='tree-leaf' primary-id='682bfe8739'><a href='/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/IFactory%20%E1%84%80%E1%85%A1%20%E1%84%92%E1%85%A2%E1%84%89%E1%85%A5%E1%86%A8%E1%84%83%E1%85%AC%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%87%E1%85%A1%E1%86%BC%E1%84%89%E1%85%B5%E1%86%A8.html'>IFactory 가 해석되는 방식</a></li><li class='tree-leaf' primary-id='6f100daebb'><a href='/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Metadata%20Tags.html'>Metadata Tags</a></li><li class='tree-leaf' primary-id='08aefcfe45'><a href='/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Metadata%20Tags%20%E1%84%80%E1%85%B5%E1%84%87%E1%85%A1%E1%86%AB%E1%84%8B%E1%85%B4%20Dependency%20Injection%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%8B%E1%85%B1%E1%84%92%E1%85%A1%E1%86%AB%20describeType%20%E1%84%87%E1%85%AE%E1%86%AB%E1%84%89%E1%85%A5%E1%86%A8.html'>Metadata Tags 기반의 Dependency Injection을 위한 describeType 분석</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Flash/Graphics'><a>Graphics</a><ul><li class='tree-leaf' primary-id='ed6ba6a5be'><a href='/Flash/Graphics/3D%20Plan%20%E1%84%92%E1%85%A7%E1%86%BC%E1%84%90%E1%85%A2%E1%84%8B%E1%85%B4%20Triangle%20Vertex%20Drawing.html'>3D Plan 형태의 Triangle Vertex Drawing</a></li><li class='tree-leaf' primary-id='b081b7a23d'><a href='/Flash/Graphics/Bitmap%20Drawing%20%E1%84%92%E1%85%A1%E1%86%AF%20%E1%84%84%E1%85%A2%E1%84%8B%E1%85%B4%20Matrix%20%E1%84%80%E1%85%A8%E1%84%89%E1%85%A1%E1%86%AB.html'>Bitmap Drawing 할 때의 Matrix 계산</a></li><li class='tree-leaf' primary-id='b4a98875cb'><a href='/Flash/Graphics/Drawing%20%E1%84%80%E1%85%A1%E1%84%82%E1%85%B3%E1%86%BC%E1%84%92%E1%85%A1%E1%86%AB%20Graphics%20Container%20%E1%84%83%E1%85%B3%E1%86%AF%E1%84%8B%E1%85%B4%20%E1%84%8C%E1%85%A9%E1%86%BC%E1%84%85%E1%85%B2%E1%84%8B%E1%85%AA%20%E1%84%90%E1%85%B3%E1%86%A8%E1%84%89%E1%85%A5%E1%86%BC.html'>Drawing 가능한 Graphics Container 들의 종류와 특성</a></li><li class='tree-leaf' primary-id='42ce642148'><a href='/Flash/Graphics/Easing%20And%20Tween.html'>Easing And Tween</a></li></ul></li><li class='tree-leaf' primary-id='79eabde1bb'><a href='/Flash/Polygonal%20Data%20Structures.html'>Polygonal Data Structures</a></li><li class='tree-leaf' primary-id='3ed30052a2'><a href='/Flash/Search%20XML.html'>Search XML</a></li><li class='tree-leaf' primary-id='1c1470174b'><a href='/Flash/Sort%20Compare%20Functions.html'>Sort Compare Functions</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Math'><a>Math</a><ul><li class='tree-leaf' primary-id='c3415bdcf0'><a href='/Math/%E1%84%89%E1%85%A1%E1%86%B7%E1%84%80%E1%85%A1%E1%86%A8%E1%84%92%E1%85%A1%E1%86%B7%E1%84%89%E1%85%AE.html'>삼각함수</a></li><li class='tree-leaf' primary-id='4a5ddc35bc'><a href='/Math/%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8%E1%84%89%E1%85%B5%E1%86%A8.html'>수학식</a></li><li class='tree-leaf' primary-id='23a4958bdd'><a href='/Math/%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8%E1%84%8C%E1%85%A5%E1%86%A8%20%E1%84%80%E1%85%B3%E1%84%85%E1%85%A2%E1%84%91%E1%85%B5%E1%86%A8%E1%84%89%E1%85%B3%20%E1%84%83%E1%85%B3%E1%84%85%E1%85%A9%E1%84%8B%E1%85%B5%E1%86%BC.html'>수학적 그래픽스 드로잉</a></li><li class='tree-leaf' primary-id='6992060a94'><a href='/Math/%E1%84%8B%E1%85%B5%E1%84%8B%E1%85%A3%E1%84%80%E1%85%B5%E1%84%85%E1%85%A9%20%E1%84%89%E1%85%B1%E1%86%B8%E1%84%80%E1%85%A6%20%E1%84%87%E1%85%A2%E1%84%8B%E1%85%AE%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%83%E1%85%A2%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8.html'>이야기로 쉽게 배우는 대수학</a></li><li class='tree-leaf' primary-id='9d6599d506'><a href='/Math/%E1%84%8B%E1%85%B5%E1%86%B0%E1%84%8B%E1%85%A5%E1%84%8B%E1%85%A3%20%E1%84%92%E1%85%A1%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8%E1%84%8E%E1%85%A2%E1%86%A8%E1%84%83%E1%85%B3%E1%86%AF.html'>읽어야 하는 수학책들</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Programming'><a>Programming</a><ul><li class='tree-leaf' primary-id='105ebe373c'><a href='/Programming/Bitwise%20State%20Flag.html'>Bitwise State Flag</a></li><li class='tree-leaf' primary-id='4472a58288'><a href='/Programming/Category%20Key%20%E1%84%80%E1%85%A1%20%E1%84%8B%E1%85%B5%E1%86%BB%E1%84%82%E1%85%B3%E1%86%AB%20Object%20List%20%E1%84%85%E1%85%B3%E1%86%AF%20Tree%20%E1%84%92%E1%85%A7%E1%86%BC%E1%84%90%E1%85%A2%E1%84%85%E1%85%A9%20%E1%84%87%E1%85%A7%E1%86%AB%E1%84%92%E1%85%AA%E1%86%AB.html'>Category Key 가 있는 Object List 를 Tree 형태로 변환</a></li><li class='tree-leaf' primary-id='da8732fbaf'><a href='/Programming/HTTP.html'>HTTP</a></li><li class='tree-leaf' primary-id='8f5b1cb046'><a href='/Programming/HTTP%20Spec.html'>HTTP Spec</a></li><li class='tree-leaf' primary-id='3291e384b1'><a href='/Programming/Regular%20Expressions.html'>Regular Expressions</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Server'><a>Server</a><ul><li class='tree-leaf' primary-id='1613d3e7b7'><a href='/Server/Develop%20Npm%20Module.html'>Develop Npm Module</a></li><li class='tree-node tree-node-open' branche-id='/Server/Java'><a>Java</a><ul><li class='tree-leaf' primary-id='4abae4cd62'><a href='/Server/Java/JDK%20Java%20VisualVM%E1%84%8B%E1%85%B3%E1%84%85%E1%85%A9%20%E1%84%92%E1%85%A7%E1%86%AB%E1%84%8C%E1%85%A2%20%E1%84%89%E1%85%B5%E1%86%AF%E1%84%92%E1%85%A2%E1%86%BC%E1%84%8C%E1%85%AE%E1%86%BC%E1%84%8B%E1%85%B5%E1%86%AB%20MBeans%20%E1%84%92%E1%85%AA%E1%86%A8%E1%84%8B%E1%85%B5%E1%86%AB%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>JDK Java VisualVM으로 현재 실행중인 MBeans 확인하기</a></li><li class='tree-leaf' primary-id='952fab070f'><a href='/Server/Java/Tomcat%20%E1%84%80%E1%85%A2%E1%84%87%E1%85%A1%E1%86%AF%20%E1%84%85%E1%85%A9%E1%84%80%E1%85%B3.html'>Tomcat 개발 로그</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Server/Jenkins'><a>Jenkins</a><ul><li class='tree-leaf' primary-id='e0eb3ab0f7'><a href='/Server/Jenkins/Install%20Jenkins%20On%20CentOS.html'>Install Jenkins On CentOS</a></li><li class='tree-leaf' primary-id='d65efba978'><a href='/Server/Jenkins/Install%20Jenkins%20On%20Ubuntu.html'>Install Jenkins On Ubuntu</a></li><li class='tree-leaf' primary-id='b4fb1748c6'><a href='/Server/Jenkins/Jenkins%20%E1%84%80%E1%85%A8%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%8B%E1%85%B3%E1%84%85%E1%85%A9%20%E1%84%8C%E1%85%A5%E1%86%B8%E1%84%89%E1%85%A9%E1%86%A8%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>Jenkins 계정으로 접속하기</a></li><li class='tree-leaf' primary-id='3b587723d4'><a href='/Server/Jenkins/Jenkins%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20sudo%20%E1%84%80%E1%85%AF%E1%86%AB%E1%84%92%E1%85%A1%E1%86%AB%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%89%E1%85%B5%E1%86%AF%E1%84%92%E1%85%A2%E1%86%BC%E1%84%89%E1%85%B5%E1%84%8F%E1%85%B5%E1%84%80%E1%85%B5.html'>Jenkins에서 sudo 권한을 실행시키기</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Server/NginX'><a>NginX</a><ul><li class='tree-leaf' primary-id='17b4a2fad1'><a href='/Server/NginX/Install%20NginX%20On%20CentOS.html'>Install NginX On CentOS</a></li><li class='tree-leaf' primary-id='dcbdd73f89'><a href='/Server/NginX/Install%20NginX%20On%20Mac.html'>Install NginX On Mac</a></li><li class='tree-leaf' primary-id='eb6d1347bb'><a href='/Server/NginX/Install%20NginX%20On%20Ubuntu.html'>Install NginX On Ubuntu</a></li><li class='tree-leaf' primary-id='72014b538a'><a href='/Server/NginX/NginX%20Location%20Rule.html'>NginX Location Rule</a></li><li class='tree-leaf' primary-id='65e345b2c0'><a href='/Server/NginX/NginX%E1%84%85%E1%85%B3%E1%86%AF%20Jenkins%E1%84%8B%E1%85%B4%20Reverse%20Proxy%E1%84%85%E1%85%A9%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>NginX를 Jenkins의 Reverse Proxy로 설정하기</a></li><li class='tree-leaf' primary-id='cfce786c1d'><a href='/Server/NginX/NginX%E1%84%85%E1%85%B3%E1%86%AF%20Node.js%E1%84%8B%E1%85%B4%20Reverse%20Proxy%E1%84%85%E1%85%A9%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>NginX를 Node.js의 Reverse Proxy로 설정하기</a></li><li class='tree-leaf' primary-id='00066940d6'><a href='/Server/NginX/NginX%E1%84%8B%E1%85%A6%20Basic%20Authenication%20%E1%84%8C%E1%85%A5%E1%86%A8%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>NginX에 Basic Authenication 적용하기</a></li><li class='tree-leaf' primary-id='73e5b27d01'><a href='/Server/NginX/Nginx%20Proxy%20Redirect.html'>Nginx Proxy Redirect</a></li><li class='tree-leaf' primary-id='82e535cafb'><a href='/Server/NginX/include%E1%84%85%E1%85%B3%E1%86%AF%20%E1%84%89%E1%85%A1%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A2%E1%84%89%E1%85%A5%20NginX%E1%84%8B%E1%85%B4%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%82%E1%85%A1%E1%84%82%E1%85%AE%E1%84%80%E1%85%B5.html'>include를 사용해서 NginX의 설정을 나누기</a></li><li class='tree-leaf' primary-id='4182eabcb0'><a href='/Server/NginX/nginx.conf%20%E1%84%91%E1%85%A1%E1%84%8B%E1%85%B5%E1%86%AF%20%E1%84%89%E1%85%A1%E1%86%AF%E1%84%91%E1%85%A7%E1%84%87%E1%85%A9%E1%84%80%E1%85%B5.html'>nginx.conf 파일 살펴보기</a></li><li class='tree-leaf' primary-id='a2cd6cd717'><a href='/Server/NginX/php-frm%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8E%E1%85%B5.html'>php-frm 설치</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Server/Redis'><a>Redis</a><ul><li class='tree-leaf' primary-id='178f93933f'><a href='/Server/Redis/Redis.html'>Redis</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Server/Ubuntu Server'><a>Ubuntu Server</a><ul><li class='tree-leaf' primary-id='486c0029ed'><a href='/Server/Ubuntu%20Server/Dropbox%20Linux%20Command-Line%20Client.html'>Dropbox Linux Command-Line Client</a></li><li class='tree-leaf' primary-id='0c3629b10e'><a href='/Server/Ubuntu%20Server/Node.js%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8E%E1%85%B5.html'>Node.js 설치</a></li><li class='tree-leaf' primary-id='4929fbf41a'><a href='/Server/Ubuntu%20Server/apt-get%20%E1%84%86%E1%85%A7%E1%86%BC%E1%84%85%E1%85%A7%E1%86%BC%E1%84%8B%E1%85%A5.html'>apt-get 명령어</a></li><li class='tree-leaf' primary-id='5d7a7de91f'><a href='/Server/Ubuntu%20Server/init.d%20%E1%84%89%E1%85%B5%E1%84%89%E1%85%B3%E1%84%90%E1%85%A6%E1%86%B7%20%E1%84%8B%E1%85%B5%E1%84%87%E1%85%A6%E1%86%AB%E1%84%90%E1%85%B3%20%E1%84%86%E1%85%A1%E1%86%AB%E1%84%83%E1%85%B3%E1%86%AF%E1%84%80%E1%85%B5.html'>init.d 시스템 이벤트 만들기</a></li><li class='tree-leaf' primary-id='b564d322ab'><a href='/Server/Ubuntu%20Server/%E1%84%80%E1%85%B5%E1%84%87%E1%85%A9%E1%86%AB%20%E1%84%89%E1%85%A1%E1%84%92%E1%85%A1%E1%86%BC%E1%84%83%E1%85%B3%E1%86%AF.html'>기본 사항들</a></li></ul></li><li class='tree-leaf' primary-id='963310e7f7'><a href='/Server/Ubuntu%20Server%2013.04%20Setting%20Log.html'>Ubuntu Server 13.04 Setting Log</a></li><li class='tree-node tree-node-open' branche-id='/Server/Windows Azure'><a>Windows Azure</a><ul><li class='tree-leaf' primary-id='74075410e2'><a href='/Server/Windows%20Azure/Azure%E1%84%8B%E1%85%A6%20Ubuntu%20Server%20Virtual%20Machine%20%E1%84%86%E1%85%A1%E1%86%AB%E1%84%83%E1%85%B3%E1%86%AF%E1%84%80%E1%85%B5.html'>Azure에 Ubuntu Server Virtual Machine 만들기</a></li></ul></li></ul></li><li class='tree-node tree-node-open' branche-id='/Shell'><a>Shell</a><ul><li class='tree-node tree-node-open' branche-id='/Shell/SSH Authentication'><a>SSH Authentication</a><ul><li class='tree-leaf' primary-id='01a687ca19'><a href='/Shell/SSH%20Authentication/SSH%20Key%E1%84%85%E1%85%B3%E1%86%AF%20%E1%84%90%E1%85%A9%E1%86%BC%E1%84%92%E1%85%A1%E1%86%AB%20Server%20%E1%84%8C%E1%85%A5%E1%86%B8%E1%84%89%E1%85%A9%E1%86%A8.html'>SSH Key를 통한 Server 접속</a></li><li class='tree-leaf' primary-id='cb25faa5eb'><a href='/Shell/SSH%20Authentication/ssh-keygen.html'>ssh-keygen</a></li></ul></li><li class='tree-leaf' primary-id='bcfaf1af59'><a href='/Shell/basic%20commands.html'>basic commands</a></li><li class='tree-leaf' primary-id='b186429e54'><a href='/Shell/curl.html'>curl</a></li><li class='tree-leaf' primary-id='414814d3e3'><a href='/Shell/fish.html'>fish</a></li><li class='tree-leaf' primary-id='59a0304a16'><a href='/Shell/fswatch.html'>fswatch</a></li><li class='tree-leaf' primary-id='876efbf837'><a href='/Shell/grep.html'>grep</a></li><li class='tree-leaf' primary-id='90ba6890bd'><a href='/Shell/htpasswd.html'>htpasswd</a></li><li class='tree-leaf' primary-id='f88e529c77'><a href='/Shell/make.html'>make</a></li><li class='tree-leaf' primary-id='00cc218921'><a href='/Shell/mdfind.html'>mdfind</a></li><li class='tree-leaf' primary-id='887bd33454'><a href='/Shell/netstat.html'>netstat</a></li><li class='tree-leaf' primary-id='e9508e6dea'><a href='/Shell/pwd.html'>pwd</a></li><li class='tree-leaf' primary-id='cc2f6d1d41'><a href='/Shell/scp.html'>scp</a></li><li class='tree-leaf' primary-id='88716c9ab2'><a href='/Shell/system%20info%20commands.html'>system info commands</a></li><li class='tree-leaf' primary-id='1c2fbec511'><a href='/Shell/tree.html'>tree</a></li><li class='tree-leaf' primary-id='ea0aa9d094'><a href='/Shell/user,%20group,%20permission%20management.html'>user, group, permission management</a></li><li class='tree-leaf' primary-id='c94ba08fb8'><a href='/Shell/which.html'>which</a></li><li class='tree-leaf' primary-id='f309786b7b'><a href='/Shell/zsh.html'>zsh</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web'><a>Web</a><ul><li class='tree-node tree-node-open' branche-id='/Web/Angular'><a>Angular</a><ul><li class='tree-leaf' primary-id='f94212ed71'><a href='/Web/Angular/Getting%20Started.html'>Getting Started</a></li></ul></li><li class='tree-leaf' primary-id='3a29326e2c'><a href='/Web/Async.html'>Async</a></li><li class='tree-node tree-node-open' branche-id='/Web/Browsers'><a>Browsers</a><ul><li class='tree-leaf' primary-id='88910047de'><a href='/Web/Browsers/Chrome%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20URL%20Protocol%E1%84%8B%E1%85%B5%20%E1%84%8C%E1%85%A1%E1%86%A8%E1%84%83%E1%85%A9%E1%86%BC%E1%84%83%E1%85%AC%E1%84%8C%E1%85%B5%20%E1%84%8B%E1%85%A1%E1%86%AD%E1%84%8B%E1%85%B3%E1%86%AF%E1%84%84%E1%85%A2.html'>Chrome에서 URL Protocol이 작동되지 않을때</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web/Eclipse'><a>Eclipse</a><ul><li class='tree-leaf' primary-id='b9c183d3ad'><a href='/Web/Eclipse/Eclipse%20Path%20Tools.html'>Eclipse Path Tools</a></li><li class='tree-leaf' primary-id='3ca68a4684'><a href='/Web/Eclipse/Eclipse%20Word%20Wrap.html'>Eclipse Word Wrap</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web/Mac'><a>Mac</a><ul><li class='tree-leaf' primary-id='78f6bfc772'><a href='/Web/Mac/Alfred%20Workflow%E1%84%85%E1%85%B3%E1%86%AF%20%E1%84%89%E1%85%A1%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A2%E1%84%89%E1%85%A5%20%E1%84%89%E1%85%B3%E1%84%8F%E1%85%B3%E1%84%85%E1%85%B5%E1%86%AB%E1%84%8F%E1%85%A2%E1%86%B8%E1%84%8E%E1%85%A7%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>Alfred Workflow를 사용해서 스크린캡쳐하기</a></li><li class='tree-leaf' primary-id='dc82f330b1'><a href='/Web/Mac/Finder%20%E1%84%80%E1%85%A5%E1%86%B7%E1%84%89%E1%85%A2%E1%86%A8%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%87%E1%85%A9%E1%86%AB%20%E1%84%8C%E1%85%B5%E1%86%AF%E1%84%8B%E1%85%B4(Raw%20Query)%20%E1%84%89%E1%85%A1%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html'>Finder 검색에서 원본 질의(Raw Query) 사용하기</a></li><li class='tree-leaf' primary-id='21c933dd33'><a href='/Web/Mac/iTerm%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20ssh%20%E1%84%8C%E1%85%A5%E1%86%B8%E1%84%89%E1%85%A9%E1%86%A8%20%E1%84%89%E1%85%B5%20%E1%84%92%E1%85%A1%E1%86%AB%E1%84%80%E1%85%B3%E1%86%AF%E1%84%8B%E1%85%B5%20%E1%84%8B%E1%85%A1%E1%86%AB%E1%84%82%E1%85%A1%E1%84%8B%E1%85%A9%E1%86%AF%20%E1%84%84%E1%85%A2.html'>iTerm에서 ssh 접속 시 한글이 안나올 때</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web/Node.js'><a>Node.js</a><ul><li class='tree-leaf' primary-id='2e05b01285'><a href='/Web/Node.js/express.html'>express</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web/Sublime Text'><a>Sublime Text</a><ul><li class='tree-leaf' primary-id='a653ea288f'><a href='/Web/Sublime%20Text/Sublime%20Text2%20Key%20Bindings.html'>Sublime Text2 Key Bindings</a></li><li class='tree-leaf' primary-id='c21436bce5'><a href='/Web/Sublime%20Text/Sublime%20Text2%20Monokai%20Customize%20Theme.html'>Sublime Text2 Monokai Customize Theme</a></li><li class='tree-leaf' primary-id='fdcf41b7d8'><a href='/Web/Sublime%20Text/Sublime%20Text2%20Settings.html'>Sublime Text2 Settings</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web/Travis'><a>Travis</a><ul><li class='tree-leaf' primary-id='4bd7c4a975'><a href='/Web/Travis/Start%20Travis.html'>Start Travis</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web/VCS'><a>VCS</a><ul><li class='tree-leaf' primary-id='62fb4437c4'><a href='/Web/VCS/git-flow.html'>git-flow</a></li></ul></li><li class='tree-node tree-node-open' branche-id='/Web/Webstorm'><a>Webstorm</a><ul><li class='tree-leaf' primary-id='4cda1e08f2'><a href='/Web/Webstorm/Webstorm%20Settings.html'>Webstorm Settings</a></li></ul></li><li class='tree-leaf' primary-id='d603513c37'><a href='/Web/npm.html'>npm</a></li></ul></li></ul>
			</div>

			<div id="list-pages-recents" class="col-md-6">
				<h3>Recently Updates</h3>
				<hr/>
				<ul>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					<li class="tree-leaf">
						<a href="/Programming/Regular%20Expressions.html">Regular Expressions</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Data%20Binding.html">Data Binding</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Data%20Grid/Data%20Grid.html">Data Grid</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%85%E1%85%B3%E1%86%AF%20Excel%20%E1%84%8E%E1%85%A5%E1%84%85%E1%85%A5%E1%86%B7%20Customizing%20%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">DataGrid 를 Excel 처럼 Customizing 하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%8B%E1%85%A6%20%E1%84%92%E1%85%AA%E1%86%A8%E1%84%8C%E1%85%A1%E1%86%BC%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%20%E1%84%82%E1%85%A5%E1%87%82%E1%84%80%E1%85%B5.html">DataGrid 에 확장 요소 넣기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%8B%E1%85%B4%20Style%20%E1%84%86%E1%85%B5%E1%86%BE%20layout%20%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%80%E1%85%A7%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%92%E1%85%A1%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%E1%84%83%E1%85%B3%E1%86%AF.html">DataGrid 의 Style 및 layout 을 결정하는 요소들</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Data%20Grid/DataGrid%20%E1%84%8B%E1%85%B4%20%E1%84%80%E1%85%AE%E1%84%89%E1%85%A5%E1%86%BC%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%E1%84%83%E1%85%B3%E1%86%AF.html">DataGrid 의 구성 요소들</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Develop%20Npm%20Module.html">Develop Npm Module</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Display%20Invalidation.html">Display Invalidation</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Graphics/Drawing%20%E1%84%80%E1%85%A1%E1%84%82%E1%85%B3%E1%86%BC%E1%84%92%E1%85%A1%E1%86%AB%20Graphics%20Container%20%E1%84%83%E1%85%B3%E1%86%AF%E1%84%8B%E1%85%B4%20%E1%84%8C%E1%85%A9%E1%86%BC%E1%84%85%E1%85%B2%E1%84%8B%E1%85%AA%20%E1%84%90%E1%85%B3%E1%86%A8%E1%84%89%E1%85%A5%E1%86%BC.html">Drawing 가능한 Graphics Container 들의 종류와 특성</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Ubuntu%20Server/Dropbox%20Linux%20Command-Line%20Client.html">Dropbox Linux Command-Line Client</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Graphics/Easing%20And%20Tween.html">Easing And Tween</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Eclipse/Eclipse%20Path%20Tools.html">Eclipse Path Tools</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Eclipse/Eclipse%20Word%20Wrap.html">Eclipse Word Wrap</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Mac/Finder%20%E1%84%80%E1%85%A5%E1%86%B7%E1%84%89%E1%85%A2%E1%86%A8%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%87%E1%85%A9%E1%86%AB%20%E1%84%8C%E1%85%B5%E1%86%AF%E1%84%8B%E1%85%B4(Raw%20Query)%20%E1%84%89%E1%85%A1%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">Finder 검색에서 원본 질의(Raw Query) 사용하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Environments/Flash%20Builder%20%E1%84%89%E1%85%A5%E1%86%BC%E1%84%82%E1%85%B3%E1%86%BC%20%E1%84%90%E1%85%B2%E1%84%82%E1%85%B5%E1%86%BC.html">Flash Builder 성능 튜닝</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Environments/Flash%20Builder%20%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20Theme%20Style%20%E1%84%89%E1%85%A9%E1%86%A8%E1%84%89%E1%85%A5%E1%86%BC%E1%84%8B%E1%85%B5%20%E1%84%82%E1%85%A1%E1%84%8B%E1%85%A9%E1%84%8C%E1%85%B5%20%E1%84%8B%E1%85%A1%E1%86%AD%E1%84%8B%E1%85%B3%E1%86%AF%E1%84%84%E1%85%A2.html">Flash Builder 에서 Theme Style 속성이 나오지 않을때</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Component/Flex%20Components.html">Flex Components</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Flex%20Display%20Models.html">Flex Display Models</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Component/Flex%20Popup%20on%20Spark%20SkinnablePopUpContainer.html">Flex Popup on Spark SkinnablePopUpContainer</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Component/Flex%20Spark%20Label.html">Flex Spark Label</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Component/Flex%20Tooltip.html">Flex Tooltip</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Component/Flex%20Tree.html">Flex Tree</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Angular/Getting%20Started.html">Getting Started</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Programming/HTTP%20Spec.html">HTTP Spec</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Programming/HTTP.html">HTTP</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/IFactory%20%E1%84%80%E1%85%A1%20%E1%84%92%E1%85%A2%E1%84%89%E1%85%A5%E1%86%A8%E1%84%83%E1%85%AC%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%87%E1%85%A1%E1%86%BC%E1%84%89%E1%85%B5%E1%86%A8.html">IFactory 가 해석되는 방식</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Component/Insert%20Tab%20Character%20In%20Text%20Area%20Component.html">Insert Tab Character In Text Area Component</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Jenkins/Install%20Jenkins%20On%20CentOS.html">Install Jenkins On CentOS</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Jenkins/Install%20Jenkins%20On%20Ubuntu.html">Install Jenkins On Ubuntu</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/Install%20NginX%20On%20CentOS.html">Install NginX On CentOS</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/Install%20NginX%20On%20Mac.html">Install NginX On Mac</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/Install%20NginX%20On%20Ubuntu.html">Install NginX On Ubuntu</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Java/JDK%20Java%20VisualVM%E1%84%8B%E1%85%B3%E1%84%85%E1%85%A9%20%E1%84%92%E1%85%A7%E1%86%AB%E1%84%8C%E1%85%A2%20%E1%84%89%E1%85%B5%E1%86%AF%E1%84%92%E1%85%A2%E1%86%BC%E1%84%8C%E1%85%AE%E1%86%BC%E1%84%8B%E1%85%B5%E1%86%AB%20MBeans%20%E1%84%92%E1%85%AA%E1%86%A8%E1%84%8B%E1%85%B5%E1%86%AB%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">JDK Java VisualVM으로 현재 실행중인 MBeans 확인하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Jenkins/Jenkins%20%E1%84%80%E1%85%A8%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%8B%E1%85%B3%E1%84%85%E1%85%A9%20%E1%84%8C%E1%85%A5%E1%86%B8%E1%84%89%E1%85%A9%E1%86%A8%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">Jenkins 계정으로 접속하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Jenkins/Jenkins%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20sudo%20%E1%84%80%E1%85%AF%E1%86%AB%E1%84%92%E1%85%A1%E1%86%AB%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%89%E1%85%B5%E1%86%AF%E1%84%92%E1%85%A2%E1%86%BC%E1%84%89%E1%85%B5%E1%84%8F%E1%85%B5%E1%84%80%E1%85%B5.html">Jenkins에서 sudo 권한을 실행시키기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Metadata%20Tags%20%E1%84%80%E1%85%B5%E1%84%87%E1%85%A1%E1%86%AB%E1%84%8B%E1%85%B4%20Dependency%20Injection%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%8B%E1%85%B1%E1%84%92%E1%85%A1%E1%86%AB%20describeType%20%E1%84%87%E1%85%AE%E1%86%AB%E1%84%89%E1%85%A5%E1%86%A8.html">Metadata Tags 기반의 Dependency Injection을 위한 describeType 분석</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20%E1%84%8B%E1%85%AF%E1%86%AB%E1%84%85%E1%85%A9%E1%86%AB/Metadata%20Tags.html">Metadata Tags</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/NginX%20Location%20Rule.html">NginX Location Rule</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/NginX%E1%84%85%E1%85%B3%E1%86%AF%20Jenkins%E1%84%8B%E1%85%B4%20Reverse%20Proxy%E1%84%85%E1%85%A9%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">NginX를 Jenkins의 Reverse Proxy로 설정하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/NginX%E1%84%85%E1%85%B3%E1%86%AF%20Node.js%E1%84%8B%E1%85%B4%20Reverse%20Proxy%E1%84%85%E1%85%A9%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">NginX를 Node.js의 Reverse Proxy로 설정하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/NginX%E1%84%8B%E1%85%A6%20Basic%20Authenication%20%E1%84%8C%E1%85%A5%E1%86%A8%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">NginX에 Basic Authenication 적용하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/Nginx%20Proxy%20Redirect.html">Nginx Proxy Redirect</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Ubuntu%20Server/Node.js%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8E%E1%85%B5.html">Node.js 설치</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Polygonal%20Data%20Structures.html">Polygonal Data Structures</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Redis/Redis.html">Redis</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Chart/ColumnChart%20Data%20Label%20%E1%84%8E%E1%85%A5%E1%84%85%E1%85%B5.html">ColumnChart Data Label 처리</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/SSH%20Authentication/SSH%20Key%E1%84%85%E1%85%B3%E1%86%AF%20%E1%84%90%E1%85%A9%E1%86%BC%E1%84%92%E1%85%A1%E1%86%AB%20Server%20%E1%84%8C%E1%85%A5%E1%86%B8%E1%84%89%E1%85%A9%E1%86%A8.html">SSH Key를 통한 Server 접속</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Search%20XML.html">Search XML</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Sort%20Compare%20Functions.html">Sort Compare Functions</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Chart/Stacked,%20Box%20Model.html">Stacked, Box Model</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Travis/Start%20Travis.html">Start Travis</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Sublime%20Text/Sublime%20Text2%20Key%20Bindings.html">Sublime Text2 Key Bindings</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Sublime%20Text/Sublime%20Text2%20Monokai%20Customize%20Theme.html">Sublime Text2 Monokai Customize Theme</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Sublime%20Text/Sublime%20Text2%20Settings.html">Sublime Text2 Settings</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Java/Tomcat%20%E1%84%80%E1%85%A2%E1%84%87%E1%85%A1%E1%86%AF%20%E1%84%85%E1%85%A9%E1%84%80%E1%85%B3.html">Tomcat 개발 로그</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Ubuntu%20Server%2013.04%20Setting%20Log.html">Ubuntu Server 13.04 Setting Log</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Webstorm/Webstorm%20Settings.html">Webstorm Settings</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Ubuntu%20Server/apt-get%20%E1%84%86%E1%85%A7%E1%86%BC%E1%84%85%E1%85%A7%E1%86%BC%E1%84%8B%E1%85%A5.html">apt-get 명령어</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Browsers/Chrome%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20URL%20Protocol%E1%84%8B%E1%85%B5%20%E1%84%8C%E1%85%A1%E1%86%A8%E1%84%83%E1%85%A9%E1%86%BC%E1%84%83%E1%85%AC%E1%84%8C%E1%85%B5%20%E1%84%8B%E1%85%A1%E1%86%AD%E1%84%8B%E1%85%B3%E1%86%AF%E1%84%84%E1%85%A2.html">Chrome에서 URL Protocol이 작동되지 않을때</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Environments/asdoc.html">asdoc</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/basic%20commands.html">basic commands</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Chart/Chart%20Style.html">Chart Style</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/curl.html">curl</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Node.js/express.html">express</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Chart/Chart%20Series%20%E1%84%8B%E1%85%B4%20%E1%84%89%E1%85%B5%E1%86%AF%E1%84%89%E1%85%B5%E1%84%80%E1%85%A1%E1%86%AB%20%E1%84%8E%E1%85%AE%E1%84%80%E1%85%A1,%20%E1%84%89%E1%85%A1%E1%86%A8%E1%84%8C%E1%85%A6.html">Chart Series 의 실시간 추가, 삭제</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/fish.html">fish</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/fswatch.html">fswatch</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/VCS/git-flow.html">git-flow</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/grep.html">grep</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/htpasswd.html">htpasswd</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Mac/iTerm%E1%84%8B%E1%85%A6%E1%84%89%E1%85%A5%20ssh%20%E1%84%8C%E1%85%A5%E1%86%B8%E1%84%89%E1%85%A9%E1%86%A8%20%E1%84%89%E1%85%B5%20%E1%84%92%E1%85%A1%E1%86%AB%E1%84%80%E1%85%B3%E1%86%AF%E1%84%8B%E1%85%B5%20%E1%84%8B%E1%85%A1%E1%86%AB%E1%84%82%E1%85%A1%E1%84%8B%E1%85%A9%E1%86%AF%20%E1%84%84%E1%85%A2.html">iTerm에서 ssh 접속 시 한글이 안나올 때</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/include%E1%84%85%E1%85%B3%E1%86%AF%20%E1%84%89%E1%85%A1%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A2%E1%84%89%E1%85%A5%20NginX%E1%84%8B%E1%85%B4%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8C%E1%85%A5%E1%86%BC%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%82%E1%85%A1%E1%84%82%E1%85%AE%E1%84%80%E1%85%B5.html">include를 사용해서 NginX의 설정을 나누기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Chart/Chart%20Data.html">Chart Data</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Ubuntu%20Server/init.d%20%E1%84%89%E1%85%B5%E1%84%89%E1%85%B3%E1%84%90%E1%85%A6%E1%86%B7%20%E1%84%8B%E1%85%B5%E1%84%87%E1%85%A6%E1%86%AB%E1%84%90%E1%85%B3%20%E1%84%86%E1%85%A1%E1%86%AB%E1%84%83%E1%85%B3%E1%86%AF%E1%84%80%E1%85%B5.html">init.d 시스템 이벤트 만들기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Programming/Category%20Key%20%E1%84%80%E1%85%A1%20%E1%84%8B%E1%85%B5%E1%86%BB%E1%84%82%E1%85%B3%E1%86%AB%20Object%20List%20%E1%84%85%E1%85%B3%E1%86%AF%20Tree%20%E1%84%92%E1%85%A7%E1%86%BC%E1%84%90%E1%85%A2%E1%84%85%E1%85%A9%20%E1%84%87%E1%85%A7%E1%86%AB%E1%84%92%E1%85%AA%E1%86%AB.html">Category Key 가 있는 Object List 를 Tree 형태로 변환</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Programming/Bitwise%20State%20Flag.html">Bitwise State Flag</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/make.html">make</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/mdfind.html">mdfind</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Environments/mxmlc,%20compc.html">mxmlc, compc</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Graphics/Bitmap%20Drawing%20%E1%84%92%E1%85%A1%E1%86%AF%20%E1%84%84%E1%85%A2%E1%84%8B%E1%85%B4%20Matrix%20%E1%84%80%E1%85%A8%E1%84%89%E1%85%A1%E1%86%AB.html">Bitmap Drawing 할 때의 Matrix 계산</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/netstat.html">netstat</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/nginx.conf%20%E1%84%91%E1%85%A1%E1%84%8B%E1%85%B5%E1%86%AF%20%E1%84%89%E1%85%A1%E1%86%AF%E1%84%91%E1%85%A7%E1%84%87%E1%85%A9%E1%84%80%E1%85%B5.html">nginx.conf 파일 살펴보기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/npm.html">npm</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/NginX/php-frm%20%E1%84%89%E1%85%A5%E1%86%AF%E1%84%8E%E1%85%B5.html">php-frm 설치</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/pwd.html">pwd</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/scp.html">scp</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Flex%20Chart/BarSeries%E1%84%8B%E1%85%A6%20%E1%84%8E%E1%85%AE%E1%84%80%E1%85%A1%E1%84%8C%E1%85%A5%E1%86%A8%E1%84%8B%E1%85%B5%E1%86%AB%20%E1%84%8B%E1%85%AD%E1%84%89%E1%85%A9%E1%84%83%E1%85%B3%E1%86%AF%E1%84%8B%E1%85%B3%E1%86%AF%20%E1%84%80%E1%85%B3%E1%84%85%E1%85%B5%E1%84%80%E1%85%B5.html">BarSeries에 추가적인 요소들을 그리기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Windows%20Azure/Azure%E1%84%8B%E1%85%A6%20Ubuntu%20Server%20Virtual%20Machine%20%E1%84%86%E1%85%A1%E1%86%AB%E1%84%83%E1%85%B3%E1%86%AF%E1%84%80%E1%85%B5.html">Azure에 Ubuntu Server Virtual Machine 만들기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Async.html">Async</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/SSH%20Authentication/ssh-keygen.html">ssh-keygen</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/system%20info%20commands.html">system info commands</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Web/Mac/Alfred%20Workflow%E1%84%85%E1%85%B3%E1%86%AF%20%E1%84%89%E1%85%A1%E1%84%8B%E1%85%AD%E1%86%BC%E1%84%92%E1%85%A2%E1%84%89%E1%85%A5%20%E1%84%89%E1%85%B3%E1%84%8F%E1%85%B3%E1%84%85%E1%85%B5%E1%86%AB%E1%84%8F%E1%85%A2%E1%86%B8%E1%84%8E%E1%85%A7%E1%84%92%E1%85%A1%E1%84%80%E1%85%B5.html">Alfred Workflow를 사용해서 스크린캡쳐하기</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/tree.html">tree</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/user,%20group,%20permission%20management.html">user, group, permission management</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/which.html">which</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Shell/zsh.html">zsh</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Server/Ubuntu%20Server/%E1%84%80%E1%85%B5%E1%84%87%E1%85%A9%E1%86%AB%20%E1%84%89%E1%85%A1%E1%84%92%E1%85%A1%E1%86%BC%E1%84%83%E1%85%B3%E1%86%AF.html">기본 사항들</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Math/%E1%84%89%E1%85%A1%E1%86%B7%E1%84%80%E1%85%A1%E1%86%A8%E1%84%92%E1%85%A1%E1%86%B7%E1%84%89%E1%85%AE.html">삼각함수</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Math/%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8%E1%84%89%E1%85%B5%E1%86%A8.html">수학식</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Math/%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8%E1%84%8C%E1%85%A5%E1%86%A8%20%E1%84%80%E1%85%B3%E1%84%85%E1%85%A2%E1%84%91%E1%85%B5%E1%86%A8%E1%84%89%E1%85%B3%20%E1%84%83%E1%85%B3%E1%84%85%E1%85%A9%E1%84%8B%E1%85%B5%E1%86%BC.html">수학적 그래픽스 드로잉</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Math/%E1%84%8B%E1%85%B5%E1%84%8B%E1%85%A3%E1%84%80%E1%85%B5%E1%84%85%E1%85%A9%20%E1%84%89%E1%85%B1%E1%86%B8%E1%84%80%E1%85%A6%20%E1%84%87%E1%85%A2%E1%84%8B%E1%85%AE%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%83%E1%85%A2%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8.html">이야기로 쉽게 배우는 대수학</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Math/%E1%84%8B%E1%85%B5%E1%86%B0%E1%84%8B%E1%85%A5%E1%84%8B%E1%85%A3%20%E1%84%92%E1%85%A1%E1%84%82%E1%85%B3%E1%86%AB%20%E1%84%89%E1%85%AE%E1%84%92%E1%85%A1%E1%86%A8%E1%84%8E%E1%85%A2%E1%86%A8%E1%84%83%E1%85%B3%E1%86%AF.html">읽어야 하는 수학책들</a>
					</li>
					
					
					
					<li class="tree-leaf">
						<a href="/Flash/Graphics/3D%20Plan%20%E1%84%92%E1%85%A7%E1%86%BC%E1%84%90%E1%85%A2%E1%84%8B%E1%85%B4%20Triangle%20Vertex%20Drawing.html">3D Plan 형태의 Triangle Vertex Drawing</a>
					</li>
					
					
				</ul>
			</div>
		</div>
	</div>
</div>
<div id="copyright">
	<div class="container-fluid">
		<div id="copyright-links" class="row">
			<div class="col-md-12">
				<p class="text-center">
					<a href="http://github.com/iamssen" target="_blank"><i class="fa fa-github-square fa-4"></i></a>
					<a href="https://www.behance.net/ssen" target="_blank"><i class="fa fa-behance-square fa-4"></i></a>
					<a href="https://twitter.com/ssen1980" target="_blank"><i class="fa fa-twitter-square fa-4"></i></a>
					<a href="/feed.xml"><i class="fa fa-rss-square fa-4"></i></a>
				</p>
			</div>
		</div>
	</div>
</div>

</body>
</html>
