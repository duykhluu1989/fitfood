<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($recipe->id) ? 'Create' : 'Update' }}</button>

            @if(!empty($recipe->id) && $recipe->validateDelete())
                <a href="{{ url('admin/recipe/delete', ['id' => $recipe->id]) }}" class="btn btn-primary btn-outline" onclick="return showConfirmMessage();">Delete</a>
            @endif

            <a href="{{ url('admin/recipe') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                <div class="row" style="margin-bottom: 20px">
                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><b>Name</b></span>
                            <input type="text" class="form-control ResourceNameInput" placeholder="Name" name="recipe[resource][name][]" value="{{ $recipeResource->resource->name }}" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Quantity</span>
                            <input type="text" class="form-control ResourceQuantityInput" placeholder="Quantity" name="recipe[resource][quantity][]" value="{{ App\Libraries\Util::formatMoney($recipeResource->quantity) }}" />
                            <span class="input-group-addon" data-addon="Unit">{{ $recipeResource->resource->unit->name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Price</span>
                            <input type="text" class="form-control" placeholder="Price" readonly="readonly" value="{{ App\Libraries\Util::formatMoney($recipeResource->price) }}" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Calories</span>
                            <input type="text" class="form-control" placeholder="Calories" readonly="readonly" value="{{ App\Libraries\Util::formatMoney($recipeResource->calories) }}" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Carb</span>
                            <input type="text" class="form-control" placeholder="Carb" readonly="readonly" value="{{ App\Libraries\Util::formatMoney($recipeResource->carb) }}" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Fat</span>
                            <input type="text" class="form-control" placeholder="Fat" readonly="readonly" value="{{ App\Libraries\Util::formatMoney($recipeResource->fat) }}" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <span class="input-group-addon">Protein</span>
                            <input type="text" class="form-control" placeholder="Protein" readonly="readonly" value="{{ App\Libraries\Util::formatMoney($recipeResource->protein) }}" />
                        </div>
                    </div>
                    <div class="col-sm-11">
                        <div class="input-group">
                            <span class="input-group-addon">Note</span>
                            <input type="text" class="form-control" placeholder="Note" name="recipe[resource][note][]" value="{{ $recipeResource->note }}" />
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button class="btn btn-primary btn-outline RemoveResourceButton" type="button" data-toggle="tooltip" title="Remove Resource"><i class="fa fa-trash-o fa-fw"></i></button>
                    </div>
                    <input type="hidden" placeholder="QuantityBase" value="{{ $recipeResource->resource->quantity }}" />
                    <input type="hidden" placeholder="PriceBase" value="{{ $recipeResource->resource->price }}" />
                    <input type="hidden" placeholder="CaloriesBase" value="{{ $recipeResource->resource->calories }}" />
                    <input type="hidden" placeholder="CarbBase" value="{{ $recipeResource->resource->carb }}" />
                    <input type="hidden" placeholder="FatBase" value="{{ $recipeResource->resource->fat }}" />
                    <input type="hidden" placeholder="ProteinBase" value="{{ $recipeResource->resource->protein }}" />
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

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Calories</h3>
                </div>
                <div class="panel-body">
                    <input type="text" id="RecipeTotalCaloriesInput" class="form-control" value="{{ App\Libraries\Util::formatMoney($recipe->calories) }}" readonly="readonly" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Carb</h3>
                </div>
                <div class="panel-body">
                    <input type="text" id="RecipeTotalCarbInput" class="form-control" value="{{ App\Libraries\Util::formatMoney($recipe->carb) }}" readonly="readonly" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Fat</h3>
                </div>
                <div class="panel-body">
                    <input type="text" id="RecipeTotalFatInput" class="form-control" value="{{ App\Libraries\Util::formatMoney($recipe->fat) }}" readonly="readonly" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Protein</h3>
                </div>
                <div class="panel-body">
                    <input type="text" id="RecipeTotalProteinInput" class="form-control" value="{{ App\Libraries\Util::formatMoney($recipe->protein) }}" readonly="readonly" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Image (800 x 800)</h3>
        </div>
        <div class="panel-body">
            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
            @if(!empty($recipe->image_src))
                <img src="{{ $recipe->image_src }}" width="50%" alt="Fitfood" />
            @endif
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('#AddResourceButton').click(function() {

                $('#ListResourceDiv').append(
                    '<div class="row" style="margin-bottom: 20px">' +
                    '<div class="col-sm-6">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon"><b>Name</b></span>' +
                    '<input type="text" class="form-control ResourceNameInput" placeholder="Name" name="recipe[resource][name][]" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">Quantity</span>' +
                    '<input type="text" class="form-control ResourceQuantityInput" placeholder="Quantity" name="recipe[resource][quantity][]" readonly="readonly" />' +
                    '<span class="input-group-addon" data-addon="Unit"></span>' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">Price</span>' +
                    '<input type="text" class="form-control" placeholder="Price" readonly="readonly" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">Calories</span>' +
                    '<input type="text" class="form-control" placeholder="Calories" readonly="readonly" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">Carb</span>' +
                    '<input type="text" class="form-control" placeholder="Carb" readonly="readonly" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">Fat</span>' +
                    '<input type="text" class="form-control" placeholder="Fat" readonly="readonly" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-3">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">Protein</span>' +
                    '<input type="text" class="form-control" placeholder="Protein" readonly="readonly" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-11">' +
                    '<div class="input-group">' +
                    '<span class="input-group-addon">Note</span>' +
                    '<input type="text" class="form-control" placeholder="Note" name="recipe[resource][note][]" />' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-sm-1">' +
                    '<button class="btn btn-primary btn-outline RemoveResourceButton" type="button" data-toggle="tooltip" title="Remove Resource"><i class="fa fa-trash-o fa-fw"></i></button>' +
                    '</div>' +
                    '<input type="hidden" placeholder="QuantityBase" />' +
                    '<input type="hidden" placeholder="PriceBase" />' +
                    '<input type="hidden" placeholder="CaloriesBase" />' +
                    '<input type="hidden" placeholder="CarbBase" />' +
                    '<input type="hidden" placeholder="FatBase" />' +
                    '<input type="hidden" placeholder="ProteinBase" />' +
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

                if($(this).hasClass('ResourceNameInput'))
                {
                    $(this).autocomplete({

                        minLength: 3,
                        source: function(request, response) {

                            $.ajax({
                                url: '{{ url('admin/recipe/get/autoComplete/resource') }}',
                                type: 'post',
                                data: '_token={{ csrf_token() }}&term=' + request.term,
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

                            var groupDiv = $(this).parent().parent().parent();
                            groupDiv.find('input[placeholder="Name"]').val(ui.item.name);
                            groupDiv.find('input[placeholder="Quantity"]').val(ui.item.quantity).removeAttr('readonly');
                            groupDiv.find('span[data-addon="Unit"]').html(ui.item.unit);
                            groupDiv.find('input[placeholder="Price"]').val(ui.item.price);
                            groupDiv.find('input[placeholder="Calories"]').val(ui.item.calories);
                            groupDiv.find('input[placeholder="Carb"]').val(ui.item.carb);
                            groupDiv.find('input[placeholder="Fat"]').val(ui.item.fat);
                            groupDiv.find('input[placeholder="Protein"]').val(ui.item.protein);
                            groupDiv.find('input[placeholder="QuantityBase"]').val(ui.item.quantity.split('.').join(''));
                            groupDiv.find('input[placeholder="PriceBase"]').val(ui.item.price.split('.').join(''));
                            groupDiv.find('input[placeholder="CaloriesBase"]').val(ui.item.calories.split('.').join(''));
                            groupDiv.find('input[placeholder="CarbBase"]').val(ui.item.carb.split('.').join(''));
                            groupDiv.find('input[placeholder="FatBase"]').val(ui.item.fat.split('.').join(''));
                            groupDiv.find('input[placeholder="ProteinBase"]').val(ui.item.protein.split('.').join(''));

                            calculateRecipeTotalPrice();

                            return false;
                        }

                    }).autocomplete('instance')._renderItem = function(ul, item) {

                        return $('<li>').append('<a>' + item.name + (item.name_en ? (' - ' + item.name_en) : '') +
                            '<br /><b>Price:</b> ' + item.price + ' - <b>Quantity:</b> ' + item.quantity + ' ' + item.unit +
                            ' - <b>Calories:</b> ' + item.calories + ' - <b>Carb:</b> ' + item.carb + ' - <b>Fat:</b> ' + item.fat + ' - <b>Protein:</b> ' + item.protein + '</a>').appendTo(ul);

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
                        var baseCalories = parseInt(groupDiv.find('input[placeholder="CaloriesBase"]').val());
                        var baseCarb = parseInt(groupDiv.find('input[placeholder="CarbBase"]').val());
                        var baseFat = parseInt(groupDiv.find('input[placeholder="FatBase"]').val());
                        var baseProtein = parseInt(groupDiv.find('input[placeholder="ProteinBase"]').val());
                        var currentQuantity = parseInt($(this).val().split('.').join(''));
                        groupDiv.find('input[placeholder="Price"]').val(formatMoney(Math.round(basePrice * currentQuantity / baseQuantity).toString()));
                        groupDiv.find('input[placeholder="Calories"]').val(formatMoney(Math.round(baseCalories * currentQuantity / baseQuantity).toString()));
                        groupDiv.find('input[placeholder="Carb"]').val(formatMoney(Math.round(baseCarb * currentQuantity / baseQuantity).toString()));
                        groupDiv.find('input[placeholder="Fat"]').val(formatMoney(Math.round(baseFat * currentQuantity / baseQuantity).toString()));
                        groupDiv.find('input[placeholder="Protein"]').val(formatMoney(Math.round(baseProtein * currentQuantity / baseQuantity).toString()));
                    }
                    else
                    {
                        groupDiv.find('input[placeholder="Price"]').val('0');
                        groupDiv.find('input[placeholder="Calories"]').val('0');
                        groupDiv.find('input[placeholder="Carb"]').val('0');
                        groupDiv.find('input[placeholder="Fat"]').val('0');
                        groupDiv.find('input[placeholder="Protein"]').val('0');
                    }

                    calculateRecipeTotalPrice();
                }

            });

            function calculateRecipeTotalPrice()
            {
                var recipeTotalPrice = 0;
                var recipeTotalCalories = 0;
                var recipeTotalCarb = 0;
                var recipeTotalFat = 0;
                var recipeTotalProtein = 0;

                $('#ListResourceDiv .row').each(function() {

                    var resourcePrice = $(this).find('input[placeholder="Price"]').val();
                    if(resourcePrice != '')
                        recipeTotalPrice += parseInt(resourcePrice.split('.').join(''));
                    var resourceCalories = $(this).find('input[placeholder="Calories"]').val();
                    if(resourceCalories != '')
                        recipeTotalCalories += parseInt(resourceCalories.split('.').join(''));
                    var resourceCarb = $(this).find('input[placeholder="Carb"]').val();
                    if(resourceCarb != '')
                        recipeTotalCarb += parseInt(resourceCarb.split('.').join(''));
                    var resourceFat = $(this).find('input[placeholder="Fat"]').val();
                    if(resourceFat != '')
                        recipeTotalFat += parseInt(resourceFat.split('.').join(''));
                    var resourceProtein = $(this).find('input[placeholder="Protein"]').val();
                    if(resourceProtein != '')
                        recipeTotalProtein += parseInt(resourceProtein.split('.').join(''));

                });

                $('#RecipeTotalPriceInput').val(formatMoney(recipeTotalPrice.toString()));
                $('#RecipeTotalCaloriesInput').val(formatMoney(recipeTotalCalories.toString()));
                $('#RecipeTotalCarbInput').val(formatMoney(recipeTotalCarb.toString()));
                $('#RecipeTotalFatInput').val(formatMoney(recipeTotalFat.toString()));
                $('#RecipeTotalProteinInput').val(formatMoney(recipeTotalProtein.toString()));
            }

        });

    </script>

@stop