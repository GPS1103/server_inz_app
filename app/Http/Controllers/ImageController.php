<?php

namespace App\Http\Controllers;

use App\Events\NewFrame as Frame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function newFrame(Request $request)
    {   
        $arr = NULL;
        $path = 'public/tmp/ramdisk/identify/detect.jpg';
        $data = Storage::get($path);
        $base64 = 'data:image/jpg;base64,' . base64_encode($data);
        $arr[] = $base64;
        Frame::dispatch($arr);
        return 0;
    }
}
