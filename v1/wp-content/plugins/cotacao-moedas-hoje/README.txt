=== Cotação Moedas ===
Contributors: migueldaipre
Tags: cotação, cotação moedas, dólar hoje, euro hoje, iene hoje, ptax
Donate link: www.migueldaipre.com.br
Requires at least: 3.0.1
Tested up to: 5.1
Requires PHP: 5.6
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Cotação do Dólar, Euro e Iene em relação ao Real (R$). Todos os dados são buscados do Banco Central do Brasil diariamente pelo Web Service.

== Description ==
Tenha a Cotação do Dólar, Euro e Iene diretamente no cabeçalho do seu site ou utilize o shortcode para adicionar a cotação em qualquer lugar do seu site. É possível escolher as moedas que serão mostradas, as informações de preços são obtidos diariamente do Banco Central do Brasil, é mostrado tanto o valor de compra como o valor de venda da moeda em relação ao Real (R$).
Novas moedas serão adicionadas. Aguarde atualizações

== Installation ==
1. Baixe o arquivo compactado do plugin
 1.1 - Faça o Upload do plugin pelo painel de administrador -> Vá até: Plugins -> Adicionar Novo -> Fazer Upload do Plugin (compactado);
 1.2 - Faça o Upload do plugin via FTP ->  Descompacte o plugin e envie a pasta do Plugin para o diretório \'wp-content/plugins/\';

2. Ativar o plugin no Wordpress
 2.1 Vá até Plugins, clique em Ativar no item Cotação de Moedas Hoje

3. Ative a cotação no painel de configurações do Plugin
 3.1 - Vá até Configurações -> Cotação Moedas.
 3.2 - Selecione a opção Ativar e selecione qual ou quais moeda(s) você quer mostrar.
 3.3 - Clique em Salvar configurações.

4. É possível customizar a exibição do plugin no site
 4.1 - Vá até Configurações -> Cotação Moedas.
 4.2 - No Box Customizar é possível escolher a cor de fundo para o Item escrito Compra e Venda e
também é possível customizar o fundo da barra total do plugin. 


== Frequently Asked Questions ==
= Qual é a fonte de informação (Cotações) =
As cotações são obtidas diretamente do Site do Banco Central do Brasil através de um WebService.

= A atualização dos dados é feita com qual frequência? =
Diariamente, os valores das cotações são obtidos automaticamente do WebService do Banco Central do Brasil, 
no caso do Final de Semana ou Feriados o valor retornado é do último dia válido. 

= É necessário pagar para utilizar o plugin? =
Não, ele é totalmente gratuito. Favor referenciar o desenvolvedor do plugin em algum momento no seu website.

= Estou com dúvidas ou gostaria de entrar em contato, para quem devo escrever? =
R.: contato@migueldaipre.com.br

== Screenshots ==

1. Aparência do plugin no topo da página após ser ativado, as cores podem ser alteradas conforme o gosto pessoal.
2. Aparência do ShortCode do plugin, pode ser adicionado nos Widgets ou nas páginas e postagens.
3. Exemplo do ShortCode nos Widgets, usar o mesmo código para postagens e páginas.
4. Painel do plugin onde é possível Ativar a exibição das cotações e escolher quais moedas serão mostradas. (Novas moedas serão adicionadas em breve)
5. Painel do plugin onde é possível copiar o ShortCode e alterar as cores do plugin, alterando a cor de destaque e a cor de background.

== Changelog ==

= 1.0.2 = 

Adicionado verificação e mensagem personalizada caso ocorra algum erro com o Web Service do Banco do Brasil.

= 1.0.1 = 

Correção do erro de inicialização do SOAP com SSL 

== Upgrade Notice ==

= 1.0.1 =