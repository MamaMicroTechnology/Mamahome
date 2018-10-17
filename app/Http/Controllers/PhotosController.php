<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PhotosController extends Controller
{
     public function store() {
        $this->validate(request(), [
            'photo' => 'required|image:jpeg '
        ]);

        request()->photo->storeAs('images', 'optimized.jpg');

        // Session::put('success', 'Your Image Successfully Optimize');

        return redirect()->back();
    }
    public function get(){
    	return view('/photos');
    }
}
