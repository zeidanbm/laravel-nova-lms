<?php

namespace App\Jobs;

use Elasticsearch\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SaveToElastic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
     * @var Array
     */
    private $params;
    
    /**
     * @var string
     */
    private $index;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params, $index='catalogs')
    {
        $this->params = $params;
        $this->index = $index;
    }

    /**
     * Execute the job.
     * @param Client
     * @return void
     */
    public function handle(Client $client)
    {
        $client->index([
            'index' => $this->index,
            'id' => $this->params['model_id'],
            'body' => $this->params
        ]);
    }
}
