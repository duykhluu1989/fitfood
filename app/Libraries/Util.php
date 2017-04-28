<?php

namespace App\Libraries;

use Image;

class Util
{
    const ROLE_ADMINISTRATOR = 'Administrator';

    const ORDER_ID_PREFIX = 1000000;
    const CUSTOMER_ID_PREFIX = 1000000;

    const GRID_PER_PAGE = 50;

    const BLOG_ARTICLE_PER_PAGE = 4;

    const TIMESTAMP_ONE_DAY = 86400;
    const MINUTE_ONE_MONTH_EXPIRED = 43200;
    const MINUTE_ONE_HOUR_EXPIRED = 60;
    const MINUTE_ONE_YEAR_EXPIRED = 525600;

    const STATUS_INACTIVE_VALUE = 0;
    const STATUS_ACTIVE_VALUE = 1;
    const STATUS_INACTIVE_LABEL = 'Inactive';
    const STATUS_ACTIVE_LABEL = 'Active';

    const GENDER_MALE_VALUE = 'MALE';
    const GENDER_FEMALE_VALUE = 'FEMALE';
    const GENDER_MALE_LABEL = 'Nam';
    const GENDER_FEMALE_LABEL = 'Nữ';
    const GENDER_MALE_LABEL_EN = 'Male';
    const GENDER_FEMALE_LABEL_EN = 'Female';

    const CUSTOMER_CODE_VN = 'VN';
    const CUSTOMER_CODE_FR = 'FR';

    const FINANCIAL_STATUS_PENDING_VALUE = 'PENDING';
    const FINANCIAL_STATUS_PAID_VALUE = 'PAID';
    const FINANCIAL_STATUS_PARTIALLY_REFUND_VALUE = 'PARTIALLY_REFUND';
    const FINANCIAL_STATUS_REFUND_VALUE = 'REFUND';

    const FULFILLMENT_STATUS_PENDING_VALUE = 'PENDING';
    const FULFILLMENT_STATUS_FULFILLED_VALUE = 'FULFILLED';
    const FULFILLMENT_STATUS_PARTIALLY_FULFILLED_VALUE = 'PARTIALLY_FULFILLED';

    const PAYMENT_GATEWAY_BANK_NET_PAYPAL_VALUE = 'PAYPAL';
    const PAYMENT_GATEWAY_CASH_VALUE = 'CASH';
    const PAYMENT_GATEWAY_BANK_TRANSFER_VCB_VALUE = 'BANK_VCB';
    const PAYMENT_GATEWAY_BANK_TRANSFER_ACB_VALUE = 'BANK_ACB';
    const PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_VALUE = 'BANK_HSBC';
    const PAYMENT_GATEWAY_MPOS_VALUE = 'MPOS';
    const PAYMENT_GATEWAY_BANK_NET_PAYPAL_LABEL = 'Thanh toán trực tuyến bằng PAYPAL';
    const PAYMENT_GATEWAY_CASH_LABEL = 'Tiền mặt';
    const PAYMENT_GATEWAY_BANK_TRANSFER_VCB_LABEL = 'Chuyển khoản VCB';
    const PAYMENT_GATEWAY_BANK_TRANSFER_ACB_LABEL = 'Chuyển khoản ACB';
    const PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_LABEL = 'Chuyển khoản HSBC';
    const PAYMENT_GATEWAY_MPOS_LABEL = 'Cà thẻ tận nơi mPOS';
    const PAYMENT_GATEWAY_BANK_NET_PAYPAL_LABEL_EN = 'Online payment by PAYPAL';
    const PAYMENT_GATEWAY_CASH_LABEL_EN = 'Cash (COD)';
    const PAYMENT_GATEWAY_BANK_TRANSFER_VCB_LABEL_EN = 'Bank transfer VCB';
    const PAYMENT_GATEWAY_BANK_TRANSFER_ACB_LABEL_EN = 'Bank transfer ACB';
    const PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_LABEL_EN = 'Bank transfer HSBC';
    const PAYMENT_GATEWAY_MPOS_LABEL_EN = 'mPOS';

