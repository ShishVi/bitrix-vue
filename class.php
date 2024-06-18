<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Iblock\IblockTable;
use Bitrix\Main\SystemException;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;

class ajaxGetNews extends CBitrixComponent implements Controllerable
{ 
    
   

   
    public function configureActions()
    {
       
        return [
            // Определение AJAX действия 'getNewsList'
            'getNewsList' => [
                // Настройки безопасности для AJAX действия
                'prefilters' => [
                    // Здесь можно добавить фильтры, например, для проверки сессии
                    new ActionFilter\HttpMethod([
                        ActionFilter\HttpMethod::METHOD_POST
                    ]),
                    new ActionFilter\Csrf(),
                ],                
            ],
        ];
    }   
    public function getNewsListAction($IBLOCK_ID)
    {
        if (!Loader::includeModule("iblock")) {
            throw new \Bitrix\Main\LoaderException("Не удалось подключить модуль Инфоблоков");
        }
        

        $newsList = [];
        $arSelect = [
            "ID",
            "DETAIL_PAGE_URL",
            "PREVIEW_PICTURE",
            "NAME",
            "DATE_CREATE",
            "TAGS"
        ];
        $arFilter = [
            "IBLOCK_ID" => $IBLOCK_ID,
            '>DATE_ACTIVE_FROM' => '01.01.2010',
            '<DATE_ACTIVE_FROM' => '31.12.2010',
            "ACTIVE" => "Y"
        ];
        $properties = CIBlockElement::GetList(
            Array("sort" => "asc", "name" => "asc"),
            $arFilter,
            false,
            false,
            $arSelect
        );
        
        while ($element = $properties->GetNextElement()) {
            $prop = $element->GetFields();
            $custom_prop = $element->GetProperties();           

            $prop['PROPERTIES'] = $custom_prop;
            $prop["PREVIEW_PICTURE"] = CFile::GetPath($prop["PREVIEW_PICTURE"]);
            $authorID = 2; // Замените 2 на значение, полученное из свойства

            // Получаем имя автора по его ID
            $authorRes = CIBlockElement::GetByID($prop['PROPERTIES']['author']['VALUE']);
            if ($authorElement = $authorRes->GetNext()) {
                $authorName = $authorElement['NAME'];                
            } else {
                $authorName = "Автор не найден.";
}

            $newsList[] = [
                'id' => $prop["ID"],
                'url' => $prop["DETAIL_PAGE_URL"],
                'image' => $prop["PREVIEW_PICTURE"],
                'name' => $prop["NAME"],
                'sectionName' => $prop["IBLOCK_TYPE_ID"],
                'date' => $prop["DATE_CREATE"],
                'author' => $authorName,
                'tags' => $prop["TAGS"],
            ];
        }        
        
        
        return ['newsList' => $newsList];

    }
    public function executeComponent()
    {
        try {           
            
            $this->includeComponentTemplate();
        } 
        catch (SystemException $e) {
            ShowError($e->getMessage());
        }
       
       
    }
}
?>
