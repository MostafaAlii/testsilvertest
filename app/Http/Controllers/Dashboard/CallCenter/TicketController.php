<?php

namespace App\Http\Controllers\Dashboard\CallCenter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\CallCenter\TicketDataTable;
use App\Services\Dashboard\{CallCenter\TicketService};
use App\Models\{Callcenter, ReplyTicket, Ticket};

class TicketController extends Controller
{
    public function __construct(protected TicketDataTable $dataTable, protected TicketService $ticketService)
    {
        $this->dataTable = $dataTable;
        $this->ticketService = $ticketService;
    }

    public function index()
    {
        $data = [
            'title' => 'Tickets',
        ];
        return $this->dataTable->render('dashboard.call-center.tickets.index', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $checkData = Ticket::where('order_code', $request->order_code)->first();
            if (!$checkData) {
                $requestData = $request->all();
                $requestData = array_merge($requestData, ['callcenter_id' => get_user_data()->id]);
                $data = $this->ticketService->create($requestData);
                ReplyTicket::create([
                    'ticket_id' => $data->id,
                    'callcenter_id' => $data->callcenter_id,
                    'status' => 'waiting',
                    'messages' => $data->subject,
                ]);
                return redirect()->route('CallCenterTickets.index')->with('success', 'Ticket created successfully');
            }
            return redirect()->route('CallCenterTickets.index')->with('error', 'An error occurred while creating the Ticket');

        } catch (\Exception $e) {
            return redirect()->route('CallCenterTickets.index')->with('error', 'An error occurred while creating the Ticket');
        }
    }

    public function show($id) {
        $ticket = Ticket::where('ticket_code', $id)->first();
        if ($ticket) {
            $replies = ReplyTicket::where('ticket_id', $ticket->id)->get();
            $data = [
                'ticket' => $ticket,
                'replies' => $replies,
            ];
            return view('dashboard.call-center.tickets.ticket_details', compact('data'));
        }
    }


    public function addReply(Request $request, $ticketId) {
        try {
            $latestReply = ReplyTicket::where('ticket_id', $ticketId)->first();
            if (!$latestReply) {
                throw new \Exception('ReplyTicket not found for the given ticket ID.');
            }
            $callcenter = $latestReply->ticket->assign_to_callcenter;
            $request->validate([
                'message' => 'required',
            ]);
            $reply = new ReplyTicket();
            $reply->ticket_id = $ticketId;
            if (auth('admin')->check()) {
                $reply->admin_id = auth('admin')->user()->id;
            } elseif (auth('call-center')->check() && get_user_data()->type == 'manager') {
                $reply->manager_id = auth('call-center')->user()->id;
                $reply->callcenter_id = $callcenter;
            } elseif (auth('call-center')->check() && get_user_data()->type == 'callcenter') {
                $reply->callcenter_id = get_user_data()->id;
            }
            $reply->messages = $request->input('message');
            $reply->status = 'read';
            $reply->save();
            $ticket = Ticket::whereId($ticketId)->first();
            return redirect()->route('CallCenterTickets.show', $ticket->ticket_code);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateTicketStatus(Request $request, $ticketId) {
        $newStatus = $request->input('status') === 'on' ? 'open' : 'close';
        Ticket::whereId($ticketId)->update(['status' => $newStatus]);
        if ($newStatus === 'close') {
            ReplyTicket::where('ticket_id', $ticketId)->update(['status' => 'completed']);
        }
        return redirect()->back()->with('success', 'Ticket Updated Status successfully');
    }
}