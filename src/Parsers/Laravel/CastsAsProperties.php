<?php

namespace MagicDocs\Parsers\Laravel;

use MagicDocs\File;
use MagicDocs\Doc;
use MagicDocs\Docs;

class CastsAsProperties extends AbstractLaravelParser
{
    /**
     * Parse all properties from the `casts` array (via `getCasts()` method)
     */
    public function parse(File $file): Doc|Docs|null
    {
        if ($file->isModel() === false) {
            return null;
        }
        
        $docs = new Docs();
        $instance = $file->instance();

        foreach ($instance->getCasts() as $property => $type) {
            $type = static::parseTypes([
                $type,
            ]);

            $docs->push(
                new Doc(
                    $file->namespace,
                    'property',
                    $property,
                    schemaType: $type,
                    description: $this->viaDescription(),
                ),
            );
        }

        return $docs->orNull();
    }
}