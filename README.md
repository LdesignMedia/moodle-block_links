# Links — Learning Resources block for Moodle

[![Moodle Plugin CI](https://github.com/LdesignMedia/moodle-block_links/actions/workflows/moodle-ci.yml/badge.svg)](https://github.com/LdesignMedia/moodle-block_links/actions)

Links is a Moodle block that shows a site-wide list of web links to users. An administrator
maintains the links centrally, and each link can be shown to everyone or restricted to users
whose profile matches a chosen field (institution, department, city, country, or description).
The block can be added to courses, the dashboard, and the front page.

## Requirements

- Moodle 5.0 or later (`$plugin->requires = 2025040900`)
- PHP 8.3 or later

## Installation

1. Copy the plugin into `blocks/links/` in your Moodle site (or install the ZIP via
   *Site administration → Plugins → Install plugins*).
2. Log in as an administrator and follow the upgrade prompt to complete installation.

See the Moodle documentation for details:
<https://docs.moodle.org/en/Installing_plugins>.

## Usage

1. Go to *Site administration → Plugins → Blocks → Links* to set the block title, choose the
   profile field used for restricting links, and pick how links open (new window, same window,
   or parent frame).
2. On the same settings page, follow *Add/Edit Links* to add, edit, and delete links. Each link
   has display text, a URL, optional notes, a "show by default" flag, and an optional profile
   restriction.
3. Add the *Links* block to any course, the dashboard, or the front page. Users see the links
   that are visible to them, and following a link is logged.

## Features

- Central, site-wide list of links maintained by an administrator.
- Per-link visibility, either shown to everyone or restricted by a user profile field.
- Configurable link target (new window, same window, or parent frame).
- Configurable block title.
- Link follow, add, edit, and delete actions are recorded through the Moodle events API.
- Implements the Moodle Privacy API (the block stores no personal data).

## Bug reports and feature requests

Please report issues for this Moodle 5.x version to the maintained repository:
<https://github.com/LdesignMedia/moodle-block_links>.

## Credits

The Links block was originally created by **Sean Madden** (RIT, the original block
implementation for Moodle 1.6) and maintained and updated for later Moodle versions by
**Stephen Bourget**. It was developed for **Goffstown School District** (Goffstown, NH, USA),
and many ideas and code were adapted from other Moodle modules and from Moodle core. The
original project is at <https://github.com/sbourget/moodle-block_links>.

This Moodle 5.x–compatible version is maintained by **Ldesign Media**
(<https://ldesignmedia.nl>), which updated the plugin for current Moodle and PHP releases while
preserving the original authors' work and copyright.

## License

Copyright (C) 2006 Sean Madden, Stephen Bourget, and others.
Maintained for Moodle 5.x by Ldesign Media.

This program is free software: you can redistribute it and/or modify it under the terms of the
GNU General Public License as published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details: <https://www.gnu.org/licenses/gpl-3.0.html>.
