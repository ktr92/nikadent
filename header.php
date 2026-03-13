<?
use Bitrix\Main\Page\Asset;
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
CJSCore::Init(array("fx"));
CUtil::InitJSCore(['ajax']);
$assetsInstance = Asset::GetInstance();
global $USER, $arWishlist, $arCities, $arUser;
$arWishlist = getWishList($USER);
if($USER->IsAuthorized()) {
    $arUser = CUser::GetByID($USER->getID())->Fetch();
} else {
    $arUser = [];
}


//dump($_SESSION);
if (!isset($_SESSION['clientCity'])) {
    getUserGeoLocation();
}
if($_SESSION['clientCity'] == 'Санкт-Петербург') {
    $phone_class = 'replace_phone_2';
} else {
    $phone_class = 'replace_phone_1';
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?/*<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />*/?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title><?$APPLICATION->ShowTitle()?></title>
    <meta property="og:site_name" content="NikaDent">
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?$APPLICATION->ShowTitle()?>" />
    <meta property="og:url" content="<?=$APPLICATION->GetCurDir()?>" />
    <meta property="og:description" content="<?$APPLICATION->ShowProperty('description');?>">
    <? $APPLICATION->ShowMeta("og:image");
    $APPLICATION->SetPageProperty("og:image", "http://www.nika-dent.ru/local/templates/nika-dent_v1/img/content/nika-dent_logo.png"); ?>
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="500" />
    <meta property="og:image:height" content="300" />
    <meta content="telephone=no" name="format-detection">
    <meta name='wmail-verification' content='e82ce7c6366ac0a3d73096d2874aeabf' />


    <?
    /*
    $canonical = "https://".$_SERVER['HTTP_HOST'].$APPLICATION->GetCurDir();
        if (isset($_REQUEST['PAGEN_2']) ||	isset($_REQUEST['PAGEN_1']) ) {
            $canonical = "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $canonical = explode('?', $canonical);
            $canonical = $canonical[0];
        }

        // if ($USER->IsAdmin()){
        //     var_dump($_SERVER['REQUEST_URI']);
        // }
    ?>


    <link rel="canonical" href="<?=$canonical?>" />

    <?php
    */

    $currentPage = mb_strtolower($APPLICATION->GetCurPage(false));
    $requestUri = mb_strtolower($_SERVER['REQUEST_URI']);

    // Проверяем наличие GET-параметров и /filter/
    if (strpos($currentPage, '/filter/') !== false) {
        // Если это страница фильтра — берём адрес до /filter/
        $basePage = preg_replace('#filter/.*#', '', $currentPage);
        ?>
        <meta name="robots" content="noindex,follow" />
        <link rel="canonical" href="https://nika-dent.ru<?=htmlspecialchars($basePage)?>" />
        <?php
    } elseif (!empty($_GET)) {
        // Есть GET-параметры — canonical на базовый урл без параметров
        ?>
        <meta name="robots" content="noindex,follow" />
        <link rel="canonical" href="https://nika-dent.ru<?=htmlspecialchars($currentPage)?>" />
        <?php
    } else {
        // Обычные страницы
        ?>
        <link rel="canonical" href="https://nika-dent.ru<?=htmlspecialchars($currentPage)?>" />
        <?php
    }
    ?>

    <link rel="shortcut icon" href="/local/static/release/favicon/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="57x57" href="/local/static/release/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/local/static/release/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/local/static/release/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/local/static/release/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/local/static/release/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/local/static/release/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/local/static/release/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/local/static/release/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/local/static/release/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/local/static/release/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/local/static/release/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/local/static/release/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/local/static/release/favicon/favicon-16x16.png">
    <link rel="manifest" href="/local/static/release/favicon/manifest.json">
    <meta name="msapplication-TileImage" content="/local/static/release/favicon/ms-icon-144x144.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">
    <meta name="apple-mobile-web-app-title" content="">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <link rel="preload" href="/local/static/release/fonts/GilroyBold/GilroyBold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/local/static/release/fonts/GilroyMedium/GilroyMedium.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/local/static/release/fonts/GilroyRegular/GilroyRegular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/local/static/release/fonts/ManropeBold/ManropeBold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/local/static/release/fonts/GilroySemiBold/GilroySemiBold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/local/static/release/fonts/ManropeMedium/ManropeMedium.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/local/static/release/fonts/ManropeRegular/ManropeRegular.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/local/static/release/fonts/ManropeSemiBold/ManropeSemiBold.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.formstyler.min.css" />
    <link rel="stylesheet" href="<?=SITE_TEMPLATE_PATH?>/css/jquery.fancybox.min.css" />
    <?php
    $assetsInstance->addJs(SITE_TEMPLATE_PATH.'/js/jquery.min.js');
    //$assetsInstance->addJs('https://api-maps.yandex.ru/2.1/?lang=ru_RU&suggest_apikey=95b76ea5-6613-4cd9-a1c0-560ca75f115f');
    $assetsInstance->addJs(SITE_TEMPLATE_PATH.'/script.js');
    $assetsInstance->addCss('/local/static/release/css/styles.min.css?v=202311281735');
    $assetsInstance->addCss('/local/templates/nika/css/jquery.fias.min.css');
    $assetsInstance->addCss('/local/templates/nika/css/custom.css');
    $assetsInstance->addJs('/local/templates/nika/js/jquery.fias.min.js');
    $assetsInstance->addJs('/local/static/release2/js/common.js');
    ?>
    <?$APPLICATION->ShowHead();?>
    <meta name="yandex-verification" content="5ce0345e915c6d9f" />
    <meta name="google-site-verification" content="e4uQi_FVt8vzIrm-dljrhEVHnbX9D8XgO10sajpA-CE" />

</head>
<body>

<?php

?>
<?$APPLICATION->ShowPanel()?>
<?if($USER->isAdmin()):?>
    <style>
        .header{
            padding-top: 58px;
        }
    </style>
<?endif?>
<div class="content-wrapper" id="main-container">
    <header class="header <?php if(isMain()) { print 'header-front'; }?>">
        <?if(!CSite::InDir('/personal/order/make/') && !isset($_REQUEST['ORDER_ID'])):?>

        <div class="container">
            <div class="header__top">
                <?php Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("location-block");?>
                <div id="location-block" class="location-block">
                    <a href="#location_modal" data-fancybox class="location-link js-location-link"><?=$_SESSION['clientCity']?></a>
                    <?if($_SESSION['geoNotFound'] == 1 && !$_COOKIE['clientCity']):?>
                    <div class="location-message" style="display:block">
                        <p><span><?=$_SESSION['clientCity']?></span> — это ваш город?</p>
                        <div class="btns-row">
                            <a href="javascript:void(0);" class="location-btn btn-primary js-location-close">Да</a>
                            <a href="#location_modal" data-fancybox class="location-btn btn-secondary">Нет</a>
                        </div>
                    </div>
                    <? $_SESSION['geoNotFound'] = 0;
                    setcookie('clientCity', 'Москва', time() + (86400 * 30), "/");
                    ?>
                    <?endif?>
                </div>
                <?php Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("location-block", "");;?>
                <nav class="top-menu">
                    <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"top",
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "top",
		"COMPOSITE_FRAME_MODE" => "Y",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>
                </nav>
                <?php Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("backcall-block");?>
                <div id="backcall-block" class="backcall-block">
                    <a href="mailto:zakaz.msk@nika-dent.ru" class="mail-link" style="white-space: nowrap;">zakaz.msk@nika-dent.ru</a>
                    <div style="display: flex; align-items: center; gap: 10px;">
                       <a href="tel:+<?=$GLOBALS['contacts']['PHONE_VALUE_CLEAN']?>" class="phone-link <?=$phone_class;?>" style="display: block;">
                        <div style="line-height: 1.2; white-space:nowrap; font-size:13px"><?=$GLOBALS['contacts']['PHONE_VALUE']?></div>
                        <div style="line-height: 1.2;font-size:11px; color: gray;">Москва</div>
                        </a>

                    <a href="tel:88124588126 " class="phone-link <?=$phone_class;?>"  style="display: block;">
                        <div style="line-height: 1.2; white-space:nowrap; font-size:13px">+7 (812) 458-81-26</div>
                        <div style="line-height: 1.2;font-size:11px; color: gray;">Санкт-Петербург</div>
                    </a>

                    </div>
                 
                    <div class="time-info"><?=$GLOBALS['contacts']['WORKTIME_VALUE']?></div>
                    <a href="#backcall_modal" data-fancybox class="backcall-link js-simple-modal"><i class="icon icon-call"></i><span>Заказать звонок</span></a>
                </div>
                <?php Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("backcall-block", "");?>
            </div>
            <div class="header__bottom">
                <button class="hamburger js-mobile-menu" data-menu="mobile-menu" type="button"><i class="icon icon-hamburger"></i></button>
                <a href="/" class="logo-link">
                    <img src="/local/templates/nika2/images/newlogo_nika.svg<?//$GLOBALS['contacts']['LOGO']?>" alt="nikadent" class="logo-image" loading="lazy">
                </a>
				<a href="/catalog/" class="catalog-btn btn-primary " ><span>Каталог</span></a>
				<? /* <a href="javascript:void(0);" class="catalog-btn btn-primary js-catalog-link" data-catalog="main-catalog"><span>Каталог</span></a> */ ?>
                <div class="search-wrapper">
                    <form action="/search/" class="search-form">
                        <div class="input-group">
                            <input type="text" name="q" class="search-input form-control--search" placeholder="Поиск">
                            <a href="javascript:void(0);" class="clear-btn js-clear-input"><i class="icon icon-x-circle"></i></a>
                            <button type="submit" class="search-btn"><i class="icon icon-search"></i></button>
                        </div>
                    </form>
                    <div id="search-results" class="search-results"></div>
                </div>
                <div class="nikademia">
                    <a href="/nikalab/" target="_blank">
                        <img src="/local/templates/nika/img/logoNIKALAB.png" alt="zubotekhnicheskaya-laboratoriya" loading="lazy">
                    </a>
                </div>
                <nav class="user-menu">
                    <ul class="user-menu__list">
                        <!--<li class="user-menu__item">
                            <a href="/catalog/compare.php" class="user-menu__link js-compare-link compare-cnt" data-count="0">
                                <i class="icon icon-compare"></i>
                                <span>Сравнение</span>
                            </a>
                        </li>-->
                        <li class="user-menu__item">
                            <a href="/personal/wishlist/" class="user-menu__link js-favorite-link favorite-cnt" data-count="<?=count($arWishlist)?>" id="favorite-cnt">
                                <i class="icon icon-heart"></i>
                                <span>Избранное</span>
                            </a>
                        </li>
                        <li class="user-menu__item basket-cnt">
                            <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line","",Array(
                                    "HIDE_ON_BASKET_PAGES" => "Y",
                                    "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                    "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                    "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                    "PATH_TO_PROFILE" => SITE_DIR."personal/",
                                    "PATH_TO_REGISTER" => SITE_DIR."login/",
                                    "POSITION_FIXED" => "Y",
                                    "POSITION_HORIZONTAL" => "right",
                                    "POSITION_VERTICAL" => "top",
                                    "SHOW_AUTHOR" => "Y",
                                    "SHOW_DELAY" => "N",
                                    "SHOW_EMPTY_VALUES" => "Y",
                                    "SHOW_IMAGE" => "Y",
                                    "SHOW_NOTAVAIL" => "N",
                                    "SHOW_NUM_PRODUCTS" => "Y",
                                    "SHOW_PERSONAL_LINK" => "N",
                                    "SHOW_PRICE" => "Y",
                                    "SHOW_PRODUCTS" => "Y",
                                    "SHOW_SUMMARY" => "Y",
                                    "SHOW_TOTAL_PRICE" => "Y"
                                )
                            );?>

                        </li>
                        <?php Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("user-block");?>
                        <li class="user-menu__item user-menu-item">
                            <?if(!$USER->IsAuthorized()):?>
                            <a href="#enter_modal" data-fancybox="" class="user-menu__link js-simple-modal">
                            <?else:?>
                            <a href="/personal/" class="user-menu__link js-user-menu" >
                            <?endif?>
                                <i class="icon icon-user"></i>
                                <span><?=$USER->IsAuthorized() ? $arUser['NAME'] : 'Войти'?></span>
                            </a>
                            <?if ($USER->IsAuthorized()){?>
                            <div class="user-personal js-user-content">
                                <div class="menu-title">
                                    <span>Личный кабинет</span>
                                    <a href="javascript:void(0);" class="close-btn js-umenu-close"><i class="icon icon-close"></i></a>
                                </div>
                                <nav class="personal-menu">
                                    <?$APPLICATION->IncludeComponent(
                                    "bitrix:menu",
                                    "personal",
                                    array(
                                        "ALLOW_MULTI_SELECT" => "N",
                                        "CHILD_MENU_TYPE" => "top",
                                        "DELAY" => "N",
                                        "MAX_LEVEL" => "1",
                                        "MENU_CACHE_GET_VARS" => array(
                                        ),
                                        "MENU_CACHE_TIME" => "3600",
                                        "MENU_CACHE_TYPE" => "Y",
                                        "MENU_CACHE_USE_GROUPS" => "Y",
                                        "ROOT_MENU_TYPE" => "personal",
                                        "USE_EXT" => "N",
                                        "COMPONENT_TEMPLATE" => "personal",
                                        "COMPOSITE_FRAME_MODE" => "Y",
                                        "COMPOSITE_FRAME_TYPE" => "AUTO"
                                    ),
                                    false
                                );?>
                                </nav>
                            </div>
                            <?}?>
                        </li>
                        <?php Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("user-block", "");?>
                    </ul>
                </nav>
                <a href="javascript:void(0);" class="search-btn js-search-open"><i class="icon icon-search"></i></a>
            </div>
            <div id="mobile-menu" class="header__mobile-menu">
                <div class="mmenu-wrapper">
                    <nav class="mobile-menu">
                        <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"mobile",
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "mobile",
		"COMPOSITE_FRAME_MODE" => "Y",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>

                    </nav>
                    <div class="backcall-block">
                        <p><a href="tel:+<?=$GLOBALS['contacts']['PHONE_VALUE_CLEAN']?>" class="phone-link <?=$phone_class;?>"><?=$GLOBALS['contacts']['PHONE_VALUE']?></a><span class="time-info"><?=$GLOBALS['contacts']['WORKTIME_VALUE']?> </a> <!-- Добавьте второй номер (для Санкт-Петербурга) -->
    <a href="tel:+78123098190" class="phone-link spb-phone">
        +7(812) 309 81-90
    </a> </span></p>
                        <p><a href="#backcall_modal" data-fancybox class="backcall-link js-simple-modal"><i class="icon icon-call"></i><span>Заказать звонок</span></a></p>
                        <p><a href="#location_modal" data-fancybox class="location-link js-location-link"><?=$_SESSION['clientCity']?></a></p>
                    </div>
                </div>
            </div>
            <nav id="user-menu" class="header__user-menu">
                <ul class="user-menu__list">
                    <li class="user-menu__item">
                        <a href="/" class="user-menu__link">
                            <i class="icon icon-home"></i>
                            <span>Главная</span>
                        </a>
                    </li>
                    <li class="user-menu__item">
                        <a href="javascript:void(0);" data-catalog="main-catalog" class="user-menu__link js-catalog-link">
                            <i class="icon icon-catalogue"></i>
                            <span>Каталог</span>
                        </a>
                    </li>
                    <li class="user-menu__item basket-cnt">
                        <?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line","",Array(
                                "BLOCK_CLASS" => "js-cart-link",
                                "HIDE_ON_BASKET_PAGES" => "Y",
                                "PATH_TO_BASKET" => SITE_DIR."personal/cart/",
                                "PATH_TO_ORDER" => SITE_DIR."personal/order/make/",
                                "PATH_TO_PERSONAL" => SITE_DIR."personal/",
                                "PATH_TO_PROFILE" => SITE_DIR."personal/",
                                "PATH_TO_REGISTER" => SITE_DIR."login/",
                                "POSITION_FIXED" => "Y",
                                "POSITION_HORIZONTAL" => "right",
                                "POSITION_VERTICAL" => "top",
                                "SHOW_AUTHOR" => "Y",
                                "SHOW_DELAY" => "N",
                                "SHOW_EMPTY_VALUES" => "Y",
                                "SHOW_IMAGE" => "Y",
                                "SHOW_NOTAVAIL" => "N",
                                "SHOW_NUM_PRODUCTS" => "Y",
                                "SHOW_PERSONAL_LINK" => "N",
                                "SHOW_PRICE" => "Y",
                                "SHOW_PRODUCTS" => "Y",
                                "SHOW_SUMMARY" => "Y",
                                "SHOW_TOTAL_PRICE" => "Y"
                            )
                        );?>
                    </li>
                    <?php Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("mobuser-block");?>
                    <li class="user-menu__item">
                        <a href="/personal/wishlist/" class="user-menu__link favorite-cnt" data-count="<?=count($arWishlist)?>">
                            <i class="icon icon-heart"></i>
                            <span>Избранное</span>
                        </a>
                    </li>
                    <?if(!$USER->IsAuthorized()):?>
                    <li class="user-menu__item">
                        <a href="#enter_modal" data-fancybox="" class="user-menu__link js-user-menu">
                            <i class="icon icon-user"></i>
                            <span>Профиль</span>
                        </a>
                    </li>
                    <?else:?>
                    <li class="user-menu__item">
                        <a href="/personal/" class="user-menu__link js-user-menu">
                            <i class="icon icon-user"></i>
                            <span>Профиль</span>
                        </a>
                    </li>
                    <?endif?>
                    <?php Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("mobuser-block", "");?>
                </ul>
            </nav>
        </div>
        <div id="main-catalog" class="main-catalog">
            <?$APPLICATION->IncludeComponent(
	"bitrix:menu",
	"horizontal_multilevel",
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "catalog",
		"DELAY" => "N",
		"MAX_LEVEL" => "3",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600000",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "catalog",
		"USE_EXT" => "Y",
		"COMPONENT_TEMPLATE" => "horizontal_multilevel",
		"COMPOSITE_FRAME_MODE" => "Y",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>

        </div>
        <?else:?>
        <div class="container">
            <div class="header__checkout">
                <a href="/" class="logo-link">
                    <img src="/local/templates/nika2/images/newlogo_nika.svg" alt="nikadent" class="logo-image" loading="lazy">
                </a>
                <div class="info-content">
                    <p>Есть вопросы? Звоните: <a href="tel:+<?=$GLOBALS['contacts']['PHONE_VALUE_CLEAN']?>" class="phone-link <?=$phone_class;?>"><?=$GLOBALS['contacts']['PHONE_VALUE']?></a></p>
                    <span class="time"><?=$GLOBALS['contacts']['WORKTIME_VALUE']?></span>
                </div>
                <a href="/catalog/" class="continue-link btn-secondary">Продолжить покупки</a>
            </div>
        </div>
        <?endif?>
    </header>
    <?if(!isMain() && !CSite::InDir('/blog/') && !CSite::InDir('/producers/') && !CSite::InDir('/sale/')  && !CSite::InDir('/catalog/')):?>
    <main class="<?$APPLICATION->ShowProperty('mainClass')?>">
        <div class="container">
            <?if(!CSite::InDir('/personal/order/make/')):?>
            <div class="breadcrumbs-block">
            <?$APPLICATION->IncludeComponent("bitrix:breadcrumb","breadcrumb",Array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => "s1"
                )
            );?>
            </div>
            <?endif?>
    <?endif?>
