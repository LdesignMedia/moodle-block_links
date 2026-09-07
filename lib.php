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
 * @copyright 2014 Stephen Bourget
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Define some constants.
define('BLOCK_LINKS_INSTITUTION', 1);
define('BLOCK_LINKS_DEPARTMENT', 2);
define('BLOCK_LINKS_CITY', 3);
define('BLOCK_LINKS_COUNTRY', 4);
define('BLOCK_LINKS_DESCRIPTION', 5);

define('BLOCK_LINKS_SHOWLINK', 1);
define('BLOCK_LINKS_HIDELINK', 0);
define('BLOCK_LINKS_SHOW_EVERYONE', 'All');

define('BLOCK_LINKS_WINDOW_NEW', '_blank');
define('BLOCK_LINKS_WINDOW_PARENT', '_parent');
define('BLOCK_LINKS_WINDOW_SELF', '_self');

/**
 * Checks permissions whether a user can access a specific link.
 * @param stdclass $link
 * @return boolean
 */
function block_links_check_permissions($link) {
    global $USER, $DB;

    // Check to see if the link is hidden.
    if ($link->defaultshow == BLOCK_LINKS_HIDELINK) {
        return false;
    }

    // Can everyone see it?
    if ($link->department == BLOCK_LINKS_SHOW_EVERYONE) {
        return true;
    }

    // Do they match the user profile restriction?.
    $blockconfig = get_config('block_links');

    switch ($blockconfig->profile_field) {
        case BLOCK_LINKS_INSTITUTION:
            if ($link->department == ($USER->institution ?? '')) {
                return true;
            }
            break;

        case BLOCK_LINKS_DEPARTMENT:
            if ($link->department == ($USER->department ?? '')) {
                return true;
            }
            break;

        case BLOCK_LINKS_CITY:
            if ($link->department == ($USER->city ?? '')) {
                return true;
            }
            break;

        case BLOCK_LINKS_COUNTRY:
            if ($link->department == ($USER->country ?? '')) {
                return true;
            }
            break;

        case BLOCK_LINKS_DESCRIPTION:
            // TODO: CONVERT THIS TO MUC.
            static $description;
            if (!isset($description)) {
                $description = $DB->get_field('user', 'description', ['id' => $USER->id]);
                $description = clean_param($description, PARAM_NOTAGS);
            }
            if ($link->department == $description) {
                return true;
            }
            break;

        default:
            return false;
    }
    return false;
}
