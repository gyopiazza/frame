<?php

// Set JPEG quality for generated images
function frame_jpeg_quality_callback($quality)
{
    return (int) 100;
}

add_filter('jpeg_quality', 'frame_jpeg_quality_callback');