<?php

namespace tool_bulk_rubric_assign;

class rubric_assign_controller
{

    public static function perform_update($match_text, $course_id, $rubric_id) {
        // TODO
    }

    public static function get_rubric_templates() {
        global $DB;

        $sql = "
            SELECT
                DISTINCT gd.id,
                gd.name
            FROM
                {grading_definitions} gd
            JOIN {grading_areas} ga ON
                (gd.areaid = ga.id)
            JOIN {context} cx ON
                (ga.contextid = cx.id)
            LEFT JOIN {gradingform_rubric_criteria} rc ON
                (rc.definitionid = gd.id)
            LEFT JOIN {gradingform_rubric_levels} rl ON
                (rl.criterionid = rc.id)
            WHERE
                gd.method = 'rubric'
                AND ga.contextid = 1
                AND ga.component = 'core_grading'
            ORDER BY
                gd.name
        ";

        return $DB->get_records_sql_menu($sql);
    }

}