    const BANK_TRANSFER_ACCOUNT_NAME = 'THAI QUOC KIM';
    const BANK_TRANSFER_VCB_ACCOUNT_NUMBER = 'VCB 0251002419911';
    const BANK_TRANSFER_ACB_ACCOUNT_NUMBER = 'ACB 114704899';
    const BANK_TRANSFER_HSBC_ACCOUNT_NUMBER = 'HSBC 091048330041';

    const SHIPPING_TIME_NIGHT_BEFORE_VALUE = 'THE_NIGHT_BEFORE';
    const SHIPPING_TIME_NIGHT_BEFORE_LABEL = 'Tối hôm trước (19:00 - 22:00)';
    const SHIPPING_TIME_NIGHT_BEFORE_LABEL_EN = 'Night before (19:00 - 22:00)';
    const SHIPPING_TIME_NIGHT_BEFORE_LABEL_ADMIN = 'Buổi tối (19:00 - 22:00)';

    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_PRICE = 50000;
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_COW_VALUE = 'CHANGE_INGREDIENT_NO_COW';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_FISH_VALUE = 'CHANGE_INGREDIENT_NO_FISH';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_CHICKEN_VALUE = 'CHANGE_INGREDIENT_NO_CHICKEN';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_PIG_VALUE = 'CHANGE_INGREDIENT_NO_PIG';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_SHRIMP_VALUE = 'CHANGE_INGREDIENT_NO_SHRIMP';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_COW_LABEL = 'Không bò';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_FISH_LABEL = 'Không cá';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_CHICKEN_LABEL = 'Không gà';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_PIG_LABEL = 'Không heo';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_SHRIMP_LABEL = 'Không tôm';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_COW_LABEL_EN = 'No beef';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_FISH_LABEL_EN = 'No fish';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_CHICKEN_LABEL_EN = 'No chicken';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_PIG_LABEL_EN = 'No pork';
    const ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_SHRIMP_LABEL_EN = 'No shrimp';

    const ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_PRICE = 50000;
    const ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_VALUE = 'CHANGE_MEAL_COURSE';
    const ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL = 'Đổi bữa ăn linh hoạt (T2 sáng trưa, T3 trưa tối ...)';
    const ORDER_EXTRA_REQUEST_CHANGE_MEAL_COURSE_LABEL_EN = 'Change meal (breakfast-lunch on Mon, lunch-dinner on Tue ...)';

    const ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_PRICE = 200000;
    const ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_VALUE = 'EXTRA_BREAKFAST';
    const ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL = 'Thêm phần ăn sáng dành cho gói MEAT LOVER';
    const ORDER_EXTRA_REQUEST_EXTRA_BREAKFAST_LABEL_EN = 'Add extra breakfast for MEAT LOVER';

    const ORDER_ITEM_MEAL_STATUS_PENDING_VALUE = 'PENDING';
    const ORDER_ITEM_MEAL_STATUS_FULFILLED_VALUE = 'FULFILLED';

    const DISCOUNT_TYPE_FIXED_AMOUNT_VALUED = 'FIXED_AMOUNT';
    const DISCOUNT_TYPE_PERCENTAGE_VALUED = 'PERCENTAGE';

    const TRANSACTION_TYPE_PAY_VALUE = 'PAY';
    const TRANSACTION_TYPE_REFUND_VALUE = 'REFUND';
    const TRANSACTION_TYPE_BALANCE_PRICE_VALUE = 'BALANCE_PRICE';
    const TRANSACTION_TYPE_BALANCE_PAY_VALUE = 'BALANCE_PAY';

    const MEAL_BREAKFAST_LABEL = 'BREAKFAST';
    const MEAL_LUNCH_LABEL = 'LUNCH';
    const MEAL_DINNER_LABEL = 'DINNER';
    const MEAL_FRUIT_LABEL = 'FRUIT';
    const MEAL_VEGGIES_LABEL = 'VEGGIES';
    const MEAL_JUICE_LABEL = 'JUICE';

