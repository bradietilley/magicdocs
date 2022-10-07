<?php

namespace MagicDocs\Parsers\Laravel;

use MagicDocs\ArgumentList;
use MagicDocs\File;
use MagicDocs\Doc;
use MagicDocs\Docs;
use MagicDocs\TypeMultiple;

class ModelHasFactoryReturnsFactoryClass extends AbstractLaravelParser
{
    public array $config = [
        'trait' => 'Illuminate\\Database\\Eloquent\\Factories\\HasFactory',
        'namespace' => 'Database\\Factories',
        'method' => 'factory',
    ];

    /**
     * Parse all columns from the database via artisan model:show command
     */
    public function parse(File $file): Doc|Docs|null
    {
        $factory = $this->get('trait');
        $namespace = $this->get('namespace');
        $method = $this->get('method');
        
        if ($file->isModel() === false) {
            return null;
        }
        
        if ($file->hasTrait($factory) === false) {
            return null;
        }

        $return = TypeMultiple::parse(
            sprintf(
                '%s\\%sFactory',
                $namespace,
                $file->name(),
            ),
        );

        $args = ArgumentList::parse($file->method($method)->getParameters());

        $docs = new Docs([
            new Doc(
                $file->namespace,
                'method',
                'factory',
                isStatic: true,
                schemaReturn: $return,
                schemaArgs: $args,
                description: $this->viaDescription(),
            ),
        ]);

        return $docs->orNull();
    }
}