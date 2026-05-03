<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Http\Requests\UpdateAttachmentRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Illuminate\Routing\Attributes\Controllers\Middleware;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\Facades\Image;

#[Middleware('auth')]
class AttachmentController extends Controller
{
    public function sanitize_filename($filename)
    {
        $sanitized = preg_replace('/[^a-zA-Z0-9\\-\\._]/', '', $filename);

        return $sanitized;
    }

    public function show_attachment($entity, $entity_id, $type = 'attachment', $file_name = null)
    {
        switch ($type) {
            case 'attachment':
                Gate::authorize('show-attachment');
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/attachments/'.$file_name;
                break;
            case 'avatar':
                Gate::authorize('show-avatar');
                $file_name = 'avatar.png';
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
            case 'event-attachment':
                Gate::authorize('show-event-attachment');
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/attachments/'.$file_name;
                break;
            case 'schedule':
                Gate::authorize('show-event-schedule');
                $file_name = 'schedule.pdf';
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
            case 'contract':
                Gate::authorize('show-event-attachment');
                $file_name = 'contract.pdf';
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
            case 'evaluations':
                Gate::authorize('show-event-evaluation');
                $file_name = 'evaluations.pdf';
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
            case 'group_photo':
                Gate::authorize('show-event-group-photo');
                $file_name = 'group_photo.jpg';
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
            case 'asset_photo':
                Gate::authorize('show-asset');
                $file_name = 'asset_photo.jpg';
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
            case 'signature':
                Gate::authorize('show-signature');
                $file_name = 'signature.png';
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
            default:
                Gate::authorize('show-attachment');
                $path = storage_path().'/app/private/'.$entity.'/'.$entity_id.'/'.$file_name;
                break;
        }
        // dd($path);
        if (! File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = response($file);
        $response->header('Content-Type', $type);

        return $response;
    }

    #[Authorize('create-attachment')]
    public function store_attachment($file, $entity = 'event', $entity_id = 0, $type = null, $description = null)
    {   // TODO: Not sure if this is being called from anywhere but contact attachments seems to be missing the attachments folder in the path (see update_attachment method)
        $file_name = $this->sanitize_filename($file->getClientOriginalName());
        $attachment = new \App\Models\Attachment;
        $attachment->mime_type = $file->getClientMimeType();
        $attachment->description = $description;
        $attachment->upload_date = \Carbon\Carbon::now();
        $attachment->entity = $entity;
        $attachment->entity_id = $entity_id;
        switch ($type) {
            case 'contract':
                Gate::authorize('create-event-contract');
                $attachment->file_type_id = config('polanco.file_type.event_contract');
                $attachment->uri = 'contract.pdf';
                break;
            case 'schedule':
                Gate::authorize('create-event-schedule');
                $attachment->file_type_id = config('polanco.file_type.event_schedule');
                $attachment->uri = 'schedule.pdf';
                break;
            case 'evaluation':
                Gate::authorize('create-event-evaluation');
                $attachment->file_type_id = config('polanco.file_type.event_evaluation');
                $attachment->uri = 'evaluations.pdf';
                break;
            case 'group_photo':
                Gate::authorize('create-event-group-photo');
                $attachment->file_type_id = config('polanco.file_type.event_group_photo');
                $attachment->uri = 'group_photo.jpg';
                break;
            case 'asset_photo':
                Gate::authorize('update-asset');
                $attachment->file_type_id = config('polanco.file_type.asset_photo');
                $attachment->uri = 'asset_photo.jpg';
                break;
            case 'attachment':
                Gate::authorize('create-attachment');
                $attachment->file_type_id = config('polanco.file_type.contact_attachment');
                $attachment->uri = $file_name;
                break;
            case 'avatar':
                Gate::authorize('create-avatar');
                $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();
                $attachment->file_type_id = config('polanco.file_type.contact_avatar');
                $attachment->uri = 'avatar.png';
                break;
            case 'signature':
                Gate::authorize('create-signature');
                $attachment->file_type_id = config('polanco.file_type.signature');
                $attachment->uri = 'signature.png';
                break;
            default:
                Gate::authorize('create-attachment');
                $attachment->file_type_id = 0;
                $attachment->uri = $file_name;
                break;
        }
        $attachment->save();
        // write file to filesystem (attachments seems to be missing attachments path - evaluate when implementing generic event attachments)
        switch ($type) {
            case 'avatar':
                Storage::disk('local')->put($entity.'/'.$entity_id.'/'.'avatar.png', $avatar->stream('png'));
                break;
            case 'signature':
                Storage::disk('local')->put($entity.'/'.$entity_id.'/'.'signature.png', File::get($file));
                break;
            default:
                Storage::disk('local')->put($entity.'/'.$entity_id.'/'.$attachment->uri, File::get($file));
                break;
        }
    }

    public function update_attachment($file, $entity = 'event', $entity_id = 0, $type = null, $description = null)
    {
        $path = $entity.'/'.$entity_id.'/';
        // dd($file->extension());

        switch ($type) {
            case 'avatar':
                Gate::authorize('create-avatar'); // if you can create it you can update it
                $file_type_id = config('polanco.file_type.contact_avatar');
                $file_name = 'avatar.png';
                $updated_file_name = 'avatar-updated-'.time().'.png';
                $mime_type = $file->getClientMimeType();
                $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();

                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::put($path.$file_name, $avatar->stream('png'));
                } else {
                    $avatar = Image::make($file->getRealPath())->fit(150, 150)->orientate();
                    Storage::put($entity.'/'.$entity_id.'/'.$file_name, $avatar->stream('png'));
                }

                break;
            case 'attachment':
                Gate::authorize('create-attachment');
                $file_type_id = ($entity == 'asset') ? config('polanco.file_type.asset_attachment') : config('polanco.file_type.contact_attachment');
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_name = $this->sanitize_filename($file->getClientOriginalName());
                $mime_type = $file->getClientMimeType();
                $file_extension = '$file->extension()';
                $updated_file_name = basename($file_name, '.'.$file_extension).'-updated-'.time().'.'.$file_extension;
                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'acknowledgment':
                Gate::authorize('create-attachment');
                $now = Carbon::now();
                $filename = $now->format('YmdHi').'-acknowledgment-'.$entity_id.'.pdf';
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_type_id = config('polanco.file_type.contact_attachment');
                $file_name = $this->sanitize_filename($filename);
                $updated_file_name = basename($file_name, '.pdf').'-updated-'.time().'.pdf';
                $mime_type = 'application/pdf';
                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, $file);
                } else {
                    Storage::disk('local')->put($path.$file_name, $file);
                }
                break;
            case 'gift_certificate':
                Gate::authorize('create-attachment');
                $now = Carbon::now();
                $filename = $description.'.pdf';
                $description = 'Gift Certificate #'.$description;
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_type_id = config('polanco.file_type.contact_attachment');
                $file_name = $this->sanitize_filename($filename);
                $updated_file_name = basename($file_name, '.pdf').'-updated-'.time().'.pdf';
                $mime_type = 'application/pdf';
                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, $file);
                } else {
                    Storage::disk('local')->put($path.$file_name, $file);
                }
                break;
            case 'event_attachment':
                Gate::authorize('create-event-attachment');
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_type_id = config('polanco.file_type.event_attachment');
                $file_name = $this->sanitize_filename($file->getClientOriginalName());
                $mime_type = $file->getClientMimeType();
                $file_extension = $file->extension();
                $updated_file_name = basename($file_name, '.'.$file_extension).'-updated-'.time().'.'.$file_extension;

                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'schedule':
                Gate::authorize('create-event-schedule');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_schedule');
                $file_name = 'schedule.pdf';
                $mime_type = $file->getClientMimeType();
                $updated_file_name = 'schedule-updated-'.time().'.pdf';

                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'contract':
                Gate::authorize('create-event-contract');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_contract');
                $file_name = 'contract.pdf';
                $mime_type = $file->getClientMimeType();
                $updated_file_name = 'contract-updated-'.time().'.pdf';

                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'evaluations':
                Gate::authorize('create-event-evaluation');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_evaluation');
                $file_name = 'evaluations.pdf';
                $mime_type = $file->getClientMimeType();
                $updated_file_name = 'evaluations-updated-'.time().'.pdf';

                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                } else {
                    Storage::disk('local')->put($path.$file_name, File::get($file));
                }
                break;
            case 'group_photo':
                Gate::authorize('create-event-group-photo');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.event_group_photo');
                $file_name = 'group_photo.jpg';
                $updated_file_name = 'group_photo-updated-'.time().'.jpg';
                $group_photo = Image::make($file->getRealPath());
                $mime_type = $group_photo->mime();
                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, $group_photo->stream('jpg'));
                } else {
                    Storage::disk('local')->put($path.$file_name, $group_photo->stream('jpg'));
                }
                break;
            case 'asset_photo':
                Gate::authorize('update-asset');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.asset_photo');
                $file_name = 'asset_photo.jpg';
                $updated_file_name = 'asset_photo-updated-'.time().'.jpg';
                $asset_photo = Image::make($file->getRealPath());
                $mime_type = $asset_photo->mime();
                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, $asset_photo->stream('jpg'));
                } else {
                    Storage::disk('local')->put($path.$file_name, $asset_photo->stream('jpg'));
                }
                break;
            case 'signature':
                Gate::authorize('create-signature');
                $path = $entity.'/'.$entity_id.'/';
                $file_type_id = config('polanco.file_type.signature');
                $file_name = 'signature.png';
                $mime_type = $file->getClientMimeType();
                $updated_file_name = 'signature-updated-'.time().'.png';
                $signature = Image::make($file->getRealPath());
                if (File::exists(storage_path().'/app/private/'.$path.$file_name)) {
                    Storage::move($path.$file_name, $path.$updated_file_name);
                    Storage::disk('local')->put($path.$file_name, $signature->stream('png'));
                } else {
                    Storage::disk('local')->put($path.$file_name, $signature->stream('png'));
                }
                break;

            default:
                Gate::authorize('create-attachment');
                break;
        }
        $attachment = \App\Models\Attachment::firstOrNew(['entity' => $entity, 'entity_id' => $entity_id, 'file_type_id' => $file_type_id, 'uri' => $file_name]);
        $attachment->upload_date = \Carbon\Carbon::now();
        $attachment->description = $description;
        $attachment->mime_type = $mime_type;
        $attachment->uri = $file_name;

        $attachment->save();
    }

    #[Authorize('delete-attachment')]
    public function delete_attachment($file_name, $entity = 'event', $entity_id = 0, $type = null): RedirectResponse
    {
        $path = $entity.'/'.$entity_id.'/';
        switch ($type) {
            case 'group_photo':
                $file_name = 'group_photo.jpg';
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_group_photo'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'group_photo-deleted-'.time().'.jpg';
                break;
            case 'asset_photo':
                $file_name = 'asset_photo.jpg';
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.asset_photo'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'asset_photo-deleted-'.time().'.jpg';
                break;
            case 'contract':
                $file_name = 'contract.pdf';
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_contract'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'contract-deleted-'.time().'.pdf';
                break;
            case 'schedule':
                $file_name = 'schedule.pdf';
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_schedule'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'schedule-deleted-'.time().'.pdf';
                break;
            case 'evaluations':
                $file_name = 'evaluations.pdf';
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_evaluation'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'evaluations-deleted-'.time().'.pdf';
                break;
            case 'attachment':
                $file_type_id = ($entity == 'asset') ? config('polanco.file_type.asset_attachment') : config('polanco.file_type.contact_attachment');
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId($file_type_id)->firstOrFail();
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_extension = File::extension($path.$file_name);
                $file_basename = File::name($path.$file_name);
                $updated_file_name = $file_basename.'-deleted-'.time().'.'.$file_extension;
                break;
            case 'event-attachment':
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.event_attachment'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/attachments/';
                $file_extension = File::extension($path.$file_name);
                $file_basename = File::name($path.$file_name);
                $updated_file_name = $file_basename.'-deleted-'.time().'.'.$file_extension;
                break;
            case 'avatar':
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.contact_avatar'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/';
                $updated_file_name = 'avatar-deleted-'.time().'.png';
                break;
            case 'signature':
                $attachment = \App\Models\Attachment::whereEntity($entity)->whereEntityId($entity_id)->whereUri($file_name)->whereFileTypeId(config('polanco.file_type.contact_attachment'))->firstOrFail();
                $path = $entity.'/'.$entity_id.'/attachments/';
                $updated_file_name = 'signature-deleted-'.time().'.png';
                break;

            default:
                break;
        }

        if (! File::exists(storage_path().'/app/private/'.$path.$file_name)) {
            abort(404);
        }
        if (Storage::move($path.$file_name, $path.$updated_file_name)) {
            $attachment->uri = $updated_file_name;
            $attachment->save();
            $attachment->delete();
        }

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $entity_id);
    }

    #[Authorize('show-attachment')]
    public function show_contact_attachment($user_id, $file_name)
    {
        return $this->show_attachment('contact', $user_id, 'attachment', $file_name);
    }

    #[Authorize('show-event-attachment')]
    public function show_event_attachment($event_id, $file_name)
    {
        return $this->show_attachment('event', $event_id, 'event-attachment', $file_name);
    }

    #[Authorize('delete-attachment')]
    public function delete_contact_attachment($user_id, $attachment): RedirectResponse
    {
        $this->delete_attachment($attachment, 'contact', $user_id, 'attachment');

        // TODO: get contact type and redirect to person, parish, organization, vendor as appropriate
        return Redirect::action([\App\Http\Controllers\PersonController::class, 'show'], $user_id);
    }

    #[Authorize('delete-attachment')]
    public function delete_event_attachment($event_id, $attachment): RedirectResponse
    {
        $this->delete_attachment($attachment, 'event', $event_id, 'event-attachment');

        // TODO: get contact type and redirect to person, parish, organization, vendor as appropriate
        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $event_id);
    }

    #[Authorize('show-avatar')]
    public function get_avatar($user_id)
    {
        return $this->show_attachment('contact', $user_id, 'avatar', 'avatar.png');
    }

    public function get_signature($contact_id)
    {
        // $this->authorize('show-signature');

        return $this->show_attachment('contact', $contact_id, 'signature', 'signature.png');
    }

    #[Authorize('delete-attachment')]
    public function delete_avatar($user_id): RedirectResponse
    {
        $this->delete_attachment('avatar.png', 'contact', $user_id, 'avatar');

        return Redirect::action([\App\Http\Controllers\PersonController::class, 'show'], $user_id);
    }

    #[Authorize('show-event-attachment')]
    public function get_event_contract($event_id)
    {
        return $this->show_attachment('event', $event_id, 'contract', null);
    }

    #[Authorize('show-event-schedule')]
    public function get_event_schedule($event_id)
    {
        return $this->show_attachment('event', $event_id, 'schedule', null);
    }

    #[Authorize('show-event-evaluation')]
    public function get_event_evaluations($event_id)
    {
        return $this->show_attachment('event', $event_id, 'evaluations', null);
    }

    #[Authorize('delete-attachment')]
    public function delete_event_evaluations($event_id): RedirectResponse
    {
        $this->delete_attachment('evaluations.pdf', 'event', $event_id, 'evaluations');

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $event_id);
    }

    #[Authorize('delete-attachment')]
    public function delete_event_schedule($event_id): RedirectResponse
    {
        $this->delete_attachment('schedule.pdf', 'event', $event_id, 'schedule');

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $event_id);
    }

    #[Authorize('delete-attachment')]
    public function delete_event_contract($event_id): RedirectResponse
    {
        $this->delete_attachment('contract.pdf', 'event', $event_id, 'contract');

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $event_id);
    }

    #[Authorize('delete-attachment')]
    public function delete_event_group_photo($event_id): RedirectResponse
    {
        $this->delete_attachment('group_photo.jpg', 'event', $event_id, 'group_photo');

        return Redirect::action([\App\Http\Controllers\RetreatController::class, 'show'], $event_id);
    }

    #[Authorize('show-event-group-photo')]
    public function get_event_group_photo($event_id)
    {
        return $this->show_attachment('event', $event_id, 'group_photo', null);
    }

    #[Authorize('delete-attachment')]
    public function delete_asset_photo($asset_id): RedirectResponse
    {
        $this->delete_attachment('asset_photo.jpg', 'asset', $asset_id, 'asset_photo');

        return Redirect::action([\App\Http\Controllers\AssetController::class, 'show'], $asset_id);
    }

    #[Authorize('show-asset')]
    public function get_asset_photo($asset_id)
    {
        return $this->show_attachment('asset', $asset_id, 'asset_photo', null);
    }

    #[Authorize('show-attachment')]
    public function show_asset_attachment($asset_id, $file_name)
    {
        return $this->show_attachment('asset', $asset_id, 'attachment', $file_name);
    }

    #[Authorize('delete-attachment')]
    public function delete_asset_attachment($asset_id, $file_name): RedirectResponse
    {
        $this->delete_attachment($file_name, 'asset', $asset_id, 'attachment');

        return Redirect::action([\App\Http\Controllers\AssetController::class, 'show'], $asset_id);
    }

    /**
     * Display the specified resource.
     */
    #[Authorize('show-attachment')]
    public function show(int $id): View
    {
        $attachment = \App\Models\Attachment::findOrFail($id);
        // $this->authorize('show-'.$attachment->entity);

        return view('attachments.show', compact('attachment')); //
    }

    /**
     * Show the form for editing the specified resource.
     */
    #[Authorize('update-attachment')]
    public function edit(int $id): View
    {
        $attachment = \App\Models\Attachment::findOrFail($id);

        return view('attachments.edit', compact('attachment'));
    }

    /**
     * Update the specified resource in storage.
     * Really only used to allow for changing the description of a file
     */
    #[Authorize('update-attachment')]
    public function update(UpdateAttachmentRequest $request, int $id): RedirectResponse
    {
        $attachment = \App\Models\Attachment::findOrFail($id);
        $attachment->description = $request->input('description');
        $attachment->save();

        flash('Attachment: <a href="'.url('/attachment/'.$attachment->id).'">'.$attachment->uri.'</a> updated')->success();

        return Redirect::action([self::class, 'show'], $id);
    }

    /**
     * Display a listing of the resource.
     */
    #[Authorize('show-attachment')]
    public function index(): View
    {
        $attachments = \App\Models\Attachment::orderByDesc('upload_date')->paginate(25, ['*'], 'attachments');

        return view('attachments.index', compact('attachments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    #[Authorize('create-attachment')]
    public function create(): RedirectResponse
    {
        flash('Attachment create route is undefined. To create an attachment upload it using the asset, contact or event pages.')->warning()->important();

        return Redirect::back();   //
    }

    /**
     * Store a newly created resource in storage.
     */
    #[Authorize('create-attachment')]
    public function store(StoreAttachmentRequest $request): RedirectResponse
    {
        flash('Storing attachment is undefined.')->warning()->important();

        return Redirect::back();
    }

    /**
     * Remove the specified resource from storage.
     */
    #[Authorize('delete-attachment')]
    public function destroy(int $id): RedirectResponse
    {
        flash('Deleting attachment method is undefined.')->warning()->important();

        return Redirect::back();
    }
}
