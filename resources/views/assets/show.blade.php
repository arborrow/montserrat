@extends('template')
@section('content')

<div class="row bg-cover" style="border:1px;">
    <div class="col-12">
        @can('update-asset')
        <h1>
            Asset details: <strong><a href="{{url('asset/'.$asset->id.'/edit')}}">{{ $asset->name }}</a></strong>
        </h1>
        @else
        <h1>
            Asset details: <strong>{{$asset->name}}</strong>
        </h1>
        @endCan
    </div>
    <div class="col-12">
        <h3 class="text-primary">General information</h3>
        <div class="row">
            <div class="col-3"><strong>Name:</strong> {{$asset->name}}</div>
            <div class="col-3"><strong>Asset Type:</strong>
                <a href="{{ url('asset/type/'.$asset->asset_type_id) }}"> {{$asset->asset_type_name}} </a></div>
            <div class="col-3"><strong>Description:</strong> {{$asset->description}}</div>
            <div class="col-3">
                @if (Storage::has('asset/'.$asset->id.'/asset_photo.jpg'))
                    <img src="{{url('asset/'.$asset->id).'/photo'}}" class="img" style="padding:5px; width:300px;">
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-3"><strong>Manufacturer:</strong> {{$asset->manufacturer}} </div>
            <div class="col-3"><strong>Model:</strong> {{$asset->model}} </div>
            <div class="col-3"><strong>Serial number:</strong> {{$asset->serial_number}} </div>
            <div class="col-3"><strong>Year:</strong> {{$asset->year}} </div>
        </div>
        <div class="row">
            <div class="col-3"><strong>Parent:</strong> {{$asset->parent_name}}</div>
            <div class="col-3"><strong>Location:</strong>
                <a href="{{ url('asset/location/'.$asset->location_id) }}">{{$asset->location_name}}</a></div>
            <div class="col-3"><strong>Department:</strong> {{$asset->department_name}}</div>
            <div class="col-3"><strong>Remarks:</strong> {{$asset->remarks}}</div>
            <div class="col-3"><strong>Status:</strong> {{$asset->status}}</div>
            <div class="col-3"><strong>Active:{{$asset->is_active ? 'Yes':'No'}}</strong></div>
        </div>
        <h3 class="text-primary">Service information</h3>
        <div class="row">
            <div class="col-3"><strong>Manufacturer:</strong> {!!$asset->manufacturer_contact_name_link!!}</div>
            <div class="col-3"><strong>Vendor:</strong> {!!$asset->vendor_name_link!!}</div>
        </div>
        <h3 class="text-primary">Power specifications</h3>
        <div class="row">
            <div class="col-3"><strong>Power line voltage:</strong> {{$asset->power_line_voltage}} {{ $asset->power_line_voltage_uom_name }}</div>
            <div class="col-3"><strong>Power phase voltage:</strong> {{$asset->power_phase_voltage}} {{ $asset->power_phase_voltage_uom_name }}</div>
            <div class="col-3"><strong>Power phases:</strong> {{$asset->power_phases}}</div>
            <div class="col-3"><strong>Power amperage:</strong> {{$asset->power_amp}} {{ $asset->power_amp_uom_name }}</div>
        </div>
        <h3 class="text-primary">Physical specifications</h3>
        <div class="row">
            <div class="col-2"><strong>Length:</strong> {{$asset->length}} {{ $asset->length_uom_name }}</div>
            <div class="col-2"><strong>Width:</strong> {{$asset->width}} {{ $asset->width_uom_name }}</div>
            <div class="col-2"><strong>Height:</strong> {{$asset->height}} {{ $asset->height_uom_name }}</div>
            <div class="col-2"><strong>Weight:</strong> {{$asset->weight}} {{ $asset->weight_uom_name }}</div>
            <div class="col-2"><strong>Capacity:</strong> {{$asset->capacity}} {{ $asset->capacity_uom_name }}</div>
        </div>
        <h3 class="text-primary">Purchase info</h3>
        <div class="row">
            <div class="col-2"><strong>Purchase date:</strong> {{$asset->purchase_day}}</div>
            <div class="col-2"><strong>Purchase price:</strong> {{$asset->purchase_price}}</div>
            <div class="col-2"><strong>Start date:</strong> {{$asset->start_day}}</div>
            <div class="col-2"><strong>End date:</strong> {{$asset->end_day}}</div>
            <div class="col-2"><strong>Life expectancy:</strong> {{$asset->life_expectancy}} {{ $asset->life_expectancy_uom_name }}</div>
            <div class="col-3"><strong>Replacement:</strong>
                @if ($asset->replacement_id > 0)
                <a href="{{ url('asset/'.$asset->replacement_id) }}"> {{$asset->replacement_name}}</a>
                @else
                {{ $asset->replacement_name }}
                @endIf
            </div>
        </div>
        <h3 class="text-primary">Warranty info</h3>
        <div class="row">
            <div class="col-3"><strong>Warranty start date:</strong> {{$asset->warranty_start_day}}</div>
            <div class="col-3"><strong>Warranty end date:</strong> {{$asset->warranty_end_day}}</div>
        </div>
        <h3 class="text-primary">Depreciation info</h3>
        <div class="row">
            <div class="col-3"><strong>Depreciation start date:</strong> {{$asset->depreciation_start_day}}</div>
            <div class="col-3"><strong>Depreciation end date:</strong> {{$asset->depreciation_end_day}}</div>
            <div class="col-3"><strong>Depreciation type:</strong> {{$asset->depreciation_type_id}}</div>
            <div class="col-3"><strong>Depreciation rate:</strong> {{$asset->depreciation_rate}}</div>
            <div class="col-3"><strong>Depreciation value:</strong> {{$asset->depreciation_value}}</div>
            <div class="col-3"><strong>Depreciation time:</strong> {{$asset->depreciation_time}} {{ $asset->depreciation_time_uom_name }}</div>
        </div>
        <h3 class="text-primary">Attachments ({{ $files->count() }})</h3>
        <div class="row">
            <div class="col-12 mt-3" id="attachments">
                @if ($files->isEmpty())
                    <p>There are no attachments for this asset.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Uploaded date</th>
                                <th>MIME type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($files->sortByDesc('upload_date') as $file)
                            <tr>
                                <td><a href="{{url('asset/'.$asset->id.'/attachment/'.$file->uri)}}">{{ $file->uri }}</a></td>
                                <td>{{$file->description}}</td>
                                <td>{{ $file->upload_date}}</td>
                                <td>{{ $file->mime_type }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <h3 class="text-primary">Website(s)</h3>
        <div class="row">
            <div class="col-12 mt-3" id="attachments">
                @if ($asset->websites->isEmpty())
                    <p>There are no websites associated with this asset.</p>
                @else
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Website</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asset->websites->sortByDesc('created_date') as $website)
                            <tr>
                                <td>
                                    @can('show-website')
                                        <a href="{{ URL('admin/website/'.$website->id) }}">{{$website->description}}</a>
                                    @else
                                        {{$website->description}}
                                    @endCan
                                </td>
                                <td><a href="{{$website->url}}">{{ $website->url }}</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <h3 class="text-primary">Tasks</h3>
        <div class="row">
            <div class="col-12 mt-3" id="attachments">
                @if ($asset->tasks->isEmpty())
                    <p>There are no tasks for this asset.</p>
                @else
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Dates (Start - Until)</th>
                                <th>Frequency</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asset->tasks->sortByDesc('scheduled_date') as $task)
                            <tr>
                                <td><a href="{{ URL('asset_task/'.$task->id) }}"> {{$task->title}} </a></td>
                                <td>{{$task->start_date}} - {{ $task->scheduled_until_date }}</td>
                                <td>{{$task->frequency}}</td>
                                <td>{{$task->priority}} </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-6 text-right">
                @can('update-asset')
                <a href="{{ action('AssetController@edit', $asset->id) }}" class="btn btn-info">{!! Html::image('images/edit.png', 'Edit',array('title'=>"Edit")) !!}</a>
                @endCan
            </div>
            <div class="col-6 text-left">
                @can('delete-asset')
                {!! Form::open(['method' => 'DELETE', 'route' => ['asset.destroy', $asset->id],'onsubmit'=>'return ConfirmDelete()']) !!}
                {!! Form::image('images/delete.png','btnDelete',['class' => 'btn btn-danger','title'=>'Delete']) !!}
                {!! Form::close() !!}
                @endCan
            </div>
        </div>
    </div>
</div>

@stop
