<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($category->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('blogCategory') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>

@if(isset($errors))
    @include('admin.layouts.partials.form_error', ['errors' => $errors])
@endif

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Name</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="category[name]" value="{{ $category->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Slug</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="category[slug]" value="{{ $category->slug }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <label class="checkbox-inline">
                        <input<?php echo ($category->status ? ' checked="checked"' : ''); ?> type="checkbox" name="category[status]" value="status" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Name EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="category[name_en]" value="{{ $category->name_en }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Slug EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="category[slug_en]" value="{{ $category->slug_en }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Image (1600 x 505)</h3>
        </div>
        <div class="panel-body">
            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
            @if(!empty($category->image_src))
                <img src="{{ $category->image_src }}" width="50%" alt="Fitfood" />
            @endif
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">