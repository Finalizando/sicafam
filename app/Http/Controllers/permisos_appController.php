<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use App\Role;
use App\Http\Controllers\rol_usuarioController;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class permisos_appController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nombre_rol=$request->nombre_rol;
        if($request->nombre_rol=='')
       {
         flash()->warning('Seleccione un rol') ; 
         return redirect()->back();  
       }
      else {
        $obj_permiso_app=  Permission::all();        
        return view('rol_usuario/permisos_app', compact('obj_permiso_app','nombre_rol'));
       }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->permisos))
        {
         flash()->warning('Seleccione por lo menos un permiso') ; 
         return redirect()->back();    
        }
        $obj_rol_usuario= new rol_usuarioController();
        $id_rol_usuario=$obj_rol_usuario->fnc_obtener_id($request->nombre_rol);        
        $obj_role=  Role::find($id_rol_usuario);        
        foreach ($request->input('permisos') as $value) 
        {
            $obj_role->attachPermission($value);
        }        
        flash()->success('Permisos asignados exitosamente') ; 
        return redirect()->back();  
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
