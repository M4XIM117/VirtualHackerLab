<?php
    function uploadUnSanitized($fileStorage, $fileName, $tmpFileName)
    {
        if ($tmpFileName != '') {
            $newFilePath = $fileStorage . $fileName;
            return move_uploaded_file($tmpFileName, $newFilePath) ?
                sendData(200, 'File saved.') :
                sendData(500, 'File could not be saved.');
        }
    }

    function uploadSanitized($fileStorage, $fileName, $tmpFileName)
    {
        if($tmpFileName === '') return sendData(400, 'Missing Input!');

        $acceptedMimes = array(
            1 => 'gif', 'jpeg', 'png'
        );
        $mimeTypes = array(IMAGETYPE_GIF => 'gif', IMAGETYPE_JPEG => 'jpeg', IMAGETYPE_PNG => 'png');
        // $mimeType = $acceptedMimes[exif_imagetype($tmpFileName)];

        if (exif_imagetype($tmpFileName) != IMAGETYPE_GIF &&
            exif_imagetype($tmpFileName) != IMAGETYPE_JPEG &&
            exif_imagetype($tmpFileName) != IMAGETYPE_PNG)
            return sendData(400, 'Invalid File! Only (jpeg, png, gif, jpg) image types are allowed');

        $fileName = pathinfo($fileName, PATHINFO_FILENAME);

        $newFilePath = $fileStorage . $fileName . '.' . $mimeTypes[exif_imagetype($tmpFileName)];
        return move_uploaded_file($tmpFileName, $newFilePath) ?
            sendData(200, 'File saved.') :
            sendData(500, 'File could not be saved.');
    }

    function sendData($code, $message)
    {
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            500 => '500 Internal Server Error'
        );
        header('Status: ' . $status[$code]);
        http_response_code($code);
        header('Content-type:application/json;charset=utf-8');
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        echo json_encode(array(
            'status' => $code,
            'message' => $message
        ));
        exit();
    }

    $fileStorage = '../public/uploads/images/';
    $fileName = $_FILES['file']['name'];
    $tmpFileName = $_FILES['file']['tmp_name'];
    uploadUnSanitized($fileStorage, $fileName, $tmpFileName);
    // uploadSanitized($fileStorage, $fileName, $tmpFileName);


