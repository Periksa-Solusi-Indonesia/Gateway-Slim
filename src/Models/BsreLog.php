<?php

namespace App\Models;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Container\ContainerInterface;
use Illuminate\Database\Eloquent\Model;


class BsreLog extends Model
{
    protected $table = 'bsre_log'; 
    public $timestamps = false;   
    protected $fillable = ['request_body', 'response', 'date_make'];

    public static function saveLog($requestData, $apiResponseBody)
    {
        try {
            DB::table('bsre_log')->insert([
                'request_body' => json_encode($requestData),
                'response' => $apiResponseBody,
                'date_make' => date('Y-m-d H:i:s'), 
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Gagal menyimpan log: " . $e->getMessage());
        }
    }
}
