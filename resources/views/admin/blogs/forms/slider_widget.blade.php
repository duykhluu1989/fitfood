<?php
$widgetDetails = array();
$maxWidgetDetailId = 0;
if(!empty($widget->detail))
{
    $details = json_decode($widget->detail, true);
    foreach($details as $detail)
    {
        $widgetDetails[$detail['position']] = $detail;

        if($detail['id'] > $maxWidgetDetailId)
            $maxWidgetDetailId = $detail['id'];
    }
    ksort($widgetDetails);
}
?>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="panel-title">
                        Image
                        <?php
                        switch($widget->name)
                        {
                            case App\Libraries\Util::WIDGET_NAME_HOME_SLIDER:

                                echo '(' . App\Libraries\Util::WIDGET_HOME_SLIDER_IMAGE_MAX_WIDTH . ' x ' . App\Libraries\Util::WIDGET_HOME_SLIDER_IMAGE_MAX_HEIGHT . ')';

                                break;
                        }
                        ?>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <button type="button" id="AddImageButton" data-toggle="tooltip" title="Add Image" class="btn btn-primary btn-outline">
                        <i class="fa fa-plus fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body" id="ListImageDiv">
            @foreach($widgetDetails as $widgetDetail)
                <div class="row">
                    <div class="col-sm-1">
                        <img src="{{ $widgetDetail['image_src'] }}" width="100%" alt="Fitfood" />
                    </div>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" name="image[]" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Caption" name="widget[detail][caption][]" value="{{ isset($widgetDetail['caption']) ? $widgetDetail['caption'] : '' }}" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" placeholder="Url" name="widget[detail][url][]" value="{{ isset($widgetDetail['url']) ? $widgetDetail['url'] : '' }}" />
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-primary btn-outline RemoveImageButton" type="button" data-toggle="tooltip" title="Remove Image"><i class="fa fa-trash-o fa-fw"></i></button>
                    </div>
                    <input type="hidden" name="widget[detail][id][]" value="{{ $widgetDetail['id'] }}" />
                </div>
            @endforeach
        </div>
    </div>
</div>

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            var maxWidgetDetailId = {{ $maxWidgetDetailId }};

            $('#AddImageButton').click(function() {

                maxWidgetDetailId ++;

                $('#ListImageDiv').append(
                    '<div class="row">' +
                    '<div class="col-sm-1">' +
                    '</div>' +
                    '<div class="col-sm-4">' +
                    '<input type="file" class="form-control" name="image[]" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" required="required" />' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<input type="text" class="form-control" placeholder="Caption" name="widget[detail][caption][]" />' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<input type="text" class="form-control" placeholder="Url" name="widget[detail][url][]" />' +
                    '</div>' +
                    '<div class="col-sm-1">' +
                    '<button class="btn btn-primary btn-outline RemoveImageButton" type="button" data-toggle="tooltip" title="Remove Image"><i class="fa fa-trash-o fa-fw"></i></button>' +
                    '</div>' +
                    '<input type="hidden" name="widget[detail][id][]" value="' + maxWidgetDetailId + '" />' +
                    '</div>'
                );

            });

            $('#ListImageDiv').on('mouseenter', 'button', function() {

                if($(this).hasClass('RemoveImageButton'))
                    $(this).tooltip('show');

            });

            $('#ListImageDiv').on('click', 'button', function() {

                if($(this).hasClass('RemoveImageButton'))
                    $(this).parent().parent().remove();

            });

            $('#ListImageDiv').sortable({

                revert: true,
                cursor: "move"

            });

        });

    </script>

@stop