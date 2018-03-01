<?php

/**
 * Created by PhpStorm.
 * User: matteo
 * Date: 21/07/2016
 * Time: 17:44
 */
require_once ("DbConnection.php");
require_once ("Record.php");
require_once ("Log.php");
require_once ("ClanRecord.php");
require_once ("Constants.php");

class DAO
{

    /**
     * return false if tag isn't stored it, else return true
     * @param $tag
     * @return bool|Exception
     * @throws Exception
     */
    public static function hasClansRecorded($tag){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT * FROM tableTagClans WHERE tag=:tag";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = ClanRecord::newInstance($row[0],$row[1],$row[2]);
            }
            return count($list)>0;
        } catch(Exception $e) {
            return $e;
        }
    }

    /**
     * return a clan tag stored filtering by a tag
     * @param $tag
     * @return ClanRecord|Exception|null
     * @throws Exception
     */
    public static function getClanRecordByTag($tag){
        $connection = DbConnection::getConnection();
        $list = null;
        $sql = "SELECT * FROM tableTagClans WHERE tag=:tag";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list = ClanRecord::newInstance($row[0],$row[1],$row[2]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return all ClansRecord stored
     * @return array|Exception
     * @throws Exception
     */
    public static function getClansRecord(){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT * FROM tableTagClans";
        $q = $connection->prepare($sql);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = ClanRecord::newInstance($row[0],$row[1],$row[2]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * insert a new ClanRecord
     * @param string $tag
     * @param string $name
     * @return int
     * @throws Exception
     */
    public static function insertClanRecord($tag, $name){
        $connection = DbConnection::getConnection();
        $sql = "INSERT INTO tableTagClans(tag,clanName) VALUES(:tag,:name)";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":name", $name);
        try {
            $res = $q->execute();
            if($res) {
                return Constants::SUCCESS;
            } else {
                return Constants::ERROR;
            }
        } catch(Exception $e) {
            return Constants::ERROR;
        }
    }

    /**
     * insert a new Record initialized with troops donated
     * @param string $tag
     * @param string $name
     * @param int $donations
     * @param string $tagClan
     * @return int
     * @throws Exception
     */
    public static function insertRecordDonated($tag, $name, $donations, $tagClan){
        $connection = DbConnection::getConnection();
        $sql = "INSERT INTO tableRecords(tag,playerName,donations,tagClan) VALUES(:tag,:name,:donations,:tagClan)";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":name", $name);
        $q->bindParam(":donations", $donations);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            if($res) {
                return Constants::SUCCESS;
            } else {
                return Constants::ERROR;
            }
        } catch(Exception $e) {
            return Constants::ERROR;
        }
    }

    /**
     * insert a new Record initialized with troops received
     * @param string $tag
     * @param string $name
     * @param int $donations
     * @param string $tagClan
     * @return int
     * @throws Exception
     */
    public static function insertRecordReceived($tag, $name, $donations, $tagClan){
        $connection = DbConnection::getConnection();
        $sql = "INSERT INTO tableRecords(tag,playerName,ricevute,tagClan) VALUES(:tag,:name,:donations,:tagClan)";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":name", $name);
        $q->bindParam(":ricevute", $donations);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            if($res) {
                return Constants::SUCCESS;
            } else {
                return Constants::ERROR;
            }
        } catch(Exception $e) {
            return Constants::ERROR;
        }
    }

    /**
     * return all Records stored filtering by tagPlayer and tagClan
     * @param string $tagPlayer
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function checkRecordbyTag($tagPlayer, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT * FROM tableRecords WHERE (tag=:tag AND tagClan=:tagClan)";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tagPlayer);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Record::newInstance($row[0],$row[1],$row[2],$row[3],$row[4]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * update troops donated of a Record
     * @param string $tag
     * @param string $name
     * @param int $donations
     * @param string $tagClan
     * @return Exception|int
     * @throws Exception
     */
    public static function updateRecordDonated($tag, $name, $donations, $tagClan){
        $connection = DbConnection::getConnection();
        $sql = "UPDATE tableRecords SET playerName=:name, donations=:donations WHERE tag=:tag AND tagClan=:tagClan";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":name", $name);
        $q->bindParam(":donations", $donations);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            if($res) {
                return Constants::SUCCESS;
            } else {
                return Constants::ERROR;
            }
        } catch(Exception $e) {
            return $e;
        }
    }

    /**
     * update troops received of a Record
     * @param string $tag
     * @param string $name
     * @param int $donations
     * @param string $tagClan
     * @return Exception|int
     * @throws Exception
     */
    public static function updateRecordReceived($tag, $name, $donations, $tagClan){
        $connection = DbConnection::getConnection();
        $sql = "UPDATE tableRecords SET playerName=:name, ricevute=:ricevute WHERE tag=:tag AND tagClan=:tagClan";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":name", $name);
        $q->bindParam(":ricevute", $donations);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            if($res) {
                return Constants::SUCCESS;
            } else {
                return Constants::ERROR;
            }
        } catch(Exception $e) {
            return $e;
        }
    }

    /**
     * return a Record filtering by player name and tagClan
     * @param string $name
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function searchMember($name, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT * FROM tableRecords WHERE playerName LIKE :name AND tagClan=:tagClan ORDER BY playerName";
        $q = $connection->prepare($sql);
        $name = "%$name%";
        $q->bindParam(":name", $name);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Record::newInstance($row[0],$row[1],$row[2],$row[3],$row[4]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return all Records filtering by tagClan, sorting by name
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getRecords($tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT * FROM tableRecords WHERE tagClan=:tagClan ORDER BY playerName";
        $q = $connection->prepare($sql);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Record::newInstance($row[0],$row[1],$row[2],$row[3],$row[4]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return all Logs of troops donated, filtering by tagClan
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getLogsDonated($tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT * FROM tableLogs WHERE tagClan=:tagClan ORDER BY id DESC LIMIT 100";
        $q = $connection->prepare($sql);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return all Logs of troops received, filtering by tagClan
     * @param $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getLogsReceived($tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT * FROM received WHERE tagClan=:tagClan ORDER BY id DESC LIMIT 100";
        $q = $connection->prepare($sql);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return all Logs of troops donated to a player between $date, $dateSub, $dateAdd. filtering by tagClan
     * @param string $date
     * @param string $dateSub
     * @param string $dateAdd
     * @param string $tag
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getSuggestsBetween($date, $dateSub, $dateAdd, $tag, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT *  FROM tableLogs WHERE ((logDate LIKE :logDate OR logDate LIKE :logDateSub OR logDate LIKE :logDateAdd) AND tag<>:tag AND tagClan=:tagClan) ORDER BY id DESC LIMIT 100";
        $date="%$date%";
        $dateSub="%$dateSub%";
        $dateAdd="%$dateAdd%";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":logDate", $date);
        $q->bindParam(":logDateSub", $dateSub);
        $q->bindParam(":logDateAdd", $dateAdd);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return all Logs of troops donated to a player between on date $date. filtering by tagClan
     * @param string $date
     * @param string $tag
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getSuggests($date, $tag, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT *  FROM tableLogs WHERE ((logDate LIKE :logDate) AND tag<>:tag AND tagClan=:tagClan) ORDER BY id DESC LIMIT 100";
        $date="%$date%";
        $q = $connection->prepare($sql);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":logDate", $date);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * insert a new Log of troops donated
     * @param string $name
     * @param int $donations
     * @param string $date
     * @param string $tag
     * @param string $tagClan
     * @return int
     * @throws Exception
     */
    public static function insertLogDonated($name, $donations, $date, $tag, $tagClan){
        $connection = DbConnection::getConnection();
        $sql = "INSERT INTO tableLogs (playerName,donations,logDate,tag,tagClan) VALUES(:name,:donations,:logDate, :tag, :tagClan)";
        $q = $connection->prepare($sql);
        $q->bindParam(":name", $name);
        $q->bindParam(":donations", $donations);
        $q->bindParam(":logDate", $date);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            if($res) {
                return Constants::SUCCESS;
            } else {
                return Constants::ERROR;
            }
        } catch(Exception $e) {
            return Constants::ERROR;
        }
    }

    /**
     * insert a new Log of troops received
     * @param string $name
     * @param int $donations
     * @param string $date
     * @param string $tag
     * @param string $tagClan
     * @return int
     * @throws Exception
     */
    public static function insertLogReceived($name, $donations, $date, $tag, $tagClan){
        $connection = DbConnection::getConnection();
        $sql = "INSERT INTO received (playerName,donations,logDate,tag,tagClan) VALUES(:name,:donations,:logDate, :tag, :tagClan)";
        $q = $connection->prepare($sql);
        $q->bindParam(":name", $name);
        $q->bindParam(":donations", $donations);
        $q->bindParam(":logDate", $date);
        $q->bindParam(":tag", $tag);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            if($res) {
                return Constants::SUCCESS;
            } else {
                return Constants::ERROR;
            }
        } catch(Exception $e) {
            return Constants::ERROR;
        }
    }

    /*
     * Below functions are not used yet, but are working here: https://iranpalang.000webhostapp.com/en/stats.php
     */

    /**
     * return the sum of a player donations, filtering by tagClan
     * @param string $tag
     * @param string $date
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getPlayerMonthDonations($tag, $date, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT tag, playerName, SUM(donations) FROM tableLogs WHERE ((logDate LIKE :date1) AND tag=:tag AND tagClan=:tagClan) GROUP BY tag, playerName";
        $q = $connection->prepare($sql);
        $date .= "%";
        $q->bindParam(":tag", $tag);
        $q->bindParam(":date1", $date);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[2],null,$row[1],null,$row[0],null);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return the sum of a player donations received, filtering by tagClan
     * @param string $tag
     * @param string $date
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getPlayerMonthReceived($tag, $date, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT tag, playerName, SUM(donations) FROM received WHERE ((logDate LIKE :date1) AND tag=:tag AND tagClan=:tagClan) GROUP BY tag, playerName";
        $q = $connection->prepare($sql);
        $date .= "%";
        $q->bindParam(":tag", $tag);
        $q->bindParam(":date1", $date);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[2],null,$row[1],null,$row[0],null);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return the sum of all player donations, filtering by tagClan
     * @param string $date
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getMonthDonations($date, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT tag, playerName, SUM(donations) AS don FROM tableLogs WHERE (logDate LIKE :date1 AND tagClan=:tagClan) GROUP BY tag, playerName ORDER BY don DESC";
        $q = $connection->prepare($sql);
        $date .= "%";
        $q->bindParam(":date1", $date);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[2],null,$row[1],null,$row[0],null);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return the sum of all player donations received, filtering by tagClan
     * @param string $date
     * @param string $tagClan
     * @return array|Exception
     * @throws Exception
     */
    public static function getMonthReceived($date, $tagClan){
        $connection = DbConnection::getConnection();
        $list = array();
        $sql = "SELECT tag, playerName, SUM(donations) AS don FROM received WHERE (logDate LIKE :date1 AND tagClan=:tagClan) GROUP BY tag, playerName ORDER BY don DESC";
        $q = $connection->prepare($sql);
        $date .= "%";
        $q->bindParam(":date1", $date);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list[] = Log::newInstance($row[2],null,$row[1],null,$row[0],null);
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return the date of first clan log stored
     * @param string $tagClan
     * @return Exception|null
     * @throws Exception
     */
    public static function getLogsFirstDate($tagClan){
        $connection = DbConnection::getConnection();
        $list = null;
        $sql = "SELECT logDate FROM tableLogs WHERE tagClan=:tagClan ORDER BY logDate LIMIT 1";
        $q = $connection->prepare($sql);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list = $row[0];
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }

    /**
     * return the date of last clan log stored on month $date
     * @param string $date
     * @param string $tagClan
     * @return Exception|null
     * @throws Exception
     */
    public static function getLogsLastDayFromMonth($date, $tagClan){
        $connection = DbConnection::getConnection();
        $list = null;
        $sql = "SELECT logDate FROM tableLogs WHERE (logDate LIKE :logDate AND tagClan=:tagClan) ORDER BY logDate DESC LIMIT 1";
        $q = $connection->prepare($sql);
        $date .= "%";
        $q->bindParam(":logDate", $date);
        $q->bindParam(":tagClan", $tagClan);
        try {
            $res = $q->execute();
            $r = $q->fetchAll();
            foreach($r as $row) {
                $list = $row[0];
            }
        } catch(Exception $e) {
            return $e;
        }
        return $list;
    }
}
