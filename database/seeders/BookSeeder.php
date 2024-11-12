<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

class BookSeeder extends Seeder
{
    public function run()
    {
        Book::factory(10)->create()->each(function ($book) {
            $book->authors()->attach(Author::inRandomOrder()->take(2)->pluck('id'));
            $book->categories()->attach(Category::inRandomOrder()->take(3)->pluck('id'));
        });
    }
}
