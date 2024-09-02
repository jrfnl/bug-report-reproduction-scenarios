<?php

namespace Jrf\PHPUnit1011\Example;

use Exception;

class Foo
{
    public static function pcreHasUtf8Support()
    {
        // This regex deliberately has a compile error to demonstrate the issue.
        return (bool) @preg_match('/^.[/u', 'a');
    }

    public static function openFile($filename)
    {
        // Silenced the PHP native warning in favour of throwing an exception.
        $download = @fopen($filename, 'wb');
        if ($download === false) {
            $error = error_get_last();
            if (!is_array($error)) {
                // Shouldn't be possible, but can happen in test situations.
                $error = ['message' => 'Failed to open stream'];
            }

            throw new Exception($error['message']);
        }
    }
}
