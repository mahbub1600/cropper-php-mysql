<?php

namespace MyFramework\View;

class ViewModel
{
    private $data = array();

    private $render = FALSE;

    public function __construct($template, $data=array())
    {
        $this->data = $data;
        //get the trace
        $trace = debug_backtrace();
        // Get the file that is asking for who awoke it
        $module=null; $controller=null;
        if(count($trace)>1){
            $order = explode('\\', end($trace)['class']);
            $module = current($order);
            $controller = end($order);
            $controller = preg_replace('/Controller/','', $controller);
        }
        try {
            if($module && $controller) {
                $file = PROJECT_ROOT. DS . 'Modules'. DS . $module . DS. 'view'. DS. strtolower($controller). DS . strtolower($template) . '.php';
            } else{
                $file = PROJECT_ROOT . 'Modules/' . $module . '/templates/' . strtolower($template) . '.php';
            }
            if (file_exists($file)) {
                $this->render = $file;
            } else {
                throw new \Exception('Template ' . $template . ' not found!');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function assign($variable, $value)
    {
        $this->data[$variable] = $value;
    }

    private $query;
    private function getQuery(){
        if(!isset($this->query)){
            $this->query = array();

            if(isset($_SERVER['REDIRECT_QUERY_STRING'])){
                $query = $_SERVER['REDIRECT_QUERY_STRING'];
                $query = explode('&', $query);
                foreach($query as $value){
                    $value=explode('=', $value);
                    $this->query[$value[0]] = (isset($value[1])?$value[1]:null);
                }
            }
            return $this->query;
        }
    }
    protected function getContent($templateFile, $param=array()) {
        $param['query'] = $this->getQuery();
        extract($param);
        ob_start();
        include $templateFile;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }

    public function __destruct()
    {
        echo $this->getContent(PROJECT_ROOT.DS.'layout'.DS.'layout.php', array('content' => $this->getContent($this->render, $this->data)));
    }
}
?>