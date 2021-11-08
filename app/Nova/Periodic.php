<?php

namespace App\Nova;

use App\Options\Format;
use App\Options\Status;
use Laravel\Nova\Panel;
use App\Options\Interval;
use App\Options\Language;
use App\Nova\Lenses\Drafts;
use Illuminate\Support\Str;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use App\Nova\Actions\IsOwned;
use App\Options\PeriodicType;
use Laravel\Nova\Fields\Text;
use App\Nova\Actions\IsChosen;
use App\Nova\Lenses\Published;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use App\Nova\Filters\UserFilter;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\Textarea;
use App\Nova\Filters\StatusFilter;
use App\Nova\Filters\PeriodicTypeFilter;
use Afkartech\MultiselectField\Multiselect;
use App\Nova\Filters\IsFeaturedOwnedFilter;
use App\Nova\Lenses\CreatedItems;
use Laravel\Nova\Http\Requests\NovaRequest;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;

class Periodic extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Periodic::class;

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
        return __('Periodics');
    }
    
    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Periodic');
    }
    
    /**
     * The icon of the resource.
     *
     * @return string
     */
    public static function icon() 
    {
        return view('icons.grid')->render();
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
    public static $priority = 3;
    
    /**
     * The relationships that should be eager loaded on index queries.
     *
     * @var array
     */
    public static $with = ['sources','publishers'];

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
            
            HasMany::make(__('Periodic Publications'), 'publications', 'App\Nova\Publication'),
            
            MorphOne::make(__('Cover Photo'), 'cover', 'App\Nova\Cover'),
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
                        ->showOnCreating(function () {
                            return $this->acquisition_year;
                        })
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
            Select::make(__('Periodic Format'), 'format_id')
                    ->rules('required')
                    ->options(Format::get())
                    ->default(1)
                    ->displayUsingLabels()
                    ->hideFromIndex(),
            
            Select::make(__('Periodic Type'), 'type_id')
                    ->rules('required')
                    ->options(PeriodicType::get())
                    ->default(8)
                    ->displayUsingLabels(),
            
            Select::make(__('Periodic Interval'), 'interval_id')
                    ->rules('exclude_if:status,draft', 'required')
                    ->options(Interval::get())
                    ->displayUsingLabels()
                    ->hideFromIndex(),
                
            NovaDependencyContainer::make([
                Text::make(__('ISSN'), 'issn')
                    ->rules('exclude_if:status,draft', 'required')
                    ->hideFromIndex(),
            ])->dependsOn('no_issn', 0),
            
            Boolean::make(__('No ISSN'), 'no_issn')
                    ->withMeta(['value' => $details['no_issn'] ?? 0])
                    ->onlyOnForms(),
                
            Text::make(__('Title'), 'title')
                ->sortable()
                ->rules('required', 'max:200')
                ->creationRules('unique:periodics,title')
                ->updateRules('unique:periodics,title,{{resourceId}}')
                ->displayUsing(function ($name) {
                    return '<span class="max-w-md">' . $name . '</span>';
                })->asHtml(),
            
            NovaDependencyContainer::make([
                Multiselect::make(__('Publishers'), 'publishers')
                        ->belongsToMany(\App\Nova\Publisher::class)
                        ->rules('exclude_if:status,draft', 'required')
                        ->taggable(),
            ])->dependsOn('no_publisher', 0),
            
            Multiselect::make(__('Publishers'), 'publishers')
                        ->belongsToMany(\App\Nova\Publisher::class)
                        ->onlyOnIndex(),
                        
            Multiselect::make(__('Sources'), 'sources')
                        ->belongsToMany(\App\Nova\Source::class)
                        ->onlyOnIndex(),
            
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
            Textarea::make(__('Biography'), 'body'),
            
            Boolean::make(__('Is Chosen'), 'is_chosen')
                    ->hideFromIndex(),
            
            Boolean::make(__('Is Owned'), 'is_owned')
                    ->hideFromIndex()
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
    protected static function fillFields(NovaRequest $request, $model, $fields){
    
        $pivot = $request->only(['sources', 'publishers']);
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
        
        
        
        $modelObject->details = [
            'no_source' => $modelObject->no_source,
            'no_acquisition_year' => $modelObject->no_acquisition_year,
            'no_issn' => $modelObject->no_issn,
            'no_publisher' => $modelObject->no_publisher,
            'no_publishing_location' => $modelObject->no_publishing_location
        ];
        
        unset(
            $modelObject->no_source,
            $modelObject->no_acquisition_year,
            $modelObject->no_issn,
            $modelObject->no_publisher,
            $modelObject->no_publishing_location
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
            new PeriodicTypeFilter,
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
