<?php

/**
 * @package JAKWEB Live Chat to WordPress
 * @author JAKWEB
 * @copyright (C) 2017
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
**/
if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}
?>

<div id="jakweblc">
  <div class="wrap">
    <div >
    <h1>Free Live Chat - from <a href="https://liv3chat.com" target="_blank">Liv3 Chat</a></h1>
    </div>
    <div class="clear"></div>

    <?php if (!$lc_embedid) { ?>
    <div class="metabox-holder">
      <div class="postbox">
        <h3>Do you already have a Liv3 Chat account?</h3>
        <div class="postbox_content">
          <ul id="jakweblc_account">
          <li><input type="radio" name="jaklc_account" id="jaklc_account1" checked="checked"> <label for="jaklc_account1">Yes, I do</label></li>
          <li><input type="radio" name="jaklc_account" id="jaklc_account0"> <label for="jaklc_account0">No, let's register</label></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Already have an account -->
    <div class="metabox-holder" id="jakweblc_have">

      <div class="postbox">
      <form method="post" action="?page=zipp_chat">
        <h3>Enter WidgetID</h3>
        <div class="postbox_content">
        <table class="form-table">
        <tr>
        <th scope="row"><label for="livechat_login">My WidgetID:</label></th>
        <td><input type="text" name="widgetid" id="widgetid" value="" size="24"><br /><br /><a href="https://liv3chat.com/c_s/operator/widget" target="_blank">Need help locating your WidgetID?</a><br /><br /><a href="https://liv3chat.com/support/wp-content/uploads/2018/10/Widget-ID.png" target="_blank"><img src="https://liv3chat.com/support/wp-content/uploads/2018/10/Widget-ID.png" width="300" height="auto"></a></td>
        </tr>
        </table>
        <p class="submit">
        <input type="hidden" name="widgetid_form" value="1">
        <input type="submit" class="button-primary" value="<?php _e('Save changes') ?>" />
        </p>
        </div>
      </form>
      </div>
    </div>

    <!-- No account show the form to register Liv3 Chat -->
    <div class="metabox-holder" id="jakweblc_nohave">
      <div class="postbox">
     
        <h3>Create new Liv3 Chat account</h3>
        <div class="postbox_content">
          <div id="jak-registerstatus"></div>

        <table>
        <tr>
        <th scope="row"><label for="username">Signup Here: </label></th>
        <td></td>
        <td><span id="username-help" class="help-block"><a href="https://liv3chat.com" target="_blank">www.liv3chat.com</a></span></td> 
        </tr>
        </table>
<div style="padding:10px;">Signup is quick and easy.</div>
        <hr />
      </form>
      </div>
    </div>

    <?php } else { ?>
    <p><a class="button-primary" href="https://liv3chat.com/c_s/operator" target="_blank">Login to Liv3 Chat</a></p>
    <p>Your WidgetID is: <strong><?php echo $lc_embedid;?></strong></p>
    <p>Don't forget to <a href="https://liv3chat.com/c_s/operator/widget">whitelist your domain</a> in Liv3 Chat Widget section: <strong><?php echo get_site_url();?></strong></p>
    <a href="https://liv3chat.com/support/wp-content/uploads/2018/10/Widget-Whitelist-Cross-Domain.png" target="_blank"><img src="https://liv3chat.com/support/wp-content/uploads/2018/10/Widget-Whitelist-Cross-Domain.png" width="300" height="auto"></a>
    <hr />
    <p>Change your WidgetID? <a href="?page=zipp_chat&amp;reset=1">Reset WidgetID</a>.</p>
    <?php

     $jaklcoptions = get_option( 'jakweblc-lc-options',false );
     if($jaklcoptions == false){
        $jaklcoptions = array (
          'always_display' => 1,
          'show_onfrontpage' => 0,
          'show_oncategory' => 0,
          'show_ontagpage' => 0,
          'show_onarticlepages' => 0,
          'exclude_url' => 0,
          'excluded_url_list' => '',
          'include_url' => 0,
          'included_url_list' => '',
          'display_on_shop' => 0,
          'display_on_productcategory' => 0,
          'display_on_productpage' => 0,
          'display_on_producttag' => 0
        );
     }
     ?>

    <div class="metabox-holder">
      <div class="postbox">
      <form method="post" action="?page=zipp_chat">
        <h3>Options</h3>
        <p class="jak-left">You can use the options below or add the live support chat to any page individually with following shortcode: <strong>[Liv3 Chat]</strong>
        <div class="postbox_content">
          <p>Show Everywhere?</p>
          <ul id="jakweblc_account">
          <li><input type="radio" name="always_display" id="always_display" value="1"<?php if ($jaklcoptions['always_display']) echo ' checked="checked"';?>> <label for="always_display">Yes</label></li>
          <li><input type="radio" name="always_display" id="always_display0" value="0"<?php if (!$jaklcoptions['always_display']) echo ' checked="checked"';?>> <label for="always_display0">No</label></li>
          </ul>

          <div class="single_options"<?php if ($jaklcoptions['always_display']) echo ' style="display:none"';?>>
            <p>Show on Front Page?</p>
            <ul>
            <li><input type="radio" name="show_onfrontpage" id="show_onfrontpage" value="1"<?php if ($jaklcoptions['show_onfrontpage']) echo ' checked="checked"';?>> <label for="show_onfrontpage">Yes</label></li>
            <li><input type="radio" name="show_onfrontpage" id="show_onfrontpage0" value="0"<?php if (!$jaklcoptions['show_onfrontpage']) echo ' checked="checked"';?>> <label for="show_onfrontpage0">No</label></li>
            </ul>

            <p>Show on Category Pages?</p>
            <ul>
            <li><input type="radio" name="show_oncategory" id="show_oncategory" value="1"<?php if ($jaklcoptions['show_oncategory']) echo ' checked="checked"';?>> <label for="show_oncategory">Yes</label></li>
            <li><input type="radio" name="show_oncategory" id="show_oncategory0" value="0"<?php if (!$jaklcoptions['show_oncategory']) echo ' checked="checked"';?>> <label for="show_oncategory0">No</label></li>
            </ul>

            <p>Show on Tag Pages?</p>
            <ul>
            <li><input type="radio" name="show_ontagpage" id="show_ontagpage" value="1"<?php if ($jaklcoptions['show_ontagpage']) echo ' checked="checked"';?>> <label for="show_ontagpage">Yes</label></li>
            <li><input type="radio" name="show_ontagpage" id="show_ontagpage0" value="0"<?php if (!$jaklcoptions['show_ontagpage']) echo ' checked="checked"';?>> <label for="show_ontagpage0">No</label></li>
            </ul>

            <p>Show on Article Pages?</p>
            <ul>
            <li><input type="radio" name="show_onarticlepages" id="show_onarticlepages" value="1"<?php if ($jaklcoptions['show_onarticlepages']) echo ' checked="checked"';?>> <label for="show_onarticlepages">Yes</label></li>
            <li><input type="radio" name="show_onarticlepages" id="show_onarticlepages0" value="0"<?php if (!$jaklcoptions['show_onarticlepages']) echo ' checked="checked"';?>> <label for="show_onarticlepages0">No</label></li>
            </ul>
          </div>

          <p>Exclude on specific URL?</p>
          <ul>
          <li><input type="radio" name="exclude_url" id="exclude_url" value="1"<?php if ($jaklcoptions['exclude_url']) echo ' checked="checked"';?>> <label for="exclude_url">Yes</label></li>
          <li><input type="radio" name="exclude_url" id="exclude_url0" value="0"<?php if (!$jaklcoptions['exclude_url']) echo ' checked="checked"';?>> <label for="exclude_url0">No</label></li>
          </ul>

          <p>Exlucde URL's</p>
          <textarea name="excluded_url_list" rows="5" cols="40"><?php echo $jaklcoptions['excluded_url_list'];?></textarea>
          <p>Enter the URL's where you <strong>don't</strong> want to show the live support chat</p>

          <div class="single_options"<?php if ($jaklcoptions['always_display']) echo ' style="display:none"';?>>
            <p>Include on specific URL?</p>
            <ul>
            <li><input type="radio" name="include_url" id="include_url" value="1"<?php if ($jaklcoptions['include_url']) echo ' checked="checked"';?>> <label for="include_url">Yes</label></li>
            <li><input type="radio" name="include_url" id="include_url0" value="0"<?php if (!$jaklcoptions['include_url']) echo ' checked="checked"';?>> <label for="include_url0">No</label></li>
            </ul>

            <p>Include URL's</p>
            <textarea name="included_url_list" rows="5" cols="40"><?php echo $jaklcoptions['included_url_list'];?></textarea>
            <p>Enter the URL's where you want to show the live support chat</p>
          </div>

          <?php 
          if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) 
        {
          ?>

            <p>Show on Shop?</p>
            <ul>
            <li><input type="radio" name="display_on_shop" id="display_on_shop" value="1"<?php if ($jaklcoptions['display_on_shop']) echo ' checked="checked"';?>> <label for="display_on_shop">Yes</label></li>
            <li><input type="radio" name="display_on_shop" id="display_on_shop0" value="0"<?php if (!$jaklcoptions['display_on_shop']) echo ' checked="checked"';?>> <label for="display_on_shop0">No</label></li>
            </ul>

            <p>Show on Shop Category Pages?</p>
            <ul>
            <li><input type="radio" name="display_on_productcategory" id="display_on_productcategory" value="1"<?php if ($jaklcoptions['display_on_productcategory']) echo ' checked="checked"';?>> <label for="display_on_productcategory">Yes</label></li>
            <li><input type="radio" name="display_on_productcategory" id="display_on_productcategory0" value="0"<?php if (!$jaklcoptions['display_on_productcategory']) echo ' checked="checked"';?>> <label for="display_on_productcategory0">No</label></li>
            </ul>

            <p>Show on Shop Article Pages?</p>
            <ul>
            <li><input type="radio" name="display_on_productpage" id="display_on_productpage" value="1"<?php if ($jaklcoptions['display_on_productpage']) echo ' checked="checked"';?>> <label for="display_on_productpage">Yes</label></li>
            <li><input type="radio" name="display_on_productpage" id="display_on_productpage0" value="0"<?php if (!$jaklcoptions['display_on_productpage']) echo ' checked="checked"';?>> <label for="display_on_productpage0">No</label></li>
            </ul>

            <p>Show on Shop Tag Pages?</p>
            <ul>
            <li><input type="radio" name="display_on_producttag" id="display_on_producttag" value="1"<?php if ($jaklcoptions['display_on_producttag']) echo ' checked="checked"';?>> <label for="display_on_producttag">Yes</label></li>
            <li><input type="radio" name="display_on_producttag" id="display_on_producttag0" value="0"<?php if (!$jaklcoptions['display_on_producttag']) echo ' checked="checked"';?>> <label for="display_on_producttag0">No</label></li>
            </ul>


          <?php } ?>

        <p class="submit">
          <input type="hidden" name="options" value="1">
          <input type="submit" value="Save Options" id="submit" class="button-primary jak-submit">
        </p>
        </div>
      </form>
      </div>
    </div>

    <?php } ?>

  </div>
</div>