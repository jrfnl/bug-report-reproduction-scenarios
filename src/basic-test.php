<?php

echo 'split with `null`',PHP_EOL;
var_dump(dba_key_split(null));
echo 'split with `false`',PHP_EOL;
var_dump(dba_key_split(false));
echo 'split with `1`',PHP_EOL;
var_dump(dba_key_split(1));
echo 'split with empty string',PHP_EOL;
var_dump(dba_key_split(""));
echo 'split with "name1"',PHP_EOL;
var_dump(dba_key_split("name1"));
echo 'split with "[key1]name1"',PHP_EOL;
var_dump(dba_key_split("[key1]name1"));

echo PHP_EOL,PHP_EOL;
echo 'PHPCompatibility tests',PHP_EOL,PHP_EOL;

echo 'false', PHP_EOL;
dba_key_split(false);
echo 'null', PHP_EOL;
DBA_KEY_SPLIT(key:   NULL );
echo 'false with comment', PHP_EOL;
dba_key_split(
    // phpcs:ignore Stnd.Cat.Sniff -- for (testing) reasons.
    FALSE
);
echo 'null with comment', PHP_EOL;
\dba_key_split( /*comment*/ null /*comment*/ );
