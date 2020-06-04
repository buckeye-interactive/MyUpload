<?php

namespace App\Http\Controllers;

use App\Ban;
use Illuminate\Http\Request;

class BanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bans = Ban::all();
        return view('auth.ban', ['bans' => $bans]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
        ]);
        Ban::create($request->all());
        return redirect(route('ban.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Ban  $ban
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ban $ban)
    {
        $ban->delete();
        return redirect(route('ban.index'));
    }
}
