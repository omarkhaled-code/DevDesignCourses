let form = document.getElementById('form');
let inputVideo = document.getElementById('video');
let inputName = document.getElementById('name');
let inputDescription = document.getElementById('description');
let inputImage = document.getElementById('image');

form.addEventListener('submit', 

    function(e) {
        e.preventDefault();

        var fileInput = document.getElementById('video');
        var file = fileInput.files[0];
        var totalBytes = file.size;
        var uploadedBytes = 0;
        var timeStarted = new Date().getTime();


        var data = new FormData();
        data.values = {
            'name': inputName,
            'description': inputDescription,
            'image': inputImage,
            'video': inputVideo,
        };
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '/add-video', true);

        xhr.upload.addEventListener('progress', function(e) {
            if(e.lengthComputable) {

                var uploadedBytes = e.loaded;
                var timeElapsed  = new Date().getTime() - timeStarted;
                var uploadSpeed = uploadedBytes / (timeElapsed / 1000 );
                var timeRemaining = (totalBytes - uploadedBytes) / uploadSpeed;

                var minutesRemaining = Math.floor(timeRemaining / 60);
                var secondsRemaining = Math.floor(timeRemaining % 60);

                console.log('Time remaining: ' + minutesRemaining + ' minutes and ' + secondsRemaining + ' seconds');

            }
        })
        
        xhr.send(data);
    }
)






























// import "jquery";

// $(document).ready(function () {
//     console.log('omar');
//     $(form).submit(function(e) {
//         e.preventDefault();
//         var formData = new FormData(this);
//         $.ajax({
//             xhr: function(){
//                 var xhr = new window.XMLHttpRequest();

//                 xhr.upload.addEventListener('progress', function(evt) {
//                     if (evt.lengthComputable) {
//                         var percentComplete = evt.loaded / evt.total;
//                         percentComplete = parseInt(percentComplete * 100);
//                         $('#progress-bar').width(percentComplete + '%');
//                         $('#progress-bar').html(percentComplete + '%');
//                     }
//                 },false);
//                 return xhr;
//             },
//             url: '/add-video', 
//                 type: 'POST',
//                 data: formData,
//                 contentType: false,
//                 processData: false,
//                 success: function(data) {
//                     alert('Video uploaded successfully!');
//                 }
//         })
//     })
// })
