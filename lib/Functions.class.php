<?php
Class Functions {
    public static function fullescape( $in )
    {
        return preg_replace('/\W+/', '_', strtolower($in));;
    }
}
?>