    const MEAL_PACK_TYPE_PACK_VALUE = 0;
    const MEAL_PACK_TYPE_PRODUCT_VALUE = 1;
    const MEAL_PACK_TYPE_PACK_LABEL = 'Package';
    const MEAL_PACK_TYPE_PRODUCT_LABEL = 'Product';

    const STATUS_MENU_HIDE_VALUE = 0;
    const STATUS_MENU_CURRENT_VALUE = 1;
    const STATUS_MENU_LAST_WEEK_VALUE = 2;
    const STATUS_MENU_NEXT_WEEK_VALUE = 3;
    const STATUS_MENU_HIDE_LABEL = 'Hide';
    const STATUS_MENU_CURRENT_LABEL = 'Current';
    const STATUS_MENU_LAST_WEEK_LABEL = 'Last week';
    const STATUS_MENU_NEXT_WEEK_LABEL = 'Next week';

    const TYPE_MENU_NORMAL_VALUE = 0;
    const TYPE_MENU_VEGETARIAN_VALUE = 1;
    const TYPE_MENU_NORMAL_LABEL = 'Normal';
    const TYPE_MENU_VEGETARIAN_LABEL = 'Vegetarian';

    const STATUS_ARTICLE_FINISH_VALUE = 0;
    const STATUS_ARTICLE_PUBLISH_VALUE = 1;
    const STATUS_ARTICLE_DRAFT_VALUE = 2;
    const STATUS_ARTICLE_FINISH_LABEL = 'Finish';
    const STATUS_ARTICLE_PUBLISH_LABEL = 'Publish';
    const STATUS_ARTICLE_DRAFT_LABEL = 'Draft';

    const WIDGET_NAME_HOME_SLIDER = 'HOME_SLIDER';

    const WIDGET_HOME_SLIDER_IMAGE_MAX_WIDTH = 4100;
    const WIDGET_HOME_SLIDER_IMAGE_MAX_HEIGHT = 1860;

    const TYPE_WIDGET_SLIDER_VALUE = 0;
    const TYPE_WIDGET_SLIDER_LABEL = 'Slider';

    const SETTING_NAME_OFF_TIME = 'OFF_TIME';
    const SETTING_NAME_USD_EXCHANGE_RATE = 'USD_EXCHANGE_RATE';

    const TYPE_SETTING_JSON_VALUE = 0;
    const TYPE_SETTING_INT_VALUE = 1;
    const TYPE_SETTING_JSON_LABEL = 'Json';
    const TYPE_SETTING_INT_LABEL = 'Int';

    const BANNER_HOME_PAGE = 'home';
    const BANNER_ORDER_PAGE = 'order';
    const BANNER_MENU_PAGE = 'menu';
    const BANNER_BLOG_PAGE = 'blog';

    const BANNER_CUSTOMER_TYPE_NEW = 'New';
    const BANNER_CUSTOMER_TYPE_OLD = 'Old';

    const BANNER_TYPE_IMAGE_VALUE = 0;
    const BANNER_TYPE_VIDEO_VALUE = 1;
    const BANNER_TYPE_IMAGE_LABEL = 'Image';
    const BANNER_TYPE_VIDEO_LABEL = 'Video';

    const COOKIE_READ_ARTICLE_NAME = 'read_article';
    const COOKIE_READ_ORDER_POLICY_NAME = 'read_order_policy';
    const COOKIE_PLACE_ORDER_CUSTOMER_NAME = 'place_order';
    const COOKIE_SEE_BANNER_NAME = 'see_banner';
    const COOKIE_HIDE_ONLINE_SUPPORT_WINDOW_NAME = 'hide_online_support_window';

    const UPLOAD_IMAGE_DIR = '/assets/upload';

