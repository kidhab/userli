<?php

namespace App\Importer;

use App\Model\OpenPpgKeyInfo;

interface OpenPgpKeyImporterInterface
{
    public static function import(string $email, string $data): OpenPpgKeyInfo;
}
