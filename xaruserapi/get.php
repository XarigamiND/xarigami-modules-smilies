<?php
/**
 * Xaraya Smilies
 *
 * @package Xarigami Modules
 * @copyright (C) 2005 by the Xaraya Development Team.
 * @license GPL <http://www.gnu.org/licenses/gpl.html>
  *
 * @subpackage Xarigami smilies
 * @copyright (C) 2008-2011 2skies.com
 * @link http://xarigami.com
 * @author John Cox
 * @author Jo Dalle Nogare <icedlava@2skies.com>
*/
/**
 * get a specific smiley
 * @poaram $args['sid'] id of smiley to get
 * @returns array
 * @return link array, or false on failure
 */
function smilies_userapi_get($args)
{
    extract($args);

    if (!isset($sid)) {
        $msg = xarML('Invalid Parameter Count');
        xarErrorSet(XAR_SYSTEM_EXCEPTION, 'BAD_PARAM',
                       new SystemException($msg));
        return;
    }

    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();

    $smiliestable = $xartable['smilies'];

    // Get link
    $query = "SELECT xar_sid,
                   xar_code,
                   xar_icon,
                   xar_emotion
            FROM $smiliestable
            WHERE xar_sid = ?";
    $bindvars = array($sid);
    $result = $dbconn->Execute($query,$bindvars);
    if (!$result) return;

    list($sid, $code, $icon, $emotion) = $result->fields;
    $result->Close();

    // Security Check
    if(!xarSecurityCheck('OverviewSmilies')) return;

    $link = array('sid'     => $sid,
                  'code'    => $code,
                  'icon'    => $icon,
                  'emotion' => $emotion);

    return $link;
}
?>
