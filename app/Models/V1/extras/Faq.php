<?php

namespace App\Models\V1\extras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\V1\extras\Faqcategory;

class Faq extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function faqcategory()
    {
        return $this->belongsTo(Faqcategory::class, 'category_id');
    }
}
