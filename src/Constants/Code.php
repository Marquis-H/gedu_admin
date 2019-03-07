<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/1/30
 * Time: 6:31 PM
 */

namespace Admin\Constants;

abstract class Code
{
	const SERVER_ERROR = 10000;
	const INVALID_REQUEST_DATA = 10001;
	const INVALID_VERIFICATION_CODE = 10002;

	const USER_NOT_EXIST = 1001;
	const USER_DISABLE = 1002;
	const VALIDATE_CODE_ERROR = 1003;

	/**
	 * @param $code
	 * @return string
	 */
	static public function getMessage($code)
	{
		switch ($code) {
			case self::INVALID_REQUEST_DATA:
				return '提交数据错误';
			case self::INVALID_VERIFICATION_CODE:
				return '验证码错误';
			case self::USER_NOT_EXIST:
				return '用户不存在';
			case self::USER_DISABLE:
				return '用户被禁用';
			case self::VALIDATE_CODE_ERROR:
				return '验证码错误或已被使用，请重新获取验证码';
			case self::SERVER_ERROR:
				return '服务器错误';
		}

		return '服务器错误';
	}
}