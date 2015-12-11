<?php
/** @Entity @Table(name="Chores")
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
    /** @Column(type="date") */
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
    public function setRefreshRate($refreshRate) {
        $this->refreshRate = $refreshRate;
    }
    public function getLastCompleted() {
        return $this->lastCompleted;
    }
    public function setLastCompleted($lastCompleted) {
        $this->lastCompleted = $lastCompleted;
    }
}

