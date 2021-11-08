<?php

namespace App\Options;

class Interval
{
	public static function get()
	{
		return [
			1 => __('Monthly'),
			2 => __('Bi-Monthly'),
			3 => __('Seasonal'),
			4 => __('Half-Yearly'),
			5 => __('Yearly'),
			6 => __('Weekly'),
			7 => __('Half-Monthly')
		];
	}
}