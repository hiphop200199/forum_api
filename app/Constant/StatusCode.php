<?php

namespace App\Constant;

class StatusCode{
    public const STOCK_REASON_PURCHASE = 1;
    public const STOCK_REASON_SALE = 2;
    public const SALE_CUSTOMER_RETAIL = 2;
    public const PURCHASE_WAIT = 1;
    public const PURCHASE_OK = 2;
    public const PAYMENT_CREDIT_CARD = 2;
    public const NOT_ACTIVE = 1;
    public const ACTIVE = 2;
    public const SUCCESS = 1;
    public const FAIL = -1;
    public const FORMAT_ERROR = -2;
    public const CAPTCHA_ERROR = -3;
    public const ACCOUNT_NOT_EXIST = -4;
    public const ACCOUNT_OR_PASSWORD_ERROR = -5;
    public const ACCOUNT_IS_INACTIVE = -6;
    public const EMAIL_FORMAT_ERROR = -7;
    public const AUTH_ERROR = -8;
    public const RESET_LINK_FAIL = -9;
    public const STRIPE_SESSION_NOT_EXIST = -10;
    public const ORDER_NOT_EXIST = -11;

}
