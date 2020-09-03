<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Snippet extends Model
{
    use SoftDeletes;

    public function language()
    {
        return $this->hasOne(Language::class, 'name', 'locale');
    }


    public function getLanguageLabelAttribute()
    {
        if (isset($this->language->label)) {
            return $this->language->label;
        } else {
            return 'Unknown language';
        }
    }

}
