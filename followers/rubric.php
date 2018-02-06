<?php
class Rubric{
  private $points;
  private $followers_count;
  private $friends_count;
  private $listed_count;
  private $favourites_count;
  private $statuses_count;
  private $created_at;
  protected $criteria=array
  (
  array("Friends",2,0),
  array("Influence",4,0),
  array("Chirpy",4,0)
  );
  protected $scaleAttribute=array
  (
  array("High",71,100),
  array("Average",36,70),
  array("Low",0,35)
  );

  function __construct ($followers_count = 0, $friends_count=0,$statuses_count=0,$created_at="",$influence=0) {
    $this->followers_count = $followers_count;
    $this->friends_count = $friends_count;
    $this->statuses_count = $statuses_count;
    $this->created_at = $created_at;
    $criteria[1][2] = $influence;
    return $this;
}

function getTwubric(){

    if($this->friends_count >=0 && $this->friends_count <1000){
        $criteria[0][2] = $this->friends_count *35/999;
    }else  if($this->friends_count >=1000 && $this->friends_count <1000000){
        $criteria[0][2] = $this->friends_count *70/999999;
    }else{
        $criteria[0][2] = $this->friends_count *100/999999999;
    }

$now = new DateTime(date('Y-m-d')); // or your date as well
$parts = explode(" ", $this->created_at );
echo '<pre>'; print_r($parts); echo '</pre>';
$your_date = new DateTime(date('Y-m-d',strtotime($parts[1]." ".$parts[2]." ".$parts[6])));
//echo " ".$now." ".$your_date;
$datediff = $now->diff( $your_date);
//$temp= ceil(abs($datediff) / 86400);
echo " ".$datediff->days;
}


}
?>