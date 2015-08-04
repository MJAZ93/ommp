<?php

include "dao.php";

$answer = new answer;

$answer->setIsAdded(false);



if(isset($_POST['action']) && isset($_POST['data'])){
    $action = $_POST['action'];
    if($action==='add') {
        $dados = $_POST['data'];
        $data = json_decode($dados);

        $query = "INSERT INTO `one_moment`.`user` (`id`, `number`, `name`, `id_image`, `date_create`, `country`, `fb_id`, `twitter_id`, `intagram_id`)
        VALUES (NULL, '$data->number', '$data->name', '$data->id_image', 'now()', $data->country, $data->fb_id, $data->twitter_id, $data->intagram_id)";

        $resultado = executarQuery($query);
        if ($resultado) {
            $answer->isAdded = true;
        }
    }
}

if (isset($_POST['data'])) {

    $dados = $_POST['data'];
    $data = json_decode($dados);

        $query = "INSERT INTO  `item` (`id` ,`id_user` ,`add_date` ,`img_src` ,`type` ,`title` ,`keywords` , `description` ,`lost_or_found_place` ,
`latitude` ,
`longitude` ,
`contact` ,
`found` ,
`found_place` ,
`found_date` ,
`active`
)
VALUES (
NULL ,  '".$data->id_user."','".$data->add_date."',  '".$data->img_src."',  '".$data->type."',  '".$data->title."',  '".$data->keywords."', '".$data->description."' , 
    '".$data->lost_or_found_place."' ,  '".$data->latitude."',  '".$data->longitude."',  '".$data->contact."',  0,  
        '', now(),  '1'
)";
        $resultado = executarQuery($query);
        if ($resultado) {
            $answer->setIsAdded(true);
            $query = "SELECT * FROM item ORDER BY id DESC LIMIT 0 , 1";
            $resultado = executarQuery($query);
             if ($array_linha = mysqli_fetch_array($resultado)) {
                $answer->setId($array_linha['id']);
				$answer->setId_user($array_linha['id_user']);
				$answer->setAdd_date($array_linha['add_date']);
				$answer->setType($array_linha['type']);
				$answer->setImg_src($array_linha['img_src']);
				$answer->setKeywords($array_linha['keywords']);
				$answer->setTitle($array_linha['title']);
				$answer->setDescription($array_linha['description']);
				$answer->setLost_or_found_place($array_linha['lost_or_found_place']);
				$answer->setLatitude($array_linha['latitude']);
				$answer->setLongitude($array_linha['longitude']);
				$answer->setContact($array_linha['contact']);
				$answer->setFound($array_linha['found']);
				$answer->setFound_place($array_linha['found_place']);
				$answer->setFound_date($array_linha['found_date']);
            } 
        }
        
    echo json_encode($answer);
}

class answer {

    public $isAdded;
	public $id;
    public $id_user;
    public $add_date;
    public $img_src;
    public $type;
    public $title;
    public $keywords;
    public $description;
    public $lost_or_found_place;
    public $latitude;
    public $longitude;
    public $contact;
    public $found;
    public $found_place;
    public $found_date;
    
    public function getId() {
        return $this->id;
    }

    public function getId_user() {
        return $this->id_user;
    }

    public function getAdd_date() {
        return $this->add_date;
    }

    public function getImg_src() {
        return $this->img_src;
    }

    public function getType() {
        return $this->type;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getKeywords() {
        return $this->keywords;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getLost_or_found_place() {
        return $this->lost_or_found_place;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getContact() {
        return $this->contact;
    }

    public function getFound() {
        return $this->found;
    }

    public function getFound_place() {
        return $this->found_place;
    }

    public function getFound_date() {
        return $this->found_date;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setId_user($id_user) {
        $this->id_user = $id_user;
    }

    public function setAdd_date($add_date) {
        $this->add_date = $add_date;
    }

    public function setImg_src($img_src) {
        $this->img_src = $img_src;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setKeywords($keywords) {
        $this->keywords = $keywords;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setLost_or_found_place($lost_or_found_place) {
        $this->lost_or_found_place = $lost_or_found_place;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }

    public function setFound($found) {
        $this->found = $found;
    }

    public function setFound_place($found_place) {
        $this->found_place = $found_place;
    }

    public function setFound_date($found_date) {
        $this->found_date = $found_date;
    }

            
    public function setIsAdded($isAdded) {
        $this->isAdded = $isAdded;
    }

    public function setIsExists($isExists) {
        $this->isExists = $isExists;
    }
}

?>
