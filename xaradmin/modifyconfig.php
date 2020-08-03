<?php
/**
 * Xarigami Smilies Config
 *
 * @package Xaraya modules
 * @copyright (C) 2005 by the Xaraya Development Team.
 * @license GPL <http://www.gnu.org/licenses/gpl.html>
 *
 * @subpackage Xarigami smilies
 * @copyright (C) 2008 2skies.com
 * @link http://xarigami.com
 * @author John Cox
 * @author Jo Dalle Nogare <icedlava@2skies.com>
 * @author Jim McDonald, Mikespub
*/

/**
 * @returns output
 * @return output with smilies configuration settings
 */
function smilies_admin_modifyconfig()
{
    // Security Check
    if(!xarSecurityCheck('AdminSmilies')) return;
    
    $data = array();

    // Bug 3957: get configured tags to skip
    $skipstring = xarModGetVar('smilies', 'skiptags');
    $skiptags = array();
    if (!empty($skipstring)) {
      $skiptags = unserialize($skipstring);
    } 
    $data['skiptags'] = join(',',$skiptags);
    // make use of the itemsperpage module var
    $data['itemsperpage'] = xarModGetVar('smilies', 'itemsperpage');
    // Bug 5116: option to hide duplicate emotions in user main
    $data['showduplicates'] = xarModGetVar('smilies', 'showduplicates');
    // Bug 5271: allow specifying a subfolder from which to serve smilies images
    $data['image_folder'] = xarModGetVar('smilies', 'image_folder');
    $data['popupsmilies'] = xarModGetVar('smilies', 'popupsmilies'); 
    $data['allowhookoverride'] = xarModGetVar('smilies', 'allowhookoverride'); 
    // call modifyconfig hooks with module
    $hooks = xarModCallHooks('module', 'modifyconfig', 'smilies',
                             array('module'   => 'smilies'));
    if (empty($hooks)) {
        $data['hooks'] = '';
    } else {
        $data['hooks'] = $hooks;
    }
    $data['authid'] = xarSecGenAuthKey('smilies');
    return $data;
}
?>