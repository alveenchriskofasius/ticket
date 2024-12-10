<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <!-- Modal toggle -->
<button data-modal-target="crud-modal" data-modal-toggle="crud-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
  New Ticket
</button>
                
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 bg-gray-700 text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Status
                </th>
                <th scope="col" class="px-6 py-3">
                    Priority
                </th>
                <th scope="col" class="px-6 py-3">
                Created Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
        @forelse ($tickets as $ticket)
            <tr class="bg-white border-b bg-gray-800 border-gray-700">
                <td class="px-6 py-4">{{ $ticket->name }}</td>
                <td class="px-6 py-4">{{ $ticket->description }}</td>
                <td class="px-6 py-4">{{ $ticket->status }}</td>
                <td class="px-6 py-4">{{ $ticket->priority }}</td>
                <td class="px-6 py-4">{{ $ticket->created_at->format('d-m-Y') }}</td>
                <td class="px-6 py-4">
                    <!-- Action buttons for view, edit, and delete -->
                    <button onclick="openEditModal({{ $ticket->id }})" class="px-3 py-2 bg-blue-500 text-white rounded">Edit</button>
                    <button onclick="deleteTicket({{ $ticket->id }})" class="px-3 py-2 bg-red-500 text-white rounded">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No tickets found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-ticket-modal></x-ticket-modal>