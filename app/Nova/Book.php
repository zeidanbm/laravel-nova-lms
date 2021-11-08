<?php

namespace App\Nova;

use App\Models\Topic;
use App\Options\Format;
use App\Options\Status;
use Laravel\Nova\Panel;
use App\Options\Edition;
use App\Options\Quality;
use App\Options\BookType;
use App\Options\Language;
use App\Nova\Lenses\Drafts;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use App\Nova\Actions\IsOwned;
use Laravel\Nova\Fields\Text;
use App\Nova\Actions\IsChosen;
use App\Nova\Lenses\Published;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Nova\Filters\UserFilter;
use Laravel\Nova\Fields\Boolean;
use App\Nova\Filters\TopicFilter;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Textarea;
use App\Nova\Filters\StatusFilter;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\BookTypeFilter;
use App\Nova\Filters\SubtopicFilter;
use Afkartech\MultiselectField\Multiselect;
use App\Nova\Filters\IsFeaturedOwnedFilter;
use App\Nova\Lenses\CreatedItems;
use Laravel\Nova\Http\Requests\NovaRequest;
use Orlyapps\NovaBelongsToDepend\NovaBelongsToDepend;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class Book extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Book::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title'
    ];
    
    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Books');
    }
    
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Book');
    }
    
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Catalogs';
    
    /**
     * The side nav menu order.
     *
     * @var int
     */
    public static $priority = 1;
    
    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['topic','subtopic','authors','sources','publishers','tags'];
    
    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon() 
    {
        return view('icons.book')->render();
    }
    
    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        $details = optional($this->model())->details;
        
        return [
            ID::make(__('ID'), 'id')->sortable(),
            
            new Panel(__('General Indexing'), $this->generalFields($details)),
            
            new Panel(__('Main Fields'), $this->mainFields($details)),
            
            new Panel(__('Topic Indexing'), $this->topicFields()),
            
            MorphOne::make(__('Cover Photo'), 'cover', 'App\Nova\Cover'),
            
            MorphOne::make(__('File'), 'file', 'App\Nova\File'),
        ];
    }
    
    /**
     * Get the general fields for the resource.
     *
     * @return array
     */
    protected function generalFields($details)
    {
        return [

            Text::make(__('ID'), 'id')
                ->rules('required')
                ->creationRules('unique:books,id')
                ->updateRules('unique:books,id,{{resourceId}}')
                ->hideFromDetail()
                ->hideFromIndex(),
            
            Select::make(__('Status'), 'status')
                    ->rules('required')
                    ->options(Status::get())
                    ->default('draft')
                    ->displayUsingLabels()
                    ->hideFromIndex(),
            
            NovaDependencyContainer::make([
                Multiselect::make(__('Sources'), 'sources')
                            ->belongsToMany(\App\Nova\Source::class)
                            ->rules('exclude_if:status,draft', 'required')
                            ->taggable(),
            ])->dependsOn('no_source', 0),
            
            Boolean::make(__('No Source'), 'no_source')
                    ->withMeta(['value' => $details['no_source'] ?? 0])
                    ->onlyOnForms(),
            
            NovaDependencyContainer::make([
                Number::make(__('Acquisition Year'), 'acquisition_year')
                        ->rules('exclude_if:status,draft', 'required', 'numeric', 'min:1900', 'max:2100')
                        ->hideFromIndex(),
            ])->dependsOn('no_acquisition_year', 0),
            
            Boolean::make(__('No Acquisition Year'), 'no_acquisition_year')
                    ->withMeta(['value' => $details['no_acquisition_year'] ?? 0])
                    ->onlyOnForms(),
            
            
        ];    
    }
    
    /**
     * Get the main fields for the resource.
     *
     * @return array
     */
    protected function mainFields($details)
    {
        return [
            Select::make(__('Book Format'), 'format_id')
                    ->rules('required')
                    ->options(Format::get())
                    ->default(1)
                    ->displayUsingLabels()
                    ->hideFromIndex(),
            
            Select::make(__('Book Type'), 'type_id')
                    ->rules('required')
                    ->options(BookType::get())
                    ->default(5)
                    ->displayUsingLabels(),
            
            NovaDependencyContainer::make([
                Text::make(__('ISBN'), 'isbn')
                    ->rules('exclude_if:status,draft', 'required')
                    ->hideFromIndex(),
            ])->dependsOn('no_isbn', 0),
            
            Boolean::make(__('No ISBN'), 'no_isbn')
                    ->withMeta(['value' => $details['no_isbn'] ?? 0])
                    ->onlyOnForms(),
                    
            NovaDependencyContainer::make([
                BelongsTo::make(__('Series'), 'series', 'App\Nova\Series')
                        ->rules('exclude_if:status,draft', 'required')
                        ->searchable()
                        ->showCreateRelationButton()
                        ->hideFromIndex(),
                
                Number::make(__('Series Book Number'), 'series_book_number', function() use($details){
                            return $details['series_book_number'] ?? NULL;
                        })->hideFromIndex(),
            ])->dependsOn('type_id', '2'),
                
            Text::make(__('Title'), 'title')
                ->sortable()
                ->rules('required', 'max:200')
                ->creationRules('unique:books,title')
                ->updateRules('unique:books,title,{{resourceId}}')
                ->displayUsing(function ($name) {
                    return '<span class="max-w-md">' . $name . '</span>';
                })->asHtml(),
            
            NovaDependencyContainer::make([
                
                NovaDependencyContainer::make([
                    Text::make(__('Sub-Title'), 'sub_title')
                        ->rules('max:200')
                        ->creationRules('unique:books,sub_title')
                        ->updateRules('unique:books,sub_title,{{resourceId}}'),
                ])->dependsOn('no_sub_title', 0),
                
                Boolean::make(__('No Sub-Title'), 'no_sub_title')
                    ->withMeta(['value' => $details['no_sub_title'] ?? 0])
                    ->onlyOnForms(),
                    
            ])->dependsOnNot('type_id', '1'),
            
            NovaDependencyContainer::make([
                Select::make(__('Edition'), 'edition', function() use($details) {
                            return $details['edition'] ?? NULL;
                        })
                        ->rules('exclude_if:status,draft', 'required')
                        ->options(Edition::get())
                        ->displayUsingLabels()
                        ->hideFromIndex(),
            ])->dependsOn('no_edition', 0),
            
            Boolean::make(__('No Edition'), 'no_edition')
                    ->withMeta(['value' => $details['no_edition'] ?? 0])
                    ->onlyOnForms(),
            
            NovaDependencyContainer::make([
                Multiselect::make(__('Authors'), 'authors')
                            ->belongsToMany(\App\Nova\Author::class)
                            ->rules('exclude_if:status,draft', 'required')
                            ->taggable(),
            ])->dependsOn('no_author', 0),
            
            Multiselect::make(__('Authors'), 'authors')
                        ->belongsToMany(\App\Nova\Author::class)
                        ->onlyOnIndex(),
            
            Boolean::make(__('No Author'), 'no_author')
                    ->withMeta(['value' => $details['no_author'] ?? 0])
                    ->onlyOnForms(),
            
            NovaDependencyContainer::make([
                Text::make(__('Translated By'), 'translated_by', function() use($details) {
                        return $details['translated_by'] ?? NULL;
                    })
                    ->rules('exclude_if:status,draft', 'required', 'max:200')
                    ->hideFromIndex(),
            ])->dependsOn('no_translator', 0),
            
            Boolean::make(__('No Translator'), 'no_translator')
                    ->withMeta(['value' => $details['no_translator'] ?? 0])
                    ->onlyOnForms(),
                                        
            NovaDependencyContainer::make([
                Text::make(__('Inspected By'), 'inspected_by', function() use($details){
                            return $details['inspected_by'] ?? NULL;
                    })
                    ->rules('exclude_if:status,draft', 'required', 'max:200')
                    ->hideFromIndex(),
            ])->dependsOn('no_inspector', 0),
            
            Boolean::make(__('No Inspector'), 'no_inspector')
                    ->withMeta(['value' => $details['no_inspector'] ?? 0])
                    ->onlyOnForms(),
                    
            NovaDependencyContainer::make([
                Text::make(__('Documented By'), 'documented_by', function() use($details){
                            return $details['documented_by'] ?? NULL;
                    })
                    ->rules('exclude_if:status,draft', 'required', 'max:200')
                    ->hideFromIndex(),
            ])->dependsOn('no_documentor', 0),
            
            Boolean::make(__('No Documentor'), 'no_documentor')
                    ->withMeta(['value' => $details['no_documentor'] ?? 0])
                    ->onlyOnForms(),
            
            NovaDependencyContainer::make([
                Multiselect::make(__('Publishers'), 'publishers')
                            ->belongsToMany(\App\Nova\Publisher::class)
                            ->rules('exclude_if:status,draft', 'required')
                            ->taggable(),
            ])->dependsOn('no_publisher', 0),
            
            Boolean::make(__('No Publisher'), 'no_publisher')
                    ->withMeta(['value' => $details['no_publisher'] ?? 0])
                    ->onlyOnForms(),
                    
            NovaDependencyContainer::make([
                Text::make(__('Publishing Location'), 'publishing_location')
                    ->rules('exclude_if:status,draft', 'required')
                    ->hideFromIndex(),
            ])->dependsOn('no_publishing_location', 0),
            
            Boolean::make(__('No Publishing Location'), 'no_publishing_location')
                    ->withMeta(['value' => $details['no_publishing_location'] ?? 0])
                    ->onlyOnForms(),
            
            NovaDependencyContainer::make([
                Select::make(__('Publishing Year Type'), 'publishing_year_type' , function() use($details){
                            return $details['publishing_year_type'] ?? NULL;
                        })
                        ->rules('required')
                        ->options([
                            1 => __('Gregorian'),
                            2 => __('Hijri')
                        ])
                        ->default(1)
                        ->displayUsingLabels()
                        ->hideFromIndex(),
                    
                Number::make(__('Publishing Year'), 'publishing_year')
                        ->rules('exclude_if:status,draft', 'required', 'numeric', 'min:1', 'max:2100')
                        ->hideFromIndex(),
            ])->dependsOn('no_publishing_year', 0),
            
            Boolean::make(__('No Publishing Year'), 'no_publishing_year')
                    ->withMeta(['value' => $details['no_publishing_year'] ?? 0])
                    ->onlyOnForms(),                
                     
            Number::make(__('Total Pages'), 'total_pages', function() use($details){
                        return $details['total_pages'] ?? NULL;
                    })
                    ->hideFromIndex(),
            
            NovaDependencyContainer::make([
                Number::make(__('Total Available Books'), 'total_available_books', function() use($details){
                            return $details['total_available_books'] ?? NULL;
                        })->hideFromIndex(),
                Number::make(__('Missing Books'), 'missing_books', function() use($details){
                            return $details['missing_books'] ?? NULL;
                        })->hideFromIndex(),
            ])->dependsOn('type_id', '1'),
            
            NovaDependencyContainer::make([
                Text::make(__('Appendices'), 'appendices', function() use($details){
                        return $details['appendices'] ?? NULL;
                    })
                    ->rules('exclude_if:status,draft', 'required', 'max:200')
                    ->hideFromIndex(),
            ])->dependsOn('no_appendices', 0),
            
            Boolean::make(__('No Appendices'), 'no_appendices')
                    ->withMeta(['value' => $details['no_appendices'] ?? 0])
                    ->onlyOnForms(),
                
            Select::make(__('Quality'), 'quality_id')
                    ->rules('required')
                    ->options(Quality::get())
                    ->default(1)
                    ->displayUsingLabels()
                    ->hideFromIndex(),
            
            Select::make(__('Language'), 'language_id')
                    ->rules('required')
                    ->options(Language::get())
                    ->default(1)
                    ->displayUsingLabels()
                    ->hideFromIndex(),
            
            Text::make(__('Shelf Code'), 'shelf_code')
                ->hideFromIndex(),
        ];
        
    }
    
    /**
     * Get the topic fields for the resource.
     *
     * @return array
     */
    protected function topicFields()
    {
        return [
            NovaBelongsToDepend::make(__('Topic'), 'topic', \App\Nova\Topic::class)
                                ->placeholder(__('Select Topic'))
                                ->rules('exclude_if:status,draft', 'required')
                                ->options(Topic::all()),
            
            NovaBelongsToDepend::make(__('SubTopic'), 'subtopic', \App\Nova\Subtopic::class)
                                ->placeholder(__('Select SubTopic'))
                                ->rules('exclude_if:status,draft', 'required')
                                ->optionsResolve(function ($topic) {
                                    // Reduce the amount of unnecessary data sent
                                    return $topic->subtopics()->get(['id','name']);
                                })
                                ->dependsOn('Topic'),
                
            Multiselect::make(__('Tags'), 'tags')
                        ->belongsToMany(\App\Nova\Tag::class)
                        ->taggable(),
                        
            Textarea::make(__('Biography'), 'body'),
            
            Boolean::make(__('Is Chosen'), 'is_chosen')
                    ->hideFromIndex(),
            
            Boolean::make(__('Is Owned'), 'is_owned')
                    ->hideFromIndex(),
        ];
        
    }
    
    /**
     * Fill the given fields for the model.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Illuminate\Support\Collection  $fields
     * @return array
     */
    protected static function fillFields(NovaRequest $request, $model, $fields)
    {
        $pivot = $request->only(['sources', 'publishers', 'authors', 'tags']);
        $fillFields = parent::fillFields($request, $model, $fields);
        // first element should be model object
        $modelObject = $fillFields[0];

        if(!empty($pivot['sources']) && !$modelObject->no_source) {
           foreach ($pivot['sources'] as $lable => $value) {
                if(Str::contains($value, 'false-')){
                    $name =  self::getTagName($value);
                    $pivot['sources'][$lable] = self::createSource($name);
                }
            }
            $request->request->set('sources', $pivot['sources']);
        }
        
        if(!empty($pivot['publishers']) && !$modelObject->no_publisher) {
            foreach ($pivot['publishers'] as $lable => $value) {
                if(Str::contains($value, 'false-')){
                    $name = self::getTagName($value);
                    $pivot['publishers'][$lable] = self::createPublisher($name);
                }
            }
            $request->request->set('publishers', $pivot['publishers']);
        }
        
        if(!empty($pivot['authors']) && !$modelObject->no_author) {
            foreach ($pivot['authors'] as $lable => $value) {
                if(Str::contains($value, 'false-')){
                    $name = self::getTagName($value);
                    $pivot['authors'][$lable] = self::createAuthor($name);
                }
            }
            $request->request->set('authors', $pivot['authors']);
        }
        
        if(!empty($pivot['tags'])) {
            foreach ($pivot['tags'] as $lable => $value) {
                if(Str::contains($value, 'false-')){
                    $name = self::getTagName($value);
                    $pivot['tags'][$lable] = self::createTag($name);
                }
            }
            $request->request->set('tags', $pivot['tags']);
        }
        
        // if(!$modelObject->no_sub_title) {
        //     $request->request->set('sub_title', NULL)
        // }
        
        $modelObject->details = [
            'edition' => ($modelObject->no_edition) ? NULL : $modelObject->edition,
            'translated_by' => ($modelObject->no_translator) ? NULL : $modelObject->translated_by,
            'inspected_by' => ($modelObject->no_inspector) ? NULL : $modelObject->inspected_by,
            'documented_by' => ($modelObject->no_documentor) ? NULL : $modelObject->documented_by,
            'total_pages' => $modelObject->total_pages,
            'total_available_books' => $modelObject->total_available_books,
            'missing_books' => $modelObject->missing_books,
            'appendices' => ($modelObject->no_appendices) ? NULL : $modelObject->appendices,
            'series_book_number' => $modelObject->series_book_number,
            'publishing_year_type' => $model->publishing_year_type,
            'no_source' => $modelObject->no_source,
            'no_acquisition_year' => $modelObject->no_acquisition_year,
            'no_isbn' => $modelObject->no_isbn,
            'no_sub_title' => $modelObject->no_sub_title,
            'no_edition' => $modelObject->no_edition,
            'no_author' => $modelObject->no_author,
            'no_translator' => $modelObject->no_translator,
            'no_inspector' => $modelObject->no_inspector,
            'no_documentor' => $modelObject->no_documentor,
            'no_publisher' => $modelObject->no_publisher,
            'no_publishing_location' => $modelObject->no_publishing_location,
            'no_publishing_year' => $modelObject->no_publishing_year,
            'no_appendices' => $modelObject->no_appendices
        ];
        
        unset(
            $modelObject->edition,
            $modelObject->translated_by,
            $modelObject->inspected_by,
            $modelObject->documented_by,
            $modelObject->total_pages,
            $modelObject->total_available_books,
            $modelObject->missing_books,
            $modelObject->appendices,
            $modelObject->series_book_number,
            $modelObject->publishing_year_type,
            $modelObject->no_source,
            $modelObject->no_acquisition_year,
            $modelObject->no_isbn,
            $modelObject->no_sub_title,
            $modelObject->no_edition,
            $modelObject->no_author,
            $modelObject->no_translator,
            $modelObject->no_inspector,
            $modelObject->no_documentor,
            $modelObject->no_publisher,
            $modelObject->no_publishing_location,
            $modelObject->no_publishing_year,
            $modelObject->no_appendices
        );
        
        return $fillFields;
    }
    
    public static function getTagName($tag_id){
        return Str::of($tag_id)->replace('false-', '')->__toString(); 
    }
    
    private static function createSource($name) {
        $source = new \App\Models\Source();
        $source->name = $name;
        $source->save();
        return $source->id;
    }
    
    private static function createPublisher($name) {
        $publisher = new \App\Models\Publisher();
        $publisher->name = $name;
        $publisher->save();
        return $publisher->id;
    }
    
    private static function createAuthor($name) {
        $author = new \App\Models\Author();
        $author->name = $name;
        $author->save();
        return $author->id;
    }
    
    
    private static function createTag($name) {
        $tag = new \App\Models\Tag();
        $tag->name = $name;
        $tag->save();
        return $tag->id;
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new TopicFilter,
            new SubtopicFilter,
            new BookTypeFilter,
            new UserFilter,
            new IsFeaturedOwnedFilter,
            new StatusFilter
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [
            new Drafts(),
            new Published(),
            new CreatedItems()
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new IsChosen(),
            new IsOwned()
        ];
    }
}
