<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail as Mail;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::check()) {
            $user_id = Auth::id();

            $items = Item::where('user_id', $user_id)->get();
           
            if ($items) {
                return response()->json(['items' => $items]);
            }

        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        // save an item
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
        ]);

        $newItem = new Item;
        $user_id = Auth::id();
        // $id = Auth::check() ? Auth::id() : true; 

        $user = User::findOrFail($user_id);
        


        $newItem->name = $request->name;
        $newItem->price = $request->price;
        $newItem->user_id = $user_id;
        $newItem->save();
        Mail::send('emails.email', ['user' => $user], function ($m) use ($user) {
            $m->from('todo@app.com');
 
            $m->to($user->email, $user->name)->subject('Item created successfully');
        });
        return $newItem;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $request->validate([
            'name' => ['required', 'string'],
            'price' => ['required'],
        ]);
        $Item = Item::findOrFail($id);

        if ($Item) {
            $Item->id = $id;
            $Item->name = $request->name;
            $Item->price = $request->price;
        }

        $Item->save();
        return [$Item->name, $Item->price];
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
        $existingItem = Item::where('id', $id)->first();
        if ($existingItem) {
            $existingItem->delete();
            return "item deteled sucessfully";
        }

        return "item not found";
    }
}
