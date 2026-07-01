<?php
namespace App\Models;

/**
 * Page Model
 */
class Page extends Model {
    protected $table = 'pages';
    protected $fillable = ['title', 'slug', 'content', 'featured_image', 'meta_description', 'meta_keywords', 'status', 'author_id'];

    public static function findBySlug($slug) {
        return self::firstWhere('slug', $slug);
    }

    public static function published() {
        return self::where('status', '=', 'published');
    }
}
