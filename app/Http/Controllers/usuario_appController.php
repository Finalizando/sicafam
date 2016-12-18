<?php
/**
     * Nombre del archivo: .php
     * Descripción:
     * Fecha de creación:20/11/2016
     * Creado por: Juan Carlos Centeno Borja
     */
namespace App\Http\Controllers;

use App\User;
use App\Role;
use Auth;
use App\Http\Controllers\bitacoraController;
use App\Models\ubicacion_organizacional;
use App\Models\cargo_emp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Http\Controllers\rol_usuarioController;
use App\Http\Controllers\cargo_empController;
use App\Http\Controllers\ubicacion_orgController;
use Illuminate\Support\Facades\Input;

//use Illuminate\Support\Facades\Request;

class usuario_appController extends Controller
{
     public function __construct() {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   $obj_rol_usuario= new rol_usuarioController();
        $obj_cargo_emp= new cargo_empController();
        $obj_ubicacion_org= new ubicacion_orgController();
        $rules =array('password'=> array('min:8','max:25','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'),
                      'email_usuario'=>'unique:usuario_app',
                      'numero_dui'=>'digits:9|unique:usuario_app');        
        $this->validate($request, $rules);
        $date = Carbon::now();
        $usuario = new User();        
        $usuario->id_ubicacion_org =$obj_ubicacion_org->fnc_obtener_id($request->id_ubicacion_org);
        $usuario->id_cargo_emp=$obj_cargo_emp->fnc_obtener_id($request->cargo_emp);
        $usuario->email_usuario=$request->email_usuario;        
        $usuario->password=  bcrypt($request->password);
        $usuario->nombres_usuario=$request->nombres_usuario;
        $usuario->apellidos_usuario=$request->apellidos_usuario;
        $usuario->numero_dui=$request->numero_dui;
        $usuario->cambiar_contrasenia=1;
        $usuario->fecha_validez_contrasenia=$date->addMonth(3);
        $usuario->estado_usuario=1;
        $usuario->estado_registro=1;
        $usuario->id_usuario_crea=Auth::user()->id_usuario_app;
        $usuario->ip_dispositivo=$request->ip();
        $usuario->nombre_usuario=$this->fnc_nombre_usuario($request);
        $id_rol_usuario=$obj_rol_usuario->fnc_obtener_id($request->rol_usuario);
        $usuario->id_rol_usuario=$id_rol_usuario;
        $usuario->save();
        $obj_rol_asignado= Role::find($id_rol_usuario);
        $usuario->attachRole($obj_rol_asignado);
        $obj_usuario=  User::find($usuario->id_usuario_app);
        flash()->success('Usuario creado exitosamente '.$obj_usuario->nombre_usuario);
        return redirect()->back(); 
        }
    public function fnc_show_buscar_usuario() {
        
    }
    
