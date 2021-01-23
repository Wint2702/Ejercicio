<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prospecto extends Model
{
    use SoftDeletes;

    protected $table = "prospectos";
    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'calle',
        'numero',
        'colonia',
        'codigo_postal',
        'telefono',
        'rfc',
        'fecha_aprobado',
        'fecha_rechazado',
        'motivo_rechazo'
    ];

    protected $appends = [
        'estatus',
        'deleteUrl',
        'updateUrl',
        'documentosUrl',
        'getUrl'
    ];

    protected $dates = [
        'fecha_aprobado',
        'fecha_rechazado',
        'updated_at',
        'created_at',
        'deleted_at'
    ];



    public function getEstatusAttribute() {
        $estatus = null;
        if(isset($this->fecha_aprobado)){
            $estatus = 'Cliente';
        } elseif(isset($this->fecha_rechazado)){
            $estatus = 'Rechazado';
        }elseif(!isset($this->fecha_aprobado) && !isset($this->fecha_rechazado)){
            $estatus = 'Pendiente de evaluar';
        }
        return $estatus;
    }

    public function getDeleteUrlAttribute() {
        return route('prospectos.borrar',$this->id);
    }

    public function getUpdateUrlAttribute() {
        return route('prospectos.editar',$this->id);
    }

    public function getGetUrlAttribute() {
        return route('prospectos.ver',$this->id);
    }

    public function getDocumentosUrlAttribute() {
        $path = storage_path('public/prospectos/'.$this->id.'/documentos');
        
        if( !file_exists($path) )
        return null;
        // ó
        return route('prospectos.descargarDocs',$this->id);
    }


}
