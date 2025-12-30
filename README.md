# Bug Report Reproduction Scenarios

## Composer 2.10.0-RC runs plugin when it shouldn't (using `--no-plugins`)

### Description

See issue https://github.com/composer/composer/issues/12789


### How to reproduce

* Check out this branch
* Run `composer --no-interaction install --no-plugins -v --no-ansi` to install.
* Run `composer --no-interaction run-script post-install-cmd --no-plugins -v --no-ansi` to run the script.

Take note of the following (plugin) output showing when running the script:
```txt
Running PHPCodeSniffer Composer Installer
PHP CodeSniffer Config installed_paths set to ../../phpcompatibility/php-compatibility
```

Or have a look at the GitHub Actions output for this branch: https://github.com/jrfnl/bug-report-reproduction-scenarios/actions
