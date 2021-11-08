<?php

namespace App\Options;

class Format
{
	public static function get()
	{
		return [
			1 => __('Electronic'),
			2 => __('Digital'),
			3 => __('Paper')
		];
	}
}