<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use SoftDeletes;
    protected $table = 'file';
    protected $dates = [
        'upload_date',
    ];  //
    protected $fillable = ['entity', 'entity_id', 'file_type_id'];

    public function file_type()
    {
        return $this->hasOne(FileType::class, 'id', 'file_type_id');
    }
}
