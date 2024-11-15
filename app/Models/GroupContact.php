<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class GroupContact extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $table = 'group_contact';

    protected $fillable = ['contact_id', 'group_id', 'status'];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class, 'contact_id', 'id');
    }

    public function getContactSortNameAttribute()
    {
        $sort_name = empty($this->contact->sort_name) ? null : $this->contact->sort_name;

        return $sort_name;
    }

    public function getGroupNameAttribute()
    {
        $group_name = empty($this->group->name) ? null : $this->group->name;

        return $group_name;
    }
}
