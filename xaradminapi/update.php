<?php
/**
 * Xaraya Smilies
 *
 * @package Xaraya eXtensible Management System
 * @copyright (C) 2005 by the Xaraya Development Team.
 * @license GPL <http://www.gnu.org/licenses/gpl.html>
 * @link http://www.xaraya.org
 *
 * @subpackage Smilies Module
 * @author Jim McDonald, Mikespub, John Cox
*/
/**
 * update a smilies
 * @param $args['sid'] the ID of the :)
 * @param $args['code'] the new code of the :)
 * @param $args['icon'] the new icon of the :)
 * @param $args['emotion'] the new emotion of the :)
 */
function smilies_adminapi_update($args)
{
    // Get arguments from argument array
    extract($args);
    // Argument check
    if ((!isset($sid)) ||
        (!isset($code)) ||
        (!isset($icon)) ||
        (!isset($emotion))) {
        $msg = xarML('Invalid Parameter Count');
        xarErrorSet(XAR_SYSTEM_EXCEPTION, 'BAD_PARAM', new SystemException($msg));
        return;
    }

    // The user API function is called
    $link = xarModAPIFunc('smilies',
                          'user',
                          'get',
                          array('sid' => $sid));

    if ($link == false) {
        $msg = xarML('No Such :) Present', 'smilies');
        xarErrorSet(XAR_USER_EXCEPTION, 'MISSING_DATA', new DefaultUserException($msg));
        return; 
    }

    // Security Check
    if(!xarSecurityCheck('EditSmilies')) return;

    // Get datbase setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();

    $smiliestable = $xartable['smilies'];

    // Update the link
    $query = "UPDATE $smiliestable
            SET xar_code    = ?,
                xar_icon    = ?,
                xar_emotion = ?
            WHERE xar_sid = ?";
    $bindvars = array($code, $icon, $emotion, $sid);
    $result = $dbconn->Execute($query,$bindvars);
    if (!$result) return;

    // Let the calling process know that we have finished successfully
    return true;
}
?>