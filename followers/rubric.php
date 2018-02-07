<?php

    // Declaring class and its properties
    class Rubric {
        private $points;
        private $followers_count;
        private $friends_count;
        private $listed_count;
        private $favourites_count;
        private $statuses_count;
        private $created_at;
        private $influence;

        protected $criteria=array (
            array("Friends",2,0),
            array("Influence",4,0),
            array("Chirpy",4,0)
        );

        public $twubric=array (
            "Friends"=>0,
            "Influence"=>0,
            "Chirpy"=>0,
            "Total"=>0,
        );

        // Initalizing properies of the class

        function __construct ($followers_count = 0, $friends_count=0,$statuses_count=0,$influence=0,$created_at="") {
            $this->followers_count = $followers_count;
            $this->friends_count = $friends_count;
            $this->statuses_count = $statuses_count;
            $this->$influence = $influence;
            $this->created_at = $created_at;
            return $this;
        }
        // Initalizing properies of the class

        // Mathematical and logic functional for calculating Tweburic

        
        function getTwubric() {

            // Calculating Reburic for friends
            if($this->friends_count >=0 && $this->friends_count <1000)  {
                $criteria[0][2] = 10/3;
            }
            else  if($this->friends_count >=1000 && $this->friends_count <1000000) {
                $criteria[0][2] = 20/3;
            }
            else {
                $criteria[0][2] = 10;
            }

            
            // Calculating Reburic for influences
            if($this->influence >=0.0 && $this->influence<35.0) {
                $criteria[1][2]=10/3;
            }
            else if($this->influence>=35.0 && $this->influence<70.0) {
                $criteria[1][2]=20/3;
            }
            else {
                $criteria[1][2]=10;
            }

            // Calculating chirpness
            $now = new DateTime(date('Y-m-d')); // or your date as well
            $parts = explode(" ", $this->created_at );
           // echo '<pre>'; print_r($parts); echo '</pre>';
            $your_date = new DateTime(date('Y-m-d',strtotime($parts[1]." ".$parts[2]." ".$parts[6])));
            $datediff = $now->diff( $your_date);
            //echo " ".$datediff->days;
            $temp=$this->statuses_count/$datediff->days;

            if($temp>=0 && $temp<0.5) {
                $criteria[2][2]=10/3;
            }
            else if($temp>=0.5 && $temp<1) {
                $criteria[2][2]=20/3;
            }
            else {
                $criteria[2][2]=10;
            }
            // Calculating chirpness

            // Calculating final Twubric
            $a=2*$criteria[0][2]/10;
            $b=4*$criteria[1][2]/10;
            $c=4*$criteria[2][2]/10;
            $twubric['Friends']=$a;
            $twubric['Influence']=$b;
            $twubric['Chirpy']=$c;
            $twubric['Total']=$a+$b+$c;
            return $twubric;

        }
        // Mathematical functional for calculating Tweburic

    }
    
?>