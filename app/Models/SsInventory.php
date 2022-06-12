<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class SsInventory extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'ss_inventory';


    public function custom_form()
    {
        return $this->hasOne(SsCustomForm::class, 'id', 'custom_form_id');

    }


}
