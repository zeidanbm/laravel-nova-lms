<?php

namespace App\Options;

class Language
{
	public static function get()
	{
		return [
			1 => __('Arabic'),
			2 => __('English'),
			3 => __('French'),
			4 => __('Farsi')
		];
	}
}