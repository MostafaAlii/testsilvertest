<?php
namespace App\Services\Dashboard\CallCenter;
use App\Models\Ticket;
class TicketService {
    public function create($data) {
        return Ticket::create($data);
    }
}