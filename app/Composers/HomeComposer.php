<?php namespace App\Composers;

use App\Options\Menu;
use App\Options\Social;
use App\Options\FooterMenu;
use App\Options\FooterContact;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class HomeComposer
{
  public function compose($view)
  {
		$locale = Config::get('app.locale');
		App::setLocale($locale);
		$data = [
				'menu_items' => Menu::get(),
				'menu_footer_items' => FooterMenu::get(),
				'footer_contacts' => FooterContact::get(),
				'footer_social' => Social::get(),
				'locale' => $locale,
				'direction' => ($locale === 'ar') ? 'rtl' : 'ltr'
		];

		$view->with($data);
  }
}