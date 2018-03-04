<?php
defined('TWITS') or exit('Access denied');

class Twits_Controller
{
    protected $settings;
    protected $url = 'https://api.twitter.com/1.1/search/tweets.json';
    protected $fieldSearch = '?q=%23';//sushi
    protected $requestMethod = 'GET';

    protected $twitter;
    protected $param;

    protected $content;
    protected $form = true;

    protected $styles;
    protected $scripts;

    protected $ob_m;
    protected $twits_text = array();
    protected $twitsFromDb;

    protected $addTwit;

    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    public function getFieldSearch($request)
    {
        $this->fieldSearch .= $request;
        $this->twitter = new TwitterAPIExchange($this->settings);
        $response = $this->twitter->setGetfield($this->fieldSearch)
            ->buildOauth($this->url, $this->requestMethod)
            ->performRequest();

            $twits = json_decode($response);
            if ($twits->errors) {
                foreach ($twits->errors as $item) {
                    exit($item->code . ' ' . $item->message);
                }
            } elseif ($twits->statuses) {
                $twitsArr = $twits->statuses;
                foreach ($twitsArr as $item) {
                    $obj =($item->entities);
                    if($obj->hashtags){
                        $key = $item->id;
                        $this->twits_text[$key]['text'] = $item->text;
                        foreach ($obj->hashtags as $hashtag){
                            $this->twits_text[$key]['hashtags'][] = $hashtag->text;
                        }
                    }
                }
            }else{
               exit('not results');
            }
    }


    public function request()
    {
        $this->init();
        $this->input();
        $page = $this->output();
        echo $page;
    }

    public function init()
    {
        global $conf;

        if (isset($conf['styles'])) {//заполняем сво-во styles из конфига
            foreach ($conf['styles'] as $style) {
                $this->styles[] = SITE_URL . VIEW . trim($style, '/');
            }
        }

        if (isset($conf['scripts'])) {//заполняем сво-во scripts из конфига
            foreach ($conf['scripts'] as $script) {
                $this->scripts[] = SITE_URL . VIEW . trim($script, '/');
            }
        }
    }

    public function input()
    {
        if (!empty($_POST['id_twit']) && !empty($_POST['text_twit'] && !empty($_POST['hashtags_twit']))) {

            $id_twit = $this->clear_str($_POST['id_twit']);
            $text_twit = $this->clear_str($_POST['text_twit']);
            $hashtags_twit = $this->clear_str($_POST['hashtags_twit']);
            if ($id_twit && $text_twit && $hashtags_twit) {
                $this->ob_m = Model::get_instance();
                $this->addTwit = $this->ob_m->add_twits($id_twit, $text_twit,$hashtags_twit);//add twit db
            }
        }

        if (isset($_GET['search'])) {
             $request = $this->clear_str($_GET['search']);//очистим дан

            if ($request) {
                $this->getFieldSearch($request);//from twitter
                $this->ob_m = Model::get_instance();
                $this->twitsFromDb = $this->ob_m->get_twits($request);//from db
            }else{
                $this->form = false;
                header("Location: ".SITE_URL);
            }
        }
    }

    protected function output()
    {//метод генерирует шаблон и выводит его на экран
        if ($this->twits_text || $this->twitsFromDb) {
            $page = $this->render(VIEW . 'twits_page', array(
                'twits' => $this->twits_text,
                'twitsFromDb' => $this->twitsFromDb,
            ));

        } elseif ($this->addTwit) {
            $page = $this->render(VIEW . 'add_twit',
                array(
                    'add_twit' => $this->addTwit
                ));
        } elseif ($this->addTwit === false) {
            $page = $this->render(VIEW . 'index',
                array(
                    'content' => $this->content,
                    'styles' => $this->styles,
                    'scripts' => $this->scripts
                ));
        } else {
            if($this->form){
                $this->form = $this->render(VIEW . 'form', array());
            }

            $page = $this->render(VIEW . 'index',
                array(
                    'form' => $this->form,
                    'content' => $this->content,
                    'styles' => $this->styles,
                    'scripts' => $this->scripts
                ));
        }

        return $page;//возвращаем полностью готовую страницу
    }


    protected function render($path, $param = array())
    {
        extract($param);

        ob_start();

        if (!include($path . '.php')) {
            throw new Exception('Данного шаблона нет');
        }

        return ob_get_clean();
    }


    public function clear_str($var)
    {
        if (is_array($var)) {
            $row = array();
            foreach ($var as $key => $item) {
                $row[$key] = trim(strip_tags($item));
            }

            return $row;
        }

        return trim(strip_tags($var));
    }

}