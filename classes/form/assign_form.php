<?php

namespace tool_bulk_rubric_assign\form;

use moodleform;

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/formslib.php");

class assign_form extends moodleform {

    protected function definition()
    {
        $mform =& $this->_form;

        // Description
        $mform->addElement('html', \html_writer::tag('p', get_string('tool_description', 'tool_bulk_rubric_assign')));

        // Text in title
        $mform->addElement('text', 'title', get_string('titlematch', 'tool_bulk_rubric_assign'));
        $mform->setType('title',PARAM_TEXT);
        $mform->addRule('title', 'required', 'required');

        // Course select
        $mform->addElement('select', 'course', get_string('course'), [1 => 'Course 1', 2 => 'Course 2']);
        $mform->setType('course', PARAM_INT);
        $mform->addRule('course', 'required', 'required');

        // Rubric template select
        $mform->addElement('select', 'template', get_string('rubric', 'tool_bulk_rubric_assign'), [1 => 'Example template']);
        $mform->setType('template', PARAM_INT);
        $mform->addRule('template', 'required', 'required');


        $this->add_action_buttons(false, 'Update rubrics');
    }
}
