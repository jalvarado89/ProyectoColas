<!DOCTYPE html>
<html>
<head>
	<title>{{ $titulo }}</title>
	{{HTML::script('js/jquery-2.1.1.min.js')}}
	{{HTML::style('bootstrap/css/bootstrap.min.css')}}
</head>
<body>
	<h1>Music Box</h1>
	{{ $content }}
	{{HTML::script('bootstrap/js/bootstrap.min.js')}}
</body>
</html>