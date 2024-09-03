<?php

include dirname(__DIR__) . '/vendor/autoload.php';

if (class_exists('PHPUnit\Framework\Attributes\CoversTrait')) {
	define('HAS_COVERS_TRAIT', true);
} else {
	define('HAS_COVERS_TRAIT', false);
}
