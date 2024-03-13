# Changelog
All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [1.0.0] - 13-10-2020
### Changed
- Laravel 7 and 8 Support
- PHP 7.3+ required

## [1.0.1] - 28-07-2021
### Changed
- Caching fix
- PHP 8 Support

## [1.0.2] - 14-02-2022
- Laravel 9 Support

## [1.0.3] - 06-03-2023
- Laravel 10 Support

## [2.0.0] - 22-02-2024
### Added
- Autocomplete and get endpoint support.
- Complete test coverage.

### Changed
- Refactored codebase, make use of `Http` facade to assist testing.
- Moved core HTTP logic into `Laralabs\GetAddress\Http\Client` which provides `get()` and `post()`. Can be used if wanting to experiment with new endpoints or endpoints not supported by the package. 

### Removed
- Unused classes.

## [2.0.0] - 13-03-2024
- Laravel 11 Support