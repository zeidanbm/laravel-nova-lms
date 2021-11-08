<?php

namespace App\Options;

class Type
{
	public static function get()
	{
		return [
			1 => __('Folder'),
			2 => __('Series'),
			3 => __('Picture Book'),
			4 => __('Manuscript'),
			5 => __('Book'),
			6 => __('Rare Book'),
			7 => __('News Paper'),
			8 => __('Magazine'),
			9 => __('Specialized Magazine'),
			10 => __('Quote')
		];
	}
}