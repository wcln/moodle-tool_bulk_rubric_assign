<?php

require_once(__DIR__ . '/../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

// Calls require_login and performs permission checks for admin pages
admin_externalpage_setup('bulk_rubric_assign');

$PAGE->set_url(new moodle_url('/admin/tool/bulk_rubric_assign/assign.php'));
$PAGE->set_title(get_string('title', 'tool_bulk_rubric_assign'));
$PAGE->set_heading(get_string('heading', 'tool_bulk_rubric_assign'));

echo $OUTPUT->header();
echo $OUTPUT->heading($PAGE->heading);

$form = new \tool_bulk_rubric_assign\form\assign_form();
$form->display();

echo $OUTPUT->footer();
