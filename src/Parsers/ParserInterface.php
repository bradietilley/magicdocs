<?php

namespace MagicDocs\Parsers;

use MagicDocs\Doc;
use MagicDocs\Docs;
use MagicDocs\File;

interface ParserInterface
{
    public function withConfig(array $config);

    public function withDocs(Docs $docs);

    public function parse(File $file): Doc|Docs|null;

    public function standalone(): Doc|Docs|null;
}