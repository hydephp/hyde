# Cypress Frontend Testing

## Introduction

Cypress is a testing library that is here used to run frontend and end-to-end tests for HydePHP.

## Usage

Please see https://docs.cypress.io/ for more information.

Having issues with the realtime compiler? (At least on Windows) the built in web-server starts on localhost, which is resolved using a local IPv6 address. If you can't connect from Cypress when using `php hyde serve`, try running `php hyde serve --host=127.0.0.1` to use an IPv4 address instead.
