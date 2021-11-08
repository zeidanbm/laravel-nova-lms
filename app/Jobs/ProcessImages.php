<?php

namespace App\Jobs;

use App\Models\Cover;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Intervention\Image\ImageManagerStatic as IMG;

class ProcessImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
    protected $name;
    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $path)
    {
        $this->name = $name;
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $image = Storage::disk('do_spaces')->get($this->path . $this->name);
        $base_url = Config::get('app.do_spaces_url');
        
        $thumbnail = IMG::make($image)->fit(140, 210)->encode('jpg', 90);
        $medium = IMG::make($image)->fit(210, 315)->encode('jpg', 90);
        $large = IMG::make($image)->fit(420, 630)->encode('jpg', 90);

        Storage::disk('do_spaces')->put($this->path . 'thumbnail-' . $this->name, $thumbnail);
        Storage::disk('do_spaces')->put($this->path . 'medium-' . $this->name, $medium);
        Storage::disk('do_spaces')->put($this->path . 'large-' . $this->name, $large);
        
        DB::table('covers')
            ->where('url', $this->path . $this->name)
            ->update(['details' => json_encode(
                [
                    'thumbnail' => $base_url . $this->path . 'thumbnail-' . $this->name,
                    'medium' => $base_url . $this->path . 'medium-' . $this->name,
                    'large' => $base_url . $this->path . 'large-' . $this->name
                ])
            ]);
    }
}
