<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($role->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('role') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>

@if(isset($errors))
    @include('admin.layouts.partials.form_error', ['errors' => $errors])
@endif

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Name</h3>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" name="role[name]" value="{{ $role->name }}" autofocus="autofocus" required="required" />
        </div>
    </div>
</div>

<?php
$allowedRoutes = array();
if(!empty($role->permission))
    $allowedRoutes = json_decode($role->permission, true);
$routes = Route::getRoutes();
?>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Permission</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                @foreach($routes as $route)
                    @if(in_array('permission', $route->middleware()))
                        <?php
                        $routeName = $route->getMethods()[0] . ' - ' . $route->getPath();
                        ?>
                        <div class="col-sm-4">
                            <div class="checkbox">
                                <label>
                                    <input name="role[permission][]" type="checkbox" value="{{ $routeName }}"{{ in_array($routeName, $allowedRoutes) ? ' checked="checked"' : '' }} />{{ $routeName }}
                                </label>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($role->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('role') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>