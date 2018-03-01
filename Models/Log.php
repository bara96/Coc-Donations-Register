<?php

/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 09/09/2017
 * Time: 03:14
 */
class Log
{
    private
        $name,
        $donations,
        $date,
        $id,
        $tag,
        $tagClan;

    /**
     * return a new instance of object Log
     * @param int $donations
     * @param int $id
     * @param string $name
     * @param string $date
     * @param string $tag
     * @param string $tagClan
     * @return Log
     */
    public static function newInstance($donations, $id, $name, $date, $tag, $tagClan){
        $log = new Log();
        $log->setName($name);
        $log->setDonations($donations);
        $log->setDate($date);
        $log->setId($id);
        $log->setTag($tag);
        $log->setTagClan($tagClan);
        return $log;
    }

    /**
 * @return mixed
 */
    public function getName()
    {
        return $this->name;
    }/**
 * @param mixed $name
 */
    public function setName($name)
    {
        $this->name = $name;
    }/**
 * @return mixed
 */
    public function getDonations()
    {
        return $this->donations;
    }/**
 * @param mixed $donations
 */
    public function setDonations($donations)
    {
        $this->donations = $donations;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param mixed $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return mixed
     */
    public function getTagClan()
    {
        return $this->tagClan;
    }

    /**
     * @param mixed $tagClan
     */
    public function setTagClan($tagClan)
    {
        $this->tagClan = $tagClan;
    }

    /**
     * return a json string of object fields
     * @return string
     */
    public function getJSON(){
        return '{"tag":"'.$this->getTag().'","name":"'.$this->getName().'","donations":"'.$this->getDonations().'", 
        "date":"'.$this->getDate().'","id":"'.$this->getId().',"tagClan":"'.$this->getTagClan().'"}' ;
    }



}