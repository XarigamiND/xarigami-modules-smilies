<?php
/**
 * Xarigami Smilies options
 *
 * @package Xaraya modules
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage xarigami smilies
 * @copyright (C) 2008 2skies.com
 * @link http://xarigami.com
 * @author Jo Dalle Nogare <icedlava@2skies.com>
*/
/**
 * Grabs the list of viewing options in the following order of precedence:
 * 1. POST/GET
 * 2. User Settings (if user is logged in)
 * 3. Module Defaults
 * 4. internal defaults
 *
 * @access public
 */
function smilies_userapi_getoptions($args)
{
    if (!isset($args['itemtype'])) {
       $args['itemtype']= 0;
    } else {
        $args['itemtype'] = (int)$args['itemtype'];
    }
   
    if (!isset($args['modname']) && isset($args['modid'])) {
        $modname = xarModGetNameFromID($args['modid']);
    }
    //set all the defaults for vars that are by itemtype (not globals)
    $settings['skiptags'] = xarModGetVar('smilies','skiptags');
    $settings['image_folder'] = xarModGetVar('smilies','image_folder');
    $settings['popupsmilies'] = xarModGetVar('smilies','popupsmilies');            
    //do not include global vars here - only those that can be overridden

    //now check for itemtype and use that if it exists
    //need to discriminate between boolean vars and non-bool for correct assignment

    $boolvars = array('popupsmilies');

    // Get from hooked module if $args given    
    if (isset($args['modname']) && xarModGetVar('smilies','allowhookoverride')) {

        foreach ($settings as $k => $v) {
            //override with any hook setting if allowed
            if (in_array($k,$boolvars)) {
                 $hookedvar = xarModGetVar($args['modname'],$k . '.' .$args['itemtype']) ? 1 : 0;
            }else {
                 $hookedvar = xarModGetVar($args['modname'],$k . '.' .$args['itemtype']) ? xarModGetVar($args['modname'],$k . '.' .$args['itemtype']) : '';
            }
            $settings[$k] = $hookedvar;
        }
    }

       
    return $settings;
}

?>