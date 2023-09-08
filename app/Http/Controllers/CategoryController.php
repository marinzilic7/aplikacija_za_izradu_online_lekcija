<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        $data = $request->validate(
            [

                'ime' => 'required',

            ],
            [
                'ime.required' => 'Obavezno.',

            ]
        );


        $category = new Category();
        $category->create($data);

        return response()->json(['message' => 'Kategorija dodana']);
    }

    public function getCategories(){
        $categories = Category::get();
        return response()->json($categories);
    }
}
