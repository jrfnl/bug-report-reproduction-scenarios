<?php

require_once __DIR__ . '/setup/setup_dba_tests.inc';
check_skip('flatfile');

function set_up_db_local(string $handler, string $name, LockFlag $lock, bool $persistent = false) {
    $lock_flag = $lock->value;
    // Open file in creation/truncation mode
    $func = $persistent ? 'dba_popen' : 'dba_open';

    $db_file = $func($name, 'n'.$lock_flag, $handler);

    if ($db_file === false) {
        die("Failed to create DB");
    }

    return $db_file;
}

function run_standard_tests_local(string $handler, string $name, LockFlag $lock, bool $persistent = false): void
{
    $lock_flag = $lock->value;
    $db_file = set_up_db_local($handler, $name, $lock);
    // Close creation/truncation handler
    dba_close($db_file);

    $db_writer = dba_open($name, 'w'.$lock_flag, $handler);
    if ($db_writer === false) {
        die("Failed to open DB for write");
    }

	echo PHP_EOL,PHP_EOL;
	echo 'PHPCompatibility tests',PHP_EOL,PHP_EOL;

	dba_key_split(dba_firstkey($db_writer));
	dba_key_split(key: dba_nextkey($db_writer));
	dba_key_split(\dba_firstkey($db_writer));
	dba_key_split(
	    // Comment.
	    \dba_NextKey($db_writer)
	);

    dba_close($db_writer);
}


$db_name = 'dba_flatfile.db';
$handler = 'flatfile';

ob_start();
run_standard_tests_local($handler, $db_name, LockFlag::FileLock);
cleanup_standard_db($db_name);
$run_output = ob_get_flush();