    public static function formatMoney($money)
    {
        if($money !== null && $money !== '')
        {
            $formatted = '';
            $sign = '';

            if($money < 0)
            {
                $money = -$money;
                $sign = '-';
            }

            while($money >= 1000)
            {
                $mod = $money % 1000;

                if($formatted != '')
                    $formatted = '.' . $formatted;
                if($mod == 0)
                    $formatted = '000' . $formatted;
                else if($mod < 10)
                    $formatted = '00' . $mod . $formatted;
                else if($mod < 100)
                    $formatted = '0' . $mod . $formatted;
                else
                    $formatted = $mod . $formatted;

                $money = (int)($money / 1000);
            }

            if($formatted != '')
                $formatted = $sign . $money . '.' . $formatted;
            else
                $formatted = $sign . $money;

            return $formatted;
        }

        return '';
    }

    public static function getShippingTime($value = null)
    {
        $times = [
            '8:00 - 8:30' => '8:00 - 8:30',
            '8:30 - 9:00' => '8:30 - 9:00',
            '9:00 - 9:30' => '9:00 - 9:30',
            '9:30 - 10:00' => '9:30 - 10:00',
            '10:00 - 10:30' => '10:00 - 10:30',
            '10:30 - 11:00' => '10:30 - 11:00',
            self::SHIPPING_TIME_NIGHT_BEFORE_VALUE => self::SHIPPING_TIME_NIGHT_BEFORE_LABEL,
        ];

        if($value !== null && isset($times[$value]))
            return $times[$value];

        return $times;
    }

    public static function getPaymentMethod($value = null, $lang = null)
    {
        if($lang == 'en')
        {
            $methods = [
                //self::PAYMENT_GATEWAY_BANK_NET_PAYPAL_VALUE => self::PAYMENT_GATEWAY_BANK_NET_PAYPAL_LABEL_EN,
                self::PAYMENT_GATEWAY_CASH_VALUE => self::PAYMENT_GATEWAY_CASH_LABEL_EN,
                self::PAYMENT_GATEWAY_MPOS_VALUE => self::PAYMENT_GATEWAY_MPOS_LABEL_EN,
                self::PAYMENT_GATEWAY_BANK_TRANSFER_VCB_VALUE => self::PAYMENT_GATEWAY_BANK_TRANSFER_VCB_LABEL_EN,
                self::PAYMENT_GATEWAY_BANK_TRANSFER_ACB_VALUE => self::PAYMENT_GATEWAY_BANK_TRANSFER_ACB_LABEL_EN,
                self::PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_VALUE => self::PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_LABEL_EN,
            ];
        }
        else
        {
            $methods = [
                //self::PAYMENT_GATEWAY_BANK_NET_PAYPAL_VALUE => self::PAYMENT_GATEWAY_BANK_NET_PAYPAL_LABEL,
                self::PAYMENT_GATEWAY_CASH_VALUE => self::PAYMENT_GATEWAY_CASH_LABEL,
                self::PAYMENT_GATEWAY_MPOS_VALUE => self::PAYMENT_GATEWAY_MPOS_LABEL,
                self::PAYMENT_GATEWAY_BANK_TRANSFER_VCB_VALUE => self::PAYMENT_GATEWAY_BANK_TRANSFER_VCB_LABEL,
                self::PAYMENT_GATEWAY_BANK_TRANSFER_ACB_VALUE => self::PAYMENT_GATEWAY_BANK_TRANSFER_ACB_LABEL,
                self::PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_VALUE => self::PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_LABEL,
            ];
        }

        if($value !== null && isset($methods[$value]))
            return $methods[$value];

        return $methods;
    }

    public static function getBankAccountNumber($value = null)
    {
        $numbers = [
            self::PAYMENT_GATEWAY_BANK_TRANSFER_VCB_VALUE => self::BANK_TRANSFER_VCB_ACCOUNT_NUMBER,
            self::PAYMENT_GATEWAY_BANK_TRANSFER_ACB_VALUE => self::BANK_TRANSFER_ACB_ACCOUNT_NUMBER,
            self::PAYMENT_GATEWAY_BANK_TRANSFER_HSBC_VALUE => self::BANK_TRANSFER_HSBC_ACCOUNT_NUMBER,
        ];

        if($value !== null && isset($numbers[$value]))
            return $numbers[$value];

        return $numbers;
    }

