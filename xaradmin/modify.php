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
function smilies_admin_modify()
{
    // Security Check
    if(!xarSecurityCheck('EditSmilies')) return;
    if (!xarVarFetch('sid','int',$sid)) return;
    if (!xarVarFetch('phase', 'str:1:100', $phase, 'form', XARVAR_NOT_REQUIRED, XARVAR_PREP_FOR_DISPLAY)) return;
    if (!xarVarFetch('code', 'str:1:100', $code,'', XARVAR_NOT_REQUIRED)) return;
    if (!xarVarFetch('icon', 'str:1:100', $icon,'', XARVAR_NOT_REQUIRED)) return;
    if (!xarVarFetch('emotion', 'str:1:100',$emotion,'', XARVAR_NOT_REQUIRED)) return;
    switch(strtolower($phase)) {
        case 'update':
            // Get parameters
            if (!xarSecConfirmAuthKey()) return;
            // The API function is called.
           if (!empty($code) && !empty($emotion)) {
                if(!xarModAPIFunc('smilies','admin','update',
                                   array('sid'      => $sid,
                                         'code'     => $code,
                                         'icon'     => $icon,
                                         'emotion'  => $emotion))) return;
                 $msg =xarML('Smilie successfully updated.');
                xarTplSetMessage($msg,'status');
                xarResponseRedirect(xarModURL('smilies', 'admin', 'view'));
            } else {
                 if (empty($code)) $data['error']['code'] = 1;
                  if (empty($emotion)) $data['error']['emotion'] = 1;
                 $msg =xarML('Please fill in all required fields.');
                 xarTplSetMessage($msg,'error');
            }
        case 'form':
        default:
            // The user API function is called.
            $data = xarModAPIFunc('smilies','user','get',
                                  array('sid' => $sid));
            if ($data == false) return;
            $data['authid']         = xarSecGenAuthKey();
            $data['submitlabel']    = xarML('Submit');
            $item = array();
            $item['module'] = 'smilies';
            $item['itemtype'] = NULL; // forum
            $hooks = xarModCallHooks('item','modify','',$item);
            if (empty($hooks)) {
                $data['hooks'] = '';
            } elseif (is_array($hooks)) {
                $data['hooks'] = join('',$hooks);
            } else {
                $data['hooks'] = $hooks;
            }
            break;

    }
    return $data;
}
?>