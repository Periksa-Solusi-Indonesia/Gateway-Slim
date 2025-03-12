<?php

namespace App\Models;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Container\ContainerInterface;
use Illuminate\Database\Eloquent\Model;


class BsreLog extends Model
{
    protected $table = 'bsre_log'; 
    public $timestamps = false;   
    protected $fillable = ['response', 'nama_formulir', 'type_formulir', 'status', 'date_make', 'date_update'];

    public static function saveLog($apiResponseBody, $namaFormulir, $typeFormulir, $status)
    {
        try {
            DB::table('bsre_log')->insert([
                'response' => $apiResponseBody,
                'nama_formulir' => $namaFormulir,
                'type_formulir' => $typeFormulir,
                'status' => $status,
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan log: " . $e->getMessage());
        }
    }
}
