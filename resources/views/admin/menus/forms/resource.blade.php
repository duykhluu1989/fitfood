<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($resource->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('resource') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                    <input type="text" class="form-control" name="resource[name]" value="{{ $resource->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Name EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="resource[name_en]" value="{{ $resource->name_en }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Code</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="resource[code]" value="{{ $resource->code }}" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Category</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="resource[category_id]" required="required">
                        @foreach(App\Models\Category::getModelActiveCategory() as $category)
                            @if($resource->category_id == $category->id)
                                <option selected="selected" value="{{ $category->id }}">{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
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
                        <input<?php echo ($resource->status ? ' checked="checked"' : ''); ?> type="checkbox" name="resource[status]" value="status" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Price</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control InputMoney" name="resource[price]" value="{{ App\Libraries\Util::formatMoney($resource->price) }}" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Quantity</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control InputMoney" name="resource[quantity]" value="{{ App\Libraries\Util::formatMoney($resource->quantity) }}" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Unit</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="resource[unit_id]" required="required">
                        @foreach(App\Models\Unit::getModelActiveUnit() as $unit)
                            @if($resource->unit_id == $unit->id)
                                <option selected="selected" value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @else
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

