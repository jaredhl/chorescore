<?php
/** @Entity @Table(name="roommates")
 */
class Roommate {
    /** @ID @Column(type="integer") 
     *  @GeneratedValue
     */
    private $rid;
    /** @Column(type="string") */
    private $name;
    /** @Column(type="integer") */
    private $score;
    
    public function getRid() {
        return $this->rid;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getScore() {
        return $this->score;
    }
    public function setScore($score) {
        $this->score = $score;
    }
}

