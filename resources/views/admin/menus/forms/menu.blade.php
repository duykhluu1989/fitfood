<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($menu->id) ? 'Create' : 'Update' }}</button>
            <a href="{{ url('admin/menu') }}" class="btn btn-primary btn-outline pull-right">Back</a>
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
                    <input type="text" class="form-control" name="menu[name]" value="{{ $menu->name }}" autofocus="autofocus" required="required" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="menu[status]">
                        @foreach(App\Libraries\Util::getMenuStatus() as $value => $label)
                            @if($value == $menu->status)
                                <option selected="selected" value="<?php echo $value; ?>">{{ $label }}</option>
                            @else
                                <option value="<?php echo $value; ?>">{{ $label }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Type</h3>
                </div>
                <div class="panel-body">
                    <select class="form-control" name="menu[type]">
                        @foreach(App\Libraries\Util::getMenuType() as $value => $label)
                            @if($value == $menu->type)
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

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Recipe</h3>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th></th>
                    <th>Monday</th>
                    <th>Tuesday</th>
                    <th>Wednesday</th>
                    <th>Thursday</th>
                    <th>Friday</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $recipes = [
                    App\Libraries\Util::MEAL_BREAKFAST_LABEL => [],
                    App\Libraries\Util::MEAL_LUNCH_LABEL => [],
                    App\Libraries\Util::MEAL_DINNER_LABEL => [],
                ];
                $dayStatus = array();
                if(count($menu->menuRecipes) > 0)
                {
                    foreach($menu->menuRecipes as $menuRecipe)
                    {
                        if(!empty($menuRecipe->breakfastRecipe))
                            $recipes[App\Libraries\Util::MEAL_BREAKFAST_LABEL][$menuRecipe->day_of_week] = $menuRecipe->breakfastRecipe->name;
                        if(!empty($menuRecipe->lunchRecipe))
                            $recipes[App\Libraries\Util::MEAL_LUNCH_LABEL][$menuRecipe->day_of_week] = $menuRecipe->lunchRecipe->name;
                        if(!empty($menuRecipe->dinnerRecipe))
                            $recipes[App\Libraries\Util::MEAL_DINNER_LABEL][$menuRecipe->day_of_week] = $menuRecipe->dinnerRecipe->name;
                        $dayStatus[$menuRecipe->day_of_week] = $menuRecipe->status;
                    }
                }
                ?>
                @foreach($recipes as $meal => $recipeDayOfWeek)
                    <tr>
                        <th>{{ $meal }}</th>
                        @for($i = 1;$i <= 5;$i ++)
                            <td>
                                <input type="text" class="form-control RecipeNameInput" placeholder="Name" name="menu[recipe][name][<?php echo $i; ?>][<?php echo $meal; ?>]" value="<?php echo (isset($recipeDayOfWeek[$i]) ? $recipeDayOfWeek[$i] : ''); ?>" />
                            </td>
                        @endfor
                    </tr>
                @endforeach
                <tr>
                    <th>Status</th>
                    @for($i = 1;$i <= 5;$i ++)
                        <td>
                            <label class="checkbox-inline">
                                <input<?php echo ((isset($dayStatus[$i]) && $dayStatus[$i] == true) ? ' checked="checked"' : ''); ?> type="checkbox" name="menu[recipe][status][<?php echo $i; ?>]" value="status" /><b>Active</b>
                            </label>
                        </td>
                    @endfor
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Image (1381 x 795)</h3>
        </div>
        <div class="panel-body">
            <input type="file" class="form-control" name="image" accept=".jpg, .jpeg, .png, .gif, .JPG, .JPEG, .PNG, .GIF" />
            @if(!empty($menu->image_src))
                <img src="{{ $menu->image_src }}" width="50%" alt="Fitfood" />
            @endif
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.RecipeNameInput').autocomplete({

                minLength: 3,
                source: function(request, response) {

                    $.ajax({
                        url: '{{ url('admin/menu/get/autoComplete/recipe') }}',
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

                    $(this).val(ui.item.name);

                    return false;
                }

            }).each(function() {

                $(this).autocomplete('instance')._renderItem = function(ul, item) {

                    return $('<li>').append('<a>' + item.name + (item.name_en ? (' - ' + item.name_en) : '') + '</a>').appendTo(ul);

                };

            });

        });

    </script>

@stop