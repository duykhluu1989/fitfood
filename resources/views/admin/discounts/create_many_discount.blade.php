@extends('admin.layouts.main')

@section('title', 'New Many Discount')

@section('header', 'New Many Discount')

@section('content')

    <form method="post" action="{{ url('admin/discount/create/many') }}">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ url('admin/discount') }}" class="btn btn-primary btn-outline pull-right">Back</a>
                </div>
            </div>
        </div>

        @if(isset($errors))
            @include('admin.layouts.partials.form_error', ['errors' => $errors])
        @endif

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Number Character</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="discount[character]" value="{{ $discount->character }}" placeholder="Number Character (Min: 10 - Max: 255)" autofocus="autofocus" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Code Quantity</h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="discount[quantity]" value="{{ $discount->quantity }}" placeholder="Code Quantity (Min: 2 - Max: 300)" required="required" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
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

        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

    </form>

@stop

@section('script')

    <script type="text/javascript">

        $(document).ready(function() {

            $('.DateTimePicker').datetimepicker({

                format: 'Y-m-d H:i'

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

        });

    </script>

@stop