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
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ProspectoController extends Controller {

    public function index() {
        $prospectos = Prospecto::all();
        return View::make('prospectos.listado',['prospectos'=>$prospectos]);
    }

    public function listadoProspectos(){
        $prospectos = Prospecto::all();
        return response()->json(['data' => $prospectos],200);
    }

    public function listadoProspectosEvaluar(){
        $prospectos = Prospecto::where('fecha_aprobado', '=', null)->orWhere('fecha_rechazado', '=', null)->get();
        return response()->json(['data' => $prospectos],200);
    }

    public function verProspecto(Request $request){
        $prospecto = Prospecto::findOrFail($request->idProspecto);
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
        $prospecto = Prospecto::findOrFail($request->idProspecto);
        $prospecto->delete();
        return response()->json(['message' =>'El prospecto se eliminó correctamente.'],200);
    }

    public function aprobarProspecto(Request $request){
        $prospecto = Prospecto::findOrFail($request->idProspecto);

        try{
            $prospecto->update(['fecha_aprobado' => Carbon::now()]);
            return response()->json(['message' => 'Se aprobó el prospecto correctamente.', 'prospecto' => $prospecto],200);
        } catch (Exception $e){
            return response()->json(['message' => 'Ha ocurrido un error al intentar aprobar el prospecto.'],500);
        }
    }

    public function rechazarProspecto(Request $request){
        $prospecto = Prospecto::findOrFail($request->idProspecto);

        try{
            $prospecto->update(['fecha_rechazado' => Carbon::now()]);
            return response()->json(['message' => 'Se rechazó el prospecto correctamente.', 'prospecto' => $prospecto],200);
        } catch (Exception $e){
            return response()->json(['message' => 'Ha ocurrido un error al intentar rechazar el prospecto.'],500);
        }
    }

    public function descargarDocs (Request $request) {
        $prospecto = Prospecto::findOrFail($request->idProspecto);

        $path = storage_path('app/public/prospectos/'.$prospecto->id.'/documentos');
        $zipFileName = 'documentos_prospecto - '.$prospecto->id.'.zip';

        if( !file_exists($path) ) die('No hay documentos subidos para este prospecto.');
        $zip = new ZipArchive;
        $zip->open($path.'/'.$zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file)
        {
            if (!$file->isDir())
            {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($path) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        $headers =['Content-Type' => 'application/octet-stream'];
        if(file_exists($path.'/'.$zipFileName)){
            return response()->download($path.'/'.$zipFileName,$zipFileName,$headers)->deleteFileAfterSend(true);
        } else {
            return null;
        }


    }


}