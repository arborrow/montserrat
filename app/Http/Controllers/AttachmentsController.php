<?php


namespace montserrat\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Response;
use Image;


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


    public function create_attachment($file, $entity='events',$entity_id=0, $type=NULL,$description=NULL) {
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

        


        public function get_event_contract($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/contract.pdf';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }    

    public function get_event_schedule($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/schedule.pdf';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }    

    
    public function get_event_evaluations($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/evaluations.pdf';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }  
    /* Since soft deletes are being used in the model, 
     * I am doing a type of soft delete of files by renaming to deleted-unix_timestamp
     * TODO: on update, check if file already exists and if so, rename it to updated-unix_timestamp */
    
    public function delete_event_evaluations($event_id) {
        $evaluation = \montserrat\Attachment::whereEntity('event')->whereEntityId($event_id)->whereUri('evaluations.pdf')->firstOrFail();
        $path = storage_path() . '/app/events/'.$event_id.'/evaluations.pdf';
        $new_path = 'evaluations-deleted-'.time().'.pdf';
        if(!File::exists($path)) abort(404);
        if (Storage::move('events/'.$event_id.'/evaluations.pdf','events/'.$event_id.'/'.$new_path)) {
            $evaluation->uri=$new_path;
            $evaluation->save();
            $evaluation->delete();
        }
            
        return Redirect::action('RetreatsController@show',$event_id);
    } 
    public function delete_event_schedule($event_id) {
        $schedule = \montserrat\Attachment::whereEntity('event')->whereEntityId($event_id)->whereUri('schedule.pdf')->firstOrFail();
        //dd($evaluation);
        $path = storage_path() . '/app/events/'.$event_id.'/schedule.pdf';
        $new_path = 'contract-deleted-'.time().'.pdf';
        if(!File::exists($path)) abort(404);
        if (Storage::move('events/'.$event_id.'/schedule.pdf','events/'.$event_id.'/'.$new_path)) {
            $schedule->uri = $new_path;
            $schedule->save();
            $schedule->delete();
        }
            
        return Redirect::action('RetreatsController@show',$event_id);
    }

    public function delete_event_contract($event_id) {
        $contract = \montserrat\Attachment::whereEntity('event')->whereEntityId($event_id)->whereUri('contract.pdf')->firstOrFail();
        $path = storage_path() . '/app/events/'.$event_id.'/contract.pdf';
        $new_path = 'contract-deleted-'.time().'.pdf';
        if(!File::exists($path)) abort(404);
        if (Storage::move('events/'.$event_id.'/contract.pdf','events/'.$event_id.'/'.$new_path)) {
            $contract->uri=$new_path;
            $contract->save();
            $contract->delete();
        }
            
        return Redirect::action('RetreatsController@show',$event_id);
    }
    
    public function delete_event_group_photo($event_id) {
        $group_photo = \montserrat\Attachment::whereEntity('event')->whereEntityId($event_id)->whereUri('group_photo.jpg')->firstOrFail();
        $path = storage_path() . '/app/events/'.$event_id.'/group_photo.jpg';
        $new_path = 'group_photo-deleted-'.time().'.jpg';
        if(!File::exists($path)) abort(404);
        if (Storage::move('events/'.$event_id.'/group_photo.jpg','events/'.$event_id.'/'.$new_path)) {
            $group_photo->uri=$new_path;
            $group_photo->save();
            $group_photo->delete();
        }
            
        return Redirect::action('RetreatsController@show',$event_id);
    }

    public function get_event_group_photo($event_id) {
        $path = storage_path() . '/app/events/'.$event_id.'/group_photo.jpg';
        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }    

}
