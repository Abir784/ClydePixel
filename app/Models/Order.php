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
        'simple_clipping', 'in_clip_2_in_1', 'in_clip_3_in_1',
        'layer_masking', 'retouch', 'nechjoin', 'recolor',
        'neek_joint_wit_lequefy', 'clipping_with_liquefy',
        'vector_graphics', 'complex_multi_path', 'total_file',
        'status', 'deadline', 'comment'
    ];
    function order_by(){
       return $this->belongsTo(User::class,'added_by');
    }

    function updated_by(){
        return $this->belongsTo(User::class,'last_updated_by');
     }




}
