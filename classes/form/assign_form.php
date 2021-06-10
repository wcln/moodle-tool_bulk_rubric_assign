<?php

namespace tool_bulk_rubric_assign\form;

use html_writer;
use moodleform;

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
        $mform->addElement('text', 'title', get_string('titlematch', 'tool_bulk_rubric_assign'));
        $mform->setType('title', PARAM_TEXT);
        $mform->addRule('title', 'required', 'required');

        // Course select
        $mform->addElement('autocomplete', 'course', get_string('course'),
            [0 => get_string('none')] + $DB->get_records_menu('course', ['visible' => 1], 'fullname ASC',
                'id,fullname'));
        $mform->setType('course', PARAM_INT);
        $mform->addRule('course', 'required', 'required');

        // Rubric template select
        $mform->addElement('select', 'template', get_string('rubric', 'tool_bulk_rubric_assign'),
            [1 => 'Example template']);
        $mform->setType('template', PARAM_INT);
        $mform->addRule('template', 'required', 'required');


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
        if (empty($data['course'])) {
            $errors['course'] = get_string('error:no_course', 'tool_bulk_rubric_assign');
        }

        return $errors;
    }
}
