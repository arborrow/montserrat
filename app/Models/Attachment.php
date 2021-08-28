<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Attachment extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'file';
    protected $dates = [
        'upload_date',
    ];  //
    protected $fillable = ['entity', 'entity_id', 'file_type_id'];

    public function file_type()
    {
        return $this->hasOne(FileType::class, 'id', 'file_type_id');
    }

    public function getFileDescriptionTextAttribute()
    {
        if (isset($this->description)) {
            return $this->uri . ' ('.$this->description.')';
        } else {
            return $this->uri;
        }
    }

    public function getEntityLinkAttribute() {
        switch ($this->entity) {
            case 'asset':
                $path = url('asset/'.$this->entity_id);
                break;
            case 'contact':
                $contact = \App\Models\Contact::findOrFail($this->entity_id);
                $path = $contact->contact_url;
                break;
            case 'event':
                $path = url('retreat/'.$this->id);
                break;
            default:
                $path = null;
        }
        return "<a href='".$path."'>".ucfirst($this->entity).' '.$this->entity_id.'</a>';


    }

}
