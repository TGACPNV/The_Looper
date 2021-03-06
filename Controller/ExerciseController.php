<?php

namespace TheLooper\Controller;

use TheLooper\Model\Answer;
use TheLooper\Model\Exercise;
use TheLooper\Model\ExerciseState;
use TheLooper\Model\Field;
use TheLooper\Model\Take;

class ExerciseController
{

    public function __construct()
    {

    }

    /**
     * @description Display view to create an exercise
     */
    public static function showCreateExercise()
    {
        ob_start();
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        include_once "View/CreateExercise.php";
        $headerPath = "Components/Header/Managing.php";
        $contenu = ob_get_clean();

        require dirname(__DIR__, 1) . "/View/Layout.php";
    }

    /**
     * @description Display view to list all exercises in Answering
     */
    public static function showAllExercises()
    {
        ob_start();
        $exercises = Exercise::all();
        include_once "View/TakeExercise.php";
        $headerPath = "Components/Header/Answering.php";
        $contenu = ob_get_clean();

        require dirname(__DIR__, 1) . "/View/Layout.php";
    }

    /**
     * @description Display view to list all exercises by state
     */
    public static function showManageExercise()
    {
        ob_start();
        $exercises = Exercise::all();
        include_once "View/ManageExercise.php";
        $headerPath = "Components/Header/Results.php";
        $contenu = ob_get_clean();

        require dirname(__DIR__, 1) . "/View/Layout.php";
    }

    /**
     * @description Display view to list stats of an exercise
     */
    public static function showStatExercise()
    {
        ob_start();
        $exercise = Exercise::find($_GET['id']);
        $fields = $exercise->fields();

        include_once "View/StatExercise.php";
        $headerPath = "Components/Header/Results.php";
        $contenu = ob_get_clean();

        require dirname(__DIR__, 1) . "/View/Layout.php";
    }

    /**
     * @description Display view to list stats by a field of an exercise
     */
    public static function showStatExerciseByField()
    {
        ob_start();
        $field = Field::find($_GET['field']);
        $exercise = Exercise::find($field->exercises_id);
        include_once "View/StatExerciseByField.php";
        $headerPath = "Components/Header/Results.php";
        $contenu = ob_get_clean();

        require dirname(__DIR__, 1) . "/View/Layout.php";
    }

    /**
     * @description Display view to list stats by a take of an exercise
     */
    public static function showStatExerciseByTake()
    {
        ob_start();
        $take = Take::find($_GET['take']);
        $exercise = Exercise::find(Field::find($take->answers()[0]->field->getId())->exercises_id);
        include_once "View/StatExerciseByTake.php";
        $headerPath = "Components/Header/Results.php";
        $contenu = ob_get_clean();

        require dirname(__DIR__, 1) . "/View/Layout.php";
    }

    /**
     * @description Display view to fill fields for an exercise
     */
    public static function showExercise()
    {
        ob_start();

        if (isset($_GET["id"])) {
            $exercise = Exercise::find($_GET['id']);
            $fields = $exercise->fields();

            if (isset($_SESSION['submitSuccess'])) {
                $submitSuccess = $_SESSION['submitSuccess'];
                unset($_SESSION['submitSuccess']);
            }

            include_once "View/FulfillExercise.php";
        } else {
            header("Location:?action=showAllExercises");
        }
        $headerPath = "Components/Header/Answering.php";
        $contenu = ob_get_clean();

        require dirname(__DIR__, 1) . "/View/Layout.php";
    }

    /**
     * @description Change state building to answering
     */
    public static function answering()
    {
        // can not understand what it's doing without going to it's code and the code that use it
        $exercise = Exercise::find($_GET['id']);
        $exercise->state = ExerciseState::ANSWERING;
        $exercise->save();
        ExerciseController::showManageExercise();
    }

    /**
     * @description Change state answering to closed
     */
    public static function closed()
    {
        $exercise = Exercise::find($_GET['id']);
        $exercise->state = ExerciseState::CLOSED;
        $exercise->save();
        ExerciseController::showManageExercise();
    }

    /**
     * @description Delete an exercise
     */
    public static function deleteExercise()
    {
        $exercise = Exercise::find($_GET['id']);
        foreach ($exercise->fields() as $field) {
            foreach ($field->takes() as $take) {
                foreach ($take->answers() as $answer) {
                    $answer->delete();
                }
                $take->delete();
            }
            $field->delete();
        }

        $exercise->delete();
        header('Location: ?action=showManageExercise');
    }

    /**
     * @description Add answers for an exercise
     */
    public static function fulfill()
    {
        $take = new Take();
        $take->create();
        $fulfillments = $_POST["fulfillments"];
        $submitSuccess = true;

        foreach ($fulfillments as $id => $fulfillment) {
            $answer = new Answer();
            $answer->field = Field::find($id);
            $answer->take = Take::find($take->id);
            $answer->response = $fulfillment;
            if (!$answer->create()) $submitSuccess = false;
        }
        $_SESSION['submitSuccess'] = $submitSuccess;

        if ($submitSuccess) {
            header('Location: ?action=showEditFulfillment&id=' . $take->id);
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

    }
}