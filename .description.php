<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
    "NAME"=>GetMessage("AJAX_GET_NEWS_DESCRIPTION_NAME"),
    "DESCRIPTION"=>GetMessage("AJAX_GET_NEWS_DESCRIPTION_TEXT"),
    "PATH"=> array(
        "ID"=>"ajax_get_news_component",
        "NAME"=> GetMessage("AJAX_GET_NEWS_DESCRIPTION_GROUP_NAME"),
        "CHILD"=> array(
            "ID"=>"news_list",
            "NAME"=>GetMessage("AJAX_GET_NEWS_DESCRIPTION_CHILD_NAME"),
        ),
    ),
)

?>