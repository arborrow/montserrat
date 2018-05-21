<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Image;
use Illuminate\Support\Facades\Redirect;
use Gate;

class AttachmentController extends Controller
{
    /* used to manage file attachments for contacts, events, etc.
     * every attachment should have a record in the files table 
     * attachments are stored in the storage/app folder according to entity/entity_id
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function sanitize_filename($filename)
    {
        $sanitized = preg_replace('/[^a-zA-Z0-9\-\._]/', '', $filename);
        return $sanitized;
    }
    public function show_attachment($entity, $entity_id, $type = 'attachment', $file_name = null)
    {
        switch ($type) {
            case 'attachment':
                $this->authorize('show-attachment');
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/attachments/'.$file_name;
                break;
            case 'avatar':
                $this->authorize('show-avatar');
                $file_name = 'avatar.png';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'schedule':
                $this->authorize('show-event-schedule');
                $file_name = 'schedule.pdf';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'contract':
                $this->authorize('show-attachment');
                $file_name = 'contract.pdf';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'evaluations':
                $this->authorize('show-attachment');
                $file_name = 'evaluations.pdf';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'group_photo':
                $this->authorize('show-attachment');
                $file_name = 'group_photo.jpg';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            default:
                $this->authorize('show-attachment');
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
        }
        //dd($path);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function store_attachment($file, $entity = 'event', $entity_id = 0, $type = null, $description = null)
    {
        $this->authorize('create-attachment');
        $file_name = $this->sanitize_filename($file->getClientOriginalName());
        $attachment = new \App\Attachment;
        $attachment->mime_type = $file->getClientMimeType();
        $attachment->description = $description;
        $attachment->upload_date = \Carbon\Carbon::now();
        $attachment->entity = $entity;
        $attachment->entity_id = $entity_id;
        switch ($type) {
            case 'contract':
                $this->authorize('create-event-contract');
                $attachment->file_type_id = config('polanco.file_type.event_contract');
                $attachment->uri = 'contract.pdf';
                break;
            case 'schedule':
                $this->authorize('create-event-schedule');
                $attachment->file_type_id = config('polanco.file_type.event_schedule');
                $attachment->uri = 'schedule.pdf';
                break;
            case 'evaluation':
                $this->authorize('create-event-evaluation');
                $attachment->file_type_id = config('polanco.file_type.event_evaluation');
                $attachment->uri = 'evaluations.pdf';
                break;
            case 'group_photo':
                $this->authorize('create-event-group-photo');
                $attachment->file_type_id = config('polanco.file_type.event_group_photo');
                $attachment->uri = 'group_photo.png';
                break;
            case 'attachment':
                $this->authorize('create-attachment');
                $attachment->file_type_id = config('polanco.file_type.contact_attachment');
                $attachment->uri = $file_name;
                break;
            case 'avatar':
                $this->authorize('create-avatar');
                $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();
                $attachment->file_type_id = config('polanco.file_type.contact_avatar');
                $attachment->uri = 'avatar.png';
                break;
            default:
                $this->authorize('create-attachment');
                $attachment->file_type_id = 0;
                $attachment->uri = $file_name;
                break;
        }
        $attachment->save();
        //write file to filesystem
        if ($type=='avatar') {
            Storage::disk('local')->put($entity.'/'.$entity_id.'/'.'avatar.png', $avatar->stream('png'));
        } else {
            Storage::disk('local')->put($entity.'/'.$entity_id.'/'.$attachment->uri, File::get($file));
        }
    }

    public function update_attachment($file, $entity = 'event', $entity_id = 0, $type = null, $description = null)
    {
        
               
        $path = $entity.'/'.$entity_id.'/';

        switch ($type) {
            case 'avatar':
                $this->authorize('create-avatar'); //if you can create it you can update it
                $file_type_id = config('polanco.file_type.contact_avatar');
                $file_name = 'avatar.png';
                $updated_file_name= 'avatar-updated-'.time().'.png';
                $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();

                if (File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::put($path.$file_name, $avatar->stream('png'));
                } else {
                    $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();
                    Storage::put($entity.'/'.$entity_id.'/'.$file_name, $avatar->stream('png'));
                }

                break;
            case 'attachment':
                $this->authorize('create-attachment');
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_type_id = config('polanco.file_type.contact_attachment');
                $file_name = $this->sanitize_filename($file->getClientOriginalName());
                $file_extension = $file->getExtension();
                $updated_file_name= $file->getBasename('.'.$file_extension).'-updated-'.time().'.'.$file_extension;

                if (File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'schedule':
                $this->authorize('create-event-schedule');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_schedule');
                $file_name = 'schedule.pdf';
                $updated_file_name= 'schedule-updated-'.time().'.pdf';

                if (File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'contract':
                $this->authorize('create-event-contract');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_contract');
                $file_name = 'contract.pdf';
                $updated_file_name= 'contract-updated-'.time().'.pdf';

                if (File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'evaluations':
                $this->authorize('create-event-evaluation');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_evaluation');
                $file_name = 'evaluations.pdf';
                $updated_file_name= 'evaluations-updated-'.time().'.pdf';

                if (File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'group_photo':
                $this->authorize('create-event-group-photo');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_group_photo');
                $file_name = 'group_photo.jpg';
                $updated_file_name= 'group_photo-updated-'.time().'.pdf';
                $group_photo = Image::make($file->getRealPath());
                if (File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, $group_photo->stream('jpg'));
                } else {
                    Storage::disk('local')->put($path.$file_name, $group_photo->stream('jpg'));
                }
                break;
                
            default:
                $this->authorize('create-attachment');
                break;
        }
        $attachment = \App\Attachment::firstOrNew(['entity'=>$entity,'entity_id'=>$entity_id,'file_type_id'=>$file_type_id,'uri'=>$file_name]);
        $attachment->upload_date = \Carbon\Carbon::now();
        $attachment->description = $description;
        $attachment->mime_type = $file->getClientMimeType();
        $attachment->uri = $file_name;

        $attachment->save();
    }
    public function delete_attachment($file_name, $entity = 'event', $entity_id = 0, $type = null)
    {
        $this->authorize('delete-attachment');
               
        $path = $entity.'/'.$entity_id.'/';
        switch ($type) {
            case 'group_photo':
                $file_name='group_photo.jpg';
                $attachment = \App\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_group_photo'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'group_photo-deleted-'.time().'.jpg';
                break;
            case 'contract':
                $file_name='contract.pdf';
                $attachment = \App\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_contract'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'contract-deleted-'.time().'.pdf';
                break;
            case 'schedule':
                $file_name='schedule.pdf';
                $attachment = \App\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_schedule'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'schedule-deleted-'.time().'.pdf';
                break;
            case 'evaluations':
                $file_name='evaluations.pdf';
                $attachment = \App\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_evaluation'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'evaluations-deleted-'.time().'.pdf';
                break;
            case 'attachment':
                $attachment = \App\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.contact_attachment'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_extension = File::extension($path.$file_name);
                $file_basename = File::name($path.$file_name);
                $updated_file_name= $file_basename.'-deleted-'.time().'.'.$file_extension;
                break;
            case 'avatar':
                $attachment = \App\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.contact_avatar'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name= 'avatar-deleted-'.time().'.png';
                break;
            default:
                break;
        }
        
        if (!File::exists(storage_path().'/app/'.$path.$file_name)) {
            abort(404);
        }
        if (Storage::move($path.$file_name, $path.$updated_file_name)) {
            $attachment->uri=$updated_file_name;
            $attachment->save();
            $attachment->delete();
        }
            
        return Redirect::action('RetreatController@show', $entity_id);
    }

    public function show_contact_attachment($user_id, $file_name)
    {
        $this->authorize('show-attachment');
        return $this->show_attachment('contact', $user_id, 'attachment', $file_name);
    }
    public function delete_contact_attachment($user_id, $attachment)
    {
        $this->authorize('delete-attachment');
        $this->delete_attachment($attachment, 'contact', $user_id, 'attachment');
        // TODO: get contact type and redirect to person, parish, organization, vendor as appropriate
        return Redirect::action('PersonsController@show', $user_id);
    }
    
    public function get_avatar($user_id)
    {
        $this->authorize('show-avatar');
        return $this->show_attachment('contact', $user_id, 'avatar', 'avatar.png');
    }
    
    public function delete_avatar($user_id)
    {
        $this->authorize('delete-attachment');
        $this->delete_attachment('avatar.png', 'contact', $user_id, 'avatar');
        return Redirect::action('PersonsController@show', $user_id);
    }

    public function get_event_contract($event_id)
    {
        $this->authorize('show-event-attachment');
        return $this->show_attachment('event', $event_id, 'contract', null);
    }

    public function get_event_schedule($event_id)
    {
        $this->authorize('show-event-schedule');
        return $this->show_attachment('event', $event_id, 'schedule', null);
    }

    
    public function get_event_evaluations($event_id)
    {
        $this->authorize('show-event-evaluation');
        return $this->show_attachment('event', $event_id, 'evaluations', null);
    }
    
    public function delete_event_evaluations($event_id)
    {
        $this->authorize('delete-attachment');
        $this->delete_attachment('evaluations.pdf', 'event', $event_id, 'evaluations');
        return Redirect::action('RetreatController@show', $event_id);
    }
    public function delete_event_schedule($event_id)
    {
        $this->authorize('delete-attachment');
        $this->delete_attachment('schedule.pdf', 'event', $event_id, 'schedule');
        return Redirect::action('RetreatController@show', $event_id);
    }

    public function delete_event_contract($event_id)
    {
        $this->authorize('delete-attachment');
        $this->delete_attachment('contract.pdf', 'event', $event_id, 'contract');
        return Redirect::action('RetreatController@show', $event_id);
    }
    
    public function delete_event_group_photo($event_id)
    {
        $this->authorize('delete-attachment');
           $this->delete_attachment('group_photo.jpg', 'event', $event_id, 'group_photo');
           return Redirect::action('RetreatController@show', $event_id);
    }

    public function get_event_group_photo($event_id)
    {
        $this->authorize('show-event-group-photo');
        return $this->show_attachment('event', $event_id, 'group_photo', null);
    }
}
