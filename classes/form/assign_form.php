<?php

namespace tool_bulk_rubric_assign\form;

use html_writer;
use moodleform;
use tool_bulk_rubric_assign\rubric_assign_controller;

defined('MOODLE_INTERNAL') || die;

require_once("$CFG->libdir/formslib.php");

class assign_form extends moodleform
{

    /**
     * Define the form
     *
     * @throws \coding_exception
     * @throws \dml_exception
     */
    protected function definition()
    {
        global $DB;

        $mform =& $this->_form;

        // Description
        $mform->addElement('html', html_writer::tag('p', get_string('tool_description', 'tool_bulk_rubric_assign')));

        // Text in title
        $mform->addElement('text', 'match_text', get_string('titlematch', 'tool_bulk_rubric_assign'));
        $mform->setType('match_text', PARAM_TEXT);
        $mform->addRule('match_text', 'required', 'required');

        // Course select
        $mform->addElement('autocomplete', 'course_id', get_string('course'),
            [0 => get_string('none')] + $DB->get_records_menu('course', null, 'fullname ASC',
                'id,fullname'));
        $mform->setType('course_id', PARAM_INT);
        $mform->addRule('course_id', 'required', 'required');

        // Rubric template select
        $mform->addElement('select', 'template_id', get_string('rubric', 'tool_bulk_rubric_assign'),
            rubric_assign_controller::get_rubric_templates());
        $mform->setType('template_id', PARAM_INT);
        $mform->addRule('template_id', 'required', 'required');


        $this->add_action_buttons(false, get_string('form_submit', 'tool_bulk_rubric_assign'));
    }

    /**
     * Validate the form
     *
     * @param  array  $data
     * @param  array  $files
     *
     * @return array
     * @throws \coding_exception
     */
    public function validation($data, $files)
    {
        $errors = [];

        // Ensure that a course is selected
        if (empty($data['course_id'])) {
            $errors['course_id'] = get_string('error:no_course', 'tool_bulk_rubric_assign');
        }

        return $errors;
    }
}
