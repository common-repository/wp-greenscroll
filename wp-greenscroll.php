<?php
/*
Plugin Name: WP Greenscroll
Plugin URI: http://www.greenscroll.org/
Description: Adds Greenscroll certificate to WP sidebar
Author: LeViS
Version: 1.0.0
Author URI: http://www.greenscroll.org/
*/ 

/* Copyright 2009 Leo (email: support@greenscroll.org)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

/**
 * Options
 */
function _greenscroll_default_config()
{
	return array(
        'greenscroll_align' => 2        /* Picture align */
    );
}

add_option('greenscroll_options', _greenscroll_default_config(), 'Greenscroll Options');
$greenscroll_config = get_option('greenscroll_options');

/**
 * Create the option page
 */
add_action('admin_menu', 'add_greenscroll_options_page');

function add_greenscroll_options_page() {
	add_options_page('Greenscroll Options', 'Greenscroll', 8, basename(__FILE__), 'greenscroll_options_page');
}

function greenscroll_options_page() {
	global $greenscroll_config;

    if(!empty($_POST['_greenscroll_update'])) {
		$greenscroll_config['greenscroll_align'] = intval($_POST['greenscroll_align']);
		update_option('greenscroll_options', $greenscroll_config);
		echo '<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>';
	} 

	?>
	
	<div class="wrap">
		<h2>Greenscroll Options</h2>
		<form method="post" action="">
			<table width="100%" cellspacing="2" cellpadding="5" class="editform">
			<tr>
				<td valign="top"> Align: </td>
				<td>
					<input id='gsa1' name="greenscroll_align" type="radio" value="1" <?php checked('1', $greenscroll_config['greenscroll_align']); ?> /> 
                    <label for='gsa1'>left</label>
					<input id='gsa2' name="greenscroll_align" type="radio" value="2" <?php checked('2', $greenscroll_config['greenscroll_align']); ?> /> 
                    <label for='gsa2'>center</label>
					<input id='gsa3' name="greenscroll_align" type="radio" value="3" <?php checked('3', $greenscroll_config['greenscroll_align']); ?> /> 
                    <label for='gsa3'>right</label>
				</td>
			</tr>
			<tr>
				<td valign="top"> How show Greenscroll button:</td>
				<td>
<hr />
We can use this plug-in in two different way.<br /><br />
1.	Go to widget menu and drag and drop the "Greenscroll" widget to your sidebar location. or <br />
2.	Copy and past the below mentioned code to your desired template location.

<h2><?php echo wp_specialchars('Paste the below code to your desired template location!'); ?></h2>
<div style="padding-top:7px;padding-bottom:7px;">
<code style="padding:7px;">&lt;?php if (function_exists(greenscroll_button)) greenscroll_button(); ?&gt;</code>
</div>
				</td>
			</tr>

            <tr>
                <td></td><td><p class="submit"><input type='submit' name='_greenscroll_update' id='_greenscroll_update' value='Update Options &raquo;' /></p></td>
			</tr>
			</table>

		</form>
	</div>

	<?php
}


/**
 * Create widget
 */
register_sidebar_widget('Greenscroll', 'greenscroll_button');


/**
 * Generate button code
 */
function greenscroll_button() {
	global $greenscroll_config;
    $a = intval($greenscroll_config['greenscroll_align']);
    if ($a == 2) { $a = 'center'; } else { if ($a == 3) { $a = 'right'; } else { $a = 'left'; } }
    echo '<div style="text-align:'.$a.'">';
    echo "<a href='http://www.greenscroll.org/'><img src='https://greenscroll.org/api/images/1/greenscroll-certified-0.png' id='greenscroll_cert' alt='Greenscroll certified' /></a>";
    echo '<script src="https://greenscroll.org/api/gs.js" type="text/javascript"/>';
//    echo "<script type='text/javascript'>try{document.getElementById('greenscroll_cert').style.display='none';document.write('<a href=\"https://greenscroll.org/api/verify/\" onclick=\"window.open(\\'https:/'+'/greenscroll.org/api/verify/\\',\\'popup\\',\\'width=370,height=395,scrollbars=no,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0\\');return false;\" target=\\'_blank\\'><img src=\\'https:/'+'/greenscroll.org/api/images/1/greenscroll-certified-".$z.".png\\' alt=\\'Greenscroll Certified\\' border=\\'0\\' width=\\'135\\' height=\\'50\\' class=\\'png\\' /></a>');} catch(e){}</script>";
    echo '</div>';
}

?>