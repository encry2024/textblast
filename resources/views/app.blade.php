<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>NSI :: Text Blast v0.1</title>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/css/btn.css"/>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/css/links.css"/>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/css/fonts.css"/>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/css/input.css"/>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/css/location.css"/>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/css/panel.css"/>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/css/separators.css"/>
    <link rel="stylesheet" href="{!! URL::to('/') !!}/packages/jquery-dropdown/source/css/multilist.css"/>
    <link href="{{ asset('packages/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::to('/') }}/bootstrap/bootstrap-3.3.4/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="{{ URL::to('/') }}/packages/DataTables-1.10.4/media/css/jquery.dataTables.min.css"/>
	<link rel="stylesheet" href="{{ URL::to('/') }}/packages/autocomplete/css/jquery.tagit.css"/>
	<link rel="stylesheet" href="{{ URL::to('/') }}/packages/autocomplete/css/tagit.ui-zendesk.css"/>

</head>
<body>
    <script src="{{ URL::to('/') }}/bootstrap/bootstrap-3.3.4/js/jquery-1.11.2.min.js"></script>
	<script src="{{ URL::to('/') }}/jquery-ui-1.11.4/jquery-ui.min.js"></script>
    <script>
        $(document).off('.data-api');
    </script>

    <script src="{{ URL::to('/') }}/packages/DataTables-1.10.4/media/js/jquery.dataTables.min.js"></script>
    <script src="{{ URL::to('/') }}/bootstrap/bootstrap-3.3.4/js/bootstrap.min.js"></script>
	<script src="{{ URL::to('/') }}/packages/jquery-dropdown/demo/jquery.tmpl.min.js"></script>
	<script src="{{ URL::to('/') }}/packages/jquery-dropdown/source/js/multilist.js"></script>
	<script src="{{ URL::to('/') }}/packages/autocomplete/js/tag-it.js"></script>

	@yield('header')
	@yield('content')
    @yield('script')

    <style>
        body {
            -webkit-font-smoothing: antialiased;
            font-family:Trebuchet MS, Arial, 'Segoe UI', sans-serif;
        }
    </style>
	<!-- Scripts -->
</body>
</html>
