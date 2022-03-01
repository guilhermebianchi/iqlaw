<?php
class ResizeImage
{
    protected static  $ext;
    protected static  $image;
    protected static  $newImage;
    protected static  $origWidth;
    protected static  $origHeight;
    protected static  $resizeWidth;
    protected static  $resizeHeight;

    public static function resize ( $filename, $width, $height, $resizeOption = 'default', $origin = '' ){
        $explodeFilename = explode( '.', $filename );
        $thumbFilename = '';

        for($i=0; $i<count($explodeFilename); $i++){
            if( $i == count( $explodeFilename )-1 ){
                $thumbFilename .= '-thumb-'.$origin.'.' . $explodeFilename[$i];
            }else{
                if( $i != 0) $thumbFilename .= '.' . $explodeFilename[$i];
                else $thumbFilename .= $explodeFilename[$i];
            }
        }

        try {
            if (!file_exists($filename)) {
                throw new Exception('Image ' . $filename . ' can not be found, try another image.');
            }

            if (file_exists( $thumbFilename )) {
                return $thumbFilename;
            }

            self::setImage( $filename );
            self::resizeTo( $width, $height, $resizeOption );
            self::saveImage( $thumbFilename );

            return $thumbFilename;
        }catch (Exception $e){
            exit( $e );
        }
    }

    public static function setImage( $filename )
    {
        try {
            $size = getimagesize($filename);
            self::$ext = $size['mime'];

            switch (self::$ext) {
                case 'image/jpg':
                case 'image/jpeg':
                    self::$image = imagecreatefromjpeg($filename);
                    break;
                case 'image/gif':
                    self::$image = @imagecreatefromgif($filename);
                    break;
                case 'image/png':
                    self::$image = @imagecreatefrompng($filename);
                    break;
                default:
                    throw new Exception("File is not an image, please use another file type.", 1);
            }
           self::$origWidth = imagesx(self::$image);
           self::$origHeight = imagesy(self::$image);

           return [
               self::$origWidth,
               self::$origHeight
           ];
        }catch( Exception $e ){
            exit( $e );
        }
    }

    private static function saveImage($savePath, $imageQuality="80", $download = false)
    {
        try {
            switch (self::$ext) {
                case 'image/jpg':
                case 'image/jpeg':
                    if (imagetypes() & IMG_JPG) {
                        imagejpeg(self::$newImage, $savePath, $imageQuality);
                    }
                    break;
                case 'image/gif':
                    if (imagetypes() & IMG_GIF) {
                        imagegif(self::$newImage, $savePath);
                    }
                    break;
                case 'image/png':
                    $invertScaleQuality = 9 - round(($imageQuality / 100) * 9);

                    if (imagetypes() & IMG_PNG) {
                        imagepng(self::$newImage, $savePath, $invertScaleQuality);
                    }
                    break;
                default:
                    throw new Exception("File type not supported.", 1);
            }

            if ($download) {
                header('Content-Description: File Transfer');
                header("Content-type: application/octet-stream");
                header("Content-disposition: attachment; filename= " . $savePath . "");
                readfile($savePath);
            }
            imagedestroy(self::$newImage);
        }catch( Exception $e ){
            exit( $e );
        }
    }

    private static function resizeTo( $width, $height, $resizeOption = 'default' )
    {
        switch(strtolower($resizeOption))
        {
            case 'exact':
                self::$resizeWidth = $width;
                self::$resizeHeight = $height;
                break;
            case 'maxwidth':
                self::$resizeWidth  = $width;
                self::$resizeHeight = self::resizeHeightByWidth($width);
                break;
            case 'maxheight':
                self::$resizeWidth  = self::resizeWidthByHeight($height);
                self::$resizeHeight = $height;
                break;
            default:
                if(self::$origWidth > $width || self::$origHeight > $height)
                {
                    if ( self::$origWidth > self::$origHeight ) {
                        self::$resizeHeight = self::resizeHeightByWidth($width);
                        self::$resizeWidth  = $width;
                    } else if( self::$origWidth < self::$origHeight ) {
                        self::$resizeWidth  = self::resizeWidthByHeight($height);
                        self::$resizeHeight = $height;
                    }
                } else {
                    self::$resizeWidth = $width;
                    self::$resizeHeight = $height;
                }
                break;
        }
        self::$newImage = imagecreatetruecolor(self::$resizeWidth, self::$resizeHeight);
        imagecopyresampled(self::$newImage, self::$image, 0, 0, 0, 0, self::$resizeWidth, self::$resizeHeight, self::$origWidth, self::$origHeight);
    }

    private static function resizeHeightByWidth($width)
    {
        return floor((self::$origHeight/self::$origWidth)*$width);
    }

    private static function resizeWidthByHeight($height)
    {
        return floor((self::$origWidth/self::$origHeight)*$height);
    }
}
