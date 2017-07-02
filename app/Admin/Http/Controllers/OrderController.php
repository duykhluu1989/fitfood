<?php

namespace App\Admin\Http\Controllers;

use Log;
use App;
use Validator;
use DB;
use Excel;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Libraries\Util;
use App\Models\OrderItemMeal;
use App\Models\Transaction;
use App\Models\Shipper;
use App\Models\OrderItemMealDetail;
use App\Models\OrderItem;
use App\Models\OrderExtra;
use App\Models\Area;
use App\Models\Customer;
use App\Models\Recipe;
use App\Models\MealPack;
use App\Models\OrderAddress;
use App\Models\Discount;
use App\Models\OrderDiscount;
use App\Models\OrderItemProduct;

class OrderController extends Controller
{
    public function quickSearchOrder(Request $request)
    {
        $keyword = $request->input('keyword');

        if(!empty($keyword))
        {
            $order = Order::where('order_id', 'like', '%' . $keyword)->first();

            if(!empty($order))
                return redirect('admin/order/detail/' . $order->id);

            return redirect($request->server('HTTP_REFERER'))->with('QuickSearchOrderError', 'Found no order with ID like ' . $keyword);
        }

        return redirect($request->server('HTTP_REFERER'));
    }

    public function listOrder(Request $request)
    {
        list($orders, $sumPack, $duplicateOrderCustomerIds, $date, $filter, $queryString) = $this->getListOrder($request, 'list');

        return view('admin.orders.list_order', [
            'orders' => $orders,
            'sumPack' => $sumPack,
            'duplicateOrderCustomerIds' => $duplicateOrderCustomerIds,
            'date' => $date,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function exportOrder(Request $request)
    {
        list($orders, $sumPack, $duplicateOrderCustomerIds, $date, $filter, $queryString) = $this->getListOrder($request, 'export');

        $areasArr = Area::getArrayActiveArea();

        $formatCells = array();
        $formatMealCells = array();
        $formatDuplicateCells = array();

        $mealCellLabels = [
            1 => [
                'from' => 'Y',
                'to' => 'AA',
            ],
            2 => [
                'from' => 'AB',
                'to' => 'AD',
            ],
            3 => [
                'from' => 'AE',
                'to' => 'AG',
            ],
            4 => [
                'from' => 'AH',
                'to' => 'AJ',
            ],
            5 => [
                'from' => 'AK',
                'to' => 'AM',
            ],
        ];

        $exportData[] = [
            'Timestamp',
            'Tên | Name',
            'Phone.Reformat',
            'Địa chỉ giao hàng | Delivery Address',
            'Thời gian giao hàng mong muốn | Expected delivery time',
            'Khẩu phần ăn bạn mong muốn | Your desired package',
            'Quận | District (Phí ship cho 5 ngày/tuần | Shipping fee is for 5 days a week)',
            '',
            'Giới tính | Gender',
            'Hình thức thanh toán | Payment Method',
            'Email',
            '',
            'Yêu cầu đặc biệt | Special Request',
            'Ghi chú của khách',
            'Ghi chú giao hàng',
            'Số lượng order | Number of order',
            'Mã khuyến mãi | Promo Code',
            'Q.SIDE1',
            'TypeSIDE1',
            'Q.SIDE2',
            'TypeSIDE2',
            'Q.SIDE3',
            'TypeSIDE3',
            'Total Bill',
            'Thứ 2',
            '',
            '',
            'Thứ 3',
            '',
            '',
            'Thứ 4',
            '',
            '',
            'Thứ 5',
            '',
            '',
            'Thứ 6',
            '',
            '',
        ];

        $exportData[] = [
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            'SA',
            'TR',
            'TO',
            'SA',
            'TR',
            'TO',
            'SA',
            'TR',
            'TO',
            'SA',
            'TR',
            'TO',
            'SA',
            'TR',
            'TO',
        ];

        $i = 3;
        foreach($orders as $order)
        {
            $phone = Util::formatPhone($order->customer->phone);

            $extras = array();
            foreach($order->orderExtras as $orderExtra)
            {
                if(empty($orderExtra->order_item_id))
                {
                    if($orderExtra->code == Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE)
                        $extras[] = Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL;
                    else if($orderExtra->code == Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
                        $extras[] = Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL;
                    else
                    {
                        $codes = explode(';', $orderExtra->code);

                        foreach($codes as $code)
                            $extras[] = App\Libraries\Util::getRequestChangeIngredient($code);
                    }
                }
            }
            $extraRequest = '';
            foreach($extras as $extra)
            {
                if($extraRequest == '')
                    $extraRequest = $extra;
                else
                    $extraRequest .= ' - ' . $extra;
            }

            $districtShippingPrice = $areasArr[$order->orderAddress->district]->shipping_price;

            $mainItemIds = array();
            $sideItems = [
                'JUS SWEETIE' => 0,
                'JUS GREENIE' => 0,
                'MIXED NUTS' => 0,
            ];

            foreach($order->orderItems as $orderItem)
            {
                if($orderItem->price > 0)
                {
                    if($orderItem->meal_pack == 'JUS SWEETIE' || $orderItem->meal_pack == 'JUS GREENIE' || $orderItem->meal_pack == 'MIXED NUTS')
                        $sideItems[$orderItem->meal_pack] += 1;
                    else
                        $mainItemIds[] = $orderItem->id;
                }
            }

            $exportSide = true;
            foreach($order->orderItems as $orderItem)
            {
                if(in_array($orderItem->id, $mainItemIds))
                {
                    $meals = [
                        1 => [],
                        2 => [],
                        3 => [],
                        4 => [],
                        5 => [],
                    ];

                    foreach($orderItem->orderItemMeals as $orderItemMeal)
                    {
                        foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                        {
                            if($orderItemMealDetail->quantity > 0)
                            {
                                if($orderItemMealDetail->double)
                                {
                                    if(isset($meals[$orderItemMeal->day_of_week][$orderItemMealDetail->name]['M']))
                                        $meals[$orderItemMeal->day_of_week][$orderItemMealDetail->name]['M'] += $orderItemMealDetail->quantity;
                                    else
                                        $meals[$orderItemMeal->day_of_week][$orderItemMealDetail->name]['M'] = $orderItemMealDetail->quantity;
                                }
                                else
                                {
                                    if(isset($meals[$orderItemMeal->day_of_week][$orderItemMealDetail->name]['F']))
                                        $meals[$orderItemMeal->day_of_week][$orderItemMealDetail->name]['F'] += $orderItemMealDetail->quantity;
                                    else
                                        $meals[$orderItemMeal->day_of_week][$orderItemMealDetail->name]['F'] = $orderItemMealDetail->quantity;
                                }
                            }
                        }

                        if(count($meals[$orderItemMeal->day_of_week]) > 0)
                        {
                            foreach($meals[$orderItemMeal->day_of_week] as $mealOfDay => $detailMealOfDay)
                            {
                                $mealOfDayDetail = '';

                                foreach($detailMealOfDay as $detailType => $detailQuantity)
                                {
                                    if($mealOfDayDetail == '')
                                        $mealOfDayDetail .= $detailQuantity . ' ' . $detailType;
                                    else
                                        $mealOfDayDetail .= ' - ' . $detailQuantity . ' ' . $detailType;
                                }

                                $meals[$orderItemMeal->day_of_week][$mealOfDay] = $mealOfDayDetail;
                            }

                            $formatMealCells[] = [
                                'cell' => $mealCellLabels[$orderItemMeal->day_of_week]['from'] . $i . ':' . $mealCellLabels[$orderItemMeal->day_of_week]['to'] . $i,
                                'color' => '#d9edf7',
                            ];
                        }
                    }

                    $oiExtras = array();
                    foreach($orderItem->orderExtras as $orderExtra)
                    {
                        if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE)
                            $oiExtras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL;
                        else if($orderExtra->code == App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
                            $oiExtras[] = App\Libraries\Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL;
                        else
                        {
                            $codes = explode(';', $orderExtra->code);

                            foreach($codes as $code)
                                $oiExtras[] = App\Libraries\Util::getRequestChangeIngredient($code);
                        }
                    }
                    $oiExtraRequest = $extraRequest;
                    foreach($oiExtras as $oiExtra)
                    {
                        if($oiExtraRequest == '')
                            $oiExtraRequest = $oiExtra;
                        else
                            $oiExtraRequest .= ' ' . $oiExtra;
                    }

                    $exportData[] = [
                        $order->created_at,
                        $order->orderAddress->name,
                        $phone,
                        $order->orderAddress->address,
                        Util::getShippingTime($order->shipping_time),
                        $orderItem->meal_pack,
                        $order->orderAddress->district . (!empty($districtShippingPrice) ? (' (' . Util::formatMoney($districtShippingPrice) . ')') : ''),
                        '',
                        Util::getGender($order->orderAddress->gender),
                        Util::getPaymentMethod($order->payment_gateway),
                        $order->orderAddress->email,
                        '',
                        $oiExtraRequest,
                        $order->customer_note,
                        $order->shipping_note,
                        1,
                        !empty($order->orderDiscount) ? $order->orderDiscount->code : '',
                        $exportSide ? ($sideItems['JUS SWEETIE'] > 0 ? $sideItems['JUS SWEETIE'] : '') : '',
                        $exportSide ? ($sideItems['JUS SWEETIE'] > 0 ? 'JUS SWEETIE' : '') : '',
                        $exportSide ? ($sideItems['JUS GREENIE'] > 0 ? $sideItems['JUS GREENIE'] : '') : '',
                        $exportSide ? ($sideItems['JUS GREENIE'] > 0 ? 'JUS GREENIE' : '') : '',
                        $exportSide ? ($sideItems['MIXED NUTS'] > 0 ? $sideItems['MIXED NUTS'] : '') : '',
                        $exportSide ? ($sideItems['MIXED NUTS'] > 0 ? 'MIXED NUTS' : '') : '',
                        $order->total_price,
                        isset($meals[1][Util::MEAL_BREAKFAST_LABEL]) ? $meals[1][Util::MEAL_BREAKFAST_LABEL] : '',
                        isset($meals[1][Util::MEAL_LUNCH_LABEL]) ? $meals[1][Util::MEAL_LUNCH_LABEL] : '',
                        isset($meals[1][Util::MEAL_DINNER_LABEL]) ? $meals[1][Util::MEAL_DINNER_LABEL] : '',
                        isset($meals[2][Util::MEAL_BREAKFAST_LABEL]) ? $meals[2][Util::MEAL_BREAKFAST_LABEL] : '',
                        isset($meals[2][Util::MEAL_LUNCH_LABEL]) ? $meals[2][Util::MEAL_LUNCH_LABEL] : '',
                        isset($meals[2][Util::MEAL_DINNER_LABEL]) ? $meals[2][Util::MEAL_DINNER_LABEL] : '',
                        isset($meals[3][Util::MEAL_BREAKFAST_LABEL]) ? $meals[3][Util::MEAL_BREAKFAST_LABEL] : '',
                        isset($meals[3][Util::MEAL_LUNCH_LABEL]) ? $meals[3][Util::MEAL_LUNCH_LABEL] : '',
                        isset($meals[3][Util::MEAL_DINNER_LABEL]) ? $meals[3][Util::MEAL_DINNER_LABEL] : '',
                        isset($meals[4][Util::MEAL_BREAKFAST_LABEL]) ? $meals[4][Util::MEAL_BREAKFAST_LABEL] : '',
                        isset($meals[4][Util::MEAL_LUNCH_LABEL]) ? $meals[4][Util::MEAL_LUNCH_LABEL] : '',
                        isset($meals[4][Util::MEAL_DINNER_LABEL]) ? $meals[4][Util::MEAL_DINNER_LABEL] : '',
                        isset($meals[5][Util::MEAL_BREAKFAST_LABEL]) ? $meals[5][Util::MEAL_BREAKFAST_LABEL] : '',
                        isset($meals[5][Util::MEAL_LUNCH_LABEL]) ? $meals[5][Util::MEAL_LUNCH_LABEL] : '',
                        isset($meals[5][Util::MEAL_DINNER_LABEL]) ? $meals[5][Util::MEAL_DINNER_LABEL] : '',
                    ];

                    if($order->warning)
                    {
                        $formatCells[] = [
                            'cell' => 'A' . $i . ':' . 'X' . $i,
                            'color' => '#f2dede',
                        ];
                    }

                    if(isset($duplicateOrderCustomerIds[$order->customer_id]))
                    {
                        $formatDuplicateCells[] = [
                            'cell' => 'A' . $i . ':' . 'X' . $i,
                            'color' => '#fcf8e3',
                        ];
                    }

                    $exportSide = false;
                    $i ++;
                }
            }
        }

        Excel::create('export-order-' . $date, function($excel) use($exportData, $mealCellLabels, $formatCells, $formatMealCells, $formatDuplicateCells) {

            $excel->sheet('sheet1', function($sheet) use($exportData, $mealCellLabels, $formatCells, $formatMealCells, $formatDuplicateCells) {

                $sheet->fromArray($exportData, null, 'A1', true, false);

                foreach($mealCellLabels as $mealCellLabel)
                {
                    $sheet->mergeCells($mealCellLabel['from'] . '1:' . $mealCellLabel['to'] . '1');
                    $sheet->cell($mealCellLabel['from'] . '1', function($cell) {

                        $cell->setAlignment('center');

                    });
                }

                foreach($formatCells as $formatCell)
                {
                    $sheet->cells($formatCell['cell'], function($cells) use($formatCell) {

                        $cells->setBackground($formatCell['color']);

                    });
                }

                foreach($formatDuplicateCells as $formatDuplicateCell)
                {
                    $sheet->cells($formatDuplicateCell['cell'], function($cells) use($formatDuplicateCell) {

                        $cells->setBackground($formatDuplicateCell['color']);

                    });
                }

                foreach($formatMealCells as $formatMealCell)
                {
                    $sheet->cells($formatMealCell['cell'], function($cells) use($formatMealCell) {

                        $cells->setBackground($formatMealCell['color']);

                    });
                }

            });

        })->export('xls');
    }

    protected function getListOrder($request, $action)
    {
        $input = $request->all();

        if(!empty($input['date']))
            $date = $input['date'];
        else
            $date = date('Y-m-d');

        $dayOfWeek = date('N', strtotime($date));
        if($dayOfWeek < 6)
            $startWeek = date('Y-m-d', strtotime($date) - (Util::TIMESTAMP_ONE_DAY * ($dayOfWeek - 1)));
        else
            $startWeek = date('Y-m-d', strtotime($date) + (Util::TIMESTAMP_ONE_DAY * (8 - $dayOfWeek)));

        $queryString = '&date=' . $date;

        $builder = Order::select('ff_order.*')->with(['orderAddress', 'customer', 'orderExtras', 'orderItems' => function($query) {
            $query->where('price', '>', 0);
        }, 'orderItems.orderItemMeals' => function($query) {
            $query->orderBy('day_of_week');
        }, 'orderItems.orderItemMeals.orderItemMealDetails', 'orderDiscount'])
            ->where('ff_order.start_week', '<=', $startWeek)
            ->where('ff_order.end_week', '>=', $date)
            ->where('ff_order.free', 0)
            ->orderBy('ff_order.id', 'DESC');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['order_id']))
                $builder->where('ff_order.order_id', 'like', '%' . $input['filter']['order_id']);

            if(!empty($input['filter']['phone']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_customer` on') === false)
                    $builder->join('ff_customer', 'ff_order.customer_id', '=', 'ff_customer.id');
                $builder->where('ff_customer.phone', 'like', '%' . $input['filter']['phone']);
            }

            if(!empty($input['filter']['name']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_order_address` on') === false)
                    $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id');
                $builder->where('ff_order_address.name', 'like', '%' . $input['filter']['name'] . '%');
            }

            if(!empty($input['filter']['email']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_order_address` on') === false)
                    $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id');
                $builder->where('ff_order_address.email', 'like', '%' . $input['filter']['email'] . '%');
            }

            if(isset($input['filter']['warning']) && $input['filter']['warning'] !== '')
                $builder->where('ff_order.warning', $input['filter']['warning']);

            if(!empty($input['filter']['cancelled']))
                $builder->whereNotNull('ff_order.cancelled_at')->where('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_PENDING_VALUE);

            $filter = $input['filter'];
            $queryString .= '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
            $filter = null;

        if(empty($filter['cancelled']))
        {
            $builder->where(function($query) {
                $query->whereNull('ff_order.cancelled_at')->orWhere('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_FULFILLED_VALUE);
            });
        }

        if($action == 'list')
        {
            $orders = $builder->paginate(Util::GRID_PER_PAGE);
            $sumPack = OrderItem::join('ff_order', 'ff_order_item.order_id', '=', 'ff_order.id')
                ->where('ff_order.start_week', '<=', $startWeek)
                ->where('ff_order.end_week', '>=', $date)
                ->where(function($query) {
                    $query->whereNull('ff_order.cancelled_at')->orWhere('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_FULFILLED_VALUE);
                })
                ->where('ff_order_item.price', '>', 0)
                ->where('ff_order_item.main_dish', 1)
                ->where('ff_order.free', 0)
                ->count('ff_order_item.id');
        }
        else
        {
            $orders = $builder->get();
            $sumPack = null;
        }

        $duplicateOrderCustomerIds = Order::selectRaw('customer_id, COUNT(id) AS number_of_order')
            ->where('start_week', '<=', $startWeek)
            ->where('end_week', '>=', $date)
            ->whereNull('cancelled_at')
            ->where('free', 0)
            ->groupBy('customer_id')
            ->havingRaw('COUNT(id) > 1')
            ->pluck('number_of_order', 'customer_id')
            ->toArray();

        return [$orders, $sumPack, $duplicateOrderCustomerIds, $date, $filter, $queryString];
    }

    public function detailOrder($id)
    {
        $order = Order::with(['fromOrder' => function($query) {
            $query->select('id', 'order_id');
        }, 'customer', 'orderAddress', 'orderItems.orderItemProduct', 'orderItems.orderItemMeals' => function($query) {
            $query->orderBy('day_of_week');
        }, 'orderItems.orderItemMeals.shipper', 'orderItems.orderItemMeals.orderItemMealDetails', 'orderDiscount.discount', 'orderExtras', 'transactions'])
            ->find($id);
        
        return view('admin.orders.detail_order', ['order' => $order]);
    }

    public function confirmPaymentOrder(Request $request, $id)
    {
        $input = $request->all();

        try
        {
            DB::beginTransaction();

            $order = Order::find($id);
            $order->financial_status = Util::FINANCIAL_STATUS_PAID_VALUE;
            $order->save();

            $payment = new Transaction();
            $payment->order_id = $order->id;
            $payment->customer_id = $order->customer_id;
            $payment->gateway = $input['method'];
            $payment->created_at = trim($input['date']);
            $payment->amount = trim(str_replace('.', '', $input['amount']));
            $payment->type = Util::TRANSACTION_TYPE_PAY_VALUE;
            $payment->shipper_id = !empty($input['shipper']) ? $input['shipper'] : null;
            $payment->note = !empty($input['note']) ? trim($input['note']) : null;
            $payment->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
        }

        return redirect('admin/order/detail/' . $order->id);
    }

    public function cancelOrder(Request $request, $id)
    {
        $input = $request->all();

        $order = Order::with('orderItems.orderItemMeals.orderItemMealDetails')->find($id);

        try
        {
            DB::beginTransaction();

            $order->cancelled_at = date('Y-m-d H:i:s');
            $order->cancel_reason = !empty($input['cancel_reason']) ? $input['cancel_reason'] : null;
            $order->save();

            $orderExtraChangePriceS = array();
            $mealDateDeleteS = array();
            $dayOfWeekDeleteS = array();
            $orderItemIdChangePriceS = array();

            foreach($order->orderItems as $orderItem)
            {
                foreach($orderItem->orderItemMeals as $orderItemMeal)
                {
                    if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                    {
                        foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                        {
                            if($orderItemMealDetail->extra && !isset($orderExtraChangePriceS[$orderItemMeal->order_item_id]))
                                $orderExtraChangePriceS[$orderItemMeal->order_item_id] = OrderExtra::where('order_item_id', $orderItemMeal->order_item_id)->first();

                            $orderItemMealDetail->delete();
                        }

                        $orderItemMeal->delete();

                        $mealDateDeleteS[$orderItem->id][] = $orderItemMeal->meal_date;

                        if(!in_array($orderItemMeal->day_of_week, $dayOfWeekDeleteS))
                            $dayOfWeekDeleteS[] = $orderItemMeal->day_of_week;

                        if(!in_array($orderItem->id, $orderItemIdChangePriceS))
                            $orderItemIdChangePriceS[] = $orderItem->id;
                    }
                }
            }

            $order = Order::with('orderItems.orderItemMeals', 'orderDiscount')->find($id);

            if($order->fulfillment_status == Util::FULFILLMENT_STATUS_PARTIALLY_FULFILLED_VALUE)
            {
                $shippingDateRange = array();
                $totalItemPrice = 0;

                foreach($order->orderItems as $keyItem => $orderItem)
                {
                    foreach($orderItem->orderItemMeals as $orderItemMeal)
                    {
                        if(!in_array($orderItemMeal->day_of_week, $shippingDateRange))
                            $shippingDateRange[] = $orderItemMeal->day_of_week;
                    }

                    if(in_array($orderItem->id, $orderItemIdChangePriceS))
                    {
                        $countMealDateDeleteS = count($mealDateDeleteS[$orderItem->id]);

                        $currentMealDay = count($orderItem->orderItemMeals);
                        $order->orderItems[$keyItem]->price = $order->orderItems[$keyItem]->price * $currentMealDay / ($currentMealDay + $countMealDateDeleteS);
                        $order->orderItems[$keyItem]->save();

                        if(isset($orderExtraChangePriceS[$orderItem->id]))
                        {
                            $extraPriceChanged = $orderExtraChangePriceS[$orderItem->id]->price * $currentMealDay / ($currentMealDay + $countMealDateDeleteS);
                            $decreasePrice = $orderExtraChangePriceS[$orderItem->id]->price - $extraPriceChanged;
                            $orderExtraChangePriceS[$orderItem->id]->price -= $decreasePrice;
                            $orderExtraChangePriceS[$orderItem->id]->save();

                            $order->total_extra_price -= $decreasePrice;
                            $order->total_price -= $decreasePrice;
                        }
                    }

                    $totalItemPrice += $order->orderItems[$keyItem]->price;
                }

                foreach($dayOfWeekDeleteS as $key => $dayOfWeekDelete)
                {
                    if(in_array($dayOfWeekDelete, $shippingDateRange))
                        unset($dayOfWeekDeleteS[$key]);
                }

                $countDayOfWeekDeleteS = count($dayOfWeekDeleteS);

                if($countDayOfWeekDeleteS > 0)
                {
                    $shippingPrice = $order->shipping_price * count($shippingDateRange) / (count($shippingDateRange) + $countDayOfWeekDeleteS);
                    $decreasePrice = $order->shipping_price - $shippingPrice;
                    $order->shipping_price -= $decreasePrice;
                    $order->total_price -= $decreasePrice;
                }

                $decreasePrice = $order->total_line_items_price - $totalItemPrice;

                $order->total_line_items_price -= $decreasePrice;
                $order->total_price -= $decreasePrice;

                $order->fulfillment_status = Util::FULFILLMENT_STATUS_FULFILLED_VALUE;

                $order->reCalculateTotalDiscount();
            }
            else if($order->fulfillment_status == Util::FULFILLMENT_STATUS_PENDING_VALUE)
            {
                foreach($order->orderItems as $orderItem)
                {
                    $orderItem->price = 0;
                    $orderItem->save();
                }

                foreach($order->orderExtras as $orderExtra)
                {
                    $orderExtra->price = 0;
                    $orderExtra->save();
                }

                if(!empty($order->orderDiscount))
                {
                    $order->orderDiscount->amount = 0;
                    $order->orderDiscount->save();
                }

                $order->shipping_price = 0;
                $order->total_line_items_price = 0;
                $order->total_price = 0;
                $order->total_discounts = 0;
                $order->total_extra_price = 0;
            }

            if($order->warning == Util::STATUS_ACTIVE_VALUE)
                $order->warning = Util::STATUS_INACTIVE_VALUE;

            $order->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
        }

        return redirect('admin/order/detail/' . $order->id);
    }

    public function cancelOrderItem(Request $request, $id)
    {
        $input = $request->all();

        $orderItem = OrderItem::with('orderItemMeals.orderItemMealDetails')->find($id);

        try
        {
            DB::beginTransaction();

            $orderItem->cancelled_at = date('Y-m-d H:i:s');
            $orderItem->cancel_reason = !empty($input['cancel_reason']) ? $input['cancel_reason'] : null;
            $orderItem->save();

            $orderExtraChangePrice = null;
            $mealDateDeleteS = array();
            $dayOfWeekDeleteS = array();

            foreach($orderItem->orderItemMeals as $orderItemMeal)
            {
                if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                {
                    foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                    {
                        if($orderItemMealDetail->extra && empty($orderExtraChangePrice))
                            $orderExtraChangePrice = OrderExtra::where('order_item_id', $orderItemMeal->order_item_id)->first();

                        $orderItemMealDetail->delete();
                    }

                    $orderItemMeal->delete();

                    $mealDateDeleteS[] = $orderItemMeal->meal_date;
                    $dayOfWeekDeleteS[] = $orderItemMeal->day_of_week;
                }
            }

            $orderIdChangePrice = $orderItem->order_id;
            $orderItemIdChangePrice = $orderItem->id;

            $order = Order::with('orderItems.orderItemMeals', 'orderDiscount')->find($orderIdChangePrice);

            $shippingDateRange = array();
            $totalItemPrice = 0;

            foreach($order->orderItems as $keyItem => $orderItem)
            {
                foreach($orderItem->orderItemMeals as $orderItemMeal)
                {
                    if(!in_array($orderItemMeal->day_of_week, $shippingDateRange))
                        $shippingDateRange[] = $orderItemMeal->day_of_week;
                }

                if($orderItem->id == $orderItemIdChangePrice)
                {
                    $countMealDateDeleteS = count($mealDateDeleteS);

                    $currentMealDay = count($orderItem->orderItemMeals);
                    $order->orderItems[$keyItem]->price = $order->orderItems[$keyItem]->price * $currentMealDay / ($currentMealDay + $countMealDateDeleteS);
                    $order->orderItems[$keyItem]->save();

                    if(!empty($orderExtraChangePrice) && $orderExtraChangePrice->order_item_id == $orderItem->id)
                    {
                        $extraPriceChanged = $orderExtraChangePrice->price * $currentMealDay / ($currentMealDay + $countMealDateDeleteS);
                        $decreasePrice = $orderExtraChangePrice->price - $extraPriceChanged;
                        $orderExtraChangePrice->price -= $decreasePrice;
                        $orderExtraChangePrice->save();

                        $order->total_extra_price -= $decreasePrice;
                        $order->total_price -= $decreasePrice;
                    }
                }

                $totalItemPrice += $order->orderItems[$keyItem]->price;
            }

            foreach($dayOfWeekDeleteS as $key => $dayOfWeekDelete)
            {
                if(in_array($dayOfWeekDelete, $shippingDateRange))
                    unset($dayOfWeekDeleteS[$key]);
            }

            $countDayOfWeekDeleteS = count($dayOfWeekDeleteS);

            if($countDayOfWeekDeleteS > 0)
            {
                $shippingPrice = $order->shipping_price * count($shippingDateRange) / (count($shippingDateRange) + $countDayOfWeekDeleteS);
                $decreasePrice = $order->shipping_price - $shippingPrice;
                $order->shipping_price -= $decreasePrice;
                $order->total_price -= $decreasePrice;
            }

            $decreasePrice = $order->total_line_items_price - $totalItemPrice;

            $order->total_line_items_price -= $decreasePrice;
            $order->total_price -= $decreasePrice;

            $order->reCalculateTotalDiscount();

            $order->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
        }

        return redirect('admin/order/detail/' . $orderItem->order_id);
    }

    public function changeOrderItemMeal(Request $request)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $input = $request->all();

                $to = rawurldecode($input['to']);
                $target = $input['target'];

                $orderItemMealDetail = OrderItemMealDetail::find($target);
                $orderItemMealDetail->name = $to;
                $orderItemMealDetail->save();

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function deleteOrderItemMeal(Request $request)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $input = $request->all();

                $orderItemMeal = OrderItemMeal::with('orderItemMealDetails')->find($input['meal']);

                $main = false;
                $orderExtraChangePrice = null;

                foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                {
                    if($orderItemMealDetail->name != Util::MEAL_FRUIT_LABEL && $orderItemMealDetail->name != Util::MEAL_VEGGIES_LABEL && $orderItemMealDetail->name != Util::MEAL_JUICE_LABEL)
                        $main = true;

                    if($orderItemMealDetail->extra && empty($orderExtraChangePrice))
                        $orderExtraChangePrice = OrderExtra::where('order_item_id', $orderItemMeal->order_item_id)->first();

                    $orderItemMealDetail->delete();
                }

                $orderItemMeal->delete();

                $response['delete']['orderItemMeal'][] = $orderItemMeal->id;

                $orderIdChangePrice = $orderItemMeal->order_id;
                $mealDateDelete = $orderItemMeal->meal_date;
                $orderItemIdsChangePrice = [$orderItemMeal->order_item_id];
                $dayOfWeekDelete = $orderItemMeal->day_of_week;

                $order = Order::with('orderItems.orderItemMeals.orderItemMealDetails', 'orderDiscount')->find($orderIdChangePrice);

                if($main == true)
                {
                    $stillHaveMain = false;
                    $haveSide = false;

                    foreach($order->orderItems as $orderItem)
                    {
                        foreach($orderItem->orderItemMeals as $orderItemMeal)
                        {
                            if($orderItemMeal->meal_date == $mealDateDelete)
                            {
                                foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                {
                                    if($orderItemMealDetail->name != Util::MEAL_FRUIT_LABEL && $orderItemMealDetail->name != Util::MEAL_VEGGIES_LABEL && $orderItemMealDetail->name != Util::MEAL_JUICE_LABEL)
                                        $stillHaveMain = true;
                                    else if($orderItemMealDetail->name == Util::MEAL_FRUIT_LABEL || $orderItemMealDetail->name == Util::MEAL_VEGGIES_LABEL || $orderItemMealDetail->name == Util::MEAL_JUICE_LABEL)
                                        $haveSide = true;

                                    if($stillHaveMain == true)
                                        break;
                                }

                                break;
                            }
                        }

                        if($stillHaveMain == true)
                            break;
                    }

                    if($stillHaveMain == false && $haveSide == true)
                    {
                        foreach($order->orderItems as $keyItem => $orderItem)
                        {
                            foreach($orderItem->orderItemMeals as $keyItemMeal => $orderItemMeal)
                            {
                                if($orderItemMeal->meal_date == $mealDateDelete)
                                {
                                    foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                        $orderItemMealDetail->delete();

                                    $orderItemMeal->delete();

                                    unset($order->orderItems[$keyItem]->orderItemMeals[$keyItemMeal]);

                                    $orderItemIdsChangePrice[] = $orderItem->id;

                                    $response['delete']['orderItemMeal'][] = $orderItemMeal->id;
                                }
                            }
                        }
                    }
                }

                $shippingDateRange = array();
                $totalItemPrice = 0;

                foreach($order->orderItems as $keyItem => $orderItem)
                {
                    foreach($orderItem->orderItemMeals as $orderItemMeal)
                    {
                        if(!in_array($orderItemMeal->day_of_week, $shippingDateRange))
                            $shippingDateRange[] = $orderItemMeal->day_of_week;
                    }

                    if(in_array($orderItem->id, $orderItemIdsChangePrice))
                    {
                        $currentMealDay = count($orderItem->orderItemMeals);
                        $order->orderItems[$keyItem]->price = $order->orderItems[$keyItem]->price * $currentMealDay / ($currentMealDay + 1);
                        $order->orderItems[$keyItem]->save();

                        $response['update']['orderItem'][$order->orderItems[$keyItem]->id]['price'] =  $order->orderItems[$keyItem]->price;

                        if(!empty($orderExtraChangePrice) && $orderExtraChangePrice->order_item_id == $orderItem->id)
                        {
                            $extraPriceChanged = $orderExtraChangePrice->price * $currentMealDay / ($currentMealDay + 1);
                            $decreasePrice = $orderExtraChangePrice->price - $extraPriceChanged;
                            $orderExtraChangePrice->price -= $decreasePrice;
                            $orderExtraChangePrice->save();

                            $order->total_extra_price -= $decreasePrice;
                            $order->total_price -= $decreasePrice;

                            $response['update']['orderExtra'][$orderExtraChangePrice->id]['price'] = $orderExtraChangePrice->price;
                        }
                    }

                    $totalItemPrice += $order->orderItems[$keyItem]->price;
                }

                if(!in_array($dayOfWeekDelete, $shippingDateRange))
                {
                    $shippingPrice = $order->shipping_price * count($shippingDateRange) / (count($shippingDateRange) + 1);
                    $decreasePrice = $order->shipping_price - $shippingPrice;
                    $order->shipping_price -= $decreasePrice;
                    $order->total_price -= $decreasePrice;

                    $response['update']['order']['shipping_price'] = $order->shipping_price;
                }

                $decreasePrice = $order->total_line_items_price - $totalItemPrice;

                $order->total_line_items_price -= $decreasePrice;
                $order->total_price -= $decreasePrice;

                $order->reCalculateTotalDiscount();

                $response['update']['order']['total_discounts'] = -$order->total_discounts;

                $order->save();

                $response['update']['order']['total_price'] = $order->total_price;

                echo json_encode($response);
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function moveOrderToCurrentWeek($id)
    {
        $limitDate = date('Y-m-d', strtotime('+ 5 days'));

        $order = Order::with('orderItems.orderItemMeals.orderItemMealDetails')->whereNull('cancelled_at')->where('start_week', '>', $limitDate)->find($id);

        if(!empty($order))
        {
            try
            {
                DB::beginTransaction();

                $order->start_week = date('Y-m-d', strtotime($order->start_week) - (Util::TIMESTAMP_ONE_DAY * 7));
                $order->end_week = date('Y-m-d', strtotime($order->end_week) - (Util::TIMESTAMP_ONE_DAY * 7));
                $order->save();

                foreach($order->orderItems as $orderItem)
                {
                    foreach($orderItem->orderItemMeals as $orderItemMeal)
                    {
                        $orderItemMeal->meal_date = date('Y-m-d', strtotime($orderItemMeal->meal_date) - (Util::TIMESTAMP_ONE_DAY * 7));
                        $orderItemMeal->cook_date = date('Y-m-d', strtotime($orderItemMeal->cook_date) - (Util::TIMESTAMP_ONE_DAY * 7));
                        $orderItemMeal->shipping_date = date('Y-m-d', strtotime($orderItemMeal->shipping_date) - (Util::TIMESTAMP_ONE_DAY * 7));
                        $orderItemMeal->save();
                    }
                }

                $orderExtraChangePriceS = array();
                $mealDateDeleteS = array();
                $dayOfWeekDeleteS = array();
                $orderItemIdChangePriceS = array();

                $currentDateOfWeek = date('N');

                for($i = 0;$i < $currentDateOfWeek;$i ++)
                {
                    $mealDateDeleteS[] = date('Y-m-d', strtotime($order->start_week) + (Util::TIMESTAMP_ONE_DAY * $i));
                    $dayOfWeekDeleteS[] = $i + 1;
                }

                if(count($mealDateDeleteS) > 0)
                {
                    foreach($order->orderItems as $orderItem)
                    {
                        foreach($orderItem->orderItemMeals as $orderItemMeal)
                        {
                            if(in_array($orderItemMeal->meal_date, $mealDateDeleteS))
                            {
                                foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                                {
                                    if($orderItemMealDetail->extra && !isset($orderExtraChangePriceS[$orderItemMeal->order_item_id]))
                                        $orderExtraChangePriceS[$orderItemMeal->order_item_id] = OrderExtra::where('order_item_id', $orderItemMeal->order_item_id)->first();

                                    $orderItemMealDetail->delete();
                                }

                                $orderItemMeal->delete();

                                if(!in_array($orderItem->id, $orderItemIdChangePriceS))
                                    $orderItemIdChangePriceS[] = $orderItem->id;
                            }
                        }
                    }

                    $order = Order::with('orderItems.orderItemMeals', 'orderDiscount')->find($id);

                    $shippingDateRange = array();
                    $totalItemPrice = 0;

                    foreach($order->orderItems as $keyItem => $orderItem)
                    {
                        foreach($orderItem->orderItemMeals as $orderItemMeal)
                        {
                            if(!in_array($orderItemMeal->day_of_week, $shippingDateRange))
                                $shippingDateRange[] = $orderItemMeal->day_of_week;
                        }

                        if(in_array($orderItem->id, $orderItemIdChangePriceS))
                        {
                            $countMealDateDeleteS = count($mealDateDeleteS);

                            $currentMealDay = count($orderItem->orderItemMeals);
                            $order->orderItems[$keyItem]->price = $order->orderItems[$keyItem]->price * $currentMealDay / ($currentMealDay + $countMealDateDeleteS);
                            $order->orderItems[$keyItem]->save();

                            if(isset($orderExtraChangePriceS[$orderItem->id]))
                            {
                                $extraPriceChanged = $orderExtraChangePriceS[$orderItem->id]->price * $currentMealDay / ($currentMealDay + $countMealDateDeleteS);
                                $decreasePrice = $orderExtraChangePriceS[$orderItem->id]->price - $extraPriceChanged;
                                $orderExtraChangePriceS[$orderItem->id]->price -= $decreasePrice;
                                $orderExtraChangePriceS[$orderItem->id]->save();

                                $order->total_extra_price -= $decreasePrice;
                                $order->total_price -= $decreasePrice;
                            }
                        }

                        $totalItemPrice += $order->orderItems[$keyItem]->price;
                    }

                    foreach($dayOfWeekDeleteS as $key => $dayOfWeekDelete)
                    {
                        if(in_array($dayOfWeekDelete, $shippingDateRange))
                            unset($dayOfWeekDeleteS[$key]);
                    }

                    $countDayOfWeekDeleteS = count($dayOfWeekDeleteS);

                    if($countDayOfWeekDeleteS > 0)
                    {
                        $shippingPrice = $order->shipping_price * ($shippingDateRange['end'] - $shippingDateRange['start'] + 1) / ($shippingDateRange['end'] - $shippingDateRange['start'] + 1 + $countDayOfWeekDeleteS);
                        $decreasePrice = $order->shipping_price - $shippingPrice;
                        $order->shipping_price -= $decreasePrice;
                        $order->total_price -= $decreasePrice;
                    }

                    $decreasePrice = $order->total_line_items_price - $totalItemPrice;

                    $order->total_line_items_price -= $decreasePrice;
                    $order->total_price -= $decreasePrice;

                    $order->reCalculateTotalDiscount();

                    $order->save();
                }

                DB::commit();
            }
            catch(\Exception $e)
            {
                DB::rollBack();
            }
        }

        return redirect('admin/order/detail/' . $order->id);
    }

    public function removeOrderWarning(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $order = Order::find($id);
                $order->warning = Util::STATUS_INACTIVE_VALUE;
                $order->save();

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function setOrderWarning(Request $request, $id)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $order = Order::find($id);
                $order->warning = Util::STATUS_ACTIVE_VALUE;
                $order->save();

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function editOrderItemShippingTime(Request $request)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $input = $request->all();

                $orderItemMeals = OrderItemMeal::where('order_id', $input['order'])->where('day_of_week', $input['date'])->get();

                foreach($orderItemMeals as $orderItemMeal)
                {
                    $orderItemMeal->shipping_time = $input['shipping'];

                    if($orderItemMeal->shipping_time == Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                        $orderItemMeal->cook_date = date('Y-m-d', strtotime($orderItemMeal->meal_date) - Util::TIMESTAMP_ONE_DAY);
                    else
                        $orderItemMeal->cook_date = $orderItemMeal->meal_date;

                    $orderItemMeal->shipping_date = $orderItemMeal->cook_date;

                    $orderItemMeal->save();
                }

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function editOrderNote(Request $request)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $input = $request->all();

                $order = Order::find($input['order']);
                $order->customer_note = $input['note'];
                $order->save();

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function editOrderAddress(Request $request, $id)
    {
        $order = Order::with('orderAddress', 'customer', 'orderItems.orderItemMeals', 'orderDiscount')->whereNull('cancelled_at')->find($id);
        $areas = Area::getModelActiveArea();

        if($request->isMethod('post'))
        {
            $input = $request->input('address');

            $oldDistrict = $order->orderAddress->district;
            $oldShippingTime = $order->shipping_time;

            $order->orderAddress->name = isset($input['name']) ? trim($input['name']) : '';
            $order->customer->phone = isset($input['phone']) ? trim($input['phone']) : '';
            $order->orderAddress->email = isset($input['email']) ? trim($input['email']) : '';
            $order->orderAddress->address = isset($input['address']) ? trim($input['address']) : '';
            $order->orderAddress->district = isset($input['district']) ? trim($input['district']) : '';
            $order->shipping_time = isset($input['shipping_time']) ? trim($input['shipping_time']) : '';
            $order->orderAddress->latitude = isset($input['latitude']) ? trim($input['latitude']) : '';
            $order->orderAddress->longitude = isset($input['longitude']) ? trim($input['longitude']) : '';
            $order->orderAddress->address_google = isset($input['address_google']) ? trim($input['address_google']) : '';

            if(empty($order->customer->name))
                $order->customer->name = isset($input['name']) ? trim($input['name']) : '';
            if(empty($order->customer->email))
                $order->customer->email = isset($input['email']) ? trim($input['email']) : '';
            if(empty($order->customer->address))
                $order->customer->address = isset($input['address']) ? trim($input['address']) : '';
            if(empty($order->customer->district))
                $order->customer->district = isset($input['district']) ? trim($input['district']) : '';

            $validator = Validator::make($input, [
                'name' => 'required|string',
                'phone' => 'required|numeric',
                'email' => 'required|email',
                'address' => 'required|string',
                'district' => 'required|string',
                'shipping_time' => 'required|string',
                'latitude' => 'required|string',
                'longitude' => 'required|string',
                'address_google' => 'required|string',
            ]);

            if($validator->fails())
                $errors = $validator->errors()->all();
            else
                $errors = array();

            if(Util::validatePhone($input['phone']) == false)
                $errors[] = 'Phone is not valid';

            if(count($errors) == 0)
            {
                try
                {
                    DB::beginTransaction();

                    $order->orderAddress->save();

                    if($oldDistrict != $order->orderAddress->district)
                    {
                        $oldArea = Area::where('name', $oldDistrict)->first();
                        $newArea = Area::where('name', $order->orderAddress->district)->where('status', Util::STATUS_ACTIVE_VALUE)->first();

                        if($oldArea->shipping_price != $newArea->shipping_price)
                        {
                            $shippingDateRange = array();

                            foreach($order->orderItems as $orderItem)
                            {
                                foreach($orderItem->orderItemMeals as $orderItemMeal)
                                {
                                    if(!in_array($orderItemMeal->day_of_week, $shippingDateRange))
                                        $shippingDateRange[] = $orderItemMeal->day_of_week;
                                }
                            }

                            $shippingPrice = $newArea->shipping_price * count($shippingDateRange) / 5;
                            $order->total_price = $order->total_price - $order->shipping_price + $shippingPrice;
                            $order->shipping_price = $shippingPrice;
                        }
                    }

                    if($oldShippingTime != $order->shipping_time)
                    {
                        foreach($order->orderItems as $orderItem)
                        {
                            foreach($orderItem->orderItemMeals as $orderItemMeal)
                            {
                                if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                                {
                                    $orderItemMeal->shipping_time = $order->shipping_time;

                                    if($orderItemMeal->shipping_time == Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                                        $orderItemMeal->cook_date = date('Y-m-d', strtotime($orderItemMeal->meal_date) - Util::TIMESTAMP_ONE_DAY);
                                    else
                                        $orderItemMeal->cook_date = $orderItemMeal->meal_date;

                                    $orderItemMeal->shipping_date = $orderItemMeal->cook_date;

                                    $orderItemMeal->save();
                                }
                            }
                        }
                    }

                    $order->reCalculateTotalDiscount();

                    $order->save();
                    $order->customer->save();

                    DB::commit();

                    return redirect('admin/order/detail/' . $order->id);
                }
                catch(\Exception $e)
                {
                    DB::rollBack();

                    $errors[] = $e->getMessage();
                }
            }

            return view('admin.orders.edit_order_address', ['order' => $order, 'areas' => $areas, 'errors' => $errors]);
        }

        return view('admin.orders.edit_order_address', ['order' => $order, 'areas' => $areas]);
    }

    public function addCustomMealForOrderItem(Request $request, $id)
    {
        $input = $request->all();

        $recipeName = preg_replace('/\s+/', ' ', mb_strtoupper(trim($input['recipe_name']), 'UTF-8'));

        $orderItem = OrderItem::with('orderItemMeals.orderItemMealDetails')->find($id);

        try
        {
            DB::beginTransaction();

            foreach($orderItem->orderItemMeals as $orderItemMeal)
            {
                $added = false;

                foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                {
                    if($orderItemMealDetail->name == $recipeName)
                    {
                        $added = true;
                        break;
                    }
                }

                if($added == false)
                {
                    $customOrderItemMealDetail = new OrderItemMealDetail();
                    $customOrderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                    $customOrderItemMealDetail->order_id = $orderItemMeal->order_id;
                    $customOrderItemMealDetail->name = $recipeName;
                    $customOrderItemMealDetail->quantity = 0;
                    $customOrderItemMealDetail->save();
                }
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();
        }

        return redirect('admin/order/detail/' . $orderItem->order_id);
    }

    public function getAutoCompleteRecipeData(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $term = trim($input['term']);

                $recipes = Recipe::where('status', Util::STATUS_ACTIVE_VALUE)->where(function($query) use($term) {
                    $query->where('name', 'like', '%' . $term . '%')->orWhere('name_en', 'like', '%' . $term . '%');
                })->limit(10)->get();

                $data = array();

                foreach($recipes as $recipe)
                {
                    $data[] = [
                        'name' => $recipe->name,
                        'name_en' => $recipe->name_en,
                    ];
                }

                echo json_encode($data);
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }

    public function changeOrderItem(Request $request, $id)
    {
        $input = $request->all();

        $fromOrderItem = OrderItem::with('orderItemMeals.orderItemMealDetails')->find($id);

        $toPack = MealPack::where('status', Util::STATUS_ACTIVE_VALUE)->find($input['pack']);

        $doubles = array();
        if(!empty($toPack->double))
            $doubles = json_decode($toPack->double, true);

        if($fromOrderItem->meal_pack == $toPack->name)
            return redirect('admin/order/detail/' . $fromOrderItem->order_id)->with('orderError', 'Can not change to same pack');

        if(!empty($toPack->breakfast) || !empty($toPack->lunch) || !empty($toPack->dinner))
            $toMain = true;
        else
            $toMain = false;

        $main = false;

        foreach($fromOrderItem->orderItemMeals as $orderItemMeal)
        {
            foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
            {
                if($orderItemMealDetail->name != Util::MEAL_FRUIT_LABEL && $orderItemMealDetail->name != Util::MEAL_VEGGIES_LABEL && $orderItemMealDetail->name != Util::MEAL_JUICE_LABEL)
                {
                    $main = true;
                    break;
                }
            }

            if($main == true)
                break;
        }

        $order = Order::with('orderItems.orderItemMeals.orderItemMealDetails', 'orderDiscount')->find($fromOrderItem->order_id);

        if($main == true && $toMain == false)
        {
            $stillHaveMain = false;

            foreach($order->orderItems as $orderItem)
            {
                if($orderItem->id != $fromOrderItem->id)
                {
                    foreach($orderItem->orderItemMeals as $orderItemMeal)
                    {
                        foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                        {
                            if($orderItemMealDetail->name != Util::MEAL_FRUIT_LABEL && $orderItemMealDetail->name != Util::MEAL_VEGGIES_LABEL && $orderItemMealDetail->name != Util::MEAL_JUICE_LABEL)
                            {
                                $stillHaveMain = true;
                                break;
                            }
                        }

                        if($stillHaveMain == true)
                            break;
                    }
                }

                if($stillHaveMain == true)
                    break;
            }

            if($stillHaveMain == false)
                return redirect('admin/order/detail/' . $fromOrderItem->order_id)->with('orderError', 'Can not change to pack ' . $toPack->name);
        }

        try
        {
            DB::beginTransaction();

            $orderExtraChangePrice = null;

            foreach($order->orderItems as $orderItem)
            {
                if($orderItem->id == $fromOrderItem->id)
                {
                    $fromItemPrice = $orderItem->price;

                    $orderItem->meal_pack = $toPack->name;
                    $orderItem->meal_pack_description = $toPack->description;
                    $orderItem->price = $toPack->price;

                    $countDayOfWeek = 0;

                    foreach($orderItem->orderItemMeals as $orderItemMeal)
                    {
                        $toMealDetails = array();

                        if(!empty($toPack->breakfast))
                            $toMealDetails['breakfast'] = Util::MEAL_BREAKFAST_LABEL;
                        if(!empty($toPack->lunch))
                            $toMealDetails['lunch'] = Util::MEAL_LUNCH_LABEL;
                        if(!empty($toPack->dinner))
                            $toMealDetails['dinner'] = Util::MEAL_DINNER_LABEL;
                        if(!empty($toPack->fruit))
                            $toMealDetails['fruit'] = Util::MEAL_FRUIT_LABEL;
                        if(!empty($toPack->veggies))
                            $toMealDetails['veggies'] = Util::MEAL_VEGGIES_LABEL;
                        if(!empty($toPack->juice))
                            $toMealDetails['juice'] = Util::MEAL_JUICE_LABEL;

                        foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                        {
                            if($orderItemMealDetail->extra)
                            {
                                if(empty($orderExtraChangePrice))
                                    $orderExtraChangePrice = OrderExtra::where('order_item_id', $orderItemMeal->order_item_id)->first();

                                $orderItemMealDetail->extra = Util::STATUS_INACTIVE_VALUE;
                            }

                            $key = array_search($orderItemMealDetail->name, $toMealDetails);

                            if($key !== false)
                            {
                                if(isset($doubles[$key]))
                                    $orderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;
                                else
                                    $orderItemMealDetail->double = Util::STATUS_INACTIVE_VALUE;

                                if($toPack->vegetarian)
                                    $orderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;
                                else
                                    $orderItemMealDetail->vegetarian = Util::STATUS_INACTIVE_VALUE;

                                if($orderItemMealDetail->quantity != 1)
                                    $orderItemMealDetail->quantity = 1;

                                $orderItemMealDetail->save();
                                unset($toMealDetails[$key]);
                            }
                            else
                                $orderItemMealDetail->delete();
                        }

                        foreach($toMealDetails as $key => $toMealDetail)
                        {
                            $toOrderItemMealDetail = new OrderItemMealDetail();
                            $toOrderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                            $toOrderItemMealDetail->order_id = $order->id;
                            $toOrderItemMealDetail->name = $toMealDetail;
                            $toOrderItemMealDetail->quantity = 1;

                            if(isset($doubles[$key]))
                                $toOrderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;

                            if($toPack->vegetarian)
                                $toOrderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;

                            $toOrderItemMealDetail->extra = Util::STATUS_INACTIVE_VALUE;
                            $toOrderItemMealDetail->save();
                        }

                        $countDayOfWeek ++;
                    }

                    $orderItem->price = $orderItem->price * $countDayOfWeek / 5;
                    $orderItem->save();

                    $order->total_line_items_price = $order->total_line_items_price - $fromItemPrice + $orderItem->price;
                    $order->total_price = $order->total_price - $fromItemPrice + $orderItem->price;
                }
            }

            if(!empty($orderExtraChangePrice))
            {
                $order->total_extra_price -= $orderExtraChangePrice->price;
                $order->total_price -= $orderExtraChangePrice->price;

                $orderExtraChangePrice->delete();
            }

            $order->reCalculateTotalDiscount();

            $order->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return redirect('admin/order/detail/' . $fromOrderItem->order_id)->with('orderError', $e->getMessage());
        }

        return redirect('admin/order/detail/' . $fromOrderItem->order_id);
    }

    public function addOrderExtraRequest(Request $request, $id)
    {
        $input = $request->all();

        $order = Order::with('orderItems.orderItemMeals.orderItemMealDetails')->find($id);

        $extraChangeIngredients = Util::getRequestChangeIngredient();

        if(isset($extraChangeIngredients[$input['request']]))
            $extraPrice = Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE;
        else if($input['request'] == Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE)
            $extraPrice = Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE;
        else if($input['request'] == Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
        {
            $extraPrice = Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE;

            $orderItemIdCanAddBreakfast = null;

            foreach($order->orderItems as $orderItem)
            {
                if($orderItem->main_dish == true)
                {
                    $hadDouble = false;
                    $hadExtra = false;

                    foreach($orderItem->orderItemMeals as $orderItemMeal)
                    {
                        foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                        {
                            if($orderItemMealDetail->double == true)
                                $hadDouble = true;

                            if($orderItemMealDetail->extra == true)
                            {
                                $hadExtra = true;
                                break;
                            }
                        }

                        if($hadExtra == true)
                            break;
                    }

                    if($hadDouble == true && $hadExtra == false)
                    {
                        $orderItemIdCanAddBreakfast = $orderItem->id;

                        break;
                    }
                }
            }

            if($orderItemIdCanAddBreakfast == null)
                return redirect('admin/order/detail/' . $id)->with('orderError', 'There is no valid Meat Lover pack in order to add extra breakfast');
        }
        else
            $extraPrice = 0;

        try
        {
            DB::beginTransaction();

            $orderExtra = new OrderExtra();

            if($input['request'] == Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE && !empty($orderItemIdCanAddBreakfast))
            {
                $extraQuantity = 0;

                foreach($order->orderItems as $orderItem)
                {
                    if($orderItem->id == $orderItemIdCanAddBreakfast)
                    {
                        foreach($orderItem->orderItemMeals as $orderItemMeal)
                        {
                            $orderItemMealDetail = new OrderItemMealDetail();
                            $orderItemMealDetail->order_id = $order->id;
                            $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                            $orderItemMealDetail->name = Util::MEAL_BREAKFAST_LABEL;
                            $orderItemMealDetail->quantity = 1;
                            $orderItemMealDetail->extra = Util::STATUS_ACTIVE_VALUE;
                            $orderItemMealDetail->save();

                            $extraQuantity ++;
                        }
                    }
                }

                $extraPrice = $extraPrice * $extraQuantity / 5;

                $orderExtra->order_item_id = $orderItemIdCanAddBreakfast;
            }

            $orderExtra->order_id = $id;
            $orderExtra->price = $extraPrice;
            $orderExtra->code = $input['request'];
            $orderExtra->save();

            $order->total_extra_price += $orderExtra->price;
            $order->total_price += $orderExtra->price;
            $order->save();

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            return redirect('admin/order/detail/' . $id)->with('orderError', $e->getMessage());
        }

        return redirect('admin/order/detail/' . $id);
    }

    public function reOrder(Request $request, $id)
    {
        App::setLocale('vi');

        $fromOrder = Order::with('customer', 'orderAddress', 'orderItems', 'orderExtras', 'transactions')->find($id);

        $fromOrderPaid = 0;
        $fromOrderRefunded = 0;
        $fromOrderBalancedPrice = 0;
        $fromOrderBalancedPaid = 0;

        foreach($fromOrder->transactions as $transaction)
        {
            if($transaction->type == Util::TRANSACTION_TYPE_PAY_VALUE)
                $fromOrderPaid = $transaction->amount;
            else if($transaction->type == Util::TRANSACTION_TYPE_REFUND_VALUE)
                $fromOrderRefunded = $transaction->amount;
            else if($transaction->type == Util::TRANSACTION_TYPE_BALANCE_PRICE_VALUE)
                $fromOrderBalancedPrice = $transaction->amount;
            else if($transaction->type == Util::TRANSACTION_TYPE_BALANCE_PAY_VALUE)
                $fromOrderBalancedPaid = $transaction->amount;
        }

        $orderBalanceAmount = ($fromOrderPaid + $fromOrderBalancedPaid) - ($fromOrder->total_price + $fromOrderRefunded + $fromOrderBalancedPrice);

        if($request->isMethod('post'))
        {
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required|string',
                'gender' => 'required|in:' . Util::GENDER_MALE_VALUE . ',' . Util::GENDER_FEMALE_VALUE,
                'email' => 'required|email',
                'address' => 'required|string',
                'district' => 'required|string',
                'shipping_time' => 'required|string',
                'payment_gateway' => 'required|in:' . Util::PAYMENT_GATEWAY_CASH_VALUE . ',' . Util::PAYMENT_GATEWAY_BANK_TRANSFER_VCB_VALUE . ',' . Util::PAYMENT_GATEWAY_BANK_TRANSFER_ACB_VALUE . ',' . Util::PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_VALUE,
                'mealPack' => 'required|array'
            ]);

            $hasPack = false;
            $totalMealPack = 0;

            foreach($input['mealPack'] as $mealPackId => $inputMealPack)
            {
                $inputMealPack = trim($inputMealPack);

                if(!empty($inputMealPack) && is_numeric($inputMealPack))
                {
                    $hasPack = true;
                    $totalMealPack += $inputMealPack;
                }
            }

            if($validator->fails() || $hasPack == false || $totalMealPack > 5)
                return redirect('admin/order/reorder/' . $fromOrder->id)->with('OrderError', trans('order_form.validate'));

            try
            {
                DB::beginTransaction();

                $district = Area::where('name', $input['district'])->where('status', Util::STATUS_ACTIVE_VALUE)->first();
                $customer = $fromOrder->customer;

                $order = new Order();
                $order->customer_id = $customer->id;
                $order->created_at = date('Y-m-d H:i:s');
                $order->financial_status = Util::FINANCIAL_STATUS_PENDING_VALUE;
                $order->fulfillment_status = Util::FULFILLMENT_STATUS_PENDING_VALUE;
                $order->customer_note = trim($input['note']);
                $order->shipping_price = $district->shipping_price;
                $order->total_line_items_price = 0;
                $order->total_price = $district->shipping_price;
                $order->total_discounts = 0;
                $order->total_extra_price = 0;
                $order->start_week = date('Y-m-d', strtotime('+ ' . (8 - date('N')) . ' days'));
                $order->end_week = date('Y-m-d', strtotime('+ ' . (12 - date('N')) . ' days'));
                $order->payment_gateway = trim($input['payment_gateway']);
                $order->shipping_time = trim($input['shipping_time']);
                $order->shipping_priority = 1;
                $order->warning = Util::STATUS_INACTIVE_VALUE;
                $order->re_order = $fromOrder->id;
                $order->save();

                if(empty($customer->first_order))
                    $customer->first_order = $order->id;

                $customer->last_order = $order->id;
                $customer->orders_count += 1;
                $customer->save();

                $orderAddress = new OrderAddress();
                $orderAddress->order_id = $order->id;
                $orderAddress->email = trim($input['email']);
                $orderAddress->name = trim($input['name']);
                $orderAddress->gender = trim($input['gender']);
                $orderAddress->address = trim($input['address']);
                $orderAddress->district = $district->name;
                $orderAddress->latitude = trim($input['latitude']);
                $orderAddress->longitude = trim($input['longitude']);
                $orderAddress->address_google = trim($input['address_google']);
                $orderAddress->save();

                $mealPackIds = array();

                foreach($input['mealPack'] as $mealPackId => $quantity)
                {
                    $quantity = trim($quantity);

                    if(!empty($quantity))
                        $mealPackIds[] = $mealPackId;
                }

                $mealPacks = MealPack::where('status', Util::STATUS_ACTIVE_VALUE)->whereIn('id', $mealPackIds)->get();

                $mealValid = false;

                foreach($mealPacks as $mealPack)
                {
                    if(!empty($mealPack->breakfast) || !empty($mealPack->lunch) || !empty($mealPack->dinner))
                    {
                        $mealValid = true;
                        break;
                    }
                }

                if($mealValid == false)
                    throw new \Exception();

                $addedExtraBreakfastOrderItemId = null;
                $addedExtraBreakfast = false;

                foreach($mealPacks as $mealPack)
                {
                    $doubles = array();
                    if(!empty($mealPack->double))
                        $doubles = json_decode($mealPack->double, true);

                    for($i = 0;$i < $input['mealPack'][$mealPack->id];$i ++)
                    {
                        $orderItem = new OrderItem();
                        $orderItem->order_id = $order->id;
                        $orderItem->meal_pack = $mealPack->name;
                        $orderItem->meal_pack_description = $mealPack->description;
                        $orderItem->price = $mealPack->price;
                        $orderItem->type = $mealPack->type;
                        $orderItem->save();

                        $order->total_line_items_price += $orderItem->price;
                        $order->total_price += $orderItem->price;

                        if($mealPack->type == Util::MEAL_PACK_TYPE_PACK_VALUE)
                        {
                            for($j = 1;$j <= 5;$j ++)
                            {
                                if(empty($mealPack->breakfast) && empty($mealPack->lunch) && empty($mealPack->dinner) && empty($mealPack->fruit) && empty($mealPack->veggies) && empty($mealPack->vegetarian)
                                    && !empty($mealPack->juice) && ($j == 2 || $j == 4))
                                    continue;

                                $orderItemMeal = new OrderItemMeal();
                                $orderItemMeal->order_id = $order->id;
                                $orderItemMeal->order_item_id = $orderItem->id;
                                $orderItemMeal->day_of_week = $j;
                                $orderItemMeal->status = Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE;
                                $orderItemMeal->shipping_time = $order->shipping_time;
                                $orderItemMeal->meal_date = date('Y-m-d', strtotime('+ ' . (7 + $j - date('N')) . ' days'));

                                if($order->shipping_time == Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                                    $orderItemMeal->cook_date = date('Y-m-d', strtotime('+ ' . (6 + $j - date('N')) . ' days'));
                                else
                                    $orderItemMeal->cook_date = $orderItemMeal->meal_date;

                                $orderItemMeal->shipping_date = $orderItemMeal->cook_date;
                                $orderItemMeal->save();

                                if(!empty($mealPack->breakfast) || (!empty($input['extra_breakfast']) && $addedExtraBreakfast == false) && isset($doubles['lunch']) && isset($doubles['dinner']))
                                {
                                    $orderItemMealDetail = new OrderItemMealDetail();
                                    $orderItemMealDetail->order_id = $order->id;
                                    $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                    $orderItemMealDetail->name = Util::MEAL_BREAKFAST_LABEL;
                                    $orderItemMealDetail->quantity = 1;

                                    if(!empty($mealPack->breakfast) && !empty($mealPack->double))
                                        $orderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;
                                    else
                                        $orderItemMealDetail->double = Util::STATUS_INACTIVE_VALUE;

                                    if(empty($mealPack->breakfast) && isset($doubles['lunch']) && isset($doubles['dinner']) && !empty($input['extra_breakfast']) && $addedExtraBreakfast == false)
                                    {
                                        $addedExtraBreakfastOrderItemId = $orderItem->id;
                                        $orderItemMealDetail->extra = Util::STATUS_ACTIVE_VALUE;
                                    }
                                    else
                                        $orderItemMealDetail->extra = Util::STATUS_INACTIVE_VALUE;

                                    if(!empty($mealPack->vegetarian))
                                        $orderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;
                                    else
                                        $orderItemMealDetail->vegetarian = Util::STATUS_INACTIVE_VALUE;

                                    $orderItemMealDetail->save();

                                    if(empty($mealPack->breakfast) && isset($doubles['lunch']) && isset($doubles['dinner']) && !empty($input['extra_breakfast']) && $addedExtraBreakfast == false && $j == 5)
                                        $addedExtraBreakfast = true;
                                }

                                if(!empty($mealPack->lunch))
                                {
                                    $orderItemMealDetail = new OrderItemMealDetail();
                                    $orderItemMealDetail->order_id = $order->id;
                                    $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                    $orderItemMealDetail->name = Util::MEAL_LUNCH_LABEL;
                                    $orderItemMealDetail->quantity = 1;

                                    if(isset($doubles['lunch']))
                                        $orderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;
                                    else
                                        $orderItemMealDetail->double = Util::STATUS_INACTIVE_VALUE;

                                    if(!empty($mealPack->vegetarian))
                                        $orderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;
                                    else
                                        $orderItemMealDetail->vegetarian = Util::STATUS_INACTIVE_VALUE;

                                    $orderItemMealDetail->save();
                                }

                                if(!empty($mealPack->dinner))
                                {
                                    $orderItemMealDetail = new OrderItemMealDetail();
                                    $orderItemMealDetail->order_id = $order->id;
                                    $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                    $orderItemMealDetail->name = Util::MEAL_DINNER_LABEL;
                                    $orderItemMealDetail->quantity = 1;

                                    if(isset($doubles['dinner']))
                                        $orderItemMealDetail->double = Util::STATUS_ACTIVE_VALUE;
                                    else
                                        $orderItemMealDetail->double = Util::STATUS_INACTIVE_VALUE;

                                    if(!empty($mealPack->vegetarian))
                                        $orderItemMealDetail->vegetarian = Util::STATUS_ACTIVE_VALUE;
                                    else
                                        $orderItemMealDetail->vegetarian = Util::STATUS_INACTIVE_VALUE;

                                    $orderItemMealDetail->save();
                                }

                                if(!empty($mealPack->fruit))
                                {
                                    $orderItemMealDetail = new OrderItemMealDetail();
                                    $orderItemMealDetail->order_id = $order->id;
                                    $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                    $orderItemMealDetail->name = Util::MEAL_FRUIT_LABEL;
                                    $orderItemMealDetail->quantity = 1;

                                    $orderItemMealDetail->save();
                                }

                                if(!empty($mealPack->veggies))
                                {
                                    $orderItemMealDetail = new OrderItemMealDetail();
                                    $orderItemMealDetail->order_id = $order->id;
                                    $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                    $orderItemMealDetail->name = Util::MEAL_VEGGIES_LABEL;
                                    $orderItemMealDetail->quantity = 1;

                                    $orderItemMealDetail->save();
                                }

                                if(!empty($mealPack->juice) && ($j == 1 || $j == 3 || $j == 5))
                                {
                                    $orderItemMealDetail = new OrderItemMealDetail();
                                    $orderItemMealDetail->order_id = $order->id;
                                    $orderItemMealDetail->order_item_meal_id = $orderItemMeal->id;
                                    $orderItemMealDetail->name = Util::MEAL_JUICE_LABEL;
                                    $orderItemMealDetail->quantity = 1;

                                    $orderItemMealDetail->save();
                                }
                            }
                        }
                        else
                        {
                            $orderItemProduct = new OrderItemProduct();
                            $orderItemProduct->order_id = $order->id;
                            $orderItemProduct->order_item_id = $orderItem->id;
                            $orderItemProduct->status = Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE;
                            $orderItemProduct->shipping_time = $order->shipping_time;

                            if($order->shipping_time == Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                                $orderItemProduct->cook_date = date('Y-m-d', strtotime('+ ' . (7 - date('N')) . ' days'));
                            else
                                $orderItemProduct->cook_date = date('Y-m-d', strtotime('+ ' . (8 - date('N')) . ' days'));

                            $orderItemProduct->shipping_date = $orderItemProduct->cook_date;
                            $orderItemProduct->save();
                        }
                    }
                }

                if(!empty($input['change_ingredient']))
                {
                    $orderExtra = new OrderExtra();
                    $orderExtra->order_id = $order->id;
                    $orderExtra->price = Util::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE;
                    $orderExtra->code = $input['change_ingredient'];
                    $orderExtra->save();

                    $order->total_extra_price += $orderExtra->price;
                    $order->total_price += $orderExtra->price;
                    $order->warning = Util::STATUS_ACTIVE_VALUE;
                }

                if(!empty($input['change_meal_course']))
                {
                    $orderExtra = new OrderExtra();
                    $orderExtra->order_id = $order->id;
                    $orderExtra->price = Util::ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE;
                    $orderExtra->code = $input['change_meal_course'];
                    $orderExtra->save();

                    $order->total_extra_price += $orderExtra->price;
                    $order->total_price += $orderExtra->price;
                    $order->warning = Util::STATUS_ACTIVE_VALUE;
                }

                if(!empty($input['extra_breakfast']))
                {
                    $orderExtra = new OrderExtra();
                    $orderExtra->order_id = $order->id;
                    if($addedExtraBreakfastOrderItemId)
                        $orderExtra->order_item_id = $addedExtraBreakfastOrderItemId;
                    $orderExtra->price = Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE;
                    $orderExtra->code = $input['extra_breakfast'];
                    $orderExtra->save();

                    $order->total_extra_price += $orderExtra->price;
                    $order->total_price += $orderExtra->price;
                    $order->warning = Util::STATUS_ACTIVE_VALUE;
                }

                if(!empty($input['discount_code']))
                {
                    $discount = Discount::with('customer')->where('code', trim($input['discount_code']))->first();

                    if(!empty($discount) && (empty($discount->customer) || $customer->id == $discount->customer->id))
                    {
                        $time = strtotime('now');

                        if($discount->status == Util::STATUS_ACTIVE_VALUE && (empty($discount->start_time) || $time >= strtotime($discount->start_time)) && (empty($discount->end_time) || $time <= strtotime($discount->end_time))
                            && (empty($discount->times_limit) || $discount->times_used < $discount->times_limit))
                        {
                            if($discount->usage_unique == Util::STATUS_ACTIVE_VALUE)
                            {
                                $usedDiscount = OrderDiscount::select('ff_order_discount.*')
                                    ->join('ff_order', 'ff_order_discount.order_id', '=', 'ff_order.id')
                                    ->where('ff_order.customer_id', $customer->id)
                                    ->where('ff_order_discount.code', $discount->code)
                                    ->first();
                            }
                            else
                                $usedDiscount = null;

                            if(empty($usedDiscount))
                            {
                                if($discount->type == Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED)
                                    $discountAmount = $discount->value;
                                else
                                    $discountAmount = round($order->total_price * $discount->value / 100);

                                $orderDiscount = new OrderDiscount();
                                $orderDiscount->order_id = $order->id;
                                $orderDiscount->code = $discount->code;
                                $orderDiscount->type = $discount->type;
                                $orderDiscount->value = $discount->value;
                                $orderDiscount->amount = $discountAmount;
                                $orderDiscount->save();

                                $discount->times_used += 1;
                                $discount->save();

                                $order->total_discounts += $discountAmount;
                                $order->total_price -= $discountAmount;
                            }
                        }
                    }
                }

                if(!empty($input['transaction_balance']))
                {
                    if($orderBalanceAmount != 0)
                    {
                        if($orderBalanceAmount < 0)
                        {
                            $balancePay = new Transaction();
                            $balancePay->order_id = $fromOrder->id;
                            $balancePay->customer_id = $order->customer_id;
                            $balancePay->gateway = $input['payment_gateway'];
                            $balancePay->created_at = date('Y-m-d H:i:s');
                            $balancePay->amount = abs($orderBalanceAmount);
                            $balancePay->type = Util::TRANSACTION_TYPE_BALANCE_PAY_VALUE;
                            $balancePay->note = 'Chuyển thanh toán còn thiếu sang Order - ' . $order->order_id;
                            $balancePay->save();

                            $balancePrice = new Transaction();
                            $balancePrice->order_id = $order->id;
                            $balancePrice->customer_id = $order->customer_id;
                            $balancePrice->gateway = $input['payment_gateway'];
                            $balancePrice->created_at = date('Y-m-d H:i:s');
                            $balancePrice->amount = abs($orderBalanceAmount);
                            $balancePrice->type = Util::TRANSACTION_TYPE_BALANCE_PRICE_VALUE;
                            $balancePrice->note = 'Chuyển thanh toán còn thiếu từ Order - ' . $fromOrder->order_id;
                            $balancePrice->save();
                        }
                        else
                        {
                            $balancePrice = new Transaction();
                            $balancePrice->order_id = $fromOrder->id;
                            $balancePrice->customer_id = $order->customer_id;
                            $balancePrice->gateway = $input['payment_gateway'];
                            $balancePrice->created_at = date('Y-m-d H:i:s');
                            $balancePrice->amount = abs($orderBalanceAmount);
                            $balancePrice->type = Util::TRANSACTION_TYPE_BALANCE_PRICE_VALUE;
                            $balancePrice->note = 'Chuyển thanh toán còn dư sang Order - ' . $order->order_id;
                            $balancePrice->save();

                            $balancePay = new Transaction();
                            $balancePay->order_id = $order->id;
                            $balancePay->customer_id = $order->customer_id;
                            $balancePay->gateway = $input['payment_gateway'];
                            $balancePay->created_at = date('Y-m-d H:i:s');
                            $balancePay->amount = abs($orderBalanceAmount);
                            $balancePay->type = Util::TRANSACTION_TYPE_BALANCE_PAY_VALUE;
                            $balancePay->note = 'Chuyển thanh toán còn dư từ Order - ' . $fromOrder->order_id;
                            $balancePay->save();

                            if($balancePay->amount >= $order->total_price)
                                $order->financial_status = Util::FINANCIAL_STATUS_PAID_VALUE;
                        }
                    }
                }

                $order->save();

                DB::commit();

                return redirect('admin/order/detail/' . $order->id);
            }
            catch(\Exception $e)
            {
                DB::rollBack();

                Log::info($e->getLine() . ' ' . $e->getMessage());

                return redirect('admin/order/reorder/' . $fromOrder->id)->with('OrderError', trans('order_form.error'));
            }
        }

        $order = new Order();
        $order->customer_id = $fromOrder->customer_id;
        $order->financial_status = Util::FINANCIAL_STATUS_PENDING_VALUE;
        $order->fulfillment_status = Util::FULFILLMENT_STATUS_PENDING_VALUE;
        $order->customer_note = $fromOrder->customer_note;
        $order->shipping_price = $fromOrder->shipping_price;
        $order->total_line_items_price = 0;
        $order->total_price = $fromOrder->shipping_price;
        $order->total_discounts = 0;
        $order->total_extra_price = 0;
        $order->start_week = date('Y-m-d', strtotime('+ ' . (8 - date('N')) . ' days'));
        $order->end_week = date('Y-m-d', strtotime('+ ' . (12 - date('N')) . ' days'));
        $order->payment_gateway = $fromOrder->payment_gateway;
        $order->shipping_time = $fromOrder->shipping_time;
        $order->shipping_priority = 1;
        $order->warning = Util::STATUS_INACTIVE_VALUE;

        $orderAddress = new OrderAddress();
        $orderAddress->email = $fromOrder->orderAddress->email;
        $orderAddress->name = $fromOrder->orderAddress->name;
        $orderAddress->gender = $fromOrder->orderAddress->gender;
        $orderAddress->address = $fromOrder->orderAddress->address;
        $orderAddress->district = $fromOrder->orderAddress->district;
        $orderAddress->latitude = $fromOrder->orderAddress->latitude;
        $orderAddress->longitude = $fromOrder->orderAddress->longitude;
        $orderAddress->address_google = $fromOrder->orderAddress->address_google;

        $mealPackQuantities = array();
        $fromOrderMealPacks = array();

        foreach($fromOrder->orderItems as $orderItem)
        {
            if($orderItem->price > 0)
            {
                if(!isset($fromOrderMealPacks[$orderItem->meal_pack]))
                {
                    $mealPack = MealPack::where('name', $orderItem->meal_pack)->where('status', Util::STATUS_ACTIVE_VALUE)->first();

                    if(!empty($mealPack))
                        $fromOrderMealPacks[$orderItem->meal_pack] = $mealPack;
                }

                if(isset($fromOrderMealPacks[$orderItem->meal_pack]))
                {
                    if(!isset($mealPackQuantities[$fromOrderMealPacks[$orderItem->meal_pack]->id]))
                        $mealPackQuantities[$fromOrderMealPacks[$orderItem->meal_pack]->id] = 1;
                    else
                        $mealPackQuantities[$fromOrderMealPacks[$orderItem->meal_pack]->id] += 1;

                    $order->total_line_items_price += $fromOrderMealPacks[$orderItem->meal_pack]->price;
                    $order->total_price += $fromOrderMealPacks[$orderItem->meal_pack]->price;
                }
            }
        }

        $orderExtraRequests = array();

        foreach($fromOrder->orderExtras as $orderExtra)
        {
            $orderExtraRequests[$orderExtra->code] = true;

            if($orderExtra->code == Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE)
            {
                $order->total_extra_price += Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE;
                $order->total_price += Util::ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE;
            }
            else
            {
                $order->total_extra_price += $orderExtra->price;
                $order->total_price += $orderExtra->price;
            }
        }

        $areas = Area::getModelActiveArea();
        $mealPacks = MealPack::getModelActiveMealPack();

        return view('admin.orders.re_order', [
            'fromOrder' => $fromOrder,
            'order' => $order,
            'orderAddress' => $orderAddress,
            'mealPackQuantities' => $mealPackQuantities,
            'orderExtraRequests' => $orderExtraRequests,
            'orderBalanceAmount' => $orderBalanceAmount,
            'areas' => $areas,
            'mealPacks' => $mealPacks,
        ]);
    }

    public function checkDiscountCode(Request $request)
    {
        try
        {
            if($request->ajax())
            {
                $input = $request->all();

                $discount = Discount::with('customer')->where('code', $input['code'])->first();

                $customer = null;
                if(!empty($input['phone']))
                    $customer = Customer::where('phone', $input['phone'])->first();

                if(!empty($discount) && (empty($discount->customer) || (!empty($customer) && $customer->id == $discount->customer->id)))
                {
                    $time = strtotime('now');

                    if($discount->status == Util::STATUS_ACTIVE_VALUE && (empty($discount->start_time) || $time >= strtotime($discount->start_time)) && (empty($discount->end_time) || $time <= strtotime($discount->end_time))
                        && (empty($discount->times_limit) || $discount->times_used < $discount->times_limit))
                    {
                        if($discount->usage_unique == Util::STATUS_ACTIVE_VALUE && !empty($customer))
                        {
                            $usedDiscount = OrderDiscount::select('ff_order_discount.*')
                                ->join('ff_order', 'ff_order_discount.order_id', '=', 'ff_order.id')
                                ->where('ff_order.customer_id', $customer->id)
                                ->where('ff_order_discount.code', $discount->code)
                                ->first();

                            if(!empty($usedDiscount))
                                return 'EXPIRED';
                        }

                        if($discount->type == Util::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED)
                            echo $discount->value;
                        else
                            echo round($input['price'] * $discount->value / 100);
                    }
                    else
                        echo 'EXPIRED';
                }
                else
                    echo 'INVALID_CODE';
            }
        }
        catch(\Exception $e)
        {
            echo false;
        }
    }

    public function listCooking(Request $request)
    {
        list($orders, $date, $startWeek) = $this->getListCookingOrder($request);

        return view('admin.orders.list_cooking', ['orders' => $orders, 'date' => $date, 'startWeek' => $startWeek]);
    }

    public function exportCooking(Request $request)
    {
        list($orders, $date, $startWeek) = $this->getListCookingOrder($request);

        $exportData[] = [
            '',
            'Sunday, ' . date('Y-m-d', strtotime($startWeek) - Util::TIMESTAMP_ONE_DAY),
            'Monday, ' . $startWeek,
            'Tuesday, ' . date('Y-m-d', strtotime($startWeek) + Util::TIMESTAMP_ONE_DAY),
            'Wednesday, ' . date('Y-m-d', strtotime($startWeek) + (Util::TIMESTAMP_ONE_DAY * 2)),
            'Thursday, ' . date('Y-m-d', strtotime($startWeek) + (Util::TIMESTAMP_ONE_DAY * 3)),
            'Friday, ' . date('Y-m-d', strtotime($startWeek) + (Util::TIMESTAMP_ONE_DAY * 4)),
            'Total',
        ];

        $meals = [
            Util::MEAL_BREAKFAST_LABEL => [],
            Util::MEAL_LUNCH_LABEL => [],
            Util::MEAL_DINNER_LABEL => [],
            Util::MEAL_FRUIT_LABEL => [],
            Util::MEAL_VEGGIES_LABEL => [],
        ];
        $packs = array();

        foreach($orders as $order)
        {
            foreach($order->orderItems as $orderItem)
            {
                foreach($orderItem->orderItemMeals as $orderItemMeal)
                {
                    if($orderItemMeal->meal_date != $orderItemMeal->cook_date)
                        $dateOfWeek = $orderItemMeal->day_of_week - 1;
                    else
                        $dateOfWeek = $orderItemMeal->day_of_week;
                    if(isset($packs[$orderItem->meal_pack][$dateOfWeek]))
                        $packs[$orderItem->meal_pack][$dateOfWeek] += 1;
                    else
                        $packs[$orderItem->meal_pack][$dateOfWeek] = 1;
                    foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                    {
                        if($orderItemMealDetail->double)
                            $quantity = $orderItemMealDetail->quantity * 2;
                        else
                            $quantity = $orderItemMealDetail->quantity;
                        if(isset($meals[$orderItemMealDetail->name][$dateOfWeek]))
                            $meals[$orderItemMealDetail->name][$dateOfWeek] += $quantity;
                        else
                            $meals[$orderItemMealDetail->name][$dateOfWeek] = $quantity;
                    }
                }
            }
        }

        foreach($meals as $keyMeal => $dayMeal)
        {
            if(count($dayMeal) == 0)
                unset($meals[$keyMeal]);
        }

        $countMeals = count($meals);

        for($i = 1;$i <= $countMeals;$i ++)
        {
            if($i == 1)
                reset($meals);
            else
                next($meals);

            $key = key($meals);

            $data = [$key];

            $total = 0;
            for($j = 0;$j <= 5;$j ++)
            {
                if(isset($meals[$key][$j]))
                {
                    $data[] = $meals[$key][$j];
                    $total += $meals[$key][$j];
                }
                else
                    $data[] = 0;
            }
            $data[] = $total;

            $exportData[] = $data;
        }

        $exportData[] = ['Packs'];

        $countPacks = count($packs);

        for($i = 1;$i <= $countPacks;$i ++)
        {
            if($i == 1)
                reset($packs);
            else
                next($packs);

            $key = key($packs);

            $data = [$key];

            for($j = 0;$j <= 5;$j ++)
            {
                if(isset($packs[$key][$j]))
                    $data[] = $packs[$key][$j];
                else
                    $data[] = 0;
            }

            $exportData[] = $data;
        }

        Excel::create('export-cooking-' . $date, function($excel) use($exportData, $countMeals) {

            $excel->sheet('sheet1', function($sheet) use($exportData, $countMeals) {

                $sheet->fromArray($exportData, null, 'A1', true, false);
                $sheet->mergeCells('A' . ($countMeals + 2) . ':G' . ($countMeals + 2));
                $sheet->cell('A' . ($countMeals + 2), function($cell) {

                    $cell->setAlignment('center');

                });

            });

        })->export('xls');
    }

    protected function getListCookingOrder($request)
    {
        $input = $request->all();

        if(!empty($input['date']))
            $date = $input['date'];
        else
            $date = date('Y-m-d');

        $dayOfWeek = date('N', strtotime($date));
        if($dayOfWeek < 6)
            $startWeek = date('Y-m-d', strtotime($date) - (Util::TIMESTAMP_ONE_DAY * ($dayOfWeek - 1)));
        else
            $startWeek = date('Y-m-d', strtotime($date) + (Util::TIMESTAMP_ONE_DAY * (8 - $dayOfWeek)));

        $orders = Order::select('*')->with(['orderItems.orderItemMeals' => function($query) {
            $query->orderBy('day_of_week');
        }, 'orderItems.orderItemMeals.orderItemMealDetails'])
            ->where('start_week', '<=', $startWeek)
            ->where('end_week', '>=', $date)
            ->where('free', 0)
            ->get();

        return [$orders, $date, $startWeek];
    }

    public function assignShipping(Request $request)
    {
        $input = $request->all();

        if(!empty($input['date']))
            $date = $input['date'];
        else
            $date = date('Y-m-d');

        $dayOfWeek = date('N', strtotime($date));
        if($dayOfWeek < 6)
            $startWeek = date('Y-m-d', strtotime($date) - (Util::TIMESTAMP_ONE_DAY * ($dayOfWeek - 1)));
        else
            $startWeek = date('Y-m-d', strtotime($date) + (Util::TIMESTAMP_ONE_DAY * (8 - $dayOfWeek)));

        $queryString = '&date=' . $date;

        $builder = Order::select('ff_order.*')->with('orderAddress', 'customer')
            ->where('ff_order.start_week', '<=', $startWeek)->where('ff_order.end_week', '>=', $date)
            ->whereNull('ff_order.cancelled_at')
            ->where('ff_order.free', 0);

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['shipper']))
            {
                if($input['filter']['shipper'] == 'NO ASSIGN')
                    $builder->whereNull('ff_order.shipper_id');
                else
                    $builder->where('ff_order.shipper_id', $input['filter']['shipper']);
            }

            if(!empty($input['filter']['district']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_order_address` on') === false)
                    $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id');
                $builder->where('ff_order_address.district', $input['filter']['district']);
            }

            $filter = $input['filter'];
            $queryString .= '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
            $filter = null;

        if(isset($input['sort']))
        {
            if(isset($input['sort']['district']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_order_address` on') === false)
                    $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id');
                $builder->orderBy('ff_order_address.district', $input['sort']['district']);
            }
            else if(isset($input['sort']['latlong']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_order_address` on') === false)
                    $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id');
                $builder->orderByRaw('CONCAT(ff_order_address.latitude, ff_order_address.longitude) ' . $input['sort']['latlong']);
            }

            $sort = $input['sort'];
            $sortString = '&' . http_build_query(['sort' => $input['sort']]);
        }
        else
        {
            $sort = null;
            $sortString = null;
        }

        if($sort == null)
            $builder->orderBy('ff_order.shipping_priority', 'DESC');

        $orders = $builder->paginate(Util::GRID_PER_PAGE);

        return view('admin.orders.assign_shipping', [
            'orders' => $orders,
            'date' => $date,
            'filter' => $filter,
            'sort' => $sort,
            'queryString' => $queryString,
            'sortString' => $sortString,
        ]);
    }

    public function assignOrderShipper(Request $request)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $input = $request->all();

                $date = $input['date'];

                $dayOfWeek = date('N', strtotime($date));
                if($dayOfWeek < 6)
                    $startWeek = date('Y-m-d', strtotime($date) - (Util::TIMESTAMP_ONE_DAY * ($dayOfWeek - 1)));
                else
                    $startWeek = date('Y-m-d', strtotime($date) + (Util::TIMESTAMP_ONE_DAY * (8 - $dayOfWeek)));

                $currentDate = date('Y-m-d');

                $builder = Order::select('ff_order.*')->with(['orderItemMeals' => function($query) use($currentDate) {
                    $query->where('shipping_date', '>=', $currentDate);
                }])
                    ->where('ff_order.start_week', '<=', $startWeek)->where('ff_order.end_week', '>=', $date)
                    ->whereNull('ff_order.cancelled_at')
                    ->where('ff_order.free', 0);

                if(isset($input['filter']))
                {
                    if(!empty($input['filter']['shipper']))
                    {
                        if($input['filter']['shipper'] == 'NO ASSIGN')
                            $builder->whereNull('ff_order.shipper_id');
                        else
                            $builder->where('ff_order.shipper_id', $input['filter']['shipper']);
                    }

                    if(!empty($input['filter']['district']))
                    {
                        $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id')
                            ->where('ff_order_address.district', $input['filter']['district']);
                    }
                }

                $orderId = $input['order'];
                $shipperId = $input['shipper'];

                if($orderId == 'all')
                {
                    $orders = $builder->get();

                    foreach($orders as $order)
                    {
                        $order->shipper_id = $shipperId;
                        $order->save();

                        foreach($order->orderItemMeals as $orderItemMeal)
                        {
                            if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                            {
                                $orderItemMeal->shipper_id = $shipperId;
                                $orderItemMeal->save();
                            }
                        }
                    }
                }
                else
                {
                    $order = $builder->find($orderId);
                    $order->shipper_id = $shipperId;
                    $order->save();

                    foreach($order->orderItemMeals as $orderItemMeal)
                    {
                        if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                        {
                            $orderItemMeal->shipper_id = $shipperId;
                            $orderItemMeal->save();
                        }
                    }
                }

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function assignOrderShippingPriority(Request $request)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $input = $request->all();

                $date = $input['date'];

                $dayOfWeek = date('N', strtotime($date));
                if($dayOfWeek < 6)
                    $startWeek = date('Y-m-d', strtotime($date) - (Util::TIMESTAMP_ONE_DAY * ($dayOfWeek - 1)));
                else
                    $startWeek = date('Y-m-d', strtotime($date) + (Util::TIMESTAMP_ONE_DAY * (8 - $dayOfWeek)));

                $currentDate = date('Y-m-d');

                $builder = Order::select('ff_order.*')->with(['orderItemMeals' => function($query) use($currentDate) {
                    $query->where('shipping_date', '>=', $currentDate);
                }])
                    ->where('ff_order.start_week', '<=', $startWeek)->where('ff_order.end_week', '>=', $date)
                    ->whereNull('ff_order.cancelled_at')
                    ->where('ff_order.free', 0);

                if(isset($input['filter']))
                {
                    if(!empty($input['filter']['shipper']))
                    {
                        if($input['filter']['shipper'] == 'NO ASSIGN')
                            $builder->whereNull('ff_order.shipper_id');
                        else
                            $builder->where('ff_order.shipper_id', $input['filter']['shipper']);
                    }

                    if(!empty($input['filter']['district']))
                    {
                        $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id')
                            ->where('ff_order_address.district', $input['filter']['district']);
                    }
                }

                $orderId = $input['order'];
                $priority = $input['priority'];

                if($orderId == 'all')
                {
                    $orders = $builder->get();

                    foreach($orders as $order)
                    {
                        $order->shipping_priority = $priority;
                        $order->save();
                    }
                }
                else
                {
                    $order = $builder->find($orderId);
                    $order->shipping_priority = $priority;
                    $order->save();
                }

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function listShipping(Request $request)
    {
        $input = $request->all();

        if(!empty($input['date']))
            $date = $input['date'];
        else
            $date = date('Y-m-d');

        $orders = Order::select('ff_order.*')->with(['orderItems.orderItemMeals' => function($query) use($date) {
            $query->where('shipping_date', $date);
        }, 'orderItems.orderItemMeals.orderItemMealDetails', 'orderItems.orderItemMeals.shipper'])
            ->join('ff_order_item_meal', 'ff_order.id', '=', 'ff_order_item_meal.order_id')
            ->where('ff_order_item_meal.shipping_date', $date)
            ->where('ff_order.free', 0)
            ->where(function($query) {
                $query->whereNull('ff_order.cancelled_at')->orWhere('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_FULFILLED_VALUE);
            })
            ->groupBy('ff_order.id')
            ->get();

        $finishFulfillment = true;

        foreach($orders as $order)
        {
            foreach($order->orderItems as $orderItem)
            {
                foreach($orderItem->orderItemMeals as $orderItemMeal)
                {
                    if(empty($orderItemMeal->shipper_id))
                    {
                        $finishFulfillment = null;
                        break;
                    }

                    if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE && $finishFulfillment)
                        $finishFulfillment = false;
                }

                if($finishFulfillment === null)
                    break;
            }

            if($finishFulfillment === null)
                break;
        }

        return view('admin.orders.list_shipping', [
            'orders' => $orders,
            'date' => $date,
            'finishFulfillment' => $finishFulfillment,
        ]);
    }

    public function finishShipping(Request $request, $date)
    {
        try
        {
            DB::beginTransaction();

            if($request->ajax())
            {
                $orders = Order::select('ff_order.*')->with(['orderItems.orderItemMeals' => function($query) use($date) {
                    $query->where('shipping_date', $date);
                }])
                    ->join('ff_order_item_meal', 'ff_order.id', '=', 'ff_order_item_meal.order_id')
                    ->where('ff_order_item_meal.shipping_date', $date)
                    ->where(function($query) {
                        $query->whereNull('ff_order.cancelled_at')->orWhere('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_FULFILLED_VALUE);
                    })
                    ->where('ff_order.free', 0)
                    ->groupBy('ff_order.id')
                    ->get();

                foreach($orders as $order)
                {
                    foreach($order->orderItems as $orderItem)
                    {
                        foreach($orderItem->orderItemMeals as $orderItemMeal)
                        {
                            if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE && !empty($orderItemMeal->shipper_id))
                            {
                                $orderItemMeal->status = Util::ORDER_ITEM_MEAL_STATUS_FULFILLED_VALUE;
                                $orderItemMeal->save();
                            }
                        }
                    }
                }

                $dayOfWeek = date('N', strtotime($date));
                if($dayOfWeek < 6)
                    $startWeek = date('Y-m-d', strtotime($date) - (Util::TIMESTAMP_ONE_DAY * ($dayOfWeek - 1)));
                else
                    $startWeek = date('Y-m-d', strtotime($date) + (Util::TIMESTAMP_ONE_DAY * (8 - $dayOfWeek)));

                $orders = Order::select('*')->with('orderItems.orderItemMeals')
                    ->where('start_week', '<=', $startWeek)
                    ->where('end_week', '>=', $date)
                    ->where('ff_order.free', 0)
                    ->get();

                foreach($orders as $order)
                {
                    $fulfilled = true;

                    foreach($order->orderItems as $orderItem)
                    {
                        foreach($orderItem->orderItemMeals as $orderItemMeal)
                        {
                            if($orderItemMeal->status == Util::ORDER_ITEM_MEAL_STATUS_PENDING_VALUE)
                            {
                                $fulfilled = false;
                                break;
                            }
                        }

                        if($fulfilled == false)
                            break;
                    }

                    if($fulfilled)
                    {
                        $order->fulfillment_status = Util::FULFILLMENT_STATUS_FULFILLED_VALUE;
                        $order->save();
                    }
                    else
                    {
                        if($order->fulfillment_status == Util::FULFILLMENT_STATUS_PENDING_VALUE)
                        {
                            $order->fulfillment_status = Util::FULFILLMENT_STATUS_PARTIALLY_FULFILLED_VALUE;
                            $order->save();
                        }
                    }
                }

                echo true;
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            echo false;
        }
    }

    public function detailShipping($id, $date)
    {
        list($shipper, $orders) = $this->getListDetailShippingOrder($id, $date);

        return view('admin.orders.detail_shipping', ['shipper' => $shipper,'orders' => $orders, 'date' => $date]);
    }

    public function exportDetailShipping($id, $date)
    {
        list($shipper, $orders) = $this->getListDetailShippingOrder($id, $date);

        $exportData = array();
        $mergeCells = array();
        $formatCells = array();

        $times = Util::getShippingTime();
        foreach($times as $key => $time)
            $times[$key] = array();

        foreach($orders as $order)
        {
            foreach($order->orderItems as $orderItem)
            {
                foreach($orderItem->orderItemMeals as $orderItemMeal)
                {
                    $times[$orderItemMeal->shipping_time][] = $order;
                    break;
                }
                break;
            }
        }

        $i = 1;
        foreach($times as $key => $timeOrders)
        {
            if(count($timeOrders) > 0)
            {
                if($key == Util::SHIPPING_TIME_NIGHT_BEFORE_VALUE)
                    $exportData[] = [Util::SHIPPING_TIME_NIGHT_BEFORE_LABEL_ADMIN];
                else
                    $exportData[] = [$key];
                $mergeCells[] = 'A' . $i . ':G' . $i;
                $formatCells[] = 'A' . $i;

                $i ++;

                foreach($timeOrders as $order)
                {
                    $exportData[] = [
                        'Order ID',
                        'Bill',
                        'Phone',
                        'Name',
                        'Address',
                        'District',
                        'Priority',
                    ];

                    $i ++;

                    if($order->payment_gateway == App\Libraries\Util::PAYMENT_GATEWAY_CASH_VALUE)
                    {
                        $totalPrice = $order->total_price;

                        if(count($order->transactions) > 0)
                        {
                            foreach($order->transactions as $transaction)
                            {
                                if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_PAY_VALUE)
                                    $totalPrice -= $transaction->amount;
                                else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PRICE_VALUE)
                                    $totalPrice += $transaction->amount;
                                else if($transaction->type == App\Libraries\Util::TRANSACTION_TYPE_BALANCE_PAY_VALUE)
                                    $totalPrice -= $transaction->amount;
                            }
                        }

                        if($totalPrice < 0)
                            $totalPrice = 0;
                    }
                    else
                        $totalPrice = 0;

                    $exportData[] = [
                        $order->order_id,
                        Util::formatMoney($totalPrice),
                        $order->customer->phone,
                        $order->orderAddress->name,
                        $order->orderAddress->address,
                        $order->orderAddress->district,
                        $order->shipping_priority,
                    ];

                    $i ++;

                    $meals = [
                        Util::MEAL_BREAKFAST_LABEL => 0,
                        Util::MEAL_LUNCH_LABEL => 0,
                        Util::MEAL_DINNER_LABEL => 0,
                        Util::MEAL_FRUIT_LABEL => 0,
                        Util::MEAL_VEGGIES_LABEL => 0,
                        Util::MEAL_BREAKFAST_LABEL . ' DOUBLE' => 0,
                        Util::MEAL_LUNCH_LABEL . ' DOUBLE' => 0,
                        Util::MEAL_DINNER_LABEL . ' DOUBLE' => 0,
                        Util::MEAL_FRUIT_LABEL . ' DOUBLE' => 0,
                        Util::MEAL_VEGGIES_LABEL . ' DOUBLE' => 0,
                    ];
                    $packs = array();

                    foreach($order->orderItems as $orderItem)
                    {
                        foreach($orderItem->orderItemMeals as $orderItemMeal)
                        {
                            if(isset($packs[$orderItem->meal_pack]))
                                $packs[$orderItem->meal_pack] += 1;
                            else
                                $packs[$orderItem->meal_pack] = 1;

                            foreach($orderItemMeal->orderItemMealDetails as $orderItemMealDetail)
                            {
                                if($orderItemMealDetail->double)
                                    $mealName = $orderItemMealDetail->name . ' DOUBLE';
                                else
                                    $mealName = $orderItemMealDetail->name;
                                if(isset($meals[$mealName]))
                                    $meals[$mealName] += $orderItemMealDetail->quantity;
                                else if($orderItemMealDetail->quantity)
                                    $meals[$mealName] = $orderItemMealDetail->quantity;
                            }
                        }
                    }

                    foreach($meals as $keyMeal => $quantity)
                    {
                        if($quantity == 0)
                            unset($meals[$keyMeal]);
                    }

                    $j = 1;
                    $mealString = '';
                    foreach($meals as $keyMeal => $quantity)
                    {
                        if($j == 1)
                            $mealString .= $quantity . ' x ' . $keyMeal;
                        else
                            $mealString .= ' - ' . $quantity . ' x ' . $keyMeal;
                        $j ++;
                    }

                    $j = 1;
                    $packString = '';
                    foreach($packs as $keyPack => $quantity)
                    {
                        if($j == 1)
                            $packString .= $quantity . ' x ' . $keyPack;
                        else
                            $packString .= ' - ' . $quantity . ' x ' . $keyPack;
                        $j ++;
                    }

                    $exportData[] = [
                        'Meals',
                        '',
                        '',
                        '',
                        'Packs',
                    ];
                    $mergeCells[] = 'A' . $i . ':D' . $i;
                    $mergeCells[] = 'E' . $i . ':G' . $i;

                    $i ++;

                    $exportData[] = [
                        $mealString,
                        '',
                        '',
                        '',
                        $packString,
                    ];
                    $mergeCells[] = 'A' . $i . ':D' . $i;
                    $mergeCells[] = 'E' . $i . ':G' . $i;

                    $i ++;

                    $exportData[] = [];

                    $i ++;
                }
            }
        }

        Excel::create('export-detail-shipping-' . $shipper->name . '-' . $date, function($excel) use($exportData, $mergeCells, $formatCells) {

            $excel->sheet('sheet1', function($sheet) use($exportData, $mergeCells, $formatCells) {

                $sheet->fromArray($exportData, null, 'A1', true, false);

                foreach($mergeCells as $mergeCell)
                    $sheet->mergeCells($mergeCell);

                foreach($formatCells as $formatCell)
                {
                    $sheet->cell($formatCell, function($cell) {

                        $cell->setFontWeight('bold');
                        $cell->setBackground('#d9edf7');
                        $cell->setAlignment('center');

                    });
                }

            });

        })->export('xls');
    }

    protected function getListDetailShippingOrder($id, $date)
    {
        $shipper = Shipper::find($id);

        $orders = Order::select('ff_order.*')->with(['customer', 'orderAddress', 'orderItems.orderItemMeals' => function($query) use($id, $date) {
            $query->where('shipping_date', $date)->where('shipper_id', $id);
        }, 'orderItems.orderItemMeals.orderItemMealDetails', 'transactions' => function($query) use($date) {
            $query->where(function($query) use($date) {
                $query->where('type', Util::TRANSACTION_TYPE_PAY_VALUE)->where('created_at', 'like', $date . '%');
            })->orWhere(function($query) use($date) {
                $query->where('type', '<>', Util::TRANSACTION_TYPE_PAY_VALUE)->where('type', '<>', Util::TRANSACTION_TYPE_REFUND_VALUE);
            });
        }])
            ->join('ff_order_item_meal', 'ff_order.id', '=', 'ff_order_item_meal.order_id')
            ->where('ff_order_item_meal.shipping_date', $date)
            ->where('ff_order_item_meal.shipper_id', $id)
            ->where(function($query) {
                $query->whereNull('ff_order.cancelled_at')->orWhere('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_FULFILLED_VALUE);
            })
            ->where('ff_order.free', 0)
            ->orderBy('ff_order.shipping_priority', 'DESC')
            ->groupBy('ff_order.id')
            ->get();

        return [$shipper, $orders];
    }

    public function listFreeOrder(Request $request)
    {
        list($orders, $duplicateOrderCustomerIds, $date, $filter, $queryString) = $this->getListFreeOrder($request, 'list');

        return view('admin.orders.list_free_order', [
            'orders' => $orders,
            'duplicateOrderCustomerIds' => $duplicateOrderCustomerIds,
            'date' => $date,
            'filter' => $filter,
            'queryString' => $queryString,
        ]);
    }

    public function exportFreeOrder(Request $request)
    {
        list($orders, $duplicateOrderCustomerIds, $date, $filter, $queryString) = $this->getListFreeOrder($request, 'export');

        $formatDuplicateCells = array();

        $exportData[] = [
            'Timestamp',
            'Tên | Name',
            'Phone.Reformat',
            'Địa chỉ giao hàng | Delivery Address',
            'Thời gian giao hàng mong muốn | Expected delivery time',
            'Quận | District',
            '',
            'Giới tính | Gender',
            'Email',
            '',
            'Số lượng order | Number of order',
            'Mã khuyến mãi | Promo Code',
        ];

        $i = 2;
        foreach($orders as $order)
        {
            $phone = Util::formatPhone($order->customer->phone);

            $exportData[] = [
                $order->created_at,
                $order->orderAddress->name,
                $phone,
                $order->orderAddress->address,
                Util::getShippingTime($order->shipping_time),
                $order->orderAddress->district,
                '',
                Util::getGender($order->orderAddress->gender),
                $order->orderAddress->email,
                '',
                1,
                $order->orderDiscount->code,
            ];

            if(isset($duplicateOrderCustomerIds[$order->customer_id]))
            {
                $formatDuplicateCells[] = [
                    'cell' => 'A' . $i . ':' . 'X' . $i,
                    'color' => '#fcf8e3',
                ];
            }

            $i ++;
        }

        Excel::create('export-free-order-' . $date, function($excel) use($exportData, $formatDuplicateCells) {

            $excel->sheet('sheet1', function($sheet) use($exportData, $formatDuplicateCells) {

                $sheet->fromArray($exportData, null, 'A1', true, false);

                foreach($formatDuplicateCells as $formatDuplicateCell)
                {
                    $sheet->cells($formatDuplicateCell['cell'], function($cells) use($formatDuplicateCell) {

                        $cells->setBackground($formatDuplicateCell['color']);

                    });
                }

            });

        })->export('xls');
    }

    protected function getListFreeOrder($request, $action)
    {
        $input = $request->all();

        if(!empty($input['date']))
            $date = $input['date'];
        else
            $date = date('Y-m-d');

        $queryString = '&date=' . $date;

        $builder = Order::select('ff_order.*')->with(['orderAddress', 'customer', 'orderDiscount'])
            ->where('ff_order.start_week', $date)
            ->where('ff_order.free', 1)
            ->orderBy('ff_order.id', 'DESC');

        if(isset($input['filter']))
        {
            if(!empty($input['filter']['order_id']))
                $builder->where('ff_order.order_id', 'like', '%' . $input['filter']['order_id']);

            if(!empty($input['filter']['phone']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_customer` on') === false)
                    $builder->join('ff_customer', 'ff_order.customer_id', '=', 'ff_customer.id');
                $builder->where('ff_customer.phone', 'like', '%' . $input['filter']['phone']);
            }

            if(!empty($input['filter']['name']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_order_address` on') === false)
                    $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id');
                $builder->where('ff_order_address.name', 'like', '%' . $input['filter']['name'] . '%');
            }

            if(!empty($input['filter']['email']))
            {
                $sql = $builder->toSql();
                if(strpos($sql, 'inner join `ff_order_address` on') === false)
                    $builder->join('ff_order_address', 'ff_order.id', '=', 'ff_order_address.order_id');
                $builder->where('ff_order_address.email', 'like', '%' . $input['filter']['email'] . '%');
            }

            if(!empty($input['filter']['cancelled']))
                $builder->whereNotNull('ff_order.cancelled_at')->where('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_PENDING_VALUE);

            $filter = $input['filter'];
            $queryString .= '&' . http_build_query(['filter' => $input['filter']]);
        }
        else
            $filter = null;

        if(empty($filter['cancelled']))
        {
            $builder->where(function($query) {
                $query->whereNull('ff_order.cancelled_at')->orWhere('ff_order.fulfillment_status', Util::FULFILLMENT_STATUS_FULFILLED_VALUE);
            });
        }

        if($action == 'list')
            $orders = $builder->paginate(Util::GRID_PER_PAGE);
        else
            $orders = $builder->get();

        $duplicateOrderCustomerIds = Order::selectRaw('customer_id, COUNT(id) AS number_of_order')
            ->where('start_week', $date)
            ->whereNull('cancelled_at')
            ->where('free', 1)
            ->groupBy('customer_id')
            ->havingRaw('COUNT(id) > 1')
            ->pluck('number_of_order', 'customer_id')
            ->toArray();

        return [$orders, $duplicateOrderCustomerIds, $date, $filter, $queryString];
    }
}