<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use JeroenG\Explorer\Application\Explored;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model implements Explored
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'isbn', 'image', 'published', 'author_id', 'genre_id', 'publisher_id'
    ];

    protected $perPage = 5;

    public function mappableAs(): array
    {
        return [
            'id' => 'keyword',
            'title' => 'text',
        ];
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }

    protected $casts = ['published' => 'date'];

    protected $appends = [
        'author_name',
        'genre_name',
        'publisher_name',
        'short_description',
        'published_human',
        'image_url',
        'published_short',
    ];

    protected $with = ['author', 'genre', 'publisher'];

    /**
     * Get the author that owns the book.
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get the genre of the book.
     */
    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    /**
     * Get the publisher of the book.
     */
    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    protected function authorName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->author?->name
        );
    }

    protected function genreName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->genre?->name
        );
    }

    protected function publisherName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->publisher?->name
        );
    }

    protected function shortDescription(): Attribute
    {
        return Attribute::make(
            get: fn () => Str::limit($this->description, 60, $end = '...')
        );
    }

    protected function published(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('Y-m-d'),
            set: fn ($value) => Carbon::parse($value)->format('Y-m-d')
        );
    }

    protected function publishedHuman(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->published)->format('jS M, Y'),
        );
    }

    protected function publishedShort(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->published)->format('M Y'),
        );
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function() {
                if (empty($this->image)) return 'https://picsum.photos/400';
                return strpos($this->image, 'http') === false ? Storage::url($this->image) : $this->image;
            }
        );
    }

    protected function isbn(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => str_replace("-", "", $value),
        );
    }
}
