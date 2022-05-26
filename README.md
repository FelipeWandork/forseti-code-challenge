# SISTEMA DE WEB SCRAPING - ReadNews
Esta aplicação puxa os dados do website https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=0 e os armazena inicialmente em um banco de dados.
Apesar da aplicação ter um propósito inicial com data de encerramento, será dada sequência ao desenvolvimento do projeto, a fim de experimentar novas técnicas e ferramentas neste tipo de ação.


## MODO DE INSTALAÇÃO
1) A base de dados (estrutura + dados) está no diretório "documentação" e para instalá-la, importe o arquivo "forseti.sql".

Usuário do banco: forseti
Password do banco: RJ-2022@forseti

2) Para inserção dos dados foi utilizado um gerador de ID, evitando números sequenciais como chave primária.

2) Para desenvolvimento foi utilizada plataforma WAMPServer que já disponibilizou a infraestrutura necessária para desenvolvimento e testagens do sistema.

3) Todo diretório deve ser clonado (copiado) para a raiz do servidor web (e.g. Apache).

4) Primeira execução:

	Quando executado a primeira vez, se a base de dados estiver vazia o sistema irá buscar todas as notícias (title, link, date, hour) das 5 (cinco) primeiras páginas, gerar um UUID e popular a base de dados.
	Caso o banco já possua algum conteúdo, o sistema irá verificar qual a notícia mais recente da base, comparar com as notícias do website e só adicionar as notícias novas, desse jeito cada usuário que acessar o sistema estará acionando a atualização dos dados.

5) Funcionamento
	index.php
	O arquivo index.php é quem aciona o sistema, direcionando qualquer chamada para o controlador NavController.php.
	
	NavController.php
	Este arquivo verifica a origem da chamada e só aceita chamadas vindas do host que está armazenado na constante HOST.
	Caso o host não coincida com a constante HOST, ou a página não exista, a navegação será direcionada para o arquivo "not_found.html". Caso tudo esteja certo, a navegação será direcionada para a rota "scraping".
	
	Scraping.php
	Este é o arquivo principal do sistema.
	O sistema já começa a operar direto no método construtor com as seguintes atividades:
	- carrega o DOM das 5 páginas;
	- organiza os dados requeridos em 2 arrays (dom e xpath);
	- captura as informações desejadas e armazena nas variáveis com nomes das tags de origem (tagsA e tagsSpan);
	- através do método toReadTags os 4 itens solicitados são organizados em objetos separados (titles, links, dates, hours);
	- quando estas etapas são concluídas o sistema preenche toda a base de dados, ou apenas atualiza.
	
	
	

RETORNO
O sistema foi desenvolvido apenas para o back-end da aplicação, então ele retorna um objeto JSON, inicialmente com todos os dados da base de dados, já que por enquanto são apenas 150 notícias.