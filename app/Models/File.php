<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $primaryKey = 'file_id';
  protected $fillable = ['operation_name', 'table_id', 'filepath', 'filename', 'created_by', 'deleted_by'];

  // tracking relations
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }


  public function deletedBy()
  {
    return $this->belongsTo(User::class, 'deleted_by');
  }
}
