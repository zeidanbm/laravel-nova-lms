<?php

namespace App\Options;

class Quality
{
	public static function get()
	{
		return [
			1 => __('Great'),
			2 => __('Good'),
			3 => __('Fair'),
			4 => __('Bad')
		];
	}
}