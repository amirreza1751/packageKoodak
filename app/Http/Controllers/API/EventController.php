<?php

namespace App\Http\Controllers\API;

use App\Event;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $request->all();
        if (isset($request['Sub_unsub'])){
            foreach ($request['Sub_unsub'] as $item){

                Event::create($item);

                if ($item['event-type'] == 1.1){     /** yani karbar subscribe shode */
                    $user = User::where('mobile_number', $item['msisdn'])->first();
                    if (!isset($user)){     /** dare check mikone ke age in karbar ghablan sabt shode bude dobare nasazesh. */
                        User::create([
                            'mobile_number' => $item['msisdn']
                        ]);
                    }
                }
                if ($item['event-type'] == 1.2){     /** yani karbar un-subscribe shode */
                    $user = User::where('mobile_number', $item['msisdn'])->first();
                    if (isset($user)){     /** dare check mikone ke age in karbar vojud dare pakesh kone. */
                        $user->delete();
                    }
                }
            }
            return response()->json('Stored.', 200);
        }

        elseif (isset($request['charges'])){
            foreach ($request['charges'] as $item){
                Event::create($item);
            }
            return response()->json(['status' => 'Stored.'], 200);
        }

        else return response()->json(['status' =>'Bad request'], 400);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
