<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relationship extends Model
{
    use SoftDeletes;
    protected $table = 'relationship';
    protected $fillable = ['contact_id_a', 'contact_id_b', 'relationship_type_id', 'is_active', 'description'];

    public function relationship_type()
    {
        return $this->hasOne(RelationshipType::class, 'id', 'relationship_type_id');
    }

    public function contact_a()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id_a');
    }

    public function contact_b()
    {
        return $this->hasOne(Contact::class, 'id', 'contact_id_b');
    }

    public function getContactADisplayNameAttribute()
    {
        if (isset($this->contact_a)) {
            if ($this->contact_a->id > 0) {
                //default is individual person
                $display_name = '<a href="'.$this->contact_a->id.'">'.$this->contact_a->display_name.'</a>';
                //diocese
                if ($this->contact_a->contact_type == config('polanco.contact_type.organization') && $this->contact_a->subcontact_type == config('polanco.contact_type.diocese')) {
                    $display_name = '<a href="../diocese/'.$this->contact_a->id.'">'.$this->contact_a->display_name.'</a>';
                }
                //parish
                if ($this->contact_a->contact_type == config('polanco.contact_type.organization') && $this->contact_a->subcontact_type == config('polanco.contact_type.parish')) {
                    $display_name = '<a href="../parish/'.$this->contact_a->id.'">'.$this->contact_a->display_name.'</a>';
                }

                return $display_name;
            } else {
                return;
            }
        }
    }

    public function getContactBDisplayNameAttribute()
    {
        if (isset($this->contact_b)) {
            if ($this->contact_b->id > 0) {
                //default is individual person
                $display_name = '<a href="'.$this->contact_b->id.'">'.$this->contact_b->display_name.'</a>';
                //diocese
                if ($this->contact_b->contact_type == config('polanco.contact_type.organization') && $this->contact_b->subcontact_type == config('polanco.contact_type.diocese')) {
                    $display_name = '<a href="../diocese'.$this->contact_b->id.'">'.$this->contact_b->display_name.'</a>';
                }
                //parish
                if ($this->contact_b->contact_type == config('polanco.contact_type.organization') && $this->contact_b->subcontact_type == config('polanco.contact_type.parish')) {
                    $display_name = '<a href="../parish/'.$this->contact_b->id.'">'.$this->contact_b->display_name.'</a>';
                }

                return $display_name;
            } else {
                return;
            }
        }
    }

    public function getRelationshipTypeNameABAttribute()
    {
        if (isset($this->relationship_type)) {
            return $this->relationship_type->name_a_b;
        } else {
            return ;
        }
    }

    public function getRelationshipTypeNameBAAttribute()
    {
        if (isset($this->relationship_type)) {
            return $this->relationship_type->name_b_a;
        } else {
            return ;
        }
    }
    public function getRelationshipTypeLabelABAttribute()
    {
        if (isset($this->relationship_type)) {
            return $this->relationship_type->label_a_b;
        } else {
            return ;
        }
    }
    public function getRelationshipTypeLabelBAAttribute()
    {
        if (isset($this->relationship_type)) {
            return $this->relationship_type->label_b_a;
        } else {
            return ;
        }
    }
    public function getRelationshipTypeDescriptionAttribute()
    {
        if (isset($this->relationship_type)) {
            return $this->relationship_type->description;
        } else {
            return ;
        }
    }

}
