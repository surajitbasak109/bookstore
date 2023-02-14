<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $response = Http::get('https://fakerapi.it/api/v1/books?_quantity=100');
        $responseJson = $response->json();
        $books = $responseJson['data'];

        $bar = $this->command->getOutput()->createProgressBar(count($books));

        DB::beginTransaction();

        try {
            foreach ($books as $book) {
                $author = Author::firstOrCreate(['name' => $book['author']]);
                $genre = Genre::firstOrCreate(['name' => $book['genre']]);
                $publisher = Publisher::firstOrCreate(['name' => $book['publisher']]);

                Book::create([
                    'title' => $book['title'],
                    'description' => $book['description'],
                    'isbn' => $book['isbn'],
                    'image' => $book['image'],
                    'published' => $book['published'],
                    'author_id' => $author->id,
                    'genre_id' => $genre->id,
                    'publisher_id' => $publisher->id
                ]);

                $bar->advance();
            }
            DB::commit();
        } catch (\Exception $e) {
            $this->command->error("Book insertion failed: {$e->getMessage()}");
            DB::rollBack();
        }

        $bar->finish();
        $this->command->info("\nBook insertion completed");
    }
}
