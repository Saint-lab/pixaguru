



document.addEventListener("DOMContentLoaded", () => {

    const mockupUpload = document.querySelector('#mockup-upload');


    mockupUpload.addEventListener('change', (event) => {

        const uploadFile = document.querySelector('#img-file');

        uploadFile.src = URL.createObjectURL(event.target.files[0]);
    });



});


