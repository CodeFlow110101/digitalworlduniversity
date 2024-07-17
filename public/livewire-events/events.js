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

    Livewire.on('upload-video', (event) => {

        Livewire.dispatch(event.callbackLoaderDispatch, { value: true});

        if(event.file.files.length == 0){
            Livewire.dispatch(event.callbackDispatch, { validationKey:'video', validationMessage:'The Video is required.',fileName:null,filePath:null });
            return;
        }

        if(event.file.size>=(event.sizeLimit*1024*1024)){
            Livewire.dispatch(event.callbackDispatch, { validationKey:'video', validationMessage:'Please choose a video of size less than '+event.sizeLimit+' MB.',fileName:null,filePath:null });
            return;
        }

        var formData = new FormData();
        var file = event.file.files[0];
        formData.append('file', file);

        $.ajax({
            url: '/upload-video',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Livewire.dispatch(event.callbackDispatch, { validationKey:null, validationMessage:null,fileName:response['file_name'],filePath:response['file_path'] });
            }
        });
    })
 });