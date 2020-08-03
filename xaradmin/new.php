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
function smilies_admin_new()
{
    if(!xarSecurityCheck('AddSmilies')) return;
    if (!xarVarFetch('phase', 'str:1:100', $phase, 'form', XARVAR_NOT_REQUIRED, XARVAR_PREP_FOR_DISPLAY)) return;
    if (!xarVarFetch('code', 'str:1:100', $code,'', XARVAR_NOT_REQUIRED)) return;
    if (!xarVarFetch('icon', 'str:1:100', $icon,'', XARVAR_NOT_REQUIRED)) return;
    if (!xarVarFetch('emotion', 'str:1:100',$emotion,'', XARVAR_NOT_REQUIRED)) return;
    $data['error'] = array();
    switch(strtolower($phase)) {

        case 'update':
             if (!empty($code) && !empty($emotion)) {
                // Confirm authorisation code
                if (!xarSecConfirmAuthKey()) return;
                // The API function is called
                if (!xarModAPIFunc('smilies',
                                   'admin',
                                   'create',
                                   array('code' => $code,
                                         'icon' => $icon,
                                         'emotion' => $emotion))) return;
                $msg =xarML('New smilie created.');
                xarTplSetMessage($msg,'status');
                xarResponseRedirect(xarModURL('smilies', 'admin', 'view'));
                break;
            }elseif (empty($code) || empty($emotion)) {
                if (empty($code)) $data['error']['code'] = 1;
                  if (empty($emotion)) $data['error']['emotion'] = 1;
                 $msg =xarML('Please fill in all required fields.');
                 xarTplSetMessage($msg,'error');
            }
        case 'form':
        default:
            $data['authid']         = xarSecGenAuthKey();
            $data['submitlabel']    = xarML('Submit');
            $item = array();
            $item['module'] = 'smilies';
            $item['itemtype'] = NULL; // forum
            $hooks = xarModCallHooks('item','new','',$item);
            if (empty($hooks)) {
                $data['hooks'] = '';
            } elseif (is_array($hooks)) {
                $data['hooks'] = join('',$hooks);
            } else {
                $data['hooks'] = $hooks;
            }
            break;

    }
    // Return the output
    return $data;
}
?>