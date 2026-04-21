<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.migueldaipre.com.br
 * @since      1.0.0
 *
 * @package    Cmh_Bcb
 * @subpackage Cmh_Bcb/admin/partials
 */
?>

<?php if(extension_loaded('soap')){$soapActive = true;} ?>

<div id="chm-plugin-container">
    <div class="chm-plugin-masterhead">
        <div class="chm-plugin-masterhead__inside-container">
                <div class="chm-plugin-masterhead__logo-container">
                    <img class="chm-plugin-masterhead__logo" src="<?php echo plugin_dir_url( __DIR__ ); ?>/imgs/logo_admin.png" alt="Cotação Moedas">
                    <div class="chm-right">         
                        <a class="chm-button chm-is-primary" href="#">Precisa de Ajuda?</a>
                    </div> 
                </div>
        </div>
    </div>
 

    <div class="chm-lower">		
        <div class="chm-box">
            <h2>Adicione uma barra de cotações ao seu site.</h2>
            <p>Selecione uma das opções abaixo para começar.</p>
        </div>

        <?php if(!$soapActive){
            ?>
            <div class="chm-box error">
                <h2>Não foi possível encontrar a extensão: Soap</h2>
                <p>Para saber mais <a href="#">clique aqui</a> e veja como ativar a extensão em seu servidor de hospedagem.</p>
                <span>A extensão é indispensável para o uso do plugin.</span>
            </div>
            <?php
        }else {
            ?>

            <form method="post" name="chm_options" action="options.php">
                <div class="chm-boxes">
                    <div class="chm-box">
                        <h3><?php echo esc_html('Ativar a cotação'); ?></h3>
                        <?php
                            //Grab all options
                            $options = get_option($this->plugin_name);

                            // CHM Active
                            $active = $options['active'];

                            // CHM Currencies
                            $usd = $options['usd']; 
                            $eur = $options['eur'];
                            $jpy = $options['jpy']; 

                            // CHM Customization
                            $item_background_color = $options['item_background_color'];
                            $plugin_background_color = $options['plugin_background_color'];

                        ?>

                        <?php 
                            settings_fields($this->plugin_name);
                            do_settings_sections($this->plugin_name); 
                        ?>
                        <div class="box-currencies">
                            <!-- USD -->
                            <fieldset>
                                <legend class="screen-reader-text"><span>Ativar</span></legend>
                                <label for="<?php echo $this->plugin_name; ?>-cmh">
                                    <input type="checkbox" id="<?php echo $this->plugin_name; ?>-cmh" name="<?php echo $this->plugin_name; ?>[active]" value="1" <?php checked($active, 1); ?>/>
                                    <span><?php esc_attr_e('Ativar', $this->plugin_name); ?></span>
                                </label>
                            </fieldset>


                            <h4><?php echo esc_html('Escolha as moedas'); ?></h4>
                            <!-- USD -->
                            <fieldset>
                                <legend class="screen-reader-text"><span>Dólar (Ptax)</span></legend>
                                <label for="<?php echo $this->plugin_name; ?>-cmh">
                                    <input type="checkbox" id="<?php echo $this->plugin_name; ?>-cmh" name="<?php echo $this->plugin_name; ?>[usd]" value="1" <?php checked($usd, 1); ?>/>
                                    <span><?php esc_attr_e('Dólar (Ptax)', $this->plugin_name); ?></span>
                                </label>
                            </fieldset>

                            <!-- EUR -->
                            <fieldset>
                                <legend class="screen-reader-text"><span>Euro (Ptax)</span></legend>
                                <label for="<?php echo $this->plugin_name; ?>-chm">
                                    <input type="checkbox" id="<?php echo $this->plugin_name; ?>-chm" name="<?php echo $this->plugin_name; ?>[eur]" value="1" <?php checked($eur, 1); ?>/>
                                    <span><?php esc_attr_e('Euro (Ptax)', $this->plugin_name); ?></span>
                                </label>
                            </fieldset>

                            <!-- JPY -->
                            <fieldset>
                                <legend class="screen-reader-text"><span>Iene</span></legend>
                                <label for="<?php echo $this->plugin_name; ?>-chm">
                                    <input type="checkbox" id="<?php echo $this->plugin_name; ?>-chm" name="<?php echo $this->plugin_name; ?>[jpy]" value="1" <?php checked($jpy, 1); ?>/>
                                    <span><?php esc_attr_e('Iene', $this->plugin_name); ?></span>
                                </label>
                            </fieldset>
                        </div>     
                    </div>

                    <div classes="cmh-boxes">
                        <div class="chm-box">
                            <h3><?php echo esc_html('ShortCode'); ?></h3>
                            <p>Copie o código abaixo e adicione onde quiser. Widgets, Páginas ou Postagens</p>
                            <textarea id="shortcode" class="large-text" cols="80" rows="10">[short-cotacao]</textarea><br>
                            <div class="tooltip">
                                <button class="copy-button" onclick="copyToClipBoard()" onmouseout="outFunc()">Copiar</button>
                                    <span class="tooltiptext" id="myTooltip">Copiar</span>
                                </button>
                            </div>  
                        </div>
                    </div>


                    <div class="chm-boxes">
                        <div class="chm-box">
                        <h3><?php echo esc_html('Customizar'); ?></h3>
                            <div class="box-customizations">
                                <!-- backgroud color para os itens Compra e Venda -->
                                <fieldset >
                                    <span>Cor de Destaque dos itens Compra e Venda</span>
                                    <label for="<?php echo $this->plugin_name;?>-item_background_color">
                                        <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo $this->plugin_name;?>-item_background_color" name="<?php echo $this->plugin_name;?>[item_background_color]"  value="<?php echo $item_background_color;?>"  />
                                    </label>
                                </fieldset>

                                <!-- backgroud color para a barra  -->
                                <fieldset>
                                    <span>Cor de Fundo para a barra</span>
                                    <label for="<?php echo $this->plugin_name;?>-plugin_background_color">
                                        <input type="text" class="<?php echo $this->plugin_name;?>-color-picker" id="<?php echo $this->plugin_name;?>-plugin_background_color" name="<?php echo $this->plugin_name;?>[plugin_background_color]" value="<?php echo $plugin_background_color;?>" />
                                    </label>
                                    
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="btn-save">
                        <?php submit_button('Salvar configurações', 'primary','submit', TRUE); ?>
                    </div>
                </div>
            </form>
            <?php
        } ?>
    </div>
</div>

<script>
    function copyToClipBoard() {
        event.preventDefault();
        /* Pegar texto */
        var copyText = document.getElementById("shortcode");
        /* Seleciona o texto */
        copyText.select();
        /* Copia o texto do campo */
        document.execCommand("copy");
        
        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "Copiado: " + copyText.value;
    }

    function outFunc() {
        var tooltip = document.getElementById("myTooltip");
        tooltip.innerHTML = "Copiar para área de transferência";
    }
</script>