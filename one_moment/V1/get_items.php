<?php

include "dao.php";


if (isset($_GET['data'])) {

    $dados = $_GET['data'];

    $result = json_decode($dados);
    $filterData = "";
    $orderData = "";
    $firstTime = true;
    $firstTimeOrder = true;
    
    
	if($result->isOrderByAddDate){
		$orderData = "ORDER BY add_date DESC";
	}

    if ($result->isFilterByType) {
        $filterData = " WHERE type = '" . $result->type . "'";
        $firstTime = false;
    }

    if ($result->isFilterByLatLong) {
        if ($firstTime) {
            $filterData = " WHERE latitude < (" . ($result->latitude + $result->precision) . ") AND latitude > (" . ($result->latitude - $result->precision) . ") AND longitude < (" . ($result->longitude + $result->precision) . ") AND longitude > (" . ($result->longitude - $result->precision) . ")  ";
            $firstTime = false;
        } else {
            $filterData = $filterData . " AND latitude < (" . ($result->latitude + $result->precision) . ") AND latitude > (" . ($result->latitude - $result->precision) . ") AND longitude < (" . ($result->longitude + $result->precision) . ") AND longitude > (" . ($result->longitude - $result->precision) . ")  ";
        }
    }

    if ($result->isFilterByTitle) {
        if ($firstTime) {
            $filterData = " WHERE title like '%" . $result->title . "%'";
            $firstTime = false;
        } else {
            $filterData = $filterData . " and title like '%" . $result->title . "%'";
        }
    }

    if ($result->isFilterByRangeId) {
        if ($firstTime) {
            $filterData = " WHERE id > " . $result->minId . "";
            $firstTime = false;
        } else {
            $filterData = $filterData . " and id > " . $result->minId . "";
        }
    }

    if ($result->isFilterByDate) {
        $dateMin = new DateTime();
        $dateMin->modify('-' . $result->date_param . ' hours');

        $dateMax = new DateTime();
        $dateMax->modify('+' . $result->date_param . ' hours');


        $dateMin = $dateMin->format('Y-m-d H:i:s');
        $dateMax = $dateMax->format('Y-m-d H:i:s');

        if ($firstTime) {
            $filterData = " WHERE add_date < '" . $dateMax . "' and add_date > '" . $dateMin . "'";
            $firstTime = false;
        } else {
            $filterData = $filterData . " AND add_date < '" . $dateMax . "' and add_date > '" . $dateMin . "'";
        }
    }

    if ($result->isFilterByMinDate) {
        if ($firstTime) {
            $filterData = " WHERE add_date > '" . $result->min_date . "'";
            $firstTime = false;
        } else {
            $filterData = $filterData . " AND add_date > '" . $result->min_date . "'";
        }
    }

    if ($result->isFilterByDescription) {
        if ($firstTime) {
            $filterData = " WHERE description like '%" . $result->description . "%'";
            $firstTime = false;
        } else {
            $filterData = $filterData . " and description like '%" . $result->description . "%'";
        }
    }

    if ($result->isFilterByLostOrFoundPlace) {
        if ($firstTime) {
            $filterData = " WHERE lost_or_found_place like '%" . $result->lost_or_found_place . "%'";
            $firstTime = false;
        } else {
            $filterData = $filterData . " and lost_or_found_place like '%" . $result->lost_or_found_place . "%'";
        }
    }

     if ($result->isFilterByKeywords) {
        $i = 0;
        $where = '(';
        $array = explode(';', $result->keywords);
        while ($i < sizeof($array)) {
          //  if ($i == (sizeof($array) - 1)) {
                $where = $where . " keywords like '%" . $array[$i] . "%' OR title like '%" . $array[$i] . "%'" 
                        . " OR description like '%" . $array[$i] . "%'" . " OR lost_or_found_place like '%" . $array[$i] . "%'"
						. " OR contact like '%" . $array[$i] . "%'" . " OR found_place like '%" . $array[$i] . "%'";
          //  } else {
                 
         //   }
            $i = $i + 1;
        }
        $where = $where . ')';
       

        if ($firstTime) {
            $filterData = " WHERE " . $where . "";
            $firstTime = false;
        } else {
            $filterData = $filterData . " and " . $where . "";
        }
    }
    
    if ($result->isFilterByUserId) {
        if ($firstTime) {
            $filterData = " WHERE id_user = " . $result->id_user . "";
            $firstTime = false;
        } else {
            $filterData = $filterData . " and id_user = " . $result->id_user . "";
        }
    }

    if ($result->found) {
        $result->found = 1;
    } else {
        $result->found = 0;
    }

    if ($firstTime) {
        $filterData = " WHERE active = 1 and found = " . $result->found;
    } else {
        $filterData = $filterData . " and active = 1 and found = " . $result->found;
    }

    $query = "SELECT * FROM item " . $filterData . " " . $orderData . " LIMIT " . $result->minPar . "," . $result->maxPar . "";
	
    $position = 0;
    $resultado = executarQuery($query);
    //echo $query;

    $array = array();
    $i = 0;
    while ($array_linha = mysqli_fetch_array($resultado)) {
        $item = new item;
        $item->setId($array_linha['id']);
        $item->setId_user($array_linha['id_user']);
        $item->setAdd_date($array_linha['add_date']);
        $item->setType($array_linha['type']);
        $item->setImg_src($array_linha['img_src']);
        $item->setKeywords($array_linha['keywords']);
        $item->setTitle($array_linha['title']);
        $item->setDescription($array_linha['description']);
        $item->setLost_or_found_place($array_linha['lost_or_found_place']);
        $item->setLatitude($array_linha['latitude']);
        $item->setLongitude($array_linha['longitude']);
        $item->setContact($array_linha['contact']);
        $item->setFound($array_linha['found']);
        $item->setFound_place($array_linha['found_place']);
        $item->setFound_date($array_linha['found_date']);

        $array[$i] = $item;
        $i = $i + 1;
    }

    echo json_encode($array);
}

class item {

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

}

?>
