<?php
namespace TheLooper\Controller;


use TheLooper\Model\Exercise;
use TheLooper\Model\FieldValueKind;


class mainController
{
    private ExerciseController $exerciseController;
    private FieldController $fieldController;
    private AnswerController $answerController;
    private TakeController $takeController;

    public function __construct()
    {
        $this->exerciseController = new ExerciseController();
        $this->fieldController = new FieldController();
        $this->answerController = new AnswerController();
        $this->takeController = new TakeController();
    }


    public function showCreateField(){
        $this->exerciseController->create($_POST['exercise']['title']);
        include_once "View/CreateFields.php";
    }

    public function showCreateExercise(){
        include_once "View/CreateExercise.php";
    }

    public function showAllExercises(){
        $exercises = $this->exerciseController->showAll();
        include_once "View/TakeExercise.php";
    }

    public function showManageExercise(){
        $exercises = $this->exerciseController->showAll();
        include_once "View/ManageExercise.php";
    }

    public function showStatExercise(){
        $exercise = $this->exerciseController->find($_GET['id']);
        $fields = $exercise->fields();

        include_once "View/StatExercise.php";
    }

    public function showHome(){
        include_once "View/Home.php";
    }

    public function showExercise()
    {
        if(isset($_GET["id"])){
            $exercise = Exercise::find($_GET['id']);
            $fields = $exercise->fields();

            include_once "View/FulfillExercise.php";
        }else{
            header("Location:?action=showAllExercises");
        }


    }



}