<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Elasticsearch\Client;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteFromElastic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    private $id;
    
    /**
     * @var string
     */
    private $index;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id, $index='catalogs')
    {
        $this->id = $id;
        $this->index = $index;
    }

    /**
     * Execute the job.
     * @param Client
     * @return void
     */
    public function handle(Client $client)
    {
        $client->delete([
            'index'       => $this->index,
            'id'          => $this->id
        ]);
    }
}
