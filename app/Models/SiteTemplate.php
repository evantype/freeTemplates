<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'download_links',
        'cover',
        'demo'
    ];
}
