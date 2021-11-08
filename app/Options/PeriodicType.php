<?php

namespace App\Options;

class PeriodicType
{
	public static function get()
	{
		return [
			7 => __('News Paper'),
			8 => __('Magazine'),
			9 => __('Specialized Magazine')
		];
	}
}