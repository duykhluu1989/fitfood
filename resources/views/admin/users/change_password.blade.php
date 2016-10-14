@extends('admin.layouts.main')

@section('title', 'Change Password')

@section('header', 'Change Password - ' . $user->username)

@section('content')

    <form method="post" action="{{ url('admin/user/changePassword', ['id' => $user->id]) }}">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>

        @if(isset($errors))
            @include('admin.layouts.partials.form_error', ['errors' => $errors])
        @endif

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">New Password</h3>
                </div>
                <div class="panel-body">
                    <input type="password" class="form-control" name="user[password]" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>

    </form>

@stop

@if(session('successMessage'))

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            alert("{{ session('successMessage') }}");

        });

    </script>

@stop

@endif