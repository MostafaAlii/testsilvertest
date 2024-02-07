<?php
declare (strict_types = 1);
namespace App\Observers;
use App\Models\Ticket;
use Illuminate\Support\Str;
class TicketObserver {
    public function creating(Ticket $ticket) {
        $ticket->ticket_code = $this->generateTicketCode();
        $ticket->status = 'open';
    }

    private function generateTicketCode() {
        do {
            $randomCode = Str::random(6);
        } while (Ticket::where('ticket_code', $randomCode)->exists());
        return $randomCode;
    }
}