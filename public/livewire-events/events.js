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

        if(event.video.files.length == 0 || event.thumbnail.files.length == 0){
            Livewire.dispatch(event.callbackDispatch, { validationKey:{'video':event.video.files.length == 0,'thumbnail':event.thumbnail.files.length == 0}, validationMessage:{'video':'The Video is required.', 'thumbnail':'The Thumbnail is required.'},videoName:null,videoPath:null,thumbnailName:null,thumbnailPath:null });
            return;
        }

        if(event.video.files[0].size>=(event.videoSizeLimit*1024*1024) || event.thumbnail.files[0].size>=(event.thumbnailSizeLimit*1024*1024)){
            Livewire.dispatch(event.callbackDispatch, { validationKey:{'video':event.video.files[0].size>=(event.videoSizeLimit*1024*1024),'thumbnail':event.thumbnail.files[0].size>=(event.thumbnailSizeLimit*1024*1024)}, validationMessage:{'video':'The Video size should be less than '+event.videoSizeLimit + '.', 'thumbnail':'The Thumbnail size should be less than '+event.thumbnailSizeLimit + '.'},videoName:null,videoPath:null,thumbnailName:null,thumbnailPath:null });
            return;
        }

        var formData = new FormData();
        var video = event.video.files[0];
        var thumbnail = event.thumbnail.files[0];
        formData.append('video', video);
        formData.append('thumbnail', thumbnail);

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
                Livewire.dispatch(event.callbackDispatch, { validationKey:null, validationMessage:null, videoName:response['videoName'], videoPath:response['videoPath'], thumbnailName:response['thumbnailName'], thumbnailPath:response['thumbnailPath'] });
            }
        });
    });

    Livewire.on('upload-thumbnail', (event) => {
        
        Livewire.dispatch(event.callbackLoaderDispatch, { value: true});

        if(event.thumbnail.files.length == 0){
            Livewire.dispatch(event.callbackDispatch, { validationKey:{'thumbnail':event.thumbnail.files.length == 0}, validationMessage:{'thumbnail':'The Thumbnail is required.'}, thumbnailName:null,thumbnailPath:null });
            return;
        }

        if(event.thumbnail.files[0].size>=(event.thumbnailSizeLimit*1024*1024)){
            Livewire.dispatch(event.callbackDispatch, { validationKey:{'thumbnail':event.thumbnail.files[0].size>=(event.thumbnailSizeLimit*1024*1024)}, validationMessage:{'thumbnail':'The Thumbnail size should be less than '+event.thumbnailSizeLimit + '.'},thumbnailName:null,thumbnailPath:null });
            return;
        }

        var formData = new FormData();
        var thumbnail = event.thumbnail.files[0];
        formData.append('thumbnail', thumbnail);

        $.ajax({
            url: '/upload-thumbnail',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Livewire.dispatch(event.callbackDispatch, { validationKey:null, validationMessage:null, thumbnailName:response['thumbnailName'], thumbnailPath:response['thumbnailPath'] });
            }
        });
    })
 });