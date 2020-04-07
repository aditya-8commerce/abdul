
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
<script src="{{asset('/vendor/sweetalert/sweetalert.all.js')}}"></script>
@if ($message = Session::get('success'))
<script>
        Swal.fire({"title":"{{ $message }}","text":"","timer":5000,"width":"32rem","heightAuto":true,"padding":"1.25rem","showConfirmButton":false,"showCloseButton":true,"showClass":{"popup":"animated fadeInDown faster"},"hideClass":{"popup":"animated fadeOutUp faster"},"toast":true,"icon":"success","position":"top-end"});
</script>
@endif
@if ($message = Session::get('info'))
<script>
        Swal.fire({"title":"{{ $message }}","text":"","timer":5000,"width":"32rem","heightAuto":true,"padding":"1.25rem","showConfirmButton":false,"showCloseButton":true,"showClass":{"popup":"animated fadeInDown faster"},"hideClass":{"popup":"animated fadeOutUp faster"},"toast":true,"icon":"info","position":"top-end"});
</script>
@endif
@if ($message = Session::get('warning'))
<script>
        Swal.fire({"title":"{{ $message }}","text":"","timer":5000,"width":"32rem","heightAuto":true,"padding":"1.25rem","showConfirmButton":false,"showCloseButton":true,"showClass":{"popup":"animated fadeInDown faster"},"hideClass":{"popup":"animated fadeOutUp faster"},"toast":true,"icon":"warning","position":"top-end"});
</script>
@endif
@if ($errors->any())
  @foreach($errors->all() as $error)  
  <script>
        Swal.fire({"title":"{{ $error }}","text":"","timer":5000,"width":"32rem","heightAuto":true,"padding":"1.25rem","showConfirmButton":false,"showCloseButton":true,"showClass":{"popup":"animated fadeInDown faster"},"hideClass":{"popup":"animated fadeOutUp faster"},"toast":true,"icon":"warning","position":"top-end"});
</script>
   @endforeach
@endif
@if (session('status'))
<script>
        Swal.fire({"title":"{{ session('status') }}","text":"","timer":5000,"width":"32rem","heightAuto":true,"padding":"1.25rem","showConfirmButton":false,"showCloseButton":true,"showClass":{"popup":"animated fadeInDown faster"},"hideClass":{"popup":"animated fadeOutUp faster"},"toast":true,"icon":"success","position":"top-end"});
</script>
@endif