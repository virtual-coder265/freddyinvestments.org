<?php
namespace App\Models;

/**
 * Asset Model
 */
class Asset extends Model {
    protected $table = 'assets';
    protected $fillable = ['filename', 'original_name', 'filepath', 'file_size', 'mime_type', 'asset_type', 'alt_text', 'description', 'uploaded_by'];

    public static function byType($type) {
        return self::where('asset_type', '=', $type);
    }

    public static function findByFilename($filename) {
        return self::firstWhere('filename', $filename);
    }
}
