<?php

namespace tool_bulk_rubric_assign\form;

use moodleform;

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/formslib.php");

class assign_form extends moodleform {

    protected function definition()
    {
        $mform =& $this->_form;

        // TODO add description of tool function
        // TODO use language strings below

        // Text in title
        $mform->addElement('text', 'title', 'Text in title');
        $mform->setType('title',PARAM_TEXT);
        $mform->addRule('title', 'required', 'required');

        // Course select
        $mform->addElement('select', 'course', 'Course', [1 => 'Course 1', 2 => 'Course 2']);
        $mform->setType('course', PARAM_INT);
        $mform->addRule('course', 'required', 'required');

        // Rubric template select
        $mform->addElement('select', 'template', 'Rubric', [1 => 'Example template']);
        $mform->setType('template', PARAM_INT);
        $mform->addRule('template', 'required', 'required');


        $this->add_action_buttons(false, 'Update rubrics');
    }
}
