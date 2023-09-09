<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailController extends Controller
{
    public function addDetails(Request $request)
    {
        $data = $request->validate([
            'lesson_id' => 'required',
            'tema' => 'required',
            'lekcija' => 'required',
            'image' => '',
            'video' => '',


        ], [
            'tema.required' => 'Obavezno',
            'lekcija.required' => 'Obavezno',

        ]);

        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $extension = $videoFile->getClientOriginalExtension();
            $video_name = time() . '1.' . $extension;
            $videoFile->move(public_path('videos'), $video_name);
            $data['video'] = $video_name;
        }

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $extension = $imageFile->getClientOriginalExtension();
            $image_name = time() . '1.' . $extension;
            $imageFile->move(public_path('images'), $image_name);
            $data['image'] = $image_name;
        }


        $data['created_at'] = now();
        $data['updated_at'] = now();

        DB::table('details')->insert($data);

        return response()->json(['message' => 'Video lekcija uspješno dodana!']);
    }
}
