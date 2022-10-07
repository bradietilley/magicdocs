<?php

use MagicDocs\Parsers\Laravel\AccessorsAsProperties;

test('parser can generate property docs for all accessors for Comment model', function () {
    $parser = new AccessorsAsProperties();

    $file = getFile('Comment');
    $docs = $parser->parse($file);

    $expect = <<<EOL
namespace App\Models;
/**
 * @property int \$net_likes // [via AccessorsAsProperties]::getNetLikesAttribute()
 * @property string|null \$preview // [via AccessorsAsProperties]::preview()
 */
class Comment
{
}
EOL;
    $expect = trim($expect);
    $actual = trim((string) $docs);
    
    expect($actual)->toBe($expect);
});