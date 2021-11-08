<?php

namespace App\Http\Controllers;

use Elasticsearch\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

class AutocompleteController extends BaseController
{
  /**
   * @var Client
   */
  private $client;
  
  /**
   * @var string
   */
  private $term;

  public function __construct(Client $client, Request $request) {
    $this->client = $client;
    $this->term = ltrim($request->s);
  }
  
  /**
 * Perform ElasticSearch Autocompletion
 * Returns 5 results max
 *
 * @return \Illuminate\Http\Response
 */
  public function autocomplete()
  {
    $query = $this->buildSearchQuery();

    $params = [
      'index' => 'catalogs',
      '_source' => [
        'model_id',
        'slug'
      ],
      'body' => $query
    ];
    $response = $this->client->search($params);
    
    return $this->sendSuccess(
        'Autocomplete retrieved successfully.',
        [
            'data' => $this->parseResults($response)
        ]
    );
  }

  private function parseResults($res)
  {
    return $res['suggest']['suggestions'][0];
  }
  
  private function buildSearchQuery()
  {
    return [
      'suggest' => [
        'suggestions' => [
          'prefix' => $this->term,
          'completion' => [
            'field' => 'suggest',
            'size' => 5,
            'skip_duplicates' => true,
            'fuzzy' => [
              'fuzziness' => 1,
              'prefix_length' => 2
            ]
          ]
        ]
      ]
    ];
  }
}
