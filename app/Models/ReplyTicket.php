<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplyTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'admin_id',
        'callcenter_id',
        'manager_id',
        'messages',
        'status',
    ];


    public function ticket()
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class,'admin_id');
    }

    public function callcenter()
    {
        return $this->belongsTo(Callcenter::class,'callcenter_id');
    }

    public function manager()
    {
        return $this->belongsTo(Callcenter::class,'manager_id');
    }
}