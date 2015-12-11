<?php
/** @Entity @Table(name="chores")
 */
class Chore {
    /** @Id @Column(type="integer") 
     *  @GeneratedValue
     */
    private $cid;
    /** @Column(type="string") */
    private $name;
    /** @Column(type="integer") */
    private $baseValue;
    /** @Column(type="integer") */
    private $refreshRate;
    /** @Column(type="integer") */
    private $lastCompleted;
    
    public function getCid() {
        return $this->cid;
    }
    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
    }
    public function getBaseValue() {
        return $this->baseValue;
    }
    public function setBaseValue($baseValue) {
        $this->baseValue = $baseValue;
    }
    public function getRefreshRate() {
        return $this->refreshRate;
    }
    public function setBaseValue($baseValue) {
        $this->baseValue = $baseValue;
    }
    public function getLastCompleted() {
        return $this->lastCompleted;
    }
    public function setBaseValue($lastCompleted) {
        $this->lastCompleted = $lastCompleted;
    }
}

