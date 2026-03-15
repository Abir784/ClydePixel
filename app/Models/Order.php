<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // In the Order model (Order.php)
    protected $fillable = [
        'name', 'folder_name', 'added_by', 'last_updated_by',
        'total_file', 'dynamic_fields',
        'status', 'deadline', 'comment'
    ];

    protected function casts(): array
    {
        return [
            'dynamic_fields' => 'array',
        ];
    }
    function order_by(){
       return $this->belongsTo(User::class,'added_by');
    }

    function updated_by(){
        return $this->belongsTo(User::class,'last_updated_by');
     }




}
