<?php
/** @Entity @Table(name="Completed")
 */
class Completed {
    /** @Id @Column(type="integer")
    * @GeneratedValue
    */
    private $cid;
    /** @Column(type="integer") */
    private $rid;
    /** @Column(type="date") */
    private $date;
    /** @Column(type="integer") */
    private $finalValue;
    
    public function getCid() {
        return $this->cid;
    }
    /*public function setCid($cid){
        $this->cid = $cid;
    }*/
    public function getRid() {
        return $this->rid;
    }
    public function setRid($rid) {
        $this->rid = $rid;
    }
    public function getDate() {
        return $this->date;
    }
     public function setDate($date) {
        $this->date = $date;
    }
    public function getFinalValue() {
        return $this->finalValue;
    }
    /*public function setFinalValue($finalValue) {
        $this->finalValue = $finalValue;
    }*/
    public function setFinalValue($finalValue) {
        $this->finalValue = $finalValue;
    }
}

