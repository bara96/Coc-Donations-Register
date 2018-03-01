<?php
/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 22/02/2018
 * Time: 16:21
 */

class ClanRecord
{
    private $tagClan,
            $name,
            $active;

    /**
     * ClansRecorded constructor.
     */
    public function __construct()
    {
    }

    /**
     * return a new instance of object ClansRecorded
     * @param string $tagClan
     * @param string $name
     * @param int $active
     * @return ClanRecord
     */
    public static function newInstance($tagClan, $name, $active){
        $log = new ClanRecord();
        $log->setTagClan($tagClan);
        $log->setName($name);
        $log->setActive($active);
        return $log;
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
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }




}