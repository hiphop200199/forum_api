<?php

namespace App\Constant;

class StatusDescription{
    public const SUCCESS = '成功';
    public const FAIL = '失敗';
    public const FORMAT_ERROR = '格式錯誤';
    public const CAPTCHA_ERROR = '驗證碼錯誤';
    public const ACCOUNT_NOT_EXIST = '帳號不存在';
    public const AUTH_ERROR = '無權限';
    public const RESET_LINK_FAIL = '連結無效';
    public const CHECK_EMAIL = '請檢查信箱';
    public const STRIPE_SESSION_NOT_EXIST = 'STRIPE交易紀錄不存在';
    public const ORDER_NOT_EXIST = '訂單不存在';
}
