<?php

namespace App\Models\V1\extras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V1\extras\Faq;


class Faqcategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function faq()
    {
        return $this->hasMany(Faq::class, 'category_id');
    }
}
