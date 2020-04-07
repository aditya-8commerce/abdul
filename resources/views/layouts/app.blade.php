<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="description" content="@adit_XxX_">
  <meta name="author" content="@adit_XxX_">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ config('app.name', 'App') }}</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/bootstrap.min.css') }}">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/font-awesome.min.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/simple-line-icons.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/animate.min.css') }}"/>
  <link rel="stylesheet" type="text/css" href="{{ asset('/miminium/css/plugins/icheck/skins/flat/aero.css') }}"/>
  <link href="{{ asset('/miminium/css/style.css') }}" rel="stylesheet">
  <!-- end: Css -->
    </head>

    <body id="mimin" class="dashboard form-signin-wrapper">

      <div class="container">

         @yield('content_login')

      </div>

      <!-- end: Content -->
      <!-- start: Javascript -->
      <script src="{{ asset('/miminium/js/jquery.min.js') }}"></script>
      <script src="{{ asset('/miminium/js/jquery.ui.min.js') }}"></script>
      <script src="{{ asset('/miminium/js/bootstrap.min.js') }}"></script>
      <script src="{{ asset('/miminium/js/plugins/moment.min.js') }}"></script>
      <script src="{{ asset('/miminium/js/plugins/icheck.min.js') }}"></script>

      <!-- custom -->
      <script src="{{ asset('/miminium/js/main.js') }}"></script>
      <script type="text/javascript">
       $(document).ready(function(){
         $('input').iCheck({
          checkboxClass: 'icheckbox_flat-aero',
          radioClass: 'iradio_flat-aero'
        });
       });
     </script>
     <!-- end: Javascript -->
   </body>
   </html>