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

        $data = $data = DB::table('cities')
        ->orderBy('cities.name')
        ->select('cities.id', 'cities.name', 'regions.name AS region_name')
        ->join('regions', 'cities.region_id', '=', 'regions.id');
        if ($request->has('q')) {
            $search = $request->q;
            # Query City Name
            $data->where('cities.name', 'LIKE', "%$search%");
        }

        $data = $data->where('cities.country_id', '=', '230')  # Only US Cities ( US Country ID )
                ->take(10)  # Limit Search Record
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

        $data = $data->take(10)  # Limit Search Record
                ->get()
                ->toArray();

        return response()->json($data);
    }
}
