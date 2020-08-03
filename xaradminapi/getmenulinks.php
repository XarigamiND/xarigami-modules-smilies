<?php
/**
 * Xaraya Smilies
 *
 * @package Xarigami
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
 * utility function pass individual menu items to the main menu
 *
 * @author the Example module development team
 * @returns array
 * @return array containing the menulinks for the main menu items.
 */
function smilies_adminapi_getmenulinks()
{

    if (xarSecurityCheck('EditSmilies', 0)) {

        $menulinks[] = Array('url'   => xarModURL('smilies','admin','view'),
                              'title' => xarML('View and Edit :)'),
                              'label' => xarML('View'),
                              'active'=> array('view')
                              );
    }
    if (xarSecurityCheck('AddSmilies', 0)) {

        $menulinks[] = Array('url'   => xarModURL('smilies', 'admin', 'new'),
                              'title' => xarML('Add a new :) into the system'),
                              'label' => xarML('Add'),
                              'active'=> array('new')
                              );
    }
    if (xarSecurityCheck('AdminSmilies', 0)) {
        $menulinks[] = Array('url'   => xarModURL('smilies','admin','modifyconfig'),
                              'title' => xarML('Modify the configuration for the smilies'),
                              'label' => xarML('Modify Config'),
                              'active'=> array('modifyconfig')
                              );
    }
    if (empty($menulinks)){
        $menulinks = '';
    }

    return $menulinks;
}
?>