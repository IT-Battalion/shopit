<?php

namespace App\Services\Documents;

use PhpOffice\PhpWord\TemplateProcessor;

class DocumentService
{
    /**
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     */
    public static function loadTemplate(string $path)
    {
        return new TemplateProcessor($path);
    }
}
