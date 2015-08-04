<?php

include "dao.php";

$answer = new answer;


$answer->setIsUpdated(false);

if (isset($_POST['data'])) {
    $dados = $_POST['data'];
    $data = json_decode($dados);
        $query = "UPDATE item SET type = '".$data->type."', title = '".$data->title."', description = '".$data->description."',"
                . "description = '".$data->description."', latitude = '".$data->latitude."',"
                . "longitude = '".$data->longitude."', contact = '".$data->contact."'   WHERE id = ".$data->id;
        $resultado = executarQuery($query);
        if ($resultado) {
            $answer->setIsUpdated(true);
        }

    echo json_encode($answer);
}

class answer {
    public $isUpdated;
    
    public function getIsUpdated() {
        return $this->isUpdated;
    }

    public function setIsUpdated($isUpdated) {
        $this->isUpdated = $isUpdated;
    }


}

?>
