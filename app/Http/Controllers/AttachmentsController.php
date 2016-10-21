<?php


namespace montserrat\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Image;
use Illuminate\Support\Facades\Redirect;


class AttachmentsController extends Controller
{
    /* used to manage file attachments for contacts, events, etc.
     * every attachment should have a record in the files table 
     * attachments are stored in the storage/app folder according to entity/entity_id
     */
    
    public function sanitize_filename ($filename) {
        $sanitized = preg_replace('/[^a-zA-Z0-9\-\._]/','', $filename);
        return $sanitized;
    }
    public function show_attachment($entity, $entity_id, $type='attachment', $file_name=NULL)
    {
        switch ($type) {
            case 'attachment' :
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/attachments/'.$file_name;
                break;
            case 'avatar' :
                $file_name = 'avatar.png';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'schedule' :
                $file_name = 'schedule.pdf';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'contract' :
                $file_name = 'contract.pdf';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'evaluations' :
                $file_name = 'evaluations.pdf';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            case 'group_photo' :
                $file_name = 'group_photo.jpg';
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
            default :
                $path = storage_path() . '/app/'.$entity.'/'.$entity_id. '/'.$file_name;
                break;
        }
        //dd($path);
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function store_attachment($file, $entity='event',$entity_id=0, $type=NULL,$description=NULL) {
            $file_name = $this->sanitize_filename($file->getClientOriginalName());
            $attachment = new \montserrat\Attachment;
            $attachment->mime_type = $file->getClientMimeType();
            $attachment->description = $description;
            $attachment->upload_date = \Carbon\Carbon::now();
            $attachment->entity = $entity;
            $attachment->entity_id = $entity_id;
            switch ($type) {
                case 'contract': 
                    $attachment->file_type_id = FILE_TYPE_EVENT_CONTRACT;
                    $attachment->uri = 'contract.pdf';
                    break;
                case 'schedule' :
                    $attachment->file_type_id = FILE_TYPE_EVENT_SCHEDULE;
                    $attachment->uri = 'schedule.pdf';
                    break;
                case 'evaluation' :
                    $attachment->file_type_id = FILE_TYPE_EVENT_EVALUATION;
                    $attachment->uri = 'evaluations.pdf';
                    break;
                case 'group_photo' :
                    $attachment->file_type_id = FILE_TYPE_EVENT_GROUP_PHOTO;
                    $attachment->uri = 'group_photo.png';
                    break;
                case 'attachment' :
                    $attachment->file_type_id = FILE_TYPE_CONTACT_ATTACHMENT;
                    $attachment->uri = $file_name;
                    break;
                case 'avatar' :
                    $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();
                    $attachment->file_type_id = FILE_TYPE_CONTACT_AVATAR;
                    $attachment->uri = 'avatar.png';
                    break;
                default : 
                    $attachment->file_type_id = 0;
                    $attachment->uri = $file_name;
                    break;
            }
            $attachment->save();
            //write file to filesystem
            if ($type=='avatar') {
                Storage::disk('local')->put($entity.'/'.$entity_id.'/'.'avatar.png',$avatar->stream('png'));

            } else {
                Storage::disk('local')->put($entity.'/'.$entity_id.'/'.$attachment->uri,File::get($file));
            }
        }

    public function update_attachment ($file, $entity='event',$entity_id=0, $type=NULL,$description=NULL) {

        $path = $entity.'/'.$entity_id.'/';

        switch ($type) {
            case 'avatar' : 
                $file_type_id = FILE_TYPE_CONTACT_AVATAR;
                $file_name = 'avatar.png';
                $updated_file_name= 'avatar-updated-'.time().'.png';
                $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();

                if(File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name,$path.$updated_file_name);
                    Storage::put($path.$file_name,$avatar->stream('png'));
                } else {
                    $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();
                    Storage::put($entity.'/'.$entity_id.'/'.$file_name,$avatar->stream('png'));
                }

                break;
            case 'attachment' :
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_type_id = FILE_TYPE_CONTACT_ATTACHMENT;
                $file_name = $this->sanitize_filename($file->getClientOriginalName());
                $file_extension = $file->getExtension();
                $updated_file_name= $file->getBasename('.'.$file_extension).'-updated-'.time().'.'.$file_extension;

                if(File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name,$path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                }
                break;
            case 'schedule' :
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = FILE_TYPE_EVENT_SCHEDULE;
                $file_name = 'schedule.pdf';
                $updated_file_name= 'schedule-updated-'.time().'.pdf';

                if(File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name,$path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                }
                break;
            case 'contract' :
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = FILE_TYPE_EVENT_SCHEDULE;
                $file_name = 'contract.pdf';
                $updated_file_name= 'contract-updated-'.time().'.pdf';

                if(File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name,$path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                }
                break;
            case 'evaluations' :
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = FILE_TYPE_EVENT_EVALUATION;
                $file_name = 'evaluations.pdf';
                $updated_file_name= 'evaluations-updated-'.time().'.pdf';

                if(File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name,$path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name,File::get($file));
                }
                break;
            case 'group_photo' :
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = FILE_TYPE_EVENT_GROUP_PHOTO;
                $file_name = 'group_photo.jpg';
                $updated_file_name= 'group_photo-updated-'.time().'.pdf';
                $group_photo = Image::make($file->getRealPath());
                if(File::exists(storage_path().'/app/'.$path.$file_name)) {
                    Storage::move($path.$file_name,$path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name,$group_photo->stream('jpg'));
                } else {
                    Storage::disk('local')->put($path.$file_name,$group_photo->stream('jpg'));
                }
                break;
                
            default :
                break;
        }
        $attachment = \montserrat\Attachment::firstOrNew(['entity'=>$entity,'entity_id'=>$entity_id,'file_type_id'=>$file_type_id,'uri'=>$file_name]);
        $attachment->upload_date = \Carbon\Carbon::now();
        $attachment->description = $description;
        $attachment->mime_type = $file->getClientMimeType();
        $attachment->uri = $file_name;

