<div class="col-sm-12">
    @foreach($errors as $error)
        <div class="alert alert-danger" role="alert">
            <i class="fa fa-remove fa-fw"></i>{{ $error }}
        </div>
    @endforeach
</div>