<?php

require_once __DIR__ . '/setup/setup_dba_tests.inc';
check_skip('flatfile');

$db_name = 'dba_flatfile.db';
$handler = 'flatfile';
run_standard_tests($handler, $db_name);

cleanup_standard_db($db_name);
