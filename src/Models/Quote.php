<?php
namespace App\Models;

/**
 * Quote Model (Testimonials)
 */
class Quote extends Model {
    protected $table = 'quotes';
    protected $fillable = ['client_name', 'client_company', 'quote_text', 'rating', 'image_id', 'status', 'created_by'];

    public static function active() {
        return self::where('status', '=', 'active');
    }
}