    public function fnc_filtro_buscar_usuario(Request $request) {
        $obj_rol_usuario= new rol_usuarioController();
        $obj_controller_bitacora=new bitacoraController();
        $obj_controller_bitacora->create();
        $obj_role= Role::all();
        
        if($request->estado_usuario!=1){
           $request->estado_usuario=0; 
        }else{
           $request->estado_usuario=1; 
        }   
        if($request->rol_usuario!=''){
        $id_rol_usuario=$obj_rol_usuario->fnc_obtener_id($request->rol_usuario);
        $obj_usuario=  User::nombre_usuario($request->get('nombre_usuario'))->id_rol_usuario($id_rol_usuario)->estado_usuario($request->estado_usuario)->paginate(5); 
        }
        else
        {
         $obj_usuario=  User::nombre_usuario($request->get('nombre_usuario'))->estado_usuario($request->estado_usuario)->paginate(5);    
        }
       
        return view('usuario_app/buscar_usuario',  compact('obj_usuario','obj_role'));
        
    }
    public function fnc_show_create() {
        $obj_controller_bitacora=new bitacoraController();
        $obj_controller_bitacora->create();
        $obj_role= Role::all();
        $obj_ubicacion_org=  ubicacion_organizacional::all();
        $obj_cargo_emp= cargo_emp::all();
        return view('usuario_app/create',
                compact('obj_role',
                'obj_cargo_emp',
                'obj_ubicacion_org'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $obj_controller_bitacora=new bitacoraController();
        $obj_controller_bitacora->create();
        $obj_role= Role::all();
        $obj_ubicacion_org=  ubicacion_organizacional::all();
        $obj_cargo_emp= cargo_emp::all();
       $obj_inputs=Input::all();      
       $id_usuario_app=$obj_inputs['seleccionar'];
       $obj_usuario=User::find($id_usuario_app);
       return view('usuario_app/editar_usuario',compact(
               'obj_usuario',
               'obj_role',
               'obj_cargo_emp',
               'obj_ubicacion_org'));     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $obj_controller_bitacora=new bitacoraController();
        $obj_controller_bitacora->create();
        $obj_role= Role::all();
        $obj_usuario=  User::paginate(5);
        
        return view('usuario_app/buscar_usuario',  compact('obj_usuario','obj_role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {   
        $obj_controller_bitacora=new bitacoraController();
        $obj_controller_bitacora->create();
        $obj_role= Role::all();
        $obj_ubicacion_org=  ubicacion_organizacional::all();
        $obj_cargo_emp= cargo_emp::all();
       $obj_inputs=Input::all(); 
       //dd($obj_inputs);
       if(sizeof($obj_inputs)==0)
       {
          flash()->warning('Seleccione un usuario') ;
          return redirect()->back();  
       }else
       {
         $id_usuario_app=$obj_inputs['seleccionar'];
       $obj_usuario=User::find($id_usuario_app);       
       return view('usuario_app/editar_usuario',compact(
               'obj_usuario',
               'obj_role',
               'obj_cargo_emp',
               'obj_ubicacion_org'));     
       }
         
        
    }
    public function fnc_cambiar_estado(Request $request) {
    
       $obj_controller_bitacora=new bitacoraController();
       $obj_controller_bitacora->create(); 
       if($request->resultado=='')
       {
           flash()->warning('Seleccione un usuario') ;
           
       }
       else
       {
         $id_usuario_app=$request->resultado;
       $obj_usuario=User::find($id_usuario_app);
        if($obj_usuario->estado_usuario==1)
        {
             $obj_usuario->estado_usuario=0;
        }  
        else {
           $obj_usuario->estado_usuario=1;  
        }
        $obj_usuario->id_usuario_modifica=Auth::user()->id_usuario_app;
        $obj_usuario->ip_dispositivo=$request->ip();
        $obj_usuario->save(); 
        flash()->success('Estado ha cambiado exitosamente');
       }
       return redirect()->back();          
        
    }
    public function fnc_cambiar_contrasenia() {
        $obj_controller_bitacora=new bitacoraController();
        $obj_controller_bitacora->create();       
       $obj_inputs=Input::all(); 
     if($obj_inputs['resultado']=='')
     {
        flash()->warning('Seleccione un usuario') ; 
     }
     else
     {
     $id_usuario_app=$obj_inputs['resultado'];
       $obj_usuario=User::find($id_usuario_app);
       return view('usuario_app/cambiar_contrasenia',compact(
               'obj_usuario'
               ));     
     }
       
      return  redirect()->back(); 
    }

   /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function fnc_guardar_contrasenia(Request $request) {
        
        $usuario = User::find($request->id_usuario_app); 
        $rules =array('password'=> array('min:8','max:25','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'));   
        $this->validate($request, $rules);    
        $date = Carbon::now();
        $usuario->password=  bcrypt($request->password);        
        $usuario->cambiar_contrasenia=1;
        $usuario->fecha_validez_contrasenia=$date->addMonth(3);
        $usuario->id_usuario_modifica=Auth::user()->id_usuario_app;
        $usuario->ip_dispositivo=$request->ip();
        $usuario->save();        
        return redirect()->back(); 
   }
    
    public function fnc_guardar_modificacion(Request $request)
    {   
        $obj_rol_usuario= new rol_usuarioController();
        $obj_cargo_emp= new cargo_empController();
        $obj_ubicacion_org= new ubicacion_orgController();        
        $usuario = User::find($request->id_usuario_app); 
        $rules =array('password'=> array('min:8','max:25','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/'),
                      'email_usuario'=>'unique:usuario_app',
                      'numero_dui'=>'digits:9|unique:usuario_app');   
        
        $this->validate($request, $rules);        
        $date = Carbon::now();               
        $usuario->id_ubicacion_org =$obj_ubicacion_org->fnc_obtener_id($request->id_ubicacion_org);
        $usuario->id_cargo_emp=$obj_cargo_emp->fnc_obtener_id($request->cargo_emp);
        $usuario->email_usuario=$request->email_usuario;        
        $usuario->password=  bcrypt($request->password);
        $usuario->nombres_usuario=$request->nombres_usuario;
        $usuario->apellidos_usuario=$request->apellidos_usuario;
        $usuario->numero_dui=$request->numero_dui;
        $usuario->cambiar_contrasenia=1;
        $usuario->fecha_validez_contrasenia=$date;
        $usuario->estado_usuario=$request->estado_usuario;
        $usuario->estado_registro=1;
        $usuario->id_usuario_modifica=Auth::user()->id_usuario_app;
        $usuario->ip_dispositivo=$request->ip();
        $usuario->nombre_usuario=$request->nombre_usuario;
        $id_rol_usuario=$obj_rol_usuario->fnc_obtener_id($request->rol_usuario);
        $usuario->id_rol_usuario=$id_rol_usuario;
        //dd($usuario);
        $usuario->save();
        //$obj_rol_asignado= Role::find($id_rol_usuario);
        //$usuario->attachRole($obj_rol_asignado);
        return $this->show();
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
    /**
     *Descripción:Elimina los acentos, la ñ y caracteres especiales.
     *@author: https://coudlain.wordpress.com/2013/02/05/php-funcion-para-quitar-acentos-y-caracteres-especiales-by-estebannovo/
     *@param:  String  $String
     *@return: $String
     */    
    public function limpiar($String){
    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
    $String = str_replace(array('Á','À','Â','Ã','Ä'),"a",$String);
    $String = str_replace(array('Í','Ì','Î','Ï'),"i",$String);
    $String = str_replace(array('í','ì','î','ï'),"i",$String);
    $String = str_replace(array('é','è','ê','ë'),"e",$String);
    $String = str_replace(array('É','È','Ê','Ë'),"e",$String);
    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"o",$String);
    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
    $String = str_replace(array('Ú','Ù','Û','Ü'),"u",$String);
    $String = str_replace(array('[','^','´','`','¨','~',']'),"",$String);
    $String = str_replace("ç","c",$String);
    $String = str_replace("Ç","c",$String);
    $String = str_replace("ñ","n",$String);
    $String = str_replace("Ñ","n",$String);
    $String = str_replace("Ý","y",$String);
    $String = str_replace("ý","y",$String);
     
    $String = str_replace("&aacute;","a",$String);
    $String = str_replace("&Aacute;","a",$String);
    $String = str_replace("&eacute;","e",$String);
    $String = str_replace("&Eacute;","e",$String);
    $String = str_replace("&iacute;","i",$String);
    $String = str_replace("&Iacute;","i",$String);
    $String = str_replace("&oacute;","o",$String);
    $String = str_replace("&Oacute;","o",$String);
    $String = str_replace("&uacute;","u",$String);
    $String = str_replace("&Uacute;","u",$String);
    return $String;
}
    /**
     * .
     *
     * @param  Request $request
     * @return $nombre_usuario
     */
    public function fnc_nombre_usuario(Request $request) {
       $nombres=$request->nombres_usuario;
       $apellidos=$request->apellidos_usuario;
       //Obtener el primer nombre
       $pos      = strripos($nombres,' ' );
       if($pos){$nombres= substr($nombres,0, $pos);}
       //Obtener el primer apellido
       $pos      = strripos($apellidos,' ' );
       if($pos){$apellidos=  substr($apellidos, 0, $pos);}  
       $nombres=$this->limpiar($nombres);
       $apellidos=$this->limpiar($apellidos);
       //Convertir a minuscula
       $nombres=  strtolower($nombres);
       $apellidos=  strtolower($apellidos);
       $nombre_usuario=$nombres.$apellidos;
       return $nombre_usuario;        
        
       }
}
