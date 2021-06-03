<?php

defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $ADMIN->add('tools', new admin_externalpage('bulk_rubric_assign',
        get_string('pluginname', 'tool_bulk_rubric_assign'), "$CFG->wwwroot/$CFG->admin/tool/bulk_rubric_assign/assign.php"));

}
