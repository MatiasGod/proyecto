@if ($errors->any())
    @foreach($errors->all() as $error)
        <script>
            toastr.options.preventDuplicates = true;
            toastr.options.progressBar = true;
            var error = '{!!$error!!}';
            toastr.error(error)
        </script>
    @endforeach
@endif