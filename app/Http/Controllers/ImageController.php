<?php

namespace App\Http\Controllers;

use App\Events\NewFrame as Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function newFrame(Request $request)
    {
        Frame::dispatch(Storage::url('tmp/ramdisk/tmp.jpg'));
        return 0;
    }
}
