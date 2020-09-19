<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Activity extends Model implements Auditable
{
    use HasFactory;

    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'activity';

    public function contacts()
    {
        return $this->hasMany(ActivityContact::class, 'activity_id', 'id');
    }

    public function targets()
    {
        return $this->hasMany(ActivityContact::class, 'activity_id', 'id')->whereRecordTypeId(config('polanco.activity_contacts_type.target'));
    }

    public function creators()
    {
        return $this->hasMany(ActivityContact::class, 'activity_id', 'id')->whereRecordTypeId(config('polanco.activity_contacts_type.creator'));
    }

    public function assignees()
    {
        return $this->hasMany(ActivityContact::class, 'activity_id', 'id')->whereRecordTypeId(config('polanco.activity_contacts_type.assignee'));
    }

    public function activity_type()
    {
        return $this->hasOne(ActivityType::class, 'id', 'activity_type_id');
    }

    public function getActivityTypeLabelAttribute()
    {
        //dd($this->activity_type);
        return $this->activity_type->label;
    }

    public function getTargetsFullNameLinkAttribute()
    {
        $target_list = '';
        $targets = $this->targets;
        foreach ($targets as $target) {
            if ($targets->last() === $target) {
                $target_list .= $target->contact->contact_link_full_name;
            //$target_list .= $target->contact_id;
            } else {
                $target_list .= $target->contact->contact_link_full_name.', ';
            }
        }

        return $target_list;
    }

    public function getAssigneesFullNameLinkAttribute()
    {
        $assignee_list = '';
        $assignees = $this->assignees;
        foreach ($assignees as $assignee) {
            if ($assignees->last() === $assignee) {
                $assignee_list .= $assignee->contact->contact_link_full_name;
            } else {
                $assignee_list .= $assignee->contact->contact_link_full_name.', ';
            }
        }

        return $assignee_list;
    }

    public function getSourcesFullNameLinkAttribute()
    {
        $source_list = '';
        $sources = $this->creators;
        foreach ($sources as $source) {
            if ($sources->last() === $source) {
                $source_list .= $source->contact->contact_link_full_name;
            } else {
                $source_list .= $source->contact->contact_link_full_name.', ';
            }
        }

        return $source_list;
    }

    // alias for previous touchpoint field
    public function getTouchedAtAttribute()
    {
        return $this->activity_date_time;
    }

    public function getStatusLabelAttribute()
    {
        $status = \App\Models\ActivityStatus::findOrFail($this->status_id);

        return $status->label;
    }

    public function getPriorityLabelAttribute()
    {
        $priority = config('polanco.priority');
        if (array_search($this->priority_id, $priority)) {
            return ucfirst(array_search($this->priority_id, $priority));
        } else {
            return 'Unspecified';
        }
    }

    public function getMediumLabelAttribute()
    {
        $medium = config('polanco.medium');
        if (array_search($this->medium_id, $medium)) {
            return ucfirst(array_search($this->medium_id, $medium));
        } else {
            return 'Unspecified';
        }
    }
}
