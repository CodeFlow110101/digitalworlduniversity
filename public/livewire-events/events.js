document.addEventListener('livewire:init', () => {
    Livewire.on('send-message', (event) => {

        var formData = new FormData(event.file);

        $.ajax({
            url: '/upload', // Update with your route
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
            }
        });
        Livewire.dispatch('send-message-backend', { message:event.message, isFileAttached:event.isFileAttached, file:null });
    });
 });