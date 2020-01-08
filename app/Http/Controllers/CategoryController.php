<?php
namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::all();
        return response()->json($category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make ($request -> all(), [
            'name' => 'required',
            'description' => 'required',
         ]);

         if($validator->fails()){
            return response()->json(['error' => 'Validacion Incorrect']);
         }
         $campos = $request ->all();
         $category = Category::create($campos);

         return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $category = Category::findOrfail($id);
        return response()->json($category);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        if($request ->has('name')){
            $category->name = $request->name;
         }
         if($request ->has('description')){
            $category->description = $request->description;
         }

         if(!$category->isDirty()){
            return response()->json(['Error' => 'Error debe de haber un campo diferente para poder modificar', 'Code' => 422 ], 422 );
         }

         $category->save();

         return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json(['Confirmacion' => 'Usuario eliminado', 'data' => $category], 200);
    }
}
