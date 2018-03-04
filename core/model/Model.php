<?php
defined('TWITS') or exit('Access denied');
class Model
{
    static $instance;

    public $ins_driver;//объект класса Model_Driver

    static function get_instance()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        } else {
            return self::$instance = new self;
        }
    }

    private function __construct()
    {
        try {
            $this->ins_driver = Model_Driver::get_instance();

        } catch (Exception $e) {
            exit();
        }
    }


    public function get_twits($request)
    {
        $result = $this->ins_driver->select(
            array('id_twit', 'text_twit'),
            'twits',
            array('hashtags_twit'=>'%'.$request.'%'),
            FALSE,
            "ASC",
            FALSE,
            arraY('LIKE')
           // array('text_twit'=> $request)
        );
        $res = false;
        if($result){
            $arr = array();
            foreach ($result as $item) {
                $arr[] = $item;
            }
            $res = $arr;
        }

        return $res;
    }

    public function add_twits($id_twit, $text_twit,$hashtags_twit)
    {
        $result = $this->ins_driver->insert(
            'twits',
            array('id_twit', 'text_twit','hashtags_twit'),
            array($id_twit, $text_twit,$hashtags_twit)
        );

        if($result){
            $addTwit = array($id_twit => $text_twit);
            return $addTwit;
        }else{
            return false;
        }
    }

}































