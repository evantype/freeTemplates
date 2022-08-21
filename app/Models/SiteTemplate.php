<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperSiteTemplate
 */
class SiteTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'download_links',
        'cover',
        'demo',
        'original_link',
        'is_active',
        'description'
    ];
}
