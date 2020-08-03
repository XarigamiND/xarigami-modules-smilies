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
 * delete a smilies
 * @param $args['sid'] ID of the link
 * @returns bool
 * @return true on success, false on failure
 */
function smilies_adminapi_delete($args)
{
    // Get arguments from argument array
    extract($args);
    // Argument check
    if (!isset($sid)) {
        $msg = xarML('Invalid Parameter Count');
        xarErrorSet(XAR_SYSTEM_EXCEPTION, 'BAD_PARAM', new SystemException($msg));
        return;
    }
    // The user API function is called
    $smiley = xarModAPIFunc('smilies',
                          'user',
                          'get',
                          array('sid' => $sid));
    if (empty($smiley)) {
        $msg = xarML('No Such Smiley Present', 'smilies');
        xarErrorSet(XAR_USER_EXCEPTION, 'MISSING_DATA', new DefaultUserException($msg));
        return; 
    }
    // Security Check
    if(!xarSecurityCheck('DeleteSmilies')) return;
    // Get datbase setup
    $dbconn = xarDBGetConn();
    $xartable = xarDBGetTables();
    $smiliestable = $xartable['smilies'];
    // Delete the item
    $query = "DELETE FROM $smiliestable
            WHERE xar_sid = ?";
    $bindvars = array($sid);
    $result = $dbconn->Execute($query,$bindvars);
    if (!$result) return;
    // Let any hooks know that we have deleted a link
    xarModCallHooks('item', 'delete', $sid, '');
    // Let the calling process know that we have finished successfully
    return true;
}
?>