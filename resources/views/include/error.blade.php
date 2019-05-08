@if ($errors->any())
    {{ implode('', $errors->all(':message')) }}
@endif