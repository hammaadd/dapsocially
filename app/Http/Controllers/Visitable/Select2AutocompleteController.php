<?php

namespace App\Http\Controllers\Visitable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use App\Models\Cities;

class Select2AutocompleteController extends Controller
{
    // All Select2 Ajax Request Handler


    public function dataCitiesAjax(Request $request)
    {

        $data = $data = DB::table('cities_dd')
        ->orderBy('cities_dd.id')
        ->select('cities_dd.id', 'cities_dd.name');
        // ->join('regions', 'cities_dd.region_id', '=', 'regions.id');
        if ($request->has('q')) {
            $search = $request->q;
            # Query City Name
            $data->where('cities_dd.name', 'LIKE', "%$search%")
            ->orderBy('cities_dd.name');
        }

        $data = $data->take(env('cities_dd_limit'))  # Limit Search Record
                ->get()
                ->toArray();

        return response()->json($data);
    }

    public function dataLocationsAjax(Request $request)
    {

        $data = $data = DB::table('venues')
        ->orderBy('venues.venue_name')
        ->select('venues.id', 'venues.venue_name');
        if ($request->has('q')) {
            $search = $request->q;
            # Query City Name
            $data->where('venues.venue_name', 'LIKE', "%$search%");
        }

        $data = $data->take(env('locations_dd_limit'))  # Limit Search Record
                ->get()
                ->toArray();

        return response()->json($data);
    }
}
