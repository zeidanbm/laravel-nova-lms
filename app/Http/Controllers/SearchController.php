<?php

namespace App\Http\Controllers;

use Elasticsearch\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\BaseController;

class SearchController extends BaseController
{
  /**
   * @var Client
   */
  private $client;
  
  /**
   * @var string
   */
  private $term;
  
  /**
   * @var integer
   */
  private $per_page;
  
  /**
   * @var integer
   */
  private $page;
  
  /**
   * @var array
   */
  private $book_fields;
  
  /**
   * @var array
   */
  private $other_fields;
  
  /**
   * @var array
   */
  private $topics;
  
  /**
   * @var array
   */
  private $sub_topics;
  
  /**
   * @var array
   */
  private $types;

  public function __construct(Client $client, Request $request) {
    $this->client = $client;
    
    $this->term = ltrim($request->s);
    $this->page = $request->has('page') ? $request->page : 1;
    $this->per_page = $request->has('per_page') ? $request->per_page : 20;
    $this->book_fields = explode(',', ltrim($request->book_fields));
    $this->topics = explode(',', ltrim($request->topics));
    $this->sub_topics = explode(',', ltrim($request->sub_topics));
    $this->types = $request->types ? explode(',', ltrim($request->types)) : $this->getTypes();
    $this->other_fields = [
      'title^10',
      'title.text^8',
      'title.stemmed^6',
      'authors^10',
      'authors.text^8',
      'body^8'
    ];
  }
  
  /**
   * Perform Elasticsearch and return results
   *
   * @return \Illuminate\Http\Response
   */
  public function search()
  {
    $params = $this->buildElasticParams();
    
    $response = $this->client->search($params);
    
    return $this->sendSuccess(
        'Autocomplete retrieved successfully.',
        [
            'data' => $this->parseResults($response)
        ]
    );
  }
  
  private function buildElasticParams()
  {
    $query = $this->buildSearchQuery();
    $aggs = $this->buildAggsQuery();

    $from = ($this->page * $this->per_page) - $this->per_page;
    
    return [
      'index' => 'catalogs',
      '_source' => [
        'compress' => true,
        'type',
        'model_id',
        'format',
        'series_id',
        'title',
        'sub_title',
        'series_title',
        'topic',
        'subtopic',
        'authors',
        'cover_thumbnail',
        'tags',
        'publishers',
        'sources',
        'body',
        'slug'
      ],
      'body' => [
        'from' => intval($from),
        'size' => intval($this->per_page),
        'query' => $query,
        'aggs' => $aggs
      ]
    ];
  }

  private function buildSearchQuery()
  {
    $topic_filters = $this->buildTopicFilters();
    $subtopic_filters = (count($this->sub_topics)) ? $this->buildTopicFilters() : [];
    $type_query = $this->buildTypeQuery();

    return [
      'bool' => [
        'must' => [
          'query_string' => [
            'query' => $type_query . ' AND status:publish'
          ]
        ],
        'must' => [
          'multi_match' => [
            'query' => $this->term,
            'fields' => $this->book_fields
          ],
          'multi_match' => [
            'query' => $this->term,
            'fields' => $this->other_fields
          ]
        ]
      ],
    ];
  }
  
  private function buildFields()
  {
    $fields = [];
    
    foreach ($this->book_fields as $key => $value) {
      $fields = array_merge($fields, $this->{$value});
    }
    
    return $fields;
  }
  
  private function buildSubTopicFilters()
  {
    return [
      'terms' => [
        'subtopic' => $this->sub_topics
      ]
    ];
  }
  
  private function buildTopicFilters()
  {
    return [
      'terms' => [
        'topic' => $this->topics
      ]
    ];
  }
  
  private function buildTypeQuery()
  {
    $query = '(';
    foreach ($this->types as $key => $value) {
      $query .= "type:" . $value . " OR ";
    }
    $query = substr_replace($query, ')', -4, -1);

    return $query;
  }

  private function buildAggsQuery()
  {
    return [
      "types" => [
        "terms" => [
          "field" => "type",
          "min_doc_count" => 0
        ]
      ],
      "topic" => [
        "terms" => [
          "field" => "topic",
          "min_doc_count" => 0
        ]
      ],
      "subtopic" => [
        "terms" => [
          "field" => "subtopic",
          "min_doc_count" => 0
        ]
      ],
      "authors" => [
        "terms" => [
          "field" => "authors"
        ]
      ],
      "tags" => [
        "terms" => [
          "field" => "tags"
        ]
      ]
    ];
  }

  private function parseResults($res)
  {
    return [
      'total' => $this->getTotalHits($res),
      'results' => $res['hits']['hits'],
      'aggregations' => $res['aggregations']
    ];
  }

  /**
   * Returns the number of total results that Elasticsearch found for the given query
   *
   * @param array $response Response to get total hits from.
   * @return int
   */
  private function getTotalHits($res)
  {
    if ($this->isEmpty($res)) {
      return 0;
    }

    return $res['hits']['total'];
  }

  /**
   * Check if a response array contains results or not
   *
   * @param array $response Response to check.
   * @return bool
   */
  private function isEmpty($response)
  {
    if (!is_array($response)) {
      return true;
    }

    if (isset($response['error'])) {
      return true;
    }

    if (empty($response['hits'])) {
      return true;
    }

    if (isset($response['hits']['total']) && 0 === (int) $response['hits']['total']) {
      return true;
    }

    return false;
  }
  
  private function getTypes()
  {
    return array_merge($this->getBookTypes(), $this->getOtherTypes());
  }
  
  private function getOtherTypes()
  {
    return [
      'Periodic',
      'Quote',
      'Amel'
    ];
  }
  
  private function getBookTypes()
  {
    return [
      'Book',
      'Folder',
      'Series'
    ];
  }
}
