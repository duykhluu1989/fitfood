@extends('admin.layouts.main')

@section('title', 'List User')

@section('header', 'List User')

@section('content')

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-6">
                        @include('admin.layouts.partials.pagination', ['pagination' => $users])
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ url('admin/user/create') }}" data-toggle="tooltip" title="New User" class="btn btn-primary btn-outline">
                            <i class="fa fa-plus fa-fw"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Active</th>
                        <th></th>
                    </tr>
                    <form id="FilterForm" action="{{ url('admin/user') }}" method="get">
                        <tr>
                            <td></td>
                            <td>
                                <input type="text" class="form-control" name="filter[username]" value="{{ (isset($filter['username']) ? $filter['username'] : '') }}" />
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[role]">
                                    <option value=""></option>
                                    @foreach(App\Models\Role::all('id', 'name') as $role)
                                        @if(isset($filter['role']) && $filter['role'] == $role->id)
                                            <option selected="selected" value="{{ $role->id }}">{{ $role->name }}</option>
                                        @else
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control DropDownFilterForm" name="filter[status]">
                                    <option value=""></option>
                                    @foreach(App\Libraries\Util::getStatus() as $value => $label)
                                        @if(isset($filter['status']) && $filter['status'] !== '' && $filter['status'] == $value)
                                            <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td></td>
                        </tr>

                        <input type="submit" style="display: none" />
                    </form>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <a href="{{ url('admin/user/edit', ['id' => $user->id]) }}" class="btn btn-primary btn-outline">{{ $user->id }}</a>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>
                                @foreach($user->userRoles as $userRole)
                                    {{ $userRole->role->name }}<br />
                                @endforeach
                            </td>
                            <td<?php echo ($user->status == App\Libraries\Util::STATUS_ACTIVE_VALUE ? ' class="info"' : ''); ?>></td>
                            <td>
                                <a href="{{ url('admin/user/changePassword', ['id' => $user->id]) }}" data-toggle="tooltip" title="Change Password" class="btn btn-primary btn-outline">
                                    <i class="fa fa-lock fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                @include('admin.layouts.partials.pagination', ['pagination' => $users])
            </div>
        </div>
    </div>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DropDownFilterForm').change(function() {

                $('#FilterForm').submit();

            });

        });

    </script>

@stop