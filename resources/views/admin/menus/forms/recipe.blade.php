<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($recipe->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('recipe') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                    <input type="text" class="form-control" name="recipe[name]" value="{{ $recipe->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Name EN</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="recipe[name_en]" value="{{ $recipe->name_en }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="panel-title">Resource</h3>
                </div>
                <div class="col-sm-6">
                    <button type="button" id="AddResourceButton" data-toggle="tooltip" title="Add Resource" class="btn btn-primary btn-outline">
                        <i class="fa fa-plus fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body" id="ListResourceDiv">
            @foreach($recipe->recipeResources as $recipeResource)
                <div class="row">
                    <div class="col-sm-4">
                        <input type="text" class="form-control ResourceNameInput" placeholder="Name" name="recipe[resource][name][]" value="{{ $recipeResource->resource->name }}" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control ResourceNameENInput" placeholder="Name EN" value="{{ $recipeResource->resource->name_en }}" />
                    </div>
                    <div class="col-sm-2">
                        <div class="input-group">
                            <input type="text" class="form-control ResourceQuantityInput" placeholder="Quantity" name="recipe[resource][quantity][]" value="{{ App\Libraries\Util::formatMoney($recipeResource->quantity) }}" />
                            <span class="input-group-addon" data-addon="Unit">{{ $recipeResource->resource->unit->name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" placeholder="Price" readonly="readonly" value="{{ App\Libraries\Util::formatMoney($recipeResource->price) }}" />
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-primary btn-outline RemoveResourceButton" type="button" data-toggle="tooltip" title="Remove Resource"><i class="fa fa-trash-o fa-fw"></i></button>
                    </div>
                    <input type="hidden" placeholder="QuantityBase" value="{{ $recipeResource->resource->quantity }}" />
                    <input type="hidden" placeholder="PriceBase" value="{{ $recipeResource->resource->price }}" />
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <label class="checkbox-inline">
                        <input<?php echo ($recipe->status ? ' checked="checked"' : ''); ?> type="checkbox" name="recipe[status]" value="status" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Price</h3>
                </div>
                <div class="panel-body">
                    <input type="text" id="RecipeTotalPriceInput" class="form-control" value="{{ App\Libraries\Util::formatMoney($recipe->price) }}" readonly="readonly" />
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('#AddResourceButton').click(function() {

                $('#ListResourceDiv').append(
                    '<div class="row">' +
                    '<div class="col-sm-4">' +
                    '<input type="text" class="form-control ResourceNameInput" placeholder="Name" name="recipe[resource][name][]" />' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<input type="text" class="form-control ResourceNameENInput" placeholder="Name EN" />' +
                    '</div>' +
                    '<div class="col-sm-2">' +
                    '<div class="input-group">' +
                    '<input type="text" class="form-control ResourceQuantityInput" placeholder="Quantity" name="recipe[resource][quantity][]" readonly="readonly" />' +
                    '<span class="input-group-addon" data-addon="Unit"></span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-2">' +
                    '<input type="text" class="form-control" placeholder="Price" readonly="readonly" />' +
                    '</div>' +
                    '<div class="col-sm-1">' +
                    '<button class="btn btn-primary btn-outline RemoveResourceButton" type="button" data-toggle="tooltip" title="Remove Resource"><i class="fa fa-trash-o fa-fw"></i></button>' +
                    '</div>' +
                    '<input type="hidden" placeholder="QuantityBase" />' +
                    '<input type="hidden" placeholder="PriceBase" />' +
                    '</div>'
                );

            });

            $('#ListResourceDiv').on('mouseenter', 'button', function() {

               if($(this).hasClass('RemoveResourceButton'))
                   $(this).tooltip('show');

            });

            $('#ListResourceDiv').on('click', 'button', function() {

                if($(this).hasClass('RemoveResourceButton'))
                {
                    $(this).parent().parent().remove();

                    calculateRecipeTotalPrice();
                }

            });

            $('#ListResourceDiv').on('focusin', 'input', function() {

                if($(this).hasClass('ResourceNameInput') || $(this).hasClass('ResourceNameENInput'))
                {
                    var lang = 'vi';

                    if($(this).hasClass('ResourceNameENInput'))
                        lang = 'en';

                    $(this).autocomplete({

                        minLength: 3,
                        source: function(request, response) {

                            $.ajax({
                                url: '{{ url('recipe/get/autoComplete/resource') }}',
                                type: 'post',
                                data: '_token={{ csrf_token() }}&term=' + request.term + '&lang=' + lang,
                                success: function(result) {

                                    if(result)
                                    {
                                        result = JSON.parse(result);
                                        response(result);
                                    }

                                }
                            });

                        },
                        select: function(event, ui) {

                            var groupDiv = $(this).parent().parent();
                            groupDiv.find('input[placeholder="Name"]').val(ui.item.name);
                            groupDiv.find('input[placeholder="Name EN"]').val(ui.item.name_en);
                            groupDiv.find('input[placeholder="Quantity"]').val(ui.item.quantity).removeAttr('readonly');
                            groupDiv.find('span[data-addon="Unit"]').html(ui.item.unit);
                            groupDiv.find('input[placeholder="Price"]').val(ui.item.price);
                            groupDiv.find('input[placeholder="QuantityBase"]').val(ui.item.quantity.split('.').join(''));
                            groupDiv.find('input[placeholder="PriceBase"]').val(ui.item.price.split('.').join(''));

                            calculateRecipeTotalPrice();

                            return false;
                        }

                    }).autocomplete('instance')._renderItem = function(ul, item) {

                        if($(this).hasClass('ResourceNameENInput'))
                            return $('<li>').append('<a>' + item.name_en + '<br /><b>Price:</b> ' + item.price + ' - <b>Quantity:</b> ' + item.quantity + ' ' + item.unit + '</a>').appendTo(ul);
                        else
                            return $('<li>').append('<a>' + item.name + '<br /><b>Price:</b> ' + item.price + ' - <b>Quantity:</b> ' + item.quantity + ' ' + item.unit + '</a>').appendTo(ul);

                    };
                }

            });

            $('#ListResourceDiv').on('keyup', 'input', function() {

                if($(this).hasClass('ResourceQuantityInput'))
                {
                    $(this).val(formatMoney($(this).val()));

                    var groupDiv = $(this).parent().parent().parent();

                    if($(this).val() != '')
                    {
                        var basePrice = parseInt(groupDiv.find('input[placeholder="PriceBase"]').val());
                        var baseQuantity = parseInt(groupDiv.find('input[placeholder="QuantityBase"]').val());
                        var currentQuantity = parseInt($(this).val().split('.').join(''));
                        groupDiv.find('input[placeholder="Price"]').val(formatMoney(Math.round(basePrice * currentQuantity / baseQuantity).toString()));
                    }
                    else
                        groupDiv.find('input[placeholder="Price"]').val('0');

                    calculateRecipeTotalPrice();
                }

            });

            function calculateRecipeTotalPrice()
            {
                var recipeTotalPrice = 0;

                $('#ListResourceDiv').find('input[placeholder="Price"]').each(function() {

                    if($(this).val() != '')
                        recipeTotalPrice += parseInt($(this).val().split('.').join(''));

                });

                $('#RecipeTotalPriceInput').val(formatMoney(recipeTotalPrice.toString()));
            }

        });

    </script>

@stop