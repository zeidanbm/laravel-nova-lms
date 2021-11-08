<?php

namespace App\Options;

class Status
{
	public static function get()
	{
		return [
			'draft' => __('Draft'),
			'publish' => __('Published')
		];
	}
}