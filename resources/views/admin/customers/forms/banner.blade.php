<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($banner->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('admin/banner') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
            <input type="text" class="form-control" name="banner[name]" value="{{ $banner->name }}" autofocus="autofocus" required="required" />
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Start</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="DateTimePicker form-control" name="banner[start_time]" value="{{ $banner->start_time }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">End</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="DateTimePicker form-control" name="banner[end_time]" value="{{ $banner->end_time }}" />
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
                    <h3 class="panel-title">Page</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="banner[page]">
                        <option value=""></option>
                        @foreach(App\Libraries\Util::getBannerPage() as $value => $label)
                            @if($value == $banner->page)
                                <option selected="selected" value="<?php echo $value; ?>">{{ $label }}</option>
                            @else
                                <option value="<?php echo $value; ?>">{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer Type</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="banner[customer_type]">
                        <option value=""></option>
                        @foreach(App\Libraries\Util::getBannerCustomerType() as $value => $label)
                            @if($value == $banner->customer_type)
                                <option selected="selected" value="<?php echo $value; ?>">{{ $label }}</option>
                            @else
                                <option value="<?php echo $value; ?>">{{ $label }}</option>
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
                        <input<?php echo ($banner->status ? ' checked="checked"' : ''); ?> type="checkbox" name="banner[status]" value="status" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Url</h3>
        </div>
        <div class="panel-body">
            <input type="text" class="form-control" name="banner[url]" value="{{ $banner->url }}" />
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title" id="BannerSrcTitle">{{ $banner->type == App\Libraries\Util::BANNER_TYPE_VIDEO_VALUE ? 'Video Url' : 'Image' }}</h3>
                </div>
                <div class="panel-body" id="BannerSrcDiv">
                    @if($banner->type == App\Libraries\Util::BANNER_TYPE_VIDEO_VALUE)
                        <input type="text" class="form-control" name="banner[image_src]" value="{{ $banner->image_src }}" required="required" />
                    @else
                        @if(!empty($banner->image_src))
                            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
                            <img src="{{ $banner->image_src }}" width="70%" alt="Fitfood" />
                        @else
                            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" required="required" />
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Type</h3>
                </div>
                <div class="panel-body">
                    <select id="BannerTypeSelect" class="form-control" name="banner[type]">
                        @foreach(App\Libraries\Util::getBannerType() as $value => $label)
                            @if($value == $banner->type)
                                <option selected="selected" value="<?php echo $value; ?>">{{ $label }}</option>
                            @else
                                <option value="<?php echo $value; ?>">{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DateTimePicker').datetimepicker({

                format: 'Y-m-d H:i'

            });

            $('#BannerTypeSelect').change(function() {

                if($(this).val() == '<?php echo App\Libraries\Util::BANNER_TYPE_VIDEO_VALUE; ?>')
                {
                    $("#BannerSrcDiv").html('' +
                        '<input type="text" class="form-control" name="banner[image_src]" required="required" />' +
                    '');
                    $('#BannerSrcTitle').html('Video Url');
                }
                else
                {
                    $("#BannerSrcDiv").html('' +
                        '<input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" required="required" />' +
                    '');
                    $('#BannerSrcTitle').html('Image');
                }

            });

        });

    </script>

@stop

