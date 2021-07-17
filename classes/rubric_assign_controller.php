<?php

namespace tool_bulk_rubric_assign;

class rubric_assign_controller
{

    public static function perform_update($match_text, $course_id, $template_id)
    {
        global $DB;

        if ($assignments = $DB->get_records_select('assign',
            "name LIKE CONCAT('%', :match_text, '%') AND course = :course_id",
            ['match_text' => $match_text, 'course_id' => $course_id])
        ) {
            foreach ($assignments as $assignment) {
                /**
                 * This query gets us the grading area ID from the assignment ID:
                 * assign -> course_modules -> context -> grading_areas
                 *
                 */
                $sql                 = "
                    SELECT ga.id
                    FROM mdl_grading_areas ga
                    JOIN mdl_context ctx ON ctx.id = ga.contextid
                    JOIN mdl_course_modules cm ON cm.id = ctx.instanceid
                    JOIN mdl_assign a ON a.id = cm.`instance`
                    WHERE a.id = :assignment_id;
                ";
                $target_grading_area = $DB->get_record_sql($sql, ['assignment_id' => $assignment->id]);

                /**
                 * Thanks Moodle for making this as abstract as possible /s
                 *
                 * Don't even try to understand what is going on here, this is just copy & pasted from
                 * grade/grading/pick.php
                 */
                $targetmanager    = get_grading_manager($target_grading_area->id);
                $method           = $targetmanager->get_active_method();
                $targetcontroller = $targetmanager->get_controller($method);
                $sourceid         = $DB->get_field('grading_definitions', 'areaid', array('id' => $template_id),
                    MUST_EXIST);
                $sourcemanager    = get_grading_manager($sourceid);
                $sourcecontroller = $sourcemanager->get_controller($method);

                // This block was added as an error will be thrown if a form is already defined for the target
                if ($targetcontroller->is_form_defined()) {
                    $targetcontroller->delete_definition();
                }

                $targetcontroller->update_definition($sourcecontroller->get_definition_copy($targetcontroller));
                $definition = $sourcecontroller->get_definition();
                $DB->set_field('grading_definitions', 'timecopied', time(), array('id' => $definition->id));
            }

            return $assignments;
        }

        return [];
    }

    public static function get_rubric_templates()
    {
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
