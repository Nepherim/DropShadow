<?php if (!defined('PmWiki')) exit();
/*
 * PmWiki DropShadow skin
 * @requires PmWiki 2.2
 *
 * Examples at: http://pmwiki.com/Cookbook/DropShadow and http://skins.solidgone.com/
 * Copyright (c) 2007 David Gilbert
 * Dual licensed under the MIT and GPL licenses:
 *    http://www.opensource.org/licenses/mit-license.php
 *    http://www.gnu.org/licenses/gpl.html
 */
global $FmtPV;
$FmtPV['$SkinName'] = '"dropshadow"';
$FmtPV['$SkinVersion'] = '"0.0.1"';

## Default color scheme
global $SkinColor, $ValidSkinColors;
if ( !is_array($ValidSkinColors) ) $ValidSkinColors = array();
array_push($ValidSkinColors, 'red', 'blue', 'orange', 'yellow', 'green');
if ( isset($_GET['color']) && in_array($_GET['color'], $ValidSkinColors) ) {
	$SkinColor = $_GET['color'];
} elseif ( !in_array($SkinColor, $ValidSkinColors) ) {
	$SkinColor = 'blue';
}

## Move any (:noleft:) or SetTmplDisplay('PageLeftFmt', 0); directives to variables for access in jScript.
global $RightColumn, $SearchBar;
$FmtPV['$RightColumn'] = "\$GLOBALS['TmplDisplay']['PageRightFmt']";
$FmtPV['$SearchBar'] = "\$GLOBALS['TmplDisplay']['PageSearchFmt']";
$FmtPV['$ActionBar'] = "\$GLOBALS['TmplDisplay']['PageActionFmt']";
$FmtPV['$TabsBar'] = "\$GLOBALS['TmplDisplay']['PageTabsFmt']";

## Add a custom page storage location
global $PageStorePath, $WikiLibDirs;
$PageStorePath = dirname(__FILE__)."/wikilib.d/{\$FullName}";
$where = count($WikiLibDirs);
if ($where>1) $where--;
array_splice($WikiLibDirs, $where, 0, array(new PageStore($PageStorePath)));

## Override pmwiki styles otherwise they will override styles declared in css
global $HTMLStylesFmt;
$HTMLStylesFmt['pmwiki'] = '';

## Define a link stye for new page links
global $LinkPageCreateFmt;
SDV($LinkPageCreateFmt, "<a class='createlinktext' href='\$PageUrl?action=edit'>\$LinkText</a>");

# Converts H1 to H2, H2 to H3, etc.
Markup('^!', 'block',
  '/^(!{1,5})\\s?(.*)$/e',
  "'<:block,1><h'.(strlen('$1')+1).PSS('>$2</h').(strlen('$1')+1).'>'"
);
