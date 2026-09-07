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
 * The block_links link deleted event.
 *
 * @package    block_links
 * @copyright  2016 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace block_links\event;

/**
 * The block_links link deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string concept: the concept of created entry.
 * }
 *
 * @package    block_links
 * @since      Moodle 3.0
 * @copyright  2016 Stephen Bourget
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class link_deleted extends \core\event\base {
    /**
     * Init method
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'block_links';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventlinkdeleted', 'block_links');
    }

    /**
     * Returns non-localised event description with id's for admin use only.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has removed the link with id '$this->objectid'"
                . " from the links block";
    }

    /**
     * Get URL related to the action.
     *
     * @return \moodle_url
     */
    public function get_url() {
        return new \moodle_url("/blocks/links/config_global_action.php");
    }



    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        // Make sure this class is never used without proper object details.
        if ($this->contextlevel !== CONTEXT_SYSTEM) {
            throw new \coding_exception('Context level must be CONTEXT_SYSTEM.');
        }
    }

    /**
     * Backup / Restore mappings
     * @return array
     */
    public static function get_objectid_mapping() {
        return ['db' => 'block_links', 'restore' => 'block_links'];
    }
}