        $attachment->save();
    }
    public function delete_attachment($file_name, $entity='event',$entity_id=0, $type=NULL) {
        switch ($type) {
            case 'group_photo' :
                $file_name='group_photo.jpg';
                $attachment = \montserrat\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(FILE_TYPE_EVENT_GROUP_PHOTO)->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'group_photo-deleted-'.time().'.jpg';
                break;
            case 'contract' :
                $file_name='contract.pdf';
                $attachment = \montserrat\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(FILE_TYPE_EVENT_CONTRACT_PHOTO)->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'contract-deleted-'.time().'.pdf';
                break;
            case 'schedule' :
                $file_name='schedule.pdf';
                $attachment = \montserrat\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(FILE_TYPE_EVENT_CONTRACT)->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'schedule-deleted-'.time().'.pdf';
                break;
            case 'evaluations' :
                $file_name='evaluations.pdf';
                $attachment = \montserrat\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(FILE_TYPE_EVENT_EVALUATION)->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'evaluations-deleted-'.time().'.pdf';
                break;
            default : break;
        }
        
        if(!File::exists(storage_path().'/app/'.$path.$file_name)) abort(404);
        if (Storage::move($path.$file_name,$path.$updated_file_name)) {
            $attachment->uri=$updated_file_name;
            $attachment->save();
            $attachment->delete();
        }
            
        return Redirect::action('RetreatsController@show',$entity_id);
    }

    public function show_contact_attachment($user_id, $file_name)
    {
        $path = storage_path() . '/app/contact/' . $user_id . '/attachments/'.$file_name;
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    public function delete_contact_attachment($user_id, $attachment)
    {
        $file_attachment = \montserrat\Attachment::whereEntity('contact')->whereEntityId($user_id)->whereUri($attachment)->firstOrFail();
        $path = storage_path() . '/app/contact/' . $user_id . '/attachments/'.$attachment;
        if(!File::exists($path)) {abort(404);}
        
        $file_name = File::name($path);
        $extension = File::extension($path);
        $new_path = $file_name.'-deleted-'.time().'.'.$extension;
        if (Storage::move('contact/'.$user_id.'/attachments/'.$attachment,'contact/'.$user_id.'/attachments/'.$new_path)) {
            $file_attachment->uri=$new_path;
            $file_attachment->save();
            $file_attachment->delete();
        }

        return Redirect::action('PersonsController@show',$user_id);
        
    }    
    
    public function get_avatar($user_id)
    {
        $path = storage_path() . '/app/contact/' . $user_id . '/avatar.png';
        //dd($path);
        if(!File::exists($path)) {
            abort(404);
        } else {
            $file = File::get($path);
            $type = File::mimeType($path);

            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
    }
    
    public function delete_avatar($user_id)
    {
        $path = storage_path() . '/app/contact/' . $user_id . '/avatar.png';
        $new_path = 'avatar-deleted-'.time().'.png';
        if(!File::exists($path)) {
            abort(404);
        } 
        Storage::move('contact/'.$user_id.'/avatar.png','contact/'.$user_id.'/'.$new_path); 
            
        return Redirect::action('PersonsController@show',$user_id);
        
    }

    public function get_event_contract($eent_id) {
        return $this->show_attachment('event',$event_id,'contract',NULL);
    }    

    public function get_event_schedule($event_id) {
        return $this->show_attachment('event',$event_id,'schedule',NULL);
    }    

    
    public function get_event_evaluations($event_id) {
        return $this->show_attachment('event',$event_id,'evaluations',NULL);
    }  
    
    public function delete_event_evaluations($event_id) {
        $this->delete_attachment('evaluations.pdf','event',$event_id,'evaluations');
        return Redirect::action('RetreatsController@show',$event_id);
    } 
    public function delete_event_schedule($event_id) {
        $this->delete_attachment('schedule.pdf','event',$event_id,'schedule');
        return Redirect::action('RetreatsController@show',$event_id);
    }

    public function delete_event_contract($event_id) {
        $this->delete_attachment('contract.pdf','event',$event_id,'contract');
        return Redirect::action('RetreatsController@show',$event_id);
    }
    
    public function delete_event_group_photo($event_id) {
           $this->delete_attachment('group_photo.jpg','event',$event_id,'group_photo');
           return Redirect::action('RetreatsController@show',$event_id);
    }

    public function get_event_group_photo($event_id) {
        return $this->show_attachment('event',$event_id,'group_photo',NULL);
    
    }    

}
