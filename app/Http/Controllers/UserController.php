<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $usuarios = User::all();

       return response()->json($usuarios);
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
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
         ]);
        if ($validator->fails()) {
            // conflicto en la petision
            return response()->json(["Error" => 'Validation incorrect' , "code" => 409], 409);
         }
        $campos = $request ->all();
        $campos['password'] = bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        $campos['verification_token'] = User::GVT();
        $campos['admin'] = User::USUARIO_REGULAR;

        $usuario = User::create($campos);

        return response()->json($usuario);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuarios= User::findOrFail($id);
        
        return response()->json($usuarios);
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

        $user = User::findOrFail($id);

        $validator = Validator::make ($request -> all(), [
            'email' => 'email|unique:users,email,' . $user->id,
            'password' => 'min:6|confirmed',
            'admin' => 'in:' . User::USUARIO_ADMIN . ',' . User::USUARIO_NO_VERIFICADO, 
         ]);
        if ($validator->fails()) {
            // conflicto en la petision
            return response()->json(["Error" => 'Validacion incorrecta']);
         }

         if($request ->has('name')){
            $user->name = $request->name;
         }
        
         if($request->has('password')){
            $user->password = bcrypt($request->password);
         }

         if($request->has('email') && $user->email != $request->email){
            $user->verified = User::USUARIO_NO_VERIFICADO;
            $user->email = $request->email;
         }

         if($request->has('admin')){
            if(!$user->Esverificado()){
                return response()->json(['Error' => 'Solo los usuarios verificados pueden cambiar este valor']); 
            }
            $user->admin = $request->admin;
         }

          if(!$user->isDirty()){
             return response()->json(['Error' => 'Error debe de haber un campo diferente para poder modificar']);
          }

         $user->save();

         return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario= User::findOrFail($id);

        $usuario->delete();

        return response()->json($usuario);    
    }
    
    public function verify($token){
      $user = User::where('verification_token', '=', $token)->firstOrFail();

      $user->verified=User::USUARIO_VERIFICADO;

      $user->verification_token=null;
      $user->save();

      return response()->json('Usuario validado correctamente');
  }
}
