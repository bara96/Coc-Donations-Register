<?php

/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 09/09/2017
 * Time: 02:32
 */
class Record
{
    private
        $tag,
        $name,
        $donations,
        $received,
        $tagClan;

    /**
     * return a new instance of object Records
     * @param string $tag
     * @param string $nome
     * @param int $donations
     * @param int $received
     * @param string $tagClan
     * @return Record
     */
    public static function newInstance($tag, $nome, $donations, $received, $tagClan){
        $rec = new Record();
        $rec->setTag($tag);
        $rec->setName($nome);
        $rec->setDonations($donations);
        $rec->setReceived($received);
        $rec->setTagClan($tagClan);
        return $rec;
    }

 /**
 * @return mixed
 */
public function getTag()
{
    return $this->tag;
}/**
 * @param mixed $tag
 */
public function setTag($tag)
{
    $this->tag = $tag;
}/**
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
}/**
 * @return mixed
 */
public function getReceived()
{
    return $this->received;
}/**
 * @param mixed $received
 */
public function setReceived($received)
{
    $this->received = $received;
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
        return '{"tag":"'.$this->getTag().'" , "name":"'.$this->getName().'" , "donations":"'.$this->getDonations().'", 
        "received":"'.$this->getReceived().',"tagClan":"'.$this->getTagClan().'"}' ;
    }

}