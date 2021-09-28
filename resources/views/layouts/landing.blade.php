<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{{ config('app.name', 'Laravel') }}</title>


	<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div id="landing">
		<div class="layover">
			@include('inc.navbar')
			<div class="touchdown">
				<h1>BE-EAST CAPE</h1>
				<p>The platform that never sleeps.</p>
			</div>
		</div>
	</div>
	
	@yield('content')
</body>
</html>