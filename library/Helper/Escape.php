<?php
class Application_View_Helper_Escape
{
    public function escape($input){
        return htmlspecialchars($input, ENT_QUOTES);
    }
}
