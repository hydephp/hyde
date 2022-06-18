# Hyde/Testing/Hyde

This test suite contains high-level tests for the Hyde project as a whole.
These tests function partially as a sanity check / smoke test for the
process of using main Hyde features. If a test fails, it is likely that
something has gone rather wrong, or that the wrong Framework version
is loaded. Some tests also check that possibly breaking changes
are not accidentally introduced.

All tests are feature and/or integration tests.

Run with the following command:

```bash
vendor/bin/pest --testsuite="FeatureHyde"
```

Please note that the tests will modify project files.
It also assumes that the tests are run in a clean project.

Todo:

- [] Add the Cypress tests.
