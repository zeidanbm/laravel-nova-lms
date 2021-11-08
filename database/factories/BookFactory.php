<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Book;
use App\Models\User;
use App\Models\Cover;
use App\Models\Topic;
use App\Models\Author;
use App\Models\Series;
use App\Models\Source;
use App\Models\Publisher;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;
		
		/**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $author_ids = Author::all()->random(random_int(1, 3))->pluck('id');
						$publisher_ids = Publisher::all()->random(random_int(1, 3))->pluck('id');
						$source_ids = Source::all()->random(random_int(1, 3))->pluck('id');
						$tag_ids = Tag::all()->random(random_int(1, 6))->pluck('id');
						$pixel_url = 'http://lorempixel.com/g/';
						$img_id = random_int(0, 9);
						$new_cover = new Cover;
						$new_cover->url = $pixel_url . '600/900/abstract/' . $img_id;
						$new_cover->details = [
							'thumbnail' => $pixel_url . '140/210/abstract/' . $img_id,
							'medium' => $pixel_url . '210/315/abstract/' . $img_id,
							'large' => $pixel_url . '420/630/abstract/' . $img_id
						];
						
						$book->authors()->attach($author_ids);
						$book->publishers()->attach($publisher_ids);
						$book->sources()->attach($source_ids);
						$book->tags()->attach($tag_ids);
						$book->cover()->save($new_cover);
        });
		}
		
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
			Book::flushEventListeners();
			
			$user_id = User::all()->random()->id;
			$topic = Topic::all()->random();
			$subtopic = $topic->subtopics->random();
			
			$has_sub_title = random_int(0, 1);
			$has_bio = random_int(0, 1);
			$has_city = random_int(0, 1);
			$edition = random_int(0, 20);
			$translated_by = random_int(0, 1) ?? $this->faker->name;
			$inspected_by = random_int(0, 1) ?? $this->faker->name;
			$documented_by = random_int(0, 1) ?? $this->faker->name;
			$total_pages = random_int(50, 700);
			$total_available_books =  NULL;
			$missing_books = NULL;
			$appendices = NULL;
			$series_book_number = NULL;
			$publishing_year_type = random_int(1, 2);
			$no_source = 0;
			$no_acquisition_year = 0;
			$no_isbn = 0;
			$no_edition = (bool) !!$edition;
			$no_author = 0;
			$no_translator = (bool) !!$translated_by;
			$no_inspector = (bool) !!$inspected_by;
			$no_documentor = (bool) !!$documented_by;
			$no_publisher = 0;
			$no_publishing_location = (bool) !!$has_city;
			$no_publishing_year = 0;
			$no_appendices = 0;
			$title = $this->faker->realText(random_int(20, 60));
			$now = Carbon::now();
	
			return [
				'title' => $title,
				'slug' => Str::slug($title, '-', 'ar'),
				'sub_title' => $has_sub_title ? $this->faker->realText(random_int(20, 60)) : NULL,
				'body' => $has_bio ? $this->faker->paragraph() : NULL,
				'acquisition_year'=> $this->faker->year($max = 'now'),
				'type_id' => 5, // book
				'format_id' => $this->faker->randomElement(array (1,2,3)),
				'isbn' => $no_isbn ? NULL : $this->faker->isbn10 ,
				'quality_id' => $this->faker->randomElement(array (1,2,3,4)),
				'language_id' => $this->faker->randomElement(array (1,2,3,4)),
				'shelf_code' => $this->faker->ean8,
				'publishing_year' => $this->faker->year($max = 'now'),
				'publishing_location' => $has_city ? $this->faker->city : NULL,
				'topic_id' => $topic->id,
				'subtopic_id' => $subtopic->id,
				'series_id' => NULL,
				'details' => json_encode([
					'edition' => $edition,
					'translated_by' => $translated_by,
					'inspected_by' => $inspected_by,
					'documented_by' => $documented_by,
					'total_pages' => $total_pages,
					'total_available_books' => $total_available_books,
					'missing_books' => $missing_books,
					'appendices' => $appendices,
					'series_book_number' => $series_book_number,
					'publishing_year_type' => $publishing_year_type,
					'no_source' => $no_source,
					'no_acquisition_year' => $no_acquisition_year,
					'no_isbn' => $no_isbn,
					'no_sub_title' => (bool) !$has_sub_title,
					'no_edition' => $no_edition,
					'no_author' => $no_author,
					'no_translator' => $no_translator,
					'no_inspector' => $no_inspector,
					'no_documentor' => $no_documentor,
					'no_publisher' => $no_publisher,
					'no_publishing_location' => $no_publishing_location,
					'no_publishing_year' => $no_publishing_year,
					'no_appendices' => $no_appendices
				]),
				'is_chosen' => random_int(0, 1),
				'is_owned' => random_int(0, 1),
				'user_id' => $user_id,
				'status' => $this->faker->randomElement(array ('draft', 'published')),
				'created_at' => $now,
				'updated_at' => $now
			];
		}
		
		/**
		 * Indicate that the book is of type folder.
		 *
		 * @return \Illuminate\Database\Eloquent\Factories\Factory
		 */
		public function folder()
		{
				return $this->state(function (array $attributes) {
						$details = json_decode($attributes['details']);
						$details->total_available_books = random_int(1, 20);
						$missing = $this->faker->randomElements([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30], random_int(0, 20));
						$details->missing_books = $missing ? implode(',', $missing ) : NULL;
						return [
								'type_id' => 1,
								'sub_title' => NULL,
								'details' => json_encode($details)
						];
				});
		}
}