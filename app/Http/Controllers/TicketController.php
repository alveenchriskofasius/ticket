<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
     /**
     * Display a listing of the user's tickets.
     */
    public function index()
    {
        // Fetch all tickets for the authenticated user
        $tickets = Ticket::where('user_id', auth()->id())->get();
    
        // Return the view with the tickets
        return view('ticket', compact('tickets'));
    }
    

    /**
     * Fetch ticket details by ID.
     */
    public function details($id)
    {
        // Find the ticket that belongs to the current user
        $ticket = Ticket::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->firstOrFail();
    
        // Define the status and priority options
        $statusOptions = ['open', 'in_progress', 'resolved', 'closed'];
        $priorityOptions = ['low', 'medium', 'high'];
    
        // Return the ticket details, status options, and priority options as a JSON response
        return response()->json([
            'ticket' => $ticket,
            'statusOptions' => $statusOptions,
            'priorityOptions' => $priorityOptions,
        ]);
    }
    
    /**
     * Save (create or update) a ticket.
     */
    public function save(Request $request, $id = null)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'in:open,in_progress,resolved,closed',
            'priority' => 'in:low,medium,high'
        ]);
    
        // Create or update ticket
        $ticket = $id ? Ticket::find($id) : new Ticket;
        $ticket->fill($data);
        $ticket->user_id = auth()->id(); // Ensure the current user is the ticket owner
        $ticket->save();
    
        return response()->json(['message' => 'Ticket saved successfully!']);
    }
    

    /**
     * Remove the specified ticket.
     */
    public function destroy($id)
    {
        // Find and delete the ticket that belongs to the current user
        $ticket = Ticket::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $ticket->delete();

        // Return a JSON response for success
        return response()->json(['message' => 'Ticket deleted successfully!']);
    }
}
