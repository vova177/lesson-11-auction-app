<?php
namespace App\Services\UploadsManager;

use App\Framework\Config;

class UploadsManager
{

    public function __construct() {

    }


    /** Save lot image to filestorage
     *
     * Example:
     *      $uploadsManager = $this->servicesContainer->uploadsManager;
     *      $fileName = $uploadsManager->saveLotImage($_FILES['lot_image']);
     *
     * WebPath:
     * - origin: /images/lots/{file_name}.{ext}
     * - thumb: /images/lots/{file_name}_150x150.{ext}
     *
     * @param $file - file element from $_FILES array
     * @return string
     */
    public function saveLotImage( $file ) {

        $image = new \Imagick($file['tmp_name']);
        $image->cropThumbnailImage( 150, 150 );

        $fileExtension = pathinfo(
            $file['name'],
            PATHINFO_EXTENSION
        );
        $filename = uniqid().'.'.$fileExtension;
        $filenameThumb = uniqid().'_150x150.'.$fileExtension;

        move_uploaded_file( $file['tmp_name'], '../../../images/lots/'.$filename );
        $image->writeImageFile( '../../../images/lots/'.$filenameThumb );

        return $filename;
    }

}