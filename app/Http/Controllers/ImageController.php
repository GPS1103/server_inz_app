<?php

namespace App\Http\Controllers;

use App\Events\NewFrame as Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function newFrame(Request $request)
    {
        if ($request->frame) {

            $file = Storage::disk('public')->putFileAs('tmp', $request->frame, '1.png');
            Frame::dispatch(Storage::url($file));
        }
        return 0;
    }
}
