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
 * Plugin internal classes, functions and constants are defined here.
 * This code puts the new fields at the end of the form. They can be
 * inserted elsewhere with code like this, which puts the field
 * before the description field.
 * $examplefield = $mform->createElement('text', 'examplefield', get_string('examplefieldlabel', 'local_gradergroups'));
 * $mform->insertElementBefore($examplefield, 'introeditor');
 * @package     local_gradergroups
 * @copyright   2021 Marcus Green
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * @param moodleform $formwrapper The moodle quickforms wrapper object.
 * @param MoodleQuickForm $mform The actual form object (required to modify the form).
 * https://docs.moodle.org/dev/gradergroups
 * This function name depends on which plugin is implementing it. So if you were
 * implementing mod_wordsquare
 * This function would be called wordsquare_coursemodule_standard_elements
 * (the mod is assumed for course activities)
 */
function local_gradergroups_coursemodule_standard_elements($formwrapper, $mform) {
    global $COURSE, $DB, $PAGE;

    if ($PAGE->cm->id) {
        $existing = $DB->get_record('local_gradergroups', array('instanceid'=>$PAGE->cm->id));
    }

    $modulename = $formwrapper->get_current()->modulename;
    if ($modulename == 'assign') {

        

        // $mform->addElement('header', 'gradergroupsheader', get_string('gradergroupsheader', 'local_gradergroups'));
       
        // $mform->addElement('html', '<div class="alert">'.get_string('gradergroups', 'local_gradergroups').'</div>');

        $html = $mform->addElement('html', '<div class="alert alert-info"><h4><i class="fa fa-exclamation-circle"></i> NEW FEATURE</h4><p>'.get_string('gradergroups', 'local_gradergroups').'</p><p>Notifications must be enabled above or NO notifications will be sent to any teachers.</p></div>');
        $mform->insertElementBefore($html, 'sendstudentnotifications');
        if (strpos($COURSE->shortname, '-')) {
            $mform->setExpanded('notifications');
        }

        // $mform->hideIf('disabled', 'assing->sendnotifications', 'eq', 0);

        // $name = get_string('usegradergroups', 'local_gradergroups');
        // $mform->addElement('checkbox', 'usegradergroups', $name);
        // $mform->addHelpButton('usegradergroups', 'usegradergroups', 'local_gradergroups');
        // $mform->disabledIf('checkbox', 'assing->sendnotifications', 'eq', 0);
        


        

        $groups = groups_get_all_groups($COURSE->id);
        $graders = array();
        $i = 0;
        foreach ($groups as $group) {
            $i++;
            if ($group->name === $COURSE->fullname) {
                $group->name = '*All Teachers';
                $default = $group->id;
            }
            $gradergroups[$group->id] = $group->name;
        }
        asort($gradergroups);
        $name = get_string('sendnotificationstogroup', 'local_gradergroups');
        $groups = $mform->createElement('select', 'sendnotificationstogroup', $name, $gradergroups, 'size='.$i);
        $mform->insertElementBefore($groups, 'sendstudentnotifications');
        $mform->addHelpButton('sendnotificationstogroup', 'sendnotificationstogroup', 'local_gradergroups');
        // $mform->disabledIf('sendnotificationstogroup', 'assign->sendnotifications', 'eq', 1);
        $groups->setMultiple(true);
        $groups->setSelected($default);
        $mform->setdefault('sendnotificationstogroup', $existing->data);

        // $context = context_course::instance($COURSE->id);
        // $teachers = get_role_users(3, $context);
        // $graders = array();
        // $i = 0;
        // foreach ($teachers as $teacher) {
        //     $i++;
        //     $graders[$teacher->id] = $teacher->firstname.' '.$teacher->lastname;
        // }
        // $name = get_string('sendlatenotificationsto', 'local_gradergroups');
        // $graders = $mform->addElement('select', 'sendlatenotificationsto', $name, $graders, 'size='.$i);
        // $mform->disabledIf('sendlatenotificationsto', 'assign->sendlatenotifications', 'eq', 0);
        // $mform->addHelpButton('sendlatenotificationsto', 'sendlatenotificationsto', 'local_gradergroups');
        // $graders->setMultiple(true);
        


// $options = array(                                                                                                           
//     'multiple' => true,                                                  
//     'noselectionstring' => get_string('allgroups', 'local_gradergroups'),                                                                
// ); 
// $mform->addElement('autocomplete', 'groupids', $name, $gradergroups, $options);


//         $mform->disabledIf('usegradergroups', 'assign->sendnotifications', 'eq', 0);

//         $mform->setExpanded('gradergroupsheader');


        
        // $mform->insertElementBefore($graders, 'sendstudentnotifications');
    }
}

/**
 * Process data from submitted form
 *
 * @param stdClass $data
 * @param stdClass $course
 * @return void
 * See plugin_extend_coursemodule_edit_post_actions in
 * https://github.com/moodle/moodle/blob/master/course/modlib.php
 */
function local_gradergroups_coursemodule_edit_post_actions($data, $course) {
    global $DB;
    if (!isset($data->sendnotificationstogroup)) {
        return $data;
    } else {
    // print_r($data);
        $cm = new stdClass();
        $cm->instanceid = $data->coursemodule;
        $cm->assid = $data->coursemodule;
        $cm->asstype = $data->type;
        $cm->coursecode = $course->shortname;
        $cm->data = implode(',',$data->sendnotificationstogroup);
        $cm->timemodified = time();
        if($record = $DB->get_record('local_gradergroups', array('instanceid'=>$cm->instanceid))) {
            $cm->id = $record->id;
            // print_r($record);
            $DB->update_record('local_gradergroups', $cm);
        } else {
            $DB->insert_record('local_gradergroups', $cm);
        }
        return $data;
    }

}

// function local_gradergroups_coursemodule_update_instance($instance, $mform) {
//     print_r($instance);
//     echo('<h4>mform</h4>');
//     print_r($mform);
//     $id = $instance->instance;
//     $cmid = $instance->coursemodule;
//     $instance->id = $id;
//     $success = $DB->update_record('local_gradergroups', $instance);
//     if (!$success) {
//         return false;
//     }
// }

function local_gradergroups_coursemoduledata_preprocessing(&$defaultvalues) {
        global $DB;
echo 'ballbag';
        if ($this->current && !empty($this->current->instance)) {
            $record = $DB->get_records('local_gradergroups', ['instanceid' => $this->current->instance], 'id');
            print_r($record);
        }
}

/**
 * Validate the data in the new field when the form is submitted
 *
 * @param moodleform_mod $fromform
 * @param array $fields
 * @return void
 */
function local_gradergroups_coursemodule_validation($fromform, $fields) {
    if (get_class($fromform) == 'mod_assign_mod_form') {
     // \core\notification::add($fields['gradergroupsfield'], \core\notification::INFO);
    }
}
