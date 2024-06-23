<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Attachment extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'file';

    //
    protected $fillable = ['entity', 'entity_id', 'file_type_id'];

    protected function casts(): array
    {
        return [
            'upload_date' => 'datetime',
        ];
    }

    public function file_type(): HasOne
    {
        return $this->hasOne(FileType::class, 'id', 'file_type_id');
    }

    public function getDescriptionTextAttribute()
    {
        if (isset($this->description)) {
            return $this->description;
        } else {
            return 'N/A';
        }
    }

    public function getEntityLinkAttribute()
    {
        switch ($this->entity) {
            case 'asset':
                $path = url('asset/'.$this->entity_id);
                break;
            case 'contact':
                $contact = \App\Models\Contact::findOrFail($this->entity_id);
                $path = $contact->contact_url;
                break;
            case 'event':
                $path = url('retreat/'.$this->entity_id);
                break;
            default:
                $path = null;
        }

        return "<a href='".$path."'>".ucfirst($this->entity).' '.$this->entity_id.'</a>';
    }
}
