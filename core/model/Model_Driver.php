<?php

defined('TWITS') or exit('Access denied');

class Model_Driver
{

    static $instance;

    public $ins_db;

    static function get_instance()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }
        return self::$instance = new self;
    }

    public function __construct()
    {
        $this->ins_db = new mysqli(HOST, USER, PASSWORD, DB_NAME);

        if ($this->ins_db->connect_error) {
            throw new Exception("Ошибка соединения : " . $this->ins_db->connect_errno . "|" . iconv("CP1251", "UTF-8", $this->ins_db->connect_error));
        }

        $this->ins_db->query("SET NAMES 'utf8mb4_unicode_ci'");
    }

    public function select(
        $param,
        $table,
        $where = array(),
        $order = FALSE,
        $napr = "ASC",
        $limit = FALSE,
        $operand = arraY('='),
        $match = array()
    )
    {

        $sql = "SELECT";

        foreach ($param as $item) {
            $sql .= ' ' . $item . ',';
        }

        $sql = rtrim($sql, ',');

        $sql .= ' ' . 'FROM' . ' ' . $table;

        if (count($where) > 0) {
            $ii = 0;
            foreach ($where as $key => $val) {
                if ($ii == 0) {
                    if ($operand[$ii] == "IN") {
                        $sql .= " WHERE " . strtolower($key) . " " . $operand[$ii] . "(" . $val . ")";
                    } else {
                        $sql .= ' ' . ' WHERE ' . strtolower($key) . ' ' . $operand[$ii] . ' ' . "'" . $this->ins_db->real_escape_string($val) . "'";
                    }
                }
                if ($ii > 0) {
                    if ($operand[$ii] == "IN") {
                        $sql .= " AND " . strtolower($key) . " " . $operand[$ii] . "(" . $val . ")";
                    } else {
                        $sql .= ' ' . ' AND ' . strtolower($key) . ' ' . $operand[$ii] . ' ' . "'" . $this->ins_db->real_escape_string($val) . "'";
                    }

                }
                $ii++;
                if ((count($operand) - 1) < $ii) {
                    $operand[$ii] = $operand[$ii - 1];
                }
            }

        }

        if (count($match) > 0) {
            foreach ($match as $k => $v) {
                if (count($where) > 0) {
                    $sql .= " AND MATCH (" . $k . ") AGAINST('" . $this->ins_db->real_escape_string($v) . "')";
                } elseif (count($where) == 0) {
                    $sql .= " WHERE MATCH (" . $k . ") AGAINST('" . $this->ins_db->real_escape_string($v) . "')";
                }
            }
        }

        if ($order) {
            $sql .= ' ORDER BY ' . $order . " " . $napr . ' ';
        }

        if ($limit) {
            $sql .= " LIMIT " . $limit;
        }

        $result = $this->ins_db->query($sql);
        if (!$result) {
            throw new Exception("Ошибка запроса" . $this->ins_db->connect_errno . "|" . $this->ins_db->connect_error);
        }

        if ($result->num_rows == 0) {
            return FALSE;
        }

        for ($i = 0; $i < $result->num_rows; $i++) {
            $row[] = $result->fetch_assoc();
        }

        return $row;

    }


    public function insert($table, $data = array(), $values = array())
    {
        //$sql = "INSERT INTO brands (field_1,field_2) VALUES ('id_test','text_test')";

        $sql = "INSERT INTO " . $table . " (";

        $sql .= implode(",", $data) . ") ";

        $sql .= "VALUES (";

        foreach ($values as $val) {
            $sql .= "'" . $val . "'" . ",";
        }

        $sql = rtrim($sql, ',') . ")";
        $result = $this->ins_db->query($sql);
        if (!$result) {
          // throw new Exception("Ошибка базы данных: " . $this->ins_db->errno . " | " . $this->ins_db->error);
            return FALSE;
        }

        return TRUE;
    }

}

?>