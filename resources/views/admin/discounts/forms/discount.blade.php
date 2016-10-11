<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <button type="submit" class="btn btn-primary">{{ empty($discount->id) ? 'Create' : 'Update' }}</button>

            @if(!empty($discount->id) && $discount->times_used == 0)
                <a href="{{ url('discount/delete', ['id' => $discount->id]) }}" class="btn btn-primary btn-outline" onclick="return showConfirmMessage();">Delete</a>
            @endif

            <a href="{{ url('discount') }}" class="btn btn-primary btn-outline pull-right">Back</a>
        </div>
    </div>
</div>

@if(isset($errors))
    @include('admin.layouts.partials.form_error', ['errors' => $errors])
@endif

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="panel-title">Code</h3>
                </div>
                <div class="col-sm-6">
                    @if(empty($discount->id))
                        <div class="input-group">
                            <input id="InputNumberCharacter" type="text" class="form-control" placeholder="Number Character (Min: 6 - Max: 255)" />
                            <span class="input-group-btn"><button id="GenerateCodeButton" class="btn btn-default" type="button" data-toggle="tooltip" title="Generate Code"><i class="fa fa-random fa-fw"></i></button></span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="panel-body">
            @if(empty($discount->id))
                <input type="text" class="form-control" id="InputDiscountCode" name="discount[code]" value="{{ $discount->code }}" autofocus="autofocus" required="required" />
            @else
                <input type="text" class="form-control" value="{{ $discount->code }}" readonly="readonly" />
            @endif
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Description</h3>
        </div>
        <div class="panel-body">
            <textarea class="form-control" name="discount[description]">{{ $discount->description }}</textarea>
        </div>
    </div>
</div>

@if(!empty($discount->id))
    <div class="col-sm-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Used</h3>
                    </div>
                    <div class="panel-body">
                        <input type="text" class="form-control" value="{{ $discount->times_used }}" readonly="readonly" />
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Created</h3>
                    </div>
                    <div class="panel-body">
                        <input type="text" class="form-control" value="{{ $discount->created_at }}" readonly="readonly" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Type</h3>
                </div>
                <div class="panel-body">
                    @if(empty($discount->id))
                        <select id="TypeDropDown" class="form-control" name="discount[type]">
                            @foreach(App\Libraries\Util::getDiscountType() as $value => $label)
                                @if($discount->type == $value)
                                    <option selected="selected" value="{{ $value }}">{{ $label }}</option>
                                @else
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endif
                            @endforeach
                        </select>
                    @else
                        <input type="text" class="form-control" value="{{ $discount->type }}" readonly="readonly" />
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Value</h3>
                </div>
                <div class="panel-body">
                    @if(empty($discount->id))
                        <input type="text" id="ValueInput" class="form-control" name="discount[value]" value="{{ $discount->value }}" required="required" />
                    @else
                        <input type="text" class="form-control" value="{{ ($discount->type == App\Libraries\Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED ? App\Libraries\Util::formatMoney($discount->value) : $discount->value) }}" readonly="readonly" />
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Limit</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="form-control" name="discount[times_limit]" value="{{ $discount->times_limit }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Status</h3>
                </div>
                <div class="panel-body">
                    <label class="checkbox-inline">
                        <input<?php echo ($discount->status ? ' checked="checked"' : ''); ?> type="checkbox" name="discount[status]" value="status" /><b>Active</b>
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
                    <h3 class="panel-title">Start</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="DateTimePicker form-control" name="discount[start_time]" value="{{ $discount->start_time }}" />
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">End</h3>
                </div>
                <div class="panel-body">
                    <input type="text" class="DateTimePicker form-control" name="discount[end_time]" value="{{ $discount->end_time }}" />
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-12">
    <div class="row">
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Customer ID</h3>
                </div>
                <div class="panel-body">
                    @if(empty($discount->id))
                        <input type="text" id="CustomerNameInput" class="form-control" name="discount[customer_id_str]" value="{{ !empty($discount->customer_id_str) ? $discount->customer_id_str : '' }}" />
                    @else
                        <input type="text" class="form-control" value="{{ !empty($discount->customer) ? $discount->customer->customer_id : '' }}" readonly="readonly" />
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Usage Unique</h3>
                </div>
                <div class="panel-body">
                    <label class="checkbox-inline">
                        <input<?php echo ($discount->usage_unique ? ' checked="checked"' : ''); ?> type="checkbox" name="discount[usage_unique]" value="usage_unique" /><b>Active</b>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

@if(empty($discount->id))
    @include('admin.layouts.partials.loading')
@endif

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DateTimePicker').datetimepicker({

                format: 'Y-m-d H:i'

            });

            @if(empty($discount->id))
            $('#GenerateCodeButton').click(function() {
                var inputNumberCharacterVal = $('#InputNumberCharacter').val();
                var inputCode = $('#InputDiscountCode');

                if(inputNumberCharacterVal != '')
                {
                    if(!isNaN(inputNumberCharacterVal) && inputNumberCharacterVal >= 6 && inputNumberCharacterVal <= 255)
                    {
                        showLoadingScreen();

                        $.ajax({
                            url: '{{ url('discount/generate') }}',
                            type: 'post',
                            data: '_token={{ csrf_token() }}&number=' + inputNumberCharacterVal,
                            success: function(result) {

                                if(result)
                                {
                                    inputCode.val(result);
                                    closeLoadingScreen();
                                }

                            }
                        });
                    }
                    else
                        alert('The number character is not valid');
                }
                else
                    alert('Please input the number character');
            });

            addValueInputClassMoney();

            $('#TypeDropDown').change(function() {

                addValueInputClassMoney();

            });

            function addValueInputClassMoney()
            {
                var elemVal = $('#TypeDropDown').val();
                var inputValueElem = $('#ValueInput');

                if(elemVal == '{{ App\Libraries\Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED }}')
                {
                    inputValueElem.val(formatMoney(inputValueElem.val()));

                    inputValueElem.on('keyup', function() {

                        $(this).val(formatMoney($(this).val()));

                    });
                }
                else
                {
                    inputValueElem.val(inputValueElem.val().split('.').join(''));

                    inputValueElem.off('keyup');
                }
            }

            $('#CustomerNameInput').autocomplete({

                minLength: 3,
                source: function(request, response) {

                    $.ajax({
                        url: '{{ url('discount/get/autoComplete/customer') }}',
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

                    $(this).val(ui.item.customer_id);
                    return false;
                }

            }).autocomplete('instance')._renderItem = function(ul, item) {

                return $('<li>').append('<a>' + item.customer_id + '<br><b>Name:</b> ' + item.name + ' - <b>Phone:</b> ' + item.phone + '</a>').appendTo(ul);

            };
            @endif

        });

    </script>

@stop

