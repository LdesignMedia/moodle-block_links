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
 * @copyright 2013 Stephen Bourget
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/blocks/links/lib.php');

/**
 * This defines the edit form for managing the links.
 *
 * @package   block_links
 * @copyright 2010 Stephen Bourget
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class link_edit_form extends moodleform {
    /**
     * Link ID.
     * @var int
     */
    protected $id;

    /**
     * Link text to display.
     * @var string
     */
    protected $linktext = '';

    /**
     * URL of web-link.
     * @var string
     */
    protected $url = '';

    /**
     * Additional notes to display.
     * @var string
     */
    protected $notes = '';

    /**
     * Default display setting
     * @var bool
     */
    protected $defaultshow = BLOCK_LINKS_SHOWLINK;

    /**
     * Profile setting to match when displaying the link.
     * @var string
     */
    protected $department = BLOCK_LINKS_SHOW_EVERYONE;

    /**
     * Constructor.
     * @param string $actionurl
     * @param bool $isadd Whether the form is adding a new link (unused, kept for call compatibility).
     * @param int $id The id of the link being edited (0 when adding).
     */
    public function __construct($actionurl, $isadd = false, $id = 0) {
        $this->id = $id;
        parent::__construct($actionurl);
    }

    /**
     * Form definition.
     */
    public function definition() {
        global $DB;
        $blockconfig = get_config('block_links');
        $mform =& $this->_form;

        // Then show the fields about where this block appears.
        $mform->addElement('header', 'editlinkheader', get_string('managelinks', 'block_links'));

        $mform->addElement('text', 'linktext', get_string('linktext', 'block_links'), ['size' => 60]);
        $mform->setType('linktext', PARAM_TEXT);
        $mform->addRule('linktext', null, 'required');
        $mform->addRule('linktext', null, 'maxlength', 250);

        $mform->addElement('text', 'url', get_string('url', 'block_links'), ['size' => 60]);
        $mform->setType('url', PARAM_URL);
        $mform->addRule('url', null, 'required');
        $mform->addRule('url', null, 'maxlength', 250);

        $mform->addElement('header', 'additionalsettings', get_string('additionalsettings', 'block_links'));

        $mform->addElement('text', 'notes', get_string('notes', 'block_links'), ['size' => 60]);
        $mform->setType('notes', PARAM_TEXT);
        $mform->addRule('notes', null, 'maxlength', 250);

        $mform->addElement(
            'select',
            'defaultshow',
            get_string('defaultshow', 'block_links'),
            [BLOCK_LINKS_SHOWLINK => get_string('yes'), BLOCK_LINKS_HIDELINK => get_string('no')]
        );

        $mform->setType('defaultshow', PARAM_INT);
        $mform->setDefault('defaultshow', $this->defaultshow);

        $options = [];
        $options['All'] = get_string('all', 'block_links');

        switch ($blockconfig->profile_field) {
            case BLOCK_LINKS_INSTITUTION:
                $sql = "SELECT DISTINCT institution FROM {user} ORDER BY institution";
                $categories = $DB->get_records_sql($sql);
                foreach ($categories as $category) {
                    if (!empty($category->institution)) {
                        $options[$category->institution] = $category->institution;
                    }
                }
                break;

            case BLOCK_LINKS_DEPARTMENT:
                $sql = "SELECT DISTINCT department FROM {user} ORDER BY department";
                $categories = $DB->get_records_sql($sql);
                foreach ($categories as $category) {
                    if (!empty($category->department)) {
                        $options[$category->department] = $category->department;
                    }
                }
                break;

            case BLOCK_LINKS_CITY:
                $sql = "SELECT DISTINCT city FROM {user} ORDER BY city";
                $categories = $DB->get_records_sql($sql);
                foreach ($categories as $category) {
                    if (!empty($category->city)) {
                        $options[$category->city] = $category->city;
                    }
                }
                break;

            case BLOCK_LINKS_COUNTRY:
                $sql = "SELECT DISTINCT country FROM {user} ORDER BY country";
                $categories = $DB->get_records_sql($sql);
                foreach ($categories as $category) {
                    if (!empty($category->country)) {
                        $options[$category->country] = $category->country;
                    }
                }
                break;

            case BLOCK_LINKS_DESCRIPTION:
                $sql = "SELECT DISTINCT description FROM {user} ORDER BY description";
                $categories = $DB->get_records_sql($sql);
                foreach ($categories as $category) {
                    $item = "";
                    if (!empty($category->description)) {
                        // Strip tags etc before display.
                        $item = clean_param($category->description, PARAM_NOTAGS);
                        $options[$item] = $item;
                    }
                }
                break;

            default:
                $sql = "SELECT DISTINCT institution FROM {user} ORDER BY institution";
                $categories = $DB->get_records_sql($sql);
                foreach ($categories as $category) {
                    if (!empty($category->institution)) {
                        $options[$category->institution] = $category->institution;
                    }
                }
        }

        $mform->addElement('select', 'department', get_string('category', 'block_links'), $options);
        $mform->setType('department', PARAM_TEXT);
        $mform->setDefault('department', 'All');

        // Hidden.
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $this->add_action_buttons(true);
    }
}
