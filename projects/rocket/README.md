# Hyde Rocket 🚀 - Fast CMS dashboard for HydePHP

## Project status: EXPERIMENTAL

---

**Warning:**

This software is designed to aid application development.
It may also be useful for testing purposes or for application
demonstrations that are run in controlled environments.

It must never be used on a public network.

**Double warning:**

I cannot stress enough how much you should only use this locally.

Rocket opens up several places for remote code execution.
For example, the dashboard can be used to open and execute
files on the server filesystem. While there are some validations
in place they are only intended to catch typos and mistakes.
For example, there are some path sanitizations to prevent
accidental file editing, but these are not made to secure
against directory traversal attacks.

There is also no authentication. Access to the dashboard
gives access to the entire project.


## Installation

Rocket is not nearly ready to be installed.

However, when it is, it will probably be installed similar to Laravel Nova,
by downloading a zip file into the rocket directory of the project.

This is since Rocket is a full Laravel Lumen application,
and I'm not sure if it is possible to package it with Composer.

> Developers note, before merging into the main branch,
> this will be moved into the packages/ directory.

Right now, the rough installation process is:
clone the rocket directory into `<your-project-root>/rocket`,
navigate into the rocket directory, and run `composer install`.
And start up a development server.