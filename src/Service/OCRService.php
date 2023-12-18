<?php
namespace App\Service;

class OCRService
{
    public function extractText($imagePath)
    {
        // Example using Tesseract OCR
        $escapedImagePath = escapeshellarg($imagePath);
        $text = shell_exec("tesseract $escapedImagePath -");
        $text = trim(file_get_contents("{$imagePath}.txt")); // Read the text from the generated file

        return ['text' => $text];
    }
}