    public static function validatePhone($phone)
    {
        if(preg_match('/^0[0-9]{7,10}$/', $phone))
            return true;

        return false;
    }

    public static function generateRandomCodeByNumberCharacter($number)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $charactersLength = strlen($characters);

        $randomString = '';

        for($i = 0; $i < $number; $i++)
            $randomString .= $characters[rand(0, $charactersLength - 1)];

        return $randomString;
    }

    public static function getDiscountType($value = null)
    {
        $types = [
            self::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED => self::DISCOUNT_TYPE_FIXED_AMOUNT_VALUED,
            self::DISCOUNT_TYPE_PERCENTAGE_VALUED => self::DISCOUNT_TYPE_PERCENTAGE_VALUED,
        ];

        if($value !== null && isset($types[$value]))
            return $types[$value];

        return $types;
    }

    public static function getGender($value = null, $lang = null)
    {
        if($lang == 'en')
        {
            $genders = [
                self::GENDER_MALE_VALUE => self::GENDER_MALE_LABEL_EN,
                self::GENDER_FEMALE_VALUE => self::GENDER_FEMALE_LABEL_EN,
            ];
        }
        else
        {
            $genders = [
                self::GENDER_MALE_VALUE => self::GENDER_MALE_LABEL,
                self::GENDER_FEMALE_VALUE => self::GENDER_FEMALE_LABEL,
            ];
        }

        if($value !== null && isset($genders[$value]))
            return $genders[$value];

        return $genders;
    }

    public static function getRequestChangeIngredient($value = null, $lang = null)
    {
        if($lang == 'en')
        {
            $requests = [
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_COW_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_COW_LABEL_EN,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_FISH_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_FISH_LABEL_EN,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_CHICKEN_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_CHICKEN_LABEL_EN,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_PIG_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_PIG_LABEL_EN,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_SHRIMP_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_SHRIMP_LABEL_EN,
            ];
        }
        else
        {
            $requests = [
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_COW_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_COW_LABEL,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_FISH_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_FISH_LABEL,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_CHICKEN_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_CHICKEN_LABEL,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_PIG_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_PIG_LABEL,
                self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_SHRIMP_VALUE => self::ORDER_EXTRA_REQUEST_CHANGE_INGREDIENT_NO_SHRIMP_LABEL,
            ];
        }

        if($value !== null && isset($requests[$value]))
            return $requests[$value];

        return $requests;
    }

    public static function getCustomerCode($value = null)
    {
        $codes = [
            self::CUSTOMER_CODE_VN => self::CUSTOMER_CODE_VN,
            self::CUSTOMER_CODE_FR => self::CUSTOMER_CODE_FR,
        ];

        if($value !== null && isset($codes[$value]))
            return $codes[$value];

        return $codes;
    }

    public static function getMealPackType($value = null)
    {
        $types = [
            self::MEAL_PACK_TYPE_PACK_VALUE => self::MEAL_PACK_TYPE_PACK_LABEL,
            self::MEAL_PACK_TYPE_PRODUCT_VALUE => self::MEAL_PACK_TYPE_PRODUCT_LABEL,
        ];

        if($value !== null && isset($types[$value]))
            return $types[$value];

        return $types;
    }

    public static function getStatus($value = null)
    {
        $status = [
            self::STATUS_INACTIVE_VALUE => self::STATUS_INACTIVE_LABEL,
            self::STATUS_ACTIVE_VALUE => self::STATUS_ACTIVE_LABEL,
        ];

        if($value !== null && isset($status[$value]))
            return $status[$value];

        return $status;
    }

    public static function getMenuType($value = null)
    {
        $types = [
            self::TYPE_MENU_NORMAL_VALUE => self::TYPE_MENU_NORMAL_LABEL,
            self::TYPE_MENU_VEGETARIAN_VALUE => self::TYPE_MENU_VEGETARIAN_LABEL,
        ];

        if($value !== null && isset($types[$value]))
            return $types[$value];

        return $types;
    }

    public static function getMenuStatus($value = null)
    {
        $status = [
            self::STATUS_MENU_HIDE_VALUE => self::STATUS_MENU_HIDE_LABEL,
            self::STATUS_MENU_CURRENT_VALUE => self::STATUS_MENU_CURRENT_LABEL,
            self::STATUS_MENU_LAST_WEEK_VALUE => self::STATUS_MENU_LAST_WEEK_LABEL,
            self::STATUS_MENU_NEXT_WEEK_VALUE => self::STATUS_MENU_NEXT_WEEK_LABEL,
        ];

        if($value !== null && isset($status[$value]))
            return $status[$value];

        return $status;
    }

    public static function getArticleStatus($value = null)
    {
        $status = [
            self::STATUS_ARTICLE_FINISH_VALUE => self::STATUS_ARTICLE_FINISH_LABEL,
            self::STATUS_ARTICLE_PUBLISH_VALUE => self::STATUS_ARTICLE_PUBLISH_LABEL,
            self::STATUS_ARTICLE_DRAFT_VALUE => self::STATUS_ARTICLE_DRAFT_LABEL,
        ];

        if($value !== null && isset($status[$value]))
            return $status[$value];

        return $status;
    }

    public static function getWidgetType($value = null)
    {
        $types = [
            self::TYPE_WIDGET_SLIDER_VALUE => self::TYPE_WIDGET_SLIDER_LABEL,
        ];

        if($value !== null && isset($types[$value]))
            return $types[$value];

        return $types;
    }

    public static function formatPhone($phone)
    {
        if(strlen($phone) >= 10)
            return substr($phone, 0, 4) . '-' . substr($phone, 4, 3) . '-' . substr($phone, 7);

        return $phone;
    }

    public static function getValidImageExt()
    {
        return ['jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'];
    }

    public static function getValidExcelExt()
    {
        return ['xls', 'xlsx', 'csv', 'XLS', 'XLSX', 'CSV'];
    }

    public static function cropImage($imagePath, $width, $height)
    {
        $image = Image::make($imagePath);

        $imageWidth = $image->width();
        $imageHeight = $image->height();

        if($imageWidth > $width && $imageHeight > $height)
            $image->resize($width, $height);
        else if($imageWidth > $width)
            $image->resize($width, $imageHeight);
        else if($imageHeight > $height)
            $image->resize($imageWidth, $height);

        $image->save($imagePath);
    }

    public static function getBannerPage($value = null)
    {
        $pages = [
            self::BANNER_HOME_PAGE => self::BANNER_HOME_PAGE,
            self::BANNER_MENU_PAGE => self::BANNER_MENU_PAGE,
            self::BANNER_ORDER_PAGE => self::BANNER_ORDER_PAGE,
            self::BANNER_BLOG_PAGE => self::BANNER_BLOG_PAGE,
        ];

        if($value !== null && isset($pages[$value]))
            return $pages[$value];

        return $pages;
    }

    public static function getBannerCustomerType($value = null)
    {
        $types = [
            self::BANNER_CUSTOMER_TYPE_NEW => self::BANNER_CUSTOMER_TYPE_NEW,
            self::BANNER_CUSTOMER_TYPE_OLD => self::BANNER_CUSTOMER_TYPE_OLD,
        ];

        if($value !== null && isset($types[$value]))
            return $types[$value];

        return $types;
    }

    public static function getBannerType($value = null)
    {
        $types = [
            self::BANNER_TYPE_IMAGE_VALUE => self::BANNER_TYPE_IMAGE_LABEL,
            self::BANNER_TYPE_VIDEO_VALUE => self::BANNER_TYPE_VIDEO_LABEL,
        ];

        if($value !== null && isset($types[$value]))
            return $types[$value];

        return $types;
    }

    public static function getSettingType($value = null)
    {
        $types = [
            self::TYPE_SETTING_JSON_VALUE => self::TYPE_SETTING_JSON_LABEL,
            self::TYPE_SETTING_INT_VALUE => self::TYPE_SETTING_INT_LABEL,
        ];

        if($value !== null && isset($types[$value]))
            return $types[$value];

        return $types;
    }
}