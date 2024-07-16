<?php
/**
 * Plugin Name: Replace CDN for China
 * Plugin URI:  https://github.com/forever803/wp-replace-cdn-for-china
 * Description: Use Open Libs Service to replace Google libs, gravatar and so on.
 * Author:      xzhang
 * Author URI:  https://github.com/forever803
 * Version:     1.0
 * License:     GPL
 */


/**
 * Silence is golden
 */
if (!defined('ABSPATH')) exit;

// 匹配出css、js、图片地址
function izt_replace_url($str){
    $regexp = "/<(link|script|img)([^<>]+)>/i";
    $str = preg_replace_callback( $regexp, "izt_replace_callback", $str );
    return $str;
}

// 匹配需要替换掉的链接地址
function izt_replace_callback($matches) {
	$str = $matches[0];
	
	$patterns = array();
	$replacements = array();
	
	$replace_cdn_value = get_option("wafc_google");
	$replace_cdn_value = !$replace_cdn_value? 1 : $replace_cdn_value;
	if($replace_cdn_value > 0){
		// src
		$patterns[0] = '/fonts\.gstatic\.com/';
		$patterns[1] = '/fonts\.googleapis\.com/';
		$patterns[2] = '/ajax\.googleapis\.com/';
		$patterns[3] = '/themes\.googleusercontent\.com/';
		$patterns[4] = '/secure\.gravatar\.com/';
		
		// dest
		$replacements[0] = 'fonts.gstatic.cn';
		// $replacements[1] = 'fonts.googleapis.cn';
		$replacements[1] = 'fonts.font.im';
		$replacements[2] = 'ajax.loli.net';
		$replacements[3] = 'themes.loli.net';
		$replacements[4] = 'gravatar.loli.net';
	}
	return preg_replace($patterns, $replacements, $str);
}
function izt_replace_start() {
	//开启缓冲
	ob_start("izt_replace_url");
}
function izt_replace_end() {
	// 关闭缓冲
	if(ob_get_level() > 0) ob_end_flush();
}
/**
 * 分别将开启和关闭缓冲添加到wp_loaded和shutdown动作
 * 也可以尝试添加到其他动作，只要内容输出在两个动作之间即可
 * 参考链接：http://codex.wordpress.org/Plugin_API/Action_Reference
 */
add_action('wp_loaded', 'izt_replace_start');
add_action('shutdown', 'izt_replace_end');
add_action('admin_menu', 'izt_wafc_menu');
function izt_wafc_menu(){
	add_submenu_page( 'options-general.php', 'WP Replace CDN for China设置', 'WP Replace CDN for China', 'manage_options', 'izt-wafc', 'izt_wafc_fun' );
}
function izt_wafc_fun(){
	if (isset($_POST["action"]) && $_POST["action"] == "saveconfiguration") {
		update_option('wafc_google', $_POST["wafc_google"]);
		echo '<div class="updated"><p><strong>设置保存成功！</strong></p></div>';
	}
	$replace_cdn_value = get_option("wafc_google");
	$replace_cdn_value = !$replace_cdn_value? 1 : $replace_cdn_value;
	?>
	<div class="wrap">
		<form method="post">
		<input type="hidden" name="action" value="saveconfiguration">
		<h2>WP Replace CDN for China 插件设置</h2>
		<table class="form-table">
			<tr>
			<th>Replace CDN</th>
			<td>
				<select name="wafc_google">
				<option value="-1">不替换CDN</option>
				<option value="1"<?=$replace_cdn_value == 1?' selected="selected"':''?>>替换CDN</option>
				</select>
			</td>
			</tr>
			<tr>
			<td><input type="submit" class="button button-primary" value="保存设置"></td>
			<td></td>
			</tr>
		</table>
		</form>
	</div>

	<?php } 
?>
