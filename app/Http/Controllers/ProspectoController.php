<?php 


namespace App\Http\Controllers;

use Auth;
use View;
use Carbon\Carbon;
use App\Models\Prospecto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Filesystem\Filesystem;

class ProspectoController extends Controller {

    public function listadoProspectos(){
        $prospectos = Prospecto::all();
        return response()->json(['data' => $prospectos],200);
    }

    public function crearProspecto(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'calle' => 'required|string|max:100',
            'numero' => 'required|numeric|max:6',
            'colonia' => 'required|string|max:100',
            'codigo_postal' => 'required|numeric|max:6',
            'telefono' => 'required|string|max:20',
            'rfc' => 'required|numeric|min:12|max:13',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'calle' => $request->nombcallere,
            'numero' => $request->numero,
            'colonia' => $request->colonia,
            'codigo_postal' => $request->codigo_postal,
            'telefono' => $request->telefono,
            'rfc' => $request->rfc,
        ];
        try{
            $prospecto = Prospecto::create($data);

            if($request->has('documentos') ) {
                foreach ($request->documentos as $doc) {
                    $doc->storeAs( 'public/prospectos/'.$prospecto->id.'/documentos', microtime(true).'-'.$doc->getClientOriginalName() );
                }
            }

            return response()->json(['message' => 'Se creó exitosamente el nuevo prospecto.', 'prospecto' => $prospecto],200);
        } catch (Exception $e){
            return response()->json(['message' => 'Ha ocurrido un error al intentar crear el prospecto.'],500);
        }
    }

    public function editarProspecto(Request $request) {
        $prospecto = Prospecto::findOrFail($request->idProspecto);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'calle' => 'required|string|max:100',
            'numero' => 'required|numeric|max:6',
            'colonia' => 'required|string|max:100',
            'codigo_postal' => 'required|numeric|max:6',
            'telefono' => 'required|string|max:20',
            'rfc' => 'required|numeric|min:12|max:13',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'calle' => $request->nombcallere,
            'numero' => $request->numero,
            'colonia' => $request->colonia,
            'codigo_postal' => $request->codigo_postal,
            'telefono' => $request->telefono,
            'rfc' => $request->rfc,
        ];
        try{
            $prospecto->update($data);

            if($request->has('documentos') ) {
                foreach ($request->documentos as $doc) {
                    $doc->storeAs( 'public/prospectos/'.$prospecto->id.'/documentos', microtime(true).'-'.$doc->getClientOriginalName() );
                }
            }

            return response()->json(['message' => 'Se actualizó la información del prospecto.', 'prospecto' => $prospecto],200);
        } catch (Exception $e){
            return response()->json(['message' => 'Ha ocurrido un error al intentar actualizar los datos del prospecto.'],500);
        }
    }

    public function borrarProspecto(Request $request) {
        $propuesta = Propuesta::findOrFail($request->idPropuesta);
        $propuesta->delete();
        return response()->json(['message' =>'La propuesta se borró correctamente.'],200);
    }


}