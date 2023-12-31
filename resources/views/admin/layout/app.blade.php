<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title')</title>
    <!-- CSS files -->
    <link href="{{ url('assets/theme_assets/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/theme_assets/css/tabler-flags.min.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/theme_assets/css/tabler-payments.min.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/theme_assets/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/theme_assets/css/demo.min.css') }}" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
     alpha/css/bootstrap.css"
        rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/rowreorder/1.3.1/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">


    @stack('css_or_js')
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: Inter, -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        .modal-title {
            width: 88% !important;
        }

        th,
        td {
            padding: 4px;
        }

        .notification {
            background-color: #6383a8;
            color: white;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            padding: 9px;
            font-family: sans-serif;
        }

        .notification:hover {
            background-color: #6383a8d1;
            border-radius: 6px;
            color: white;
            padding: 9px;
            font-weight: bold;
            border: none;
            font-family: sans-serif;
        }

        button.dt-button.buttons-html5 {
            background-color: #6383a8;
            color: white;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            font-family: sans-serif;
        }

        button.dt-button.buttons-html5:hover {
            background-color: #6383a8d1;
            border-radius: 6px;
            font-weight: bold;
            border: none;
            font-family: sans-serif;
        }

        body {
            background-color: #f1f5f9;
        }

        .navbar {
            margin-bottom: 0px !important;
            margin-left: -10px !important;
            margin-right: -8px !important;
        }

        select.form-control.changeLang {
            margin-top: 8px !important;
        }

        .navbar-vertical.navbar-expand-lg .navbar-collapse .dropdown-menu-columns {
            flex-direction: column;
            margin-left: 31px;
        }
    </style>
</head>
  <body @if(\App::getLocale()=='ar' || \App::getLocale()=='arc' || \App::getLocale()=='arz' || \App::getLocale()=='ckb' || \App::getLocale()=='dv' || \App::getLocale()=='fa' || \App::getLocale()=='ha' || \App::getLocale()=='he' || \App::getLocale()=='khw' || \App::getLocale()=='ksh' || \App::getLocale()=='sd' || \App::getLocale()=='ur' || \App::getLocale()=='yi' || \App::getLocale()=='uz_AF')  style="direction:rtl !important" @endif>
    <script src="{{url('assets/theme_assets/js/demo-theme.min.js')}}"></script>
    <div class="page">
      <!-- Navbar -->
      @include('admin.layout.sidebar')
      @include('admin.layout.header')
      
   
      <div class="page-wrapper">
        <!-- Page header -->
         @yield('content')
        </div>
      @include('admin.layout.footer')
      
    </div>
  @stack('script')
    <!-- Libs JS -->
    <script src="{{url('assets/theme_assets/libs/apexcharts/dist/apexcharts.min.js')}}?1674944402" defer></script>
    <script src="{{url('assets/theme_assets/libs/jsvectormap/dist/js/jsvectormap.min.js')}}?1674944402" defer></script>
    <script src="{{url('assets/theme_assets/libs/jsvectormap/dist/maps/world.js')}}?1674944402" defer></script>
    <script src="{{url('assets/theme_assets/libs/jsvectormap/dist/maps/world-merc.js')}}?1674944402" defer></script>
    <!-- Tabler Core -->
    <script src="{{url('assets/theme_assets/js/tabler.min.js')}}?1674944402" defer></script>
    <script src="{{url('assets/theme_assets/js/demo.min.js')}}?1674944402" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/rowreorder/1.3.1/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.4.0/js/dataTables.responsive.min.js"></script>
	  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
	   <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	   <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	   <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
     
	  <script>
		$(document).ready(function() {
    var table = $('#example').DataTable( {
		"dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ordering":false,
		"paging": false,
        "searching":false,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
   			 } );
			} );
		
	  </script>
	  <script>
		$(document).ready(function() {
    var table = $('#example2').DataTable( {
		"dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ordering":false,
		"paging": false,
        "searching":false,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
   			 } );
			} );
		
	  </script>
	  <script>
		$(document).ready(function() {
    var table = $('#example3').DataTable( {
		"dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ordering":false,
		"paging": false,
        "searching":false,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
   			 } );
			} );
		
	  </script>
	  <script>
		$(document).ready(function() {
    var table = $('#example4').DataTable( {
		"dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ordering":false,
		"paging": false,
        "searching":false,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
   			 } );
			} );
		
	  </script>
	  <script>
		$(document).ready(function() {
    var table = $('#example5').DataTable( {
		"dom": 'Bfrtip',
        "buttons": [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        "ordering":false,
		"paging": false,
        "searching":false,
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
   			 } );
			} );
		
	  </script>
    <script>
function myFunctionn() {
  var input, filter, ul, li, a, i;
  input = document.getElementById("mySearch");
  filter = input.value.toUpperCase();
  ul = document.getElementById("myMenu");
  li = ul.getElementsByTagName("li");
  for (i = 0; i < li.length; i++) {
    a = li[i].getElementsByTagName("a")[0];
    if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
      li[i].style.display = "";
    } else {
      li[i].style.display = "none";
    }
  }
}
</script>
    <script type="text/javascript">
        $('#summernote').summernote({
            height: 400
        });
    </script>
    <script type="text/javascript">
        $('#summernote1').summernote({
            height: 400
        });
    </script>
    <script type="text/javascript">
        $('#summernote2').summernote({
            height: 400
        });
    </script>
@stack('script_2')
   
   
    

    
   
   
   
   
   <script>
    @foreach ($errors->all() as $error)
      toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.error("{{  $error }}");
     @endforeach  

  @if(Session::has('success'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.success("{{ session('success') }}");
  @endif

  @if(Session::has('error'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.error("{{ session('error') }}");
  @endif

  @if(Session::has('info'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.info("{{ session('info') }}");
  @endif

  @if(Session::has('warning'))
  toastr.options =
  {
    "closeButton" : true,
    "progressBar" : true
  }
      toastr.warning("{{ session('warning') }}");
  @endif
</script>
  </body>
</html>