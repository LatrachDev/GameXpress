<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->can('view_categories')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }

        $categories = Category::all();

        return response()->json([
            'message' => 'Access authorized',
            'data' => $categories,
            'count' => $categories->count(),
        ], 200);
    }

    public function show(Request $request, $id)
    {
        if (!$request->user()->can('view_categories')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }
        return response()->json($category);
    }

    public function store(Request $request)
    {
        if (!$request->user()->can('create_categories')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
        ]);

        $category = Category::create($request->all());

        return response()->json(['message' => 'category added successfully', 'category' => $category], 201);
    }

    public function update(Request $request, $id)
    {

        if (!$request->user()->can('edit_categories')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|unique:categories,slug,' . $id,
        ]);

        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }
        $category->update($request->only(['name', 'slug']));

        return response()->json(['message' => 'category updated', 'category' => $category], 200);
    }


    public function destroy(Request $request, $id)
    {
        if (!$request->user()->can('delete_categories')) {
            return response()->json(['message' => 'unauthorized'], 403);
        }
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'category deleted'], 200);
    }
}
