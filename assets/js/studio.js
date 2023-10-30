



document.addEventListener("DOMContentLoaded", () => {

    // Download

    const download = document.getElementById('download');


    download?.addEventListener("click", () => {

        const node = document.getElementById('preview');

        console.log(node.innerHTML)

        htmlToImage.toJpeg(node, { quality: 0.95 })
            .then(function (dataUrl) {
                var link = document.createElement('a');
                link.download = 'my-image-name.jpeg';
                link.href = dataUrl;
                link.click();
            });

    });


    // mockups studio

    const mockupUpload = document.querySelector('#mockup-upload');


    mockupUpload?.addEventListener('change', (event) => {

        const uploadFile = document.querySelector('#img-file');

        uploadFile.src = URL.createObjectURL(event.target.files[0]);
    });




    // Box studio

    const boxUpload1 = document.querySelector('#box-upload-1');


    // const boxUpload1 = document.querySelector('#box-upload-1');


    // const boxUpload1 = document.querySelector('#box-upload-1');

    boxUpload1?.addEventListener('change', (event) => {

        const uploadFile1 = document.querySelector('#img-file-1');
        const uploadFile2 = document.querySelector('#img-file-2');

        uploadFile1.src = URL.createObjectURL(event.target.files[0]);
        uploadFile2.src = URL.createObjectURL(event.target.files[0]);
    });




});


