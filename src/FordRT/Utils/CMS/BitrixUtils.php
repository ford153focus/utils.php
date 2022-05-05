<?php

namespace FordRT\Utils4Php\CMS;

class BitrixUtils
{
    public static function getElementProperties($iblock_id, $element_id): array
    {
        $properties=[];
        $properties_handler = CIBlockElement::GetProperty($iblock_id, $element_id);
        while ($ar_props = $properties_handler->Fetch()) {
            $properties[] = $ar_props;
        } //collect properties
        return $properties;
    }

    public static function getElementProperty($iblock_id, $element_id, $property_name): string
    {
        $properties = self::getElementProperties($iblock_id, $element_id);
        $filter = static function($property) use ($property_name) { return $property["CODE"] === $property_name; };
        $properties = array_filter($properties, $filter); //filter properties
        return array_pop($properties)['VALUE']; //get first prop
    }

    public static function getElementSection($id)
    {
        $blockListRes = CIBlockElement::GetList([], ['ID' => $id], false, false, ['ID', 'IBLOCK_SECTION_ID']);
        if($blockRes = $blockListRes->Fetch())
        {
            return CIBlockSection::GetByID($blockRes['IBLOCK_SECTION_ID']);
        }
        return null;
    }

    public static function getSectionPicture($sectionID)
    {
        $sectionHandler = CIBlockSection::GetByID($sectionID);
        if($section = $sectionHandler->GetNext()) {
            return CFile::GetPath($section["PICTURE"]);
        }
        return null;
    }
}
