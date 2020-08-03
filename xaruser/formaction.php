<?php
/**
 * Xarigami Smilies
 * @copyright (C) 2005 by the Xaraya Development Team.
 * @package Xaraya modules
 * @license GPL {@link http://www.gnu.org/licenses/gpl.html}
 *
 * @subpackage smilies
 * @copyright (C) 2008 2skies.com
 * @link http://xarigami.com
 * @author John Cox
 * @author Jo Dalle Nogare <icedlava@2skies.com>
*/

function smilies_user_formaction()
{

    $out = xarTplModule('smilies','user','formaction');

    // remove template filename in HTML comments (if any), since this part will end up inside another tag (= the form tag)
    $out = preg_replace('/<!--.*?-->/','',$out);

    return $out;
}
?>
