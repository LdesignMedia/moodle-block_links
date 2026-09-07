<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This block generates a simple list of links based on the users profile.
 *
 * @package   block_links
 * @copyright 2016 Stephen Bourget
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot . '/blocks/links/lib.php');

$id = required_param('id', PARAM_INT);
require_login();
$record = $DB->get_record('block_links', ['id' => $id], '*', MUST_EXIST);

// Verify link is actually available, and user can follow it.
if (block_links_check_permissions($record)) {
    $context = context_system::instance();
    $params = ['context' => $context, 'objectid' => $id];
    $event = \block_links\event\link_followed::create($params);
    $event->trigger();
    redirect($record->url);
} else {
    // User has no access to this link.  Print an error.
    throw new moodle_exception('linkunavailable', 'block_links');
}
