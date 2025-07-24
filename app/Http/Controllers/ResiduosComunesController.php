<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Validator;
use App\Models\ResiduoComun;
use Illuminate\Support\Arr;

class ResiduosComunesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $residuos = DB::table('residuos')
            ->where('RespelDelete', 0)
            ->orderBy('ID_Respel', 'asc')
            ->paginate(10);

        return view('residuoscomunes.index', compact('residuos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('residuoscomunes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'respelname' => 'required|string|max:255',
            'respeldescripcion' => 'required|string|max:255',
            'estadofisico' => 'required|string',
            'peligrosidad' => 'required|string',
            'tipoclasificacion' => 'nullable|string',
            'ClasificacionY' => 'nullable|string',
            'ClasificacionA' => 'nullable|string',
            'Tratamiento' => 'required|string',
            'RespelHojaSeguridad' => 'required|mimes:pdf|max:10240',
            'RespelTarj' => 'required|mimes:pdf|max:5120',
            'RespelFoto' => 'required|image|max:5120',
        ]);

        $residuo = new ResiduoComun();
        $residuo->RespelName = $request->respelname;
        $residuo->RespelDescrip = $request->respeldescripcion;
        $residuo->YRespelClasf4741 = $request->ClasificacionY;
        $residuo->ARespelClasf4741 = $request->ClasificacionA;
        $residuo->RespelIgrosidad = $request->peligrosidad;
        $residuo->RespelEstado = $request->estadofisico;
        $residuo->Cedula = Null;
        $residuo->RespelSlug = hash('sha256', rand() . time() . $request->respelname);
        $residuo->RespelStatus = Null;
        $residuo->FK_RespelCoti = Null;
        $residuo->SustanciaControlada = Null;
        $residuo->SustanciaControladaTipo = Null;
        $residuo->SustanciaControladaNombre = Null;
        $residuo->SustanciaControladaDocumento = Null;
        $residuo->RespelDeclaracion = Null;
        $residuo->RespelStatusDescription = Null;
        $residuo->AceiteUsado = Null;
        
        if(isset($request['RespelHojaSeguridad'])) {
            $file1 = $request['RespelHojaSeguridad'];
            $hoja = hash('sha256', rand().time().$file1->getClientOriginalName()).'.pdf';

            $file1->move(public_path().'/img/HojaSeguridad/',$hoja);
        }
        else{
            $hoja = 'RespelHojaDefault.pdf';
        }

        if (isset($request['RespelTarj'])) {
            $file2 = $request['RespelTarj'];
            $tarj = hash('sha256', rand().time().$file2->getClientOriginalName()).'.pdf';
            $file2->move(public_path().'/img/TarjetaEmergencia/',$tarj);
        }else{
            $tarj = 'RespelTarjetaDefault.pdf';
        }

        if (isset($request['RespelFoto'])) {
            $file3 = $request['RespelFoto'];
            $file3->move(public_path().'/img/fotoRespelCreate/',$file3);
        }else{
            $foto = 'RespelFotoDefault.png';
        } 
       

        $residuo->RespelHojaSeguridad = $hoja;
        $residuo->RespelTarj = $tarj;
        $residuo->RespelFoto = $file3;
//
        $residuo->save();

        return redirect()->route('residuoscomunes.index')->with('success', 'Residuo creado satisfactoriamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $residuo = DB::table('residuos')
            ->where('RespelSlug', $id)
            ->select('*')
            ->first();  

        return view('residuoscomunes.show', compact('residuo'));    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $residuo = DB::table('residuos')
            ->where('RespelSlug', $id)
            ->select('*')
            ->first();  

        return view('residuoscomunes.edit', compact('residuo')); 
    }

    public function update(Request $request, string $id)
    {
        $respel = ResiduoComun::where('RespelSlug', $id)->first();

        // Archivos: resolver ANTES
        if ($request->hasFile('RespelHojaSeguridad')) {
            if ($respel->RespelHojaSeguridad && file_exists(public_path('/img/HojaSeguridad/'.$respel->RespelHojaSeguridad))) {
                unlink(public_path('/img/HojaSeguridad/'.$respel->RespelHojaSeguridad));
            }
            $file1 = $request->file('RespelHojaSeguridad');
            $hoja = hash('sha256', rand().time().$file1->getClientOriginalName()).'.pdf';
            $file1->move(public_path('/img/HojaSeguridad/'), $hoja);
        } else {
            $hoja = $respel->RespelHojaSeguridad;
        }

        if ($request->hasFile('RespelTarj')) {
            if ($respel->RespelTarj && file_exists(public_path('/img/TarjetaEmergencia/'.$respel->RespelTarj))) {
                unlink(public_path('/img/TarjetaEmergencia/'.$respel->RespelTarj));
            }
            $file2 = $request->file('RespelTarj');
            $tarj = hash('sha256', rand().time().$file2->getClientOriginalName()).'.pdf';
            $file2->move(public_path('/img/TarjetaEmergencia/'), $tarj);
        } else {
            $tarj = $respel->RespelTarj;
        }

        if ($request->hasFile('RespelFoto')) {
            if ($respel->RespelFoto && file_exists(public_path('/img/fotoRespelCreate/'.$respel->RespelFoto))) {
                unlink(public_path('/img/fotoRespelCreate/'.$respel->RespelFoto));
            }
            $file3 = $request->file('RespelFoto');
            $foto = hash('sha256', rand().time().$file3->getClientOriginalName()).'.png';
            $file3->move(public_path('/img/fotoRespelCreate/'), $foto);
        } else {
            $foto = $respel->RespelFoto;
        }

        // Ahora sí: solo datos dentro del update()
        DB::table('residuos')
            ->where('RespelSlug', $id)
            ->update([
                'RespelName' => $request->respelname,
                'RespelDescrip' => $request->respeldescripcion,
                'YRespelClasf4741' => $request->ClasificacionY,
                'ARespelClasf4741' => $request->ClasificacionA,
                'RespelIgrosidad' => $request->peligrosidad,
                'RespelEstado' => $request->estadofisico,
                'Cedula' => null,
                'RespelHojaSeguridad' => $hoja,
                'RespelTarj' => $tarj,
                'RespelFoto' => $foto,
            ]);

        return redirect()->route('residuoscomunes.index')->with('success', 'Residuo actualizado correctamente.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $residuo = ResiduoComun::where('RespelSlug', $id)->first();
        $residuo->RespelDelete = 1;
        $residuo->save();

        return redirect()->route('residuoscomunes.index')->with('success', 'Persona eliminada correctamente.');
    }
}
