<?php

use CodeIgniter\I18n\Time;

function getMenuActive($patterns, $activeClass = "active")
{
    if (url_is('*administrator/' . $patterns)) {
        return $activeClass;
    }
}

function getMenuUserActive($patterns, $activeClass = "active")
{
    if (url_is('/' . $patterns)) {
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

function showProductImage($image)
{
    if (is_null($image)) {
        $path = base_url(PATH_IMAGE_DEFAULT);
    } else {
        if (strpos($image, 'https') !== false) {
            $path = $image;
        } else {
            $path = base_url(PATH_PRODUCT_IMAGE . $image);
        }
    }

    return $path;
}

function showProductMultiImage($thumb_list, $is_detail = false)
{
    if (!empty($thumb_list)) {
        if (strpos($thumb_list, 'https') !== false) {
            $path = $thumb_list;
        } else {
            if (!$is_detail) {
                $path = base_url(PATH_PRODUCT_SMALL_IMAGE . $thumb_list);
            } else {
                $path = base_url(PATH_PRODUCT_MEDIUM_IMAGE . $thumb_list);
            }
        }
    } else {
        $path = base_url(PATH_IMAGE_DEFAULT);
    }

    return $path;
}

function showUserImage($user_avatar)
{
    if (is_null($user_avatar)) {
        $path = base_url(PATH_AVATAR_DEFAULT);
    } else {
        if (strpos($user_avatar, 'https') !== false) {
            $path = $user_avatar;
        } else {
            $path = base_url(PATH_USER_IMAGE . $user_avatar);
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

function uploadMultipleFiles($files, $path, $update = false, $image_list = [])
{
    $thumb_list = '';

    foreach ($files as $file) {
        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move($path, $fileName);
            $fileNameNew = changeFileNameNew($fileName);

            $dataSmall = ['resizeX' => '350', 'resizeY' => '250'];
            $dataMedium = ['resizeX' => '650', 'resizeY' => '450'];

            imageManipulation($path, $fileName, $fileNameNew, 'small', $dataSmall);
            imageManipulation($path, $fileName, $fileNameNew, 'medium', $dataMedium);
            deleteImage($path, $fileName);

            if ($update) {
                if (!empty($image_list)) {
                    $thumb_list .= $image_list . ',' . $fileNameNew . ',';
                } else {
                    $thumb_list .= $fileNameNew . ',';
                }
            }

            $thumb_list .= $fileNameNew . ',';
        } else {
            $thumb_list .= $image_list;
        }
    }

    $thumb_list = rtrim($thumb_list, ',');

    return $thumb_list;
}

function getDateHumanize($date)
{
    $time = Time::parse($date);
    return $time->humanize();
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

function deleteMultipleProductImage($path, $array)
{
    if (!empty($array[0])) {
        foreach ($array as $item) {
            if (!is_null($item)) {
                deleteImage($path, $item);
            }
        }
    }
}

function showGender($gender)
{
    $html = '';

    if (!is_null($gender)) {
        if ($gender === GENDER_MALE) {
            $html .= 'Nam';
        } else {
            $html .= 'Nữ';
        }
    } else {
        $html .= 'Undefined';
    }

    return $html;
}

function starRating($review_rate)
{
    $html = '';

    for ($i = 0; $i < 5; $i++) {
        if (floor($review_rate) - $i >= 1) {
            $html .= '<li class="ratings-list-item"><i data-feather="star" class="filled-star"></i></li>';
        } else if ($review_rate - $i > 0) {
            $html .= '<li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>';
        } else {
            $html .= '<li class="ratings-list-item"><i data-feather="star" class="unfilled-star"></i></li>';
        }
    }

    return $html;
}
