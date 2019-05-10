@if(Session::has('message'))
<script>
    toastr.options.preventDuplicates = true;
    toastr.options.progressBar = true;
    toastr.options.positionClass = "toast-top-full-width";
    toastr.success( '{{Session::get('message')}}' )
</script>
@endif
@if(Session::has('error'))
<script>
    toastr.options.preventDuplicates = true;
    toastr.options.progressBar = true;
    toastr.options.positionClass = "toast-top-full-width";
    toastr.error('{{Session::get('error')}}')
</script>
@endif