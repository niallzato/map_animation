<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function statedata(){
    	//dd(\Request::all());

    	$request = \Request::all();
    	//dd($request['site']);
        $validator = \Validator::make($request, [
            'start' => 'required|numeric',
            'end' => 'required|numeric',
            'site' => 'required',
        ]);

        if ($validator->fails()) {
          dd($validator->errors());
        }
        else{

		$entries = \DB::table('conflict_geo')
	        ->join('conflict', function($join) use($request)
	        {
	            $join->on('conflict.id', '=', 'conflict_geo.id')
	            ->on('conflict.YEAR', '=', 'conflict_geo.year')
	            ->whereIn('conflict.Region', $request['site'])
	            ->where('conflict_geo.year','>=',$request['start'])
	            ->where('conflict_geo.year','<=',$request['end']);
	        })
	        ->orderBy('conflict_geo.year')
	        ->get();

	        //dd($entries);

			//$conflicts = json_encode($entries);
			//$entries = count($entries);

            //\Request::session()->put('text',$random);

        	return response()->json($entries);
        }

    }
}
