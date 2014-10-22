<!DOCTYPE html>
<html>
<head>
	<title>{{ $titulo }}</title>
	{{HTML::script('js/jquery-2.1.1.min.js')}}
	{{HTML::style('bootstrap/css/bootstrap.min.css')}}
</head>
<body onload="hide()">
	<h1>Music Box</h1>
	{{ $content }}
	{{HTML::script('bootstrap/js/bootstrap.min.js')}}
	{{HTML::script('js/index.js')}}
</body>
</html>