<?php

/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 21/12/2017
 * Time: 23:12
 */
class Player
{
    private $tag,
            $name,
            $badge_url,
            $th,
            $trophies,
            $stars_war,
            $attacks_won,
            $defense_won,
            $donations,
            $donations_received,
            $xp,
            $inactive_result,
            $role,
            $tagClan,
            $nameClan;

    /**
     * Player constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $tag
     * @param string $name
     * @param string $badge_url
     * @param int $th
     * @param int $trophies
     * @param int $stars_war
     * @param int $attacks_won
     * @param int $defense_won
     * @param int $donations
     * @param int $donations_received
     * @param int $xp
     * @param float $inactive_result
     * @param string $role
     * @param string $clanTag
     * @param string $clanName
     * @return Player
     */
    public static function newInstance($tag, $name, $badge_url, $th, $trophies, $stars_war, $attacks_won, $defense_won, $donations, $donations_received, $xp, $inactive_result, $role, $clanTag, $clanName)
    {
        $p = new Player();
        $p->setTag($tag);
        $p->setName($name);
        $p->setBadgeUrl($badge_url);
        $p->setTh($th);
        $p->setTrophies($trophies);
        $p->setStarsWar($stars_war);
        $p->setAttackswon($attacks_won);
        $p->setDefensewon($defense_won);
        $p->setDonations($donations);
        $p->setDonationsreceived($donations_received);
        $p->setXp($xp);
        $p->setInactiveResult($inactive_result);
        $p->setRole($role);
        $p->setTagClan($clanTag);
        $p->setNameClan($clanName);
        return $p;
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

    /**
     * @return mixed
     */
    public function getBadgeUrl()
    {
        return $this->badge_url;
    }

    /**
     * @param mixed $badge_url
     */
    public function setBadgeUrl($badge_url)
    {
        $this->badge_url = $badge_url;
    }

    /**
     * @return mixed
     */
    public function getTh()
    {
        return $this->th;
    }

    /**
     * @param mixed $th
     */
    public function setTh($th)
    {
        $this->th = $th;
    }

    /**
     * @return mixed
     */
    public function getTrophies()
    {
        return $this->trophies;
    }

    /**
     * @param mixed $trophies
     */
    public function setTrophies($trophies)
    {
        $this->trophies = $trophies;
    }

    /**
     * @return mixed
     */
    public function getStarsWar()
    {
        return $this->stars_war;
    }

    /**
     * @param mixed $stars_war
     */
    public function setStarsWar($stars_war)
    {
        $this->stars_war = $stars_war;
    }

    /**
     * @return mixed
     */
    public function getAttackswon()
    {
        return $this->attacks_won;
    }

    /**
     * @param mixed $attacks_won
     */
    public function setAttackswon($attacks_won)
    {
        $this->attacks_won = $attacks_won;
    }

    /**
     * @return mixed
     */
    public function getDefensewon()
    {
        return $this->defense_won;
    }

    /**
     * @param mixed $defense_won
     */
    public function setDefensewon($defense_won)
    {
        $this->defense_won = $defense_won;
    }

    /**
     * @return mixed
     */
    public function getDonations()
    {
        return $this->donations;
    }

    /**
     * @param mixed $donations
     */
    public function setDonations($donations)
    {
        $this->donations = $donations;
    }

    /**
     * @return mixed
     */
    public function getDonationsreceived()
    {
        return $this->donations_received;
    }

    /**
     * @param mixed $donations_received
     */
    public function setDonationsreceived($donations_received)
    {
        $this->donations_received = $donations_received;
    }

    /**
     * @return mixed
     */
    public function getXp()
    {
        return $this->xp;
    }

    /**
     * @param mixed $xp
     */
    public function setXp($xp)
    {
        $this->xp = $xp;
    }

    /**
     * @return mixed
     */
    public function getInactiveResult()
    {
        return $this->inactive_result;
    }

    /**
     * @param mixed $inactive_result
     */
    public function setInactiveResult($inactive_result)
    {
        $this->inactive_result = $inactive_result;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
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
    public function getNameClan()
    {
        return $this->nameClan;
    }

    /**
     * @param mixed $nameClan
     */
    public function setNameClan($nameClan)
    {
        $this->nameClan = $nameClan;
    }

    /**
     * return a json string of object fields
     * @return string
     */
    public function getJSON(){
        return '{"tag":"'.$this->getTag().'","name":"'.$this->getName().'","badge_url":"'.$this->getBadgeUrl().'", 
        "th":"'.$this->getTh().'","trophies":"'.$this->getTrophies().'","stars_war":"'.$this->getStarsWar().'","attacks_won":"'.$this->getAttackswon().'","defense_won":"'.$this->getDefensewon().'",
        "donations":"'.$this->getDonations().'","donations_received":"'.$this->getDonationsreceived().'","xp":"'.$this->getXp().'","inactive_result":"'.$this->getInactiveResult().'",
        "role":"'.$this->getRole().'","clanTag":"'.$this->getTagClan().'","clanName":"'.$this->getNameClan().'"}' ;
    }

}