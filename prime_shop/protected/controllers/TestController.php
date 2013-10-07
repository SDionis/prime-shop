<?php

class TestController extends Controller {
    public function actionIndex(){
        echo '1243';
    }
    
    public function actionShow(){
        //echo '124344';
        $db = Yii::app()->db;
        $id = '2r';
        echo '1234';
        //echo $db->quoteValue('r"s\'rr');
        //$sql = "SELECT * FROM tbl_user WHERE id not in (2)";
        //$command = $db->createCommand($sql);
        //$dataReader=$command->query();
       //$sql = "SELECT * FROM tbl_user WHERE id not in (3, 4)";
        //$command = $db->createCommand($sql);
        //$dataReader=$command->query();

        //$command = $db->createCommand($sql);
        //$command->bindParam(":id", $id, PDO::PARAM_INT);
        //echo $command->text;
        //echo '<pre>';
        //print_r($command);
        //echo '</pre>';
        //$row = $command->queryRow();
        //print_r($row);
        //echo $command->getText();
        echo '<pre>';
        print_r($_GET);
        echo '</pre>';
    }
    public function actionShow2(){
        echo '1234567890';
    }
}


?>