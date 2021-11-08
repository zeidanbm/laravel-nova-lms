<?php

namespace App\Providers;

use App\Models\Amel;
use App\Models\Book;
use App\Models\File;
use App\Models\Cover;
use App\Models\Image;
use App\Models\Quote;
use App\Models\Series;
use App\Models\Periodic;
use App\Models\Publication;
use App\Composers\HomeComposer;
use App\Observers\AmelObserver;
use App\Observers\BookObserver;
use App\Observers\FileObserver;
use App\Observers\CoverObserver;
use App\Observers\ImageObserver;
use App\Observers\QuoteObserver;
use App\Observers\SeriesObserver;
use App\Observers\PeriodicObserver;
use App\Observers\PublicationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Book::observe(BookObserver::class);
        Series::observe(SeriesObserver::class);
        Periodic::observe(PeriodicObserver::class);
        Quote::observe(QuoteObserver::class);
        Amel::observe(AmelObserver::class);
        Publication::observe(PublicationObserver::class);
        Cover::observe(CoverObserver::class);
        File::observe(FileObserver::class);
        Image::observe(ImageObserver::class);
        
        view()->composer('*', HomeComposer::class);
    }
}
