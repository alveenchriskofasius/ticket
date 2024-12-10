$(document).ready(function () {
    // Capture the delete button click to show the modal and pass the id to the modal button
document.querySelectorAll('[data-modal-toggle="popup-modal"]').forEach(button => {
    button.addEventListener('click', function () {
        const ticketId = this.getAttribute('data-id');  // Get the ticket id from data-id
        console.log(ticketId);
        const deleteButton = document.getElementById('buttonDelete');
        
        // Set the ticketId as a custom attribute on the delete button in the modal
        deleteButton.setAttribute('data-id', ticketId);
    });
});

// Capture the delete action inside the modal
document.getElementById('buttonDelete').addEventListener('click', function () {
    const ticketId = this.getAttribute('data-id');  // Retrieve the ticketId from the modal button
    window.Table.Delete(ticketId);  // Pass the ID to your delete function
});

});

window.Form = {
    FillForm: function (ticketId) {
        // You can fetch ticket data using AJAX or populate the form here
        $.ajax({
            url: `/tickets/details/${ticketId}`, // Adjusted to match your route
            method: 'GET',
            success: function (response) {
                console.log(response); // Log the fetched data
                Form.SetValue(response); // Populate the form
            },
            error: function (xhr, status, error) {
                console.error(`Error fetching ticket details: ${error}`);
            }
        });        
    },
    SetValue: function (obj) {
        for (var prop in obj) {
            if (obj.hasOwnProperty(prop)) {
                var element = document.getElementById(prop);
                if (element) {
                    element.value = obj[prop];
                }
            }
        }
    }
};
window.Table = {
    Delete: function(id) {
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Get CSRF token

        // Perform the delete action here, e.g., send an AJAX request to the server
        fetch(`/tickets/delete/${id}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token  // Include CSRF token here
            }
        })
        .then(response => {
            console.log(response);
            if (response.ok) {
                toastr.success('Ticket deleted successfully');
                // Optionally, close the modal after successful deletion
                document.getElementById('popup-modal').classList.add('hidden');
            } else {
                toastr.error('Failed to delete ticket');
            }
        })
        .catch(error => {
            toastr.error('Error deleting ticket');
        });
    }
};
