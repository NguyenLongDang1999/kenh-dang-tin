<?php

use CodeIgniter\I18n\Time;

function getMenuActive($patterns, $activeClass = "active")
{
    if (url_is('*administrator/' . $patterns)) {
        return $activeClass;
    }
}

function getOptionSelectStatus()
{
    $option = [
        '' => 'Vui Lòng Chọn',
        0 => 'OFF',
        1 => 'ON',
    ];

    return $option;
}

function showCategoryImage($image)
{
    if (is_null($image)) {
        $path = base_url(PATH_IMAGE_DEFAULT);
    } else {
        if (strpos($image, 'https') !== false) {
            $path = $image;
        } else {
            $path = PATH_CATEGORY_IMAGE . $image;
        }
    }

    return $path;
}

function getDateTime($date)
{
    $time = Time::parse($date);
    return $time->toLocalizedString('dd-MM-yyyy');
}

function changeFileNameNew($fileName)
{
    $parts = explode('.', $fileName);
    $parts[count($parts) - 1] = 'webp';
    $fileNameNew = implode('.', $parts);

    return $fileNameNew;
}

function imageManipulation($path, $fileName, $fileNameNew, $folder, $data)
{
    $image = \Config\Services::image();
    if ($folder == '') {
        $savePath = $path . '/';
    } else {
        $savePath = $path . '/' . $folder;
    }

    if (!file_exists($savePath)) {
        mkdir($savePath, 755);
    }

    $image->withFile($path . $fileName);
    switch ($folder) {
        case 'small':
            $image->resize($data['resizeX'], $data['resizeY'], true, 'height');
            break;

        case 'medium':
            $image->resize($data['resizeX'], $data['resizeY'], true, 'height');
            break;

        default:
            $image->resize($data['resizeX'], $data['resizeY'], true, 'height');
            break;
    }
    $image->convert(IMAGETYPE_WEBP);

    if ($folder == '') {
        return $image->save($savePath . $fileNameNew);
    } else {
        return $image->save($savePath . '/' . $fileNameNew);
    }
}

function deleteImage($path, $fileName)
{
    if (file_exists($path . $fileName)) {
        unlink($path . $fileName);
    }
}

function uploadOneFile($file, $path, $resize, $update = false, $oldImage = '')
{
    if ($file->isValid() && !$file->hasMoved()) {
        $fileName = $file->getRandomName();
        $file->move($path, $fileName);
        $fileNameNew = changeFileNameNew($fileName);
        imageManipulation($path, $fileName, $fileNameNew, '', $resize);
        deleteImage($path, $fileName);

        if ($update && !empty($oldImage)) {
            deleteImage($path, $oldImage);
        }

        return $fileNameNew;
    }
}

function deleteMultipleImage($path, $array)
{
    if (count($array) > 0) {
        foreach ($array as $item) {
            if (!is_null($item->image)) {
                deleteImage($path, $item->image);
            }
        }
    }
}
