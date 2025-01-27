<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sucursales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //funcion para crear nuestro primer usuario la mejor forma es con un seeder
    public function PrimerUsuario()
    {
       /* User::create([
           'name'=>'Leonardo',
           'email'=>'leonardo@gmail.com',
           'foto'=>'',
           'estado'=>1,
           'ultimo_login'=>'',
            'rol'=>'Administrador',
            'password'=>bcrypt('leonardo')
        ]); */
    }
    //funcion para actualizar el panel de mis datos
    public function ActualizarMisDatos(Request $request)
    {
        $datos = request();

        if (auth()->user()->email != request('email')) {
            if (request('password')) {
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:50', 'min:3'],
                    'email' => ['required', 'email', 'max:50', 'unique:users'],
                    'password' => ['required', 'string', 'min:8'],
                    'fotoPerfil' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'], // Validación de formatos de imagen
                ]);
            } else {
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:50', 'min:3'],
                    'email' => ['required', 'email', 'max:50', 'unique:users'],
                    'fotoPerfil' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'], // Validación de formatos de imagen
                ]);
            }
        } else {
            if (request('password')) {
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:50', 'min:3'],
                    'email' => ['required', 'email', 'max:50'],
                    'password' => ['required', 'string', 'min:8'],
                    'fotoPerfil' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'], // Validación de formatos de imagen
                ]);
            } else {
                $datos = request()->validate([
                    'name' => ['required', 'string', 'max:50', 'min:3'],
                    'email' => ['required', 'email', 'max:50'],
                    'fotoPerfil' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'], // Validación de formatos de imagen
                ]);
            }
        }

        // Validación si ya tenemos una imagen, se eliminará la anterior por la nueva
        if (request('fotoPerfil')) {
            if (auth()->user()->foto != '') {
                $path = storage_path('app/public/' . auth()->user()->foto);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $rutaImg = $request['fotoPerfil']->store('users', 'public');
        } else {
            $rutaImg = auth()->user()->foto;
        }

        // Validación para actualizar datos, si se incluye una nueva contraseña se actualiza; si no, solo actualiza los demás campos
        if (isset($datos['password'])) {
            DB::table('users')->where('id', auth()->user()->id)
                ->update([
                    'name' => $datos['name'],
                    'email' => $datos['email'],
                    'foto' => $rutaImg,
                    'password' => Hash::make($datos['password'])
                ]);
        } else {
            DB::table('users')->where('id', auth()->user()->id)
                ->update([
                    'name' => $datos['name'],
                    'email' => $datos['email'],
                    'foto' => $rutaImg,
                ]);
        }

        return redirect('Mis-Datos');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->rol != 'Administrador'){
            return redirect('Inicio');
        }

        $usuarios = User::all();
        $sucursales = Sucursales::where('estado', 1)->get();
        return view('modulos.users.Usuarios', compact('usuarios','sucursales'));
    }

    public function store(Request $request)
    {
        $validarEmail = request()->validate([
           'email'=>['required', 'string', 'email', 'max:50', 'unique:users'],
        ]);

        $datos = request();

        if ($datos["rol"] == 'Administrador') {
            $id_sucursal = 0;
        }else{
            $id_sucursal = $datos["id_sucursal"];
        }

        User::create([
            'name' => $datos['nombre'],
            'email' => $validarEmail['email'],
            'id_sucursal' => $id_sucursal,
            'foto'=>'',
            'password' => Hash::make($datos['password']),
            'estado' => 1,
            'ultimo_login'=>null,
            'rol' => $datos['rol']
        ]);
        return redirect('Usuarios')->with('success', 'El Usuario ha sido creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function CambiarEstado($id_usuario, $estado)
    {
        // Verificar si el usuario autenticado intenta cambiar su propio estado
        if (auth()->id() == $id_usuario) {
            return response()->json([
                'error' => 'No puedes cambiar tu propio estado.'
            ], 403);
        }
        User::find($id_usuario)->update(['estado' => $estado]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_usuario)
    {

        $usuario = User::find($id_usuario);
        return response()->json($usuario);
    }

    //Funcion para verificar la existencia de un usuario mediante correo con booleanos
    public function verficarUsuario(Request $request)
    {
        $user = User::find($request->id);
        if ($request->email != $user["email"]) {
            $emailExistente = User::where('email', $request->email)->exists();
            if ($emailExistente != null) {
                $verificacion = false;
            }else{
                $verificacion = true;
            }
        }else{
            $verificacion = true;
        }

        return response()->json(['emailVerificacion' => $verificacion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if(request('password')){
            $validarPassword = request()->validate([
                'password' => ['string', 'min:3'],
            ]);

            $pass = true;
        }else{
            $pass = false;
        }

        $datos = request();
        if ($datos["rol"] == 'Administrador') {
            $id_sucursal = 0;
        }else{
            $id_sucursal = $datos["id_sucursal"];
        }
        $User = User::find($datos["id"]);
        $User->name = $datos['nombre'];
        $User->email = $datos['email'];
        $User->id_sucursal = $id_sucursal;
        $User->rol = $datos['rol'];

        if($pass !=false){
            $User->password = Hash::make($datos['password']);
        }
        $User->save();
        return redirect('Usuarios')->with('success', 'El Usuario ha sido actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_usuario)
    {
        if (auth()->id() == $id_usuario) {
            return redirect()->back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }
        $usuario = User::find($id_usuario);

        //si el usuario tiene fotos se eliminan
        if($usuario->foto != ''){
            $path = storage_path('app/public/'.$usuario->foto);
            unlink($path);
        }
        User::destroy($id_usuario);
        return redirect('Usuarios');
    }
}
