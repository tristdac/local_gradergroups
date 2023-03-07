<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin strings are defined here.
 *
 * @package     local_gradergroups
 * @category    string
 * @copyright   2021 Marcus Green
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['gradergroupslabel'] = 'Example field';
$string['gradergroupsheader'] = 'Group Grader Notifications &nbsp;<i class="fa fa-group"></i>';
$string['gradergroups'] = 'If multiple teachers exist on this course, all teachers will be notified of student submissions by default. Limit these notifications to <strong>ONLY</strong> the grader for the group selected below.';
$string['sendlatenotificationsto'] = 'Graders to notify';
$string['sendlatenotificationsto_help'] = 'Select the graders which will receive notifications for <strong>late submissions</strong> to this assignment activity. This might be useful for staff tracking progress of a monitored student. <br><strong>Tip:</strong> Use CTRL or SHIFT keys to select multiple graders.';
$string['usegradergroups'] = "Enable group graders";
$string['usegradergroups_help'] = "Enable to notify only teachers who are members of the selected group(s)";
$string['sendnotificationstogroup'] = 'Group graders to notify';
$string['sendnotificationstogroup_help'] = '<p>Select the groups graders which will receive notifications for submissions to this assignment activity.</p><p><strong>Notifications must be enabled above or NO notifications will be sent to any teachers.</strong><p><p><strong>Tip:</strong> Use CTRL or SHIFT keys to select multiple groups.';
$string['disabled'] = 'Notice:';
$string['disabledexplanation'] = '<div class="alert alert-warning">Enable notifications above to enable below</div>';
$string['allgroups'] = 'All Teachers/Graders';

