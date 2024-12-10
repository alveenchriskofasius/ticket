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
    
    public function details($id)
    {
        // Find the ticket that belongs to the current user
        $ticket = Ticket::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->first();
       // If the ticket is not found, return a new instance with default values
       if (!$ticket) {
        $ticket = new Ticket(); // Creates an empty Ticket instance
    }
        // Return the ticket details, status options, and priority options as a JSON response
        return response()->json($ticket);
    }
    
    public function save(Request $request)
    {
    
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'in:open,in_progress,resolved,closed',
            'priority' => 'in:low,medium,high'
        ]);
    
        // Check if 'id' exists in the request and find the ticket or create a new one
        if ($request->id) {
            // If the ticket ID exists, find and update
            $ticket = Ticket::findOrFail($request->id);
        } else {
            // If no ID is provided, create a new ticket
            $ticket = new Ticket;
        }
    
        // Fill the ticket with the validated data
        $ticket->fill($data);
        $ticket->user_id = auth()->id(); // Ensure the current user is the ticket owner
        $ticket->save();
    
        return response()->json(['message' => 'Ticket saved successfully!']);
    }
    
    public function destroy($id)
    {
        // Find and delete the ticket that belongs to the current user
        $ticket = Ticket::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $ticket->delete();

        // Return a JSON response for success
        return response()->json(['message' => 'Ticket deleted successfully!']);
    }
}
