<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.migueldaipre.com.br
 * @since      1.0.0
 *
 * @package    Cmh_Bcb
 * @subpackage Cmh_Bcb/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cmh_Bcb
 * @subpackage Cmh_Bcb/public
 * @author     Miguel Ninno Daipré <contato@migueldaipre.com.br>
 */
class Cmh_Bcb_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->wp_cmh_options = get_option($this->plugin_name);
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cmh_Bcb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cmh_Bcb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/cmh-bcb-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cmh_Bcb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cmh_Bcb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cmh-bcb-public.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Registers all shortcodes at once
	 *
	 * @return [type] [description]
	 */
	public function register_shortcodes() {
		add_shortcode('short-cotacao', array( $this, 'shortcode_cotacao'));
	} // register_shortcodes()

    /**
     * cmh functions depending on each checkbox returned value in admin
     *
     * @since    1.0.0
     */

	// Cmh insert in body
	public function wp_cmh_cotacao(){
		if($this->wp_cmh_options['active']){
			$arrayFINAL = $this->cmh_cotacao_hoje();
			?>
			<div class="ticker-financial-market">
				<div class="ticker-slide">
				<section class="currencies"> 
					<?php
						foreach($arrayFINAL as $valorFinal){
							?>
							<div class="info">
								<a href="https://www.bcb.gov.br/" target="_blank">
									<span class="name"><?= $valorFinal[0]; ?></span>
									<div class="numbers"><span class="data">Compra</span><span class="value bra"><?= $valorFinal[2]; ?></span></div>
								</a>
							</div>
							<?php
						}          
					?>                   
				</section>
				</div>
			</div>
			<?php
		}
	}


    public function cmh_cotacao_hoje() {
		if($this->wp_cmh_options['active']){
			if($this->wp_cmh_options['usd'] == 1 || $this->wp_cmh_options['eur'] == 1 || $this->wp_cmh_options['jpy'] == 1 ){
				
				$usdActived = $this->wp_cmh_options['usd'];
				$eurActived = $this->wp_cmh_options['eur'];
				$jpyActived = $this->wp_cmh_options['jpy'];

				
				if($usdActived){
					$MOEDAS["USD"] = array("1", "10813");
					$arrayFINAL["USD"][] = "Dólar(PTAX)";
				}

				if($eurActived){
					$MOEDAS["EUR"] = array("21619","21620");
					$arrayFINAL["EUR"][]  = "Euro(PTAX)";
				}
				
				if($jpyActived){
					$MOEDAS["IENE"] = array("21621", "21622");
					$arrayFINAL["JPY"][]  = "Iene";
				}
				
				// vamos evitar que o arquivo WSDL seja colocado no cache
				ini_set("soap.wsdl_cache_enabled", "0");
				ini_set('soap.wsdl_cache_ttl',0);
				ini_set('default_socket_timeout', 5000);

				$options = array(
					'cache_wsdl' => 0,
					'trace' => false,
					'exceptions' => true,
					'stream_context' => stream_context_create(array(
						  'ssl' => array(
							   'verify_peer' => true,
								'verify_peer_name' => true,
								'allow_self_signed' => true
						  )
					))
				);

				try {
					$WsSOAP = new SoapClient("https://www3.bcb.gov.br/sgspub/JSP/sgsgeral/FachadaWSSGS.wsdl", $options);
					foreach($MOEDAS as $MOEDA){
						for ($i=0; $i < count($MOEDA) ; $i++) { 
							$arrayBusca[] = $MOEDA[$i];
						} 
					}

					try {
						$resultadoSingle = $WsSOAP->getUltimoValorXML("1");
						$DataUltimaMoedaSingle = simplexml_load_string($resultadoSingle);
					} catch (SoapFault $e) {
						echo 'Desculpe, não possível recuperar os dados no momento.';
						return;
					}					
					
					
					$dia = $DataUltimaMoedaSingle->SERIE->DATA->DIA;
					$mes = $DataUltimaMoedaSingle->SERIE->DATA->MES;
					$ano = $DataUltimaMoedaSingle->SERIE->DATA->ANO;
					
			
					$DATABUSCA = "".$dia."/".$mes."/".$ano."";
					// Passa o array de CODIGOS, DATA de Inicio e DATA de fim vindo da ultima consulta do próprio webservice
					$ResultadoPesquisaWS = $WsSOAP->getValoresSeriesXML($arrayBusca, $DATABUSCA, $DATABUSCA);   
					
					if (isset($ResultadoPesquisaWS)) { 
						$CotacaoMoedaWS = simplexml_load_string($ResultadoPesquisaWS);
			
						foreach($CotacaoMoedaWS->SERIE as $valor){
							if($valor->attributes()->ID == 1 || $valor->attributes()->ID == 10813){
								$arrayFINAL["USD"][] = number_format((float)$valor->ITEM->VALOR,4,',','.');
							}else if($valor->attributes()->ID == 21619 || $valor->attributes()->ID == 21620){
								$arrayFINAL["EUR"][] = number_format((float)$valor->ITEM->VALOR,4,',','.');
							}else if($valor->attributes()->ID == 21621 || $valor->attributes()->ID == 21622){
								$arrayFINAL["JPY"][] = number_format((float)$valor->ITEM->VALOR,4,',','.');
							}
						}
						
						return $arrayFINAL;

					} else {
						exit('Falha ao abrir XML do BCB.');
					}
					
				} catch (SoapFault $e ) {
					echo 'Desculpe, não possível recuperar os dados no momento.';
					return;
				}
			}			
		}	
	}
	
	// Get Background color is set and different from #fff return it's css
    public function wp_cmh_item_background_color(){
		if(isset($this->wp_cmh_options['item_background_color']) && !empty($this->wp_cmh_options['item_background_color']) ){
			$item_background_color_css  = ".ticker-financial-market .ticker-slide .info .data { background:".$this->wp_cmh_options['item_background_color']."!important;}";
			return $item_background_color_css;
		}
	}

	// Get Background color is set and different from #fff return it's css
    public function wp_cmh_plugin_background_color(){
		if(isset($this->wp_cmh_options['plugin_background_color']) && !empty($this->wp_cmh_options['plugin_background_color']) ){
			$plugin_background_color  = ".ticker-financial-market{background:".$this->wp_cmh_options['plugin_background_color']."!important;}";
			return $plugin_background_color;
		}
	}

	public function wp_cmh_background_shortcode(){
		$shortcode_background_color = ".panel{background: linear-gradient(to left, ".$this->sass_lighten($this->wp_cmh_options['item_background_color'],10)." 0%, ".$this->sass_darken($this->wp_cmh_options['item_background_color'],10)." 100%) !important;}";
		return $shortcode_background_color;
	}

	// Write the actually needed css for login customizations
	public function wp_cmh_customization(){
		if($this->wp_cmh_item_background_color() != null || $this->wp_cmh_plugin_background_color() != null){
			echo '<style>';
			if($this->wp_cmh_item_background_color() != null){
				  echo $this->wp_cmh_item_background_color();
			}
			if($this->wp_cmh_plugin_background_color() != null){
				  echo $this->wp_cmh_plugin_background_color();
				  echo $this->wp_cmh_background_shortcode();
			}
			echo '</style>';
		}
	}

	/**
	 * Processes shortcode cotacao
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function shortcode_cotacao($atts = array()) {
		if($this->wp_cmh_options['active']){
			$arrayFINAL = $this->cmh_cotacao_hoje();
			ob_start();
			// Aqui acontece a magia do shortcode
			?>
			<div class="panel">
				<div class="panel-heading">
					<h4>Dólar do Dia</h4>
				</div>
				
				<table class="table meterReadingTable">
					<?php
						foreach($arrayFINAL as $valorFinal){
							?>
							<tr class="unionTableItems">
								<td class="meterReadings"><span class="meterEdit" >R$ <?= $valorFinal[1]; ?></span></td>
							</tr>	
							<?php
						}          
					?>       
				</table>
			</div>

			<?php
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		}
	} // list_openings()

	
	private function sass_lighten($hex, $percent) {
        preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors);
        str_replace('%', '', $percent);
        $color = "#";
        for($i = 1; $i <= 3; $i++) {
            $primary_colors[$i] = hexdec($primary_colors[$i]);
            $primary_colors[$i] = round($primary_colors[$i] * (100+($percent*2))/100);
            $color .= str_pad(dechex($primary_colors[$i]), 2, '0', STR_PAD_LEFT);
        }

        return $color;
	}
	
	private function sass_darken($hex, $percent) {
		preg_match('/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors);
		str_replace('%', '', $percent);
		$color = "#";
		for($i = 1; $i <= 3; $i++) {
			$primary_colors[$i] = hexdec($primary_colors[$i]);
			$primary_colors[$i] = round($primary_colors[$i] * (100-($percent*2))/100);
			$color .= str_pad(dechex($primary_colors[$i]), 2, '0', STR_PAD_LEFT);
		}

		return $color;
	}
}
