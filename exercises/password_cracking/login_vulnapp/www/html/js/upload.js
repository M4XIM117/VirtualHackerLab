const url = "./php/upload.php";
const form = document.querySelector("#uploadForm");

form.addEventListener ("submit", function (evt) {
    evt.preventDefault ();
    const [file] = document.querySelector('[type=file]').files;
    const formData = new FormData();
    formData.append('file', file);

    fetch (url, {
        method: "POST",
        body: formData,
    }).then (async (response) => {
        await resetUploadForm(response.status);
        delay(3000);
    });
});

files.onchange = evt => {
    const [file] = files.files;
    if (file) {
        const mimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/jpg'];
        if (mimeTypes.includes(file.type)) previewFile.src = URL.createObjectURL(file)
        else previewFile.src = '../assets/broken_document.png';
        document.querySelector("#fileName").textContent = file.name;
        document.getElementById("submitFile").disabled = false;
    }
}

function delay(delayInMs) {
    setTimeout(function () {
        document.getElementById("uploadResponseBanner").style.display = 'none';
    }, delayInMs)
}

async function resetUploadForm(status) {
    const success = 'File was successfully uploaded.'
    const typeValidationErr = 'Invalid File! Only (jpeg, png, gif, jpg) image types are allowed';
    const backendError = 'File was not uploaded.';
    const responseText = status === 200 ? success :
        status === 400 ? typeValidationErr : 
        status === 500 ? backendError : 'Unexpected Error.';
    document.getElementById("uploadForm").reset();
    document.getElementById("previewFile").src = '#';
    document.getElementById("uploadScreen").style.display = 'none';
    document.getElementById("chatScreen").style.display = '';
    document.getElementById("fileName").innerText = '';
    document.getElementById("uploadResponseBanner").style.display = 'flex';
    document.getElementById("uploadResponseText").innerHTML = responseText;
}