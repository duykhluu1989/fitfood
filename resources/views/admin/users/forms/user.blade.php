<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($user->id) ? 'Create' : 'Update' }}</button>
            @if(!empty($user->id))
                <a href="{{ url('admin/user/changePassword', ['id' => $user->id]) }}" class="btn btn-primary btn-outline">Change Password</a>
            @endif
            <a href="{{ url('admin/user') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>

@if(isset($errors))
    @include('admin.layouts.partials.form_error', ['errors' => $errors])
@endif

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Username</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="user[username]" value="{{ $user->username }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <label class="checkbox-inline">
                        <input<?php echo ($user->status ? ' checked="checked"' : ''); ?> type="checkbox" name="user[status]" value="status" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

@if(empty($user->id))
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Password</h3>
            </div>
            <div class="panel-body">
                <input type="password" class="form-control" name="user[password]" required="required" />
            </div>
        </div>
    </div>
@endif

<?php
$assignRoles = array();
foreach($user->userRoles as $userRole)
    $assignRoles[] = $userRole->role_id;
?>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Role</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                @foreach(App\Models\Role::all('id', 'name') as $role)
                    <div class="col-sm-4">
                        <div class="checkbox">
                            <label>
                                <input name="user[role][]" type="checkbox" value="{{ $role->id }}"{{ in_array($role->id, $assignRoles) ? ' checked="checked"' : '' }} />{{ $role->name }}
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($user->id) ? 'Create' : 'Update' }}</button>
            @if(!empty($user->id))
                <a href="{{ url('admin/user/changePassword', ['id' => $user->id]) }}" class="btn btn-primary btn-outline">Change Password</a>
            @endif
            <a href="{{ url('admin/user') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>