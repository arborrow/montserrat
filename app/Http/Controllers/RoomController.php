<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('show-room');
        // TODO: consider eager loading building name and sorting on room.location.name
        $rooms = \App\Room::with('location')->get();
        $roomsort = $rooms->sortBy(function ($building) {
            return sprintf('%-12s%s', $building->location->name, $building->name);
        });

        return view('rooms.index', compact('roomsort'));   //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-room');
        $locations = \App\Location::orderby('name')->pluck('name', 'id');

        return view('rooms.create', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
        $this->authorize('create-room');

        $room = new \App\Room;
        $room->location_id = $request->input('location_id');
        $room->name = $request->input('name');
        $room->description = $request->input('description');
        $room->notes = $request->input('notes');
        $room->access = $request->input('access');
        $room->type = $request->input('type');
        $room->occupancy = $request->input('occupancy');
        $room->status = $request->input('status');
        $room->save();

        return Redirect::action('RoomController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('show-room');
        $room = \App\Room::findOrFail($id);
        $building = \App\Room::findOrFail($id)->location;
        $room->building = $building->name;

        return view('rooms.show', compact('room')); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('update-room');
        $locations = \App\Location::orderby('name')->pluck('name', 'id');
        $room = \App\Room::findOrFail($id);

        return view('rooms.edit', compact('room', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request, $id)
    {
        $this->authorize('update-room');

        $room = \App\Room::findOrFail($request->input('id'));
        $room->location_id = $request->input('location_id');
        $room->name = $request->input('name');
        $room->description = $request->input('description');
        $room->notes = $request->input('notes');
        $room->access = $request->input('access');
        $room->type = $request->input('type');
        $room->occupancy = $request->input('occupancy');
        $room->status = $request->input('status');
        $room->save();

        return Redirect::action('RoomController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-room');
        \App\Room::destroy($id);

        return Redirect::action('RoomController@index');
    }

    /**
     * Display the room schedules for a particular month/year - default this month.
     *
     * @param  int  $ym
     * @return \Illuminate\Http\Response
     */
    public function schedule($ym = null, $building = null)
    // TODO: $ym is really the start_date (yyyymmdd) and $building is not used and should be removed
    {
        $this->authorize('show-room');
        if ((! isset($ym)) or ($ym == 0)) {
            $dt = Carbon::now();
        //dd($dt);
        } else {
            if (! $dt = Carbon::parse($ym)) {
                return view('404');
            }
        }
        $upcoming = clone $dt;
        $previous_dt = clone $dt;
        $prev_path = url('rooms/'.$previous_dt->subDays(31)->format('Ymd'));
        $previous_link = '<a href="'.$prev_path.'">&#171;</a>';
        $dts[0] = $dt;
        //dd($dts);
        for ($i = 1; $i <= 31; $i++) {
            $dts[$i] = Carbon::parse($upcoming->addDays((1)));
        }

        $next_path = url('rooms/'.$upcoming->format('Ymd'));
        $next_link = '<a href="'.$next_path.'">&#187;</a>';

        $rooms = \App\Room::with('location')->get();
        $roomsort = $rooms->sortBy(function ($room) {
            return sprintf('%-12s%s', $room->location_id, $room->name);
        });

        $registrations_start = \App\Registration::with('room', 'room.location', 'retreatant', 'retreat')->whereNull('canceled_at')->where('room_id', '>', 0)->whereHas('retreat', function ($query) use ($dts) {
            $query->where('start_date', '>=', $dts[0])->where('start_date', '<=', $dts[30]);
        })->get();
        $registrations_end = \App\Registration::with('room', 'room.location', 'retreatant', 'retreat')->whereNull('canceled_at')->where('room_id', '>', 0)->whereHas('retreat', function ($query) use ($dts) {
            $query->where('end_date', '>=', $dts[0])->where('start_date', '<=', $dts[0]);
        })->get();

        // create matrix of rooms and dates
        foreach ($rooms as $room) {
            foreach ($dts as $dt) {
                //dd($dt);
                $m[$room->id][$dt->toDateString()]['status'] = 'A';
                $m[$room->id][$dt->toDateString()]['registration_id'] = null;
                $m[$room->id][$dt->toDateString()]['retreatant_id'] = null;
                $m[$room->id][$dt->toDateString()]['retreatant_name'] = null;

                $m[$room->id]['room'] = $room->name;
                $m[$room->id]['building'] = $room->location->name;
                $m[$room->id]['occupancy'] = $room->occupancy;
            }
        }

        /*
         * for each registration, get the number of days
         * for each day, check if the status is set (in other words it is in the room schedule matrix)
         * if it is in the matrix update the status to reserved
         */

        foreach ($registrations_start as $registration) {
            $start_time=$registration->retreat->start_date->hour+(($registration->retreat->start_date->minute/100));
            $end_time=$registration->retreat->end_date->hour+(($registration->retreat->end_date->minute/100));
            $numdays = ($registration->retreat->end_date->diffInDays($registration->retreat->start_date));
            $numdays = ($start_time>$end_time) ? $numdays+1 : $numdays;
            for ($i = 0; $i <= $numdays; $i++) {
                $matrixdate = $registration->retreat->start_date->copy()->addDays($i);
                if (array_key_exists($matrixdate->toDateString(), $m[$registration->room_id])) {
                    $m[$registration->room_id][$matrixdate->toDateString()]['status'] = 'R';
                    if (! empty($registration->arrived_at) && empty($registration->departed_at)) {
                        $m[$registration->room_id][$matrixdate->toDateString()]['status'] = 'O';
                    }
                    $m[$registration->room_id][$matrixdate->toDateString()]['registration_id'] = $registration->id;
                    $m[$registration->room_id][$matrixdate->toDateString()]['retreatant_id'] = $registration->contact_id;
                    $m[$registration->room_id][$matrixdate->toDateString()]['retreatant_name'] = $registration->retreatant->display_name;
                    $m[$registration->room_id][$matrixdate->toDateString()]['retreat_name'] = $registration->retreat_name;

                    /* For now just handle marking the room as reserved with a URL to the registration and name in the title when hovering over it
                     * I am thinking about using diffInDays to see if the retreatant arrived on the day that we are looking at or sooner
                     * If they have not yet arrived then the first day should be reserved but not occupied.
                     * Occupied will be the same link to the registration.
                     */
                }
            }
        }
        foreach ($registrations_end as $registration) {
            $start_time=$registration->retreat->start_date->hour+(($registration->retreat->start_date->minute/100));
            $end_time=$registration->retreat->end_date->hour+(($registration->retreat->end_date->minute/100));
            $numdays = ($registration->retreat->end_date->diffInDays($registration->retreat->start_date));
            $numdays = ($start_time>$end_time) ? $numdays+1 : $numdays;
            for ($i = 0; $i <= $numdays; $i++) {
                $matrixdate = $registration->retreat->start_date->copy()->addDays($i);
                if (array_key_exists($matrixdate->toDateString(), $m[$registration->room_id])) {
                    $m[$registration->room_id][$matrixdate->toDateString()]['status'] = 'R';
                    if (! empty($registration->arrived_at) && empty($registration->departed_at)) {
                        $m[$registration->room_id][$matrixdate->toDateString()]['status'] = 'O';
                    }
                    $m[$registration->room_id][$matrixdate->toDateString()]['registration_id'] = $registration->id;
                    $m[$registration->room_id][$matrixdate->toDateString()]['retreatant_id'] = $registration->contact_id;
                    $m[$registration->room_id][$matrixdate->toDateString()]['retreatant_name'] = $registration->retreatant->display_name;
                    $m[$registration->room_id][$matrixdate->toDateString()]['retreat_name'] = $registration->retreat_name;

                    /* For now just handle marking the room as reserved with a URL to the registration and name in the title when hovering over it
                     * I am thinking about using diffInDays to see if the retreatant arrived on the day that we are looking at or sooner
                     * If they have not yet arrived then the first day should be reserved but not occupied.
                     * Occupied will be the same link to the registration.
                     */
                }
            }
        }

        return view('rooms.sched2', compact('dts', 'roomsort', 'm', 'previous_link', 'next_link'));
    }
}
