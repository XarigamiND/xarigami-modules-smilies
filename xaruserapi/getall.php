<?php
/**
 * Xarigami Smilies
 *
 * @package Xarigami Modules
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage Xarigami smilies
 * @copyright (C) 2008-2011 2skies.com
 * @link http://xarigami.com
 * @author John Cox
 * @author Jo Dalle Nogare <icedlava@2skies.com>
*/
/**
 * get all smilies
 * @returns array
 * @return array of links, or false on failure
 */
function smilies_userapi_getall($args)
{
    extract($args);

    // Optional arguments
    if (!isset($startnum)) {
        $startnum = 1;
    }
    if (!isset($numitems)) {
        $numitems = -1;
    }

    $links = array();

    // Security Check
    // Do *not* return an error if there are insufficient privileges, as
    // this function is called in a transform hook.
    if (!xarSecurityCheck('OverviewSmilies', 0)) {
        return $links;
    }

    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();

    $smiliestable = $xartable['smilies'];

    // Get links
    $query = "SELECT xar_sid,
                     xar_code,
                     xar_icon,
                     xar_emotion
            FROM $smiliestable";
    // Bug 5116: Groupby emotion so we don't get duplicates
    if (isset($groupby)) {
      switch ($groupby) {
        case 'emotion':
          $query .= " GROUP BY xar_emotion";
        break;
      }
    }
    $query .= " ORDER BY xar_emotion";
    $result = $dbconn->SelectLimit($query, $numitems, $startnum-1);
    if (!$result) return;

    for (; !$result->EOF; $result->MoveNext()) {
        list($sid, $code, $icon, $emotion) = $result->fields;
        if (xarSecurityCheck('OverviewSmilies', 0)) {
            $links[] = array('sid'      => $sid,
                             'code'     => $code,
                             'icon'     => $icon,
                             'emotion'  => $emotion);
        }
    }

    $result->Close();

    return $links;
}
?>