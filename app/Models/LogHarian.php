<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogHarian extends Model
{
    protected $table = 'log_harian';

    protected $fillable = ['pegawai_id', 'status_id', 'deskripsi', 'created_at', 'updated_at'];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'pegawai_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }
}
