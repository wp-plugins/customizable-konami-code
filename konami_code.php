<?php
/*
Plugin Name: Customizable Konami Code
Plugin URI: http://www.guravehaato.info/blog/tenha-o-konami-code-no-seu-blog
Description: Insere o Konami Code no seu blog
Author: GraveHeart
Version: 0.9 beta
*/ 

function instalar_o_trem() {
	$konami_code = "Bem-vindo!";
	add_option('konami_code_string', $konami_code);
}

//incluindo funções no menu
function cria_menu_pra_bagaca() {
      add_options_page(
                       'Konami Code',         //Title
                       'Konami Code',         //Sub-menu title
                       'manage_options', //Security
                       __FILE__,         //File to open
                       'konami_code_options'  //Function to call
                      );  
}


function konami_code_options() {
      echo '<div class="wrap"><h2>Konami Code</h2>';
	if ($_REQUEST['submit']) {
		update_konami_options();
	        }
		print_konami_form();
     echo '</div>';
}


function print_konami_form () {
      $konami_string = get_option('konami_code_string');   
      echo "<form method=\"post\"><label>Insira sua mensagem:";
      echo "<input type=\"text\" name=\"konami_code_string\" value=\"$konami_string\" /></label>";
      echo " <br />      <input type=\"submit\" name=\"submit\" value=\"Submit\" />  </form>";

 }

 function update_konami_options() {
      $updated = false;
      if ($_REQUEST['konami_code_string']) {
           update_option('konami_code_string', $_REQUEST['konami_code_string']);
           $updated = true;
      }
      if ($updated) {
            echo '<div id="message" class="updated fade">';
            echo '<p>Atualizado</p>';
            echo '</div>';
       } else {
            echo '<div id="message" class="error fade">';
            echo '<p>deu pau!</p>';
            echo '</div>';
       }
  }

function konami_code($content) {
	$konami_string = get_option('konami_code_string');   
	
	?>
		<script type="text/javascript" src="http://konami-js.googlecode.com/svn/trunk/konami.js"></script>
<script type="text/javascript">
	konami.code = function() {
		alert("<? echo $konami_string; ?>")
		}
	konami.load()
</script>
<?	
}



register_activation_hook( __FILE__, 'instalar_o_trem' );
add_action('admin_menu','cria_menu_pra_bagaca');
add_action('wp_head', 'konami_code');
?>