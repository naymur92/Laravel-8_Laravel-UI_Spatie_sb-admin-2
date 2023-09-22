<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DropdownValue extends Model
{
  use HasFactory, SoftDeletes;

  protected $primaryKey = 'dropdown_value_id';
  protected $fillable = ['value', 'text_value', 'type', 'status', 'created_by', 'updated_by', 'deleted_by'];

  // tracking relations
  public function createdBy()
  {
    return $this->belongsTo(User::class, 'created_by');
  }

  public function updatedBy()
  {
    return $this->belongsTo(User::class, 'updated_by');
  }

  public function deletedBy()
  {
    return $this->belongsTo(User::class, 'deleted_by');
  }
}
