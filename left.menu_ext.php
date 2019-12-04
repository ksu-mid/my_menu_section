<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
global $APPLICATION;


CModule::IncludeModule("iblock");
$arFilter = array(
	"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
	"GLOBAL_ACTIVE"=>"Y",
	"IBLOCK_ACTIVE"=>"Y",
	"<="."DEPTH_LEVEL" => 2,
);
$arOrder = array(
	"left_margin"=>"asc",
);

$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, array(
	"ID",
	"DEPTH_LEVEL",
	"NAME",
	"SECTION_PAGE_URL",
));

while($arSection = $rsSections->GetNext())
{
	$count=CIBlockSection::GetCount(array("IBLOCK_ID"=> CATALOG_IBLOCK_ID, "SECTION_ID"=>$arSection["ID"]));
	$activeElements = CIBlockSection::GetSectionElementsCount($arSection["ID"], Array("CNT_ACTIVE"=>"Y"));
	$aMenuLinksExt[]= array(
		$arSection["NAME"],
		$arSection["SECTION_PAGE_URL"],
		array(
			$arSection["SECTION_PAGE_URL"]
		),
		array(
			"FROM_IBLOCK"=>true,
			"IS_PARENT"=> $count > 0 && $arSection["DEPTH_LEVEL"] == 1 ? true : false,
			"DEPTH_LEVEL"=>$arSection["DEPTH_LEVEL"],
			"COUNTS_OF_GOODS"=>$activeElements
		),
	);		
}
$aMenuLinks = array_merge($aMenuLinks, $aMenuLinksExt);
