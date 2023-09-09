<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function dodajLekciju(Request $request)
    {

        $data = $request->validate(
            [
                'user_id' => '',
                'category_id' => '',
                'naslov' => 'required',
                'opis' => 'required',


            ],
            [
                'naslov.required' => "Obavezno",
                'opis.required' => "Obavezno",

            ]
        );
        $lekcija = new Lesson();
        $data['user_id'] = auth()->id();
        $lekcija->create($data);
        if($lekcija){
            return response()->json(['message' => 'Lekcija je uspjesno dodana']);
        }else{
            return response()->json(['message' => 'Neuspjesno dodavanje lekcije!']);
        }


    }

    public function getLesson()
    {
        $lekcije = Lesson::with('user','category','detail')->get();

        return response()->json($lekcije);
    }

    public function deleteLesson($id){
        $lesson = Lesson::findorFail($id);
        $lesson->delete();
        return response()->json(['message' => 'Uspjesno izbrisana lekcija']);
    }

    public function urediLekciju (Request $request, $id){

        $lesson = Lesson::findOrFail($id);

        $data = $request->validate([
            'naslov' => 'required',
            'opis' => 'required',

        ]);

        $lesson->naslov=$data['naslov'];
        $lesson->opis=$data['opis'];
        $lesson->save();

        return response()->json([
            'poruka' => 'Anketa uspjesno uređena',
            'lesson' => $lesson,
        ]);
    }

    public function getLekcija($id){
        $lekcija = Lesson::with('user', 'category',)->find($id);

        return response()->json($lekcija);
    }

    public function dohvatiLekciju($id)
    {
        $lesson = Lesson::with('user', 'category','detail')->find($id);
        return response()->json($lesson);
    }
}
