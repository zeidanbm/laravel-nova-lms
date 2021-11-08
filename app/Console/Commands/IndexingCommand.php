<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Throwable;
use App\Models\Book;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class IndexingCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'laravel-elasticsearch:index:indexing
                            {index-name : The index name}
                            {model-name : The model to index}
                            {--relations= : The model relations to load}';

    /**
     * @var Client
     */
    private $client;

    public function __construct(
        Client $client
    ) {
        $this->client = $client;

        parent::__construct();
    }

    public function handle(): int
    {
        $indexName = $this->argument('index-name');
        $modelName = $this->argument('model-name');
        $modelRelations = $this->option('relations');

        if (!$this->argumentIsValid($indexName, $modelName, $modelRelations)) {
            return self::FAILURE;
        }

        if (!$this->client->indices()->exists([
            'index' => $indexName,
        ])) {
            $this->output->writeln(
                sprintf(
                    '<error>Index %s does not exist.</error>',
                    $indexName
                )
            );

            return self::FAILURE;
        }

        try {
            $this->saveInElastic($indexName, $modelName, $modelRelations);
        } catch (Throwable $exception) {
            $this->output->writeln(
                sprintf(
                    '<error>Error indexing %s, exception message: %s.</error>',
                    $indexName,
                    $exception->getMessage()
                )
            );

            return self::FAILURE;
        }

        $this->output->writeln(
            sprintf(
                '<info>Indexing of %s completed.</info>',
                $indexName
            )
        );

        return self::SUCCESS;
    }

    private function argumentIsValid($indexName, $modelName, $modelRelations): bool
    {
        if ($indexName === null ||
            !is_string($indexName) ||
            mb_strlen($indexName) === 0
        ) {
            $this->output->writeln(
                '<error>Argument index-name must be a non empty string.</error>'
            );

            return false;
        }
        
        if ($modelName === null ||
            !is_string($modelName) ||
            mb_strlen($modelName) === 0 ||
            !class_exists($modelName)
        ) {
            $this->output->writeln(
                '<error>Argument model-name must be an existing model and must be a non empty string.</error>'
            );

            return false;
        }
        
        if (
            !method_exists($modelName, 'toElastic')
        ) {
            $this->output->writeln(
                sprintf(
                    '<error>%s must implement a public static function toElastic($item) on the model.</error>',
                    $modelName
                )
            );

            return false;
        }
        
        if (
            $modelRelations &&
            !is_string($modelRelations)
        ) {
           
            $this->output->writeln(
                '<error>Model relations must be a string.</error>'
            );

            return false;
        }

        return true;
    }
    
    /**
     * Save Model in Elasticsearch
     *
     * @param string $indexName
     * @param string $modelName
     * @param array $modelRelations
     * @return void
   */
    private function saveInElastic($indexName, $modelName, $modelRelations): void
    {
        $modelRelations = $modelRelations ? explode(',', $modelRelations) : [];
        
        $modelName::with($modelRelations)->chunk(200, function($items, $index) use($indexName, $modelName){
            foreach ($items as $item){
                $this->client->index([
                    'index' => $indexName,
                    'id' => $item->id,
                    'body' => $modelName::toElastic($item)
                ]);
            }
            
            $this->output->writeln(
                sprintf(
                    '<info>%d %s indexed successfully.</info>',
                    count($items),
                    $indexName
                )
            );
        });
    }
}
