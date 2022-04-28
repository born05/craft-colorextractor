# Color Extractor Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/) and this project adheres to [Semantic Versioning](http://semver.org/).

## 2.1.0 - 2022-04-28
### Changed
- Move from league/color-extractor to ksubileau/color-thief-php

## 2.0.6.1 - 2020-11-03
### Fixed
- Fixed composer.json for composer 2

## 2.0.6 - 2020-01-27
### Changed
- Let extract task throw exceptions when the extracting itself fails.

## 2.0.5 - 2019-10-11
### Changed
- Log warnings when `ColorExtractorTask` fails, instead of throwing exceptions.

## 2.0.4 - 2019-10-11
### Fixed
- Deprecated twig extensions.

## 2.0.3 - 2019-03-20
### Changed
- Let the volume handle asset content retrieval.

## 2.0.2 - 2019-03-18
### Fixed
- Missing image check. Empty image files can still cause errors.

## 2.0.1 - 2019-03-15
### Fixed
- Prevent crashing when asset files are missing.

## 2.0.0 - 2019-01-15
### Fixed
- Stable release for Craft 3 and 3.1
- Handles corrupt images where no colors are found.

## 2.0.0-beta.6 - 2018-11-27
### Fixed
- Check for urls. Volumes need urls for the plugin to process the image.

## 2.0.0-beta.5 - 2018-11-15
### Added
- Added colorIsDark twig filter

## 2.0.0-beta.4 - 2018-11-05
### Fixed
- Fixed a major bug causing the queue to build up.

## 2.0.0-beta.3 - 2018-10-08
### Fixed
- Fixed errors thrown when imageColor field is missing on assets.

## 2.0.0-beta.2 - 2018-08-27
### Added
- Fixed links to docs
- Added icons.

## 2.0.0-beta.1 - 2018-08-22
### Added
- Initial Craft 3 release

## 1.0.6 - 2018-05-4
### Added
- Fixed php error.
- Added logging on plugin level
- Added console commmand

## 1.0.5 - 2018-05-2
### Added
- Prevent errors from breaking pageloads.
- #000000 is the default color.

## 1.0.4 - 2018-02-27
### Added
- Prevent svg's from breaking on upload.

## 1.0.3 - 2018-02-15
### Changed
- Tasks should not extract colors twice.

## 1.0.2 - 2018-02-14
### Added
- Fixed console usage

## 1.0.1 - 2018-02-14
### Added
- Added vendor to repo

## 1.0.0 - 2018-02-13
### Added
- Initial release