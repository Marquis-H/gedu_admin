<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 2019/2/13
 * Time: 3:55 PM
 */

namespace Admin\Helper;

use GuzzleHttp\Client as GuzzleHttpClient;

class Client extends GuzzleHttpClient
{
	/**
	 * @var \GuzzleHttp\Client
	 */
	private static $instance;

	/**
	 * @return GuzzleHttpClient
	 */
	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new Client([]);
		}
		return static::$instance;
	}

	/**
	 * Client constructor.
	 *
	 * @param array $config
	 */
	public function __construct(array $config)
	{
		parent::__construct($config);
	}

	/**
	 *
	 */
	private function __clone()
	{
	}

	/**
	 *
	 */
	private function __wakeup()
	{
	}
}