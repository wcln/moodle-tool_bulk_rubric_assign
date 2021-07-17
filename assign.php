<?php

use core\output\notification;
use tool_bulk_rubric_assign\rubric_assign_controller;

require_once(__DIR__.'/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

// Calls require_login and performs permission checks for admin pages
admin_externalpage_setup('bulk_rubric_assign');

$PAGE->set_url(new moodle_url('/admin/tool/bulk_rubric_assign/assign.php'));
$PAGE->set_title(get_string('title', 'tool_bulk_rubric_assign'));
$PAGE->set_heading(get_string('heading', 'tool_bulk_rubric_assign'));

echo $OUTPUT->header();
echo $OUTPUT->heading($PAGE->heading);

$form = new \tool_bulk_rubric_assign\form\assign_form();

if ($data = $form->get_data()) {
    $updated_assignments = rubric_assign_controller::perform_update($data->match_text,
        $data->course_id, $data->template_id);
    echo $OUTPUT->notification(get_string('update_success', 'tool_bulk_rubric_assign',
        ['count' => count($updated_assignments)]), notification::NOTIFY_SUCCESS);
}

$form->display();

echo $OUTPUT->footer();
