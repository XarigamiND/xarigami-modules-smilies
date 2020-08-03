<?php
/**
 * Displays standard Overview page
 *
 * @package modules
 * @copyright (C) 2002-2008 The Digital Development Foundation
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 * @link http://www.xaraya.com
 *
 * @subpackage Smilies
 * @link http://xaraya.com/index.php/release/153.html
 */
/**
 * Overview function that displays the standard Overview page
 *
 */
function smilies_admin_overview()
{
    // Security Check
    if (!xarSecurityCheck('AdminSmilies',0)) return;

    $data = array();

    // The user API function is called
    $links = xarModAPIFunc('smilies',
                           'user',
                           'getall');
    // could we not just let the template handle no smilies with a graceful message?
    if (empty($links)) {
        $msg = xarML('There are no smilies registered');
        xarErrorSet(XAR_USER_EXCEPTION, 'MISSING_DATA', new DefaultUserException($msg));
        return;
    }
      // Add the array of items to the template variables
    $data['items'] = $links;

    // if there is a separate overview function return data to it
    // else just call the main function that displays the overview

    return xarTplModule('smilies', 'admin', 'main', $data, 'main');
}

?>
