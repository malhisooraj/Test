<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * Give me the posts with category and author
     * @var string[]
     */
    protected $with = ['category', 'author'];

    /**
     * Reverse, allow all except the one declared here
     */
    //protected guarded = [];
    /**
     * Allow all this attributes for mass assignment
     * @var string[]
     */
    protected $fillable = ['title', 'excerpt', 'slug', 'body', 'category_id', 'thumbnail', 'user_id', 'status'];

    /*public function getRouteKeyName()
    {
        return 'slug';
    }*/

    /**
     *
     * @param $query
     * @param array $filters
     * @return void
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            /*$query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');*/
            $query->where(fn($query) =>
                $query
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%')
            );
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('category', fn ($query) =>
                $query->where('slug', $category)
                );
        });

        $query->when($filters['author'] ?? false, function ($query, $author) {
            $query->whereHas('author', fn ($query) =>
            $query->where('username', $author)
            );
        });

        $query->when($filters['status'] ?? false, function ($query, $status) {
            $query->where(fn($query) =>
            $query
                ->where('status', 'like', '%' . $status . '%')
            );
        });

        /*second approach
         * if ($filters['search'] ?? false) {
            $query
                ->where('title', 'like', '%' . request('search') . '%')
                ->orWhere('body', 'like', '%' . request('search') . '%');
        }*/
    }

    /**
     * Post belongs to category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Post belongs to User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    /*public function user() // this assume foreign key is user_id
    {
        return $this->belongsTo(User::class);
    }*/

    /**
     * This assumes foreign key as author_id, but explicitly we set as user_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
