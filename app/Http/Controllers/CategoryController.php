<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('category.category', [
            'categorys' => $category
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'calibration' => 'required'
        ]);

        category::create([
            'category' => $validated['category_name'],
            'calibration' => $validated['calibration']
        ]);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255'
        ]);

        $category = category::findOrFail($id);
        $category->update([
            'category' => $validated['category_name']
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        $category = category::findOrFail($id);
        $category->delete();

        return redirect()->back();
    }
}
