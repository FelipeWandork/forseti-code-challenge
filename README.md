# SISTEMA DE WEB SCRAPING - ReadNews
Esta aplicação puxa os dados do website https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=0 e os armazena inicialmente em um banco de dados.
Apesar da aplicação ter um propósito inicial com data de encerramento, será dada sequência ao desenvolvimento do projeto, a fim de experimentar novas técnicas e ferramentas neste tipo de ação.
Para o futuro, a intenção é criar um sistema que faça o scraping de qualquer website com poucas configurações.

> :construction: Projeto em construção :construction:

### MODO DE INSTALAÇÃO
1. A base de dados (estrutura + dados) está no diretório "documentação" e para instalá-la, importe o arquivo "database.sql".

2. Preencha os detalhes do seu banco no arquivo `app\database\Database.php`.

3. Na inserção dos dados foi utilizado um gerador de ID, evitando números sequenciais como chave primária.

4. Para desenvolvimento foi utilizada plataforma WAMPServer que já disponibilizou a infraestrutura necessária para desenvolvimento e testagens do sistema.

5. Todo diretório deve ser clonado (copiado) para a raiz do servidor web (e.g. Apache).

### PRIMEIRA EXECUÇÃO
Quando executado a primeira vez, se a base de dados estiver vazia o sistema irá buscar todas as notícias (title, link, date, hour) das 5 (cinco) primeiras páginas, gerar um UUID e popular a base de dados. Caso o banco já possua algum conteúdo, o sistema irá verificar qual a notícia mais recente da base, comparar com as notícias do website e só adicionar as notícias novas, desse jeito cada usuário que acessar o sistema estará acionando a atualização dos dados.

### FUNCIONAMENTO

`index.php`: o arquivo index.php é quem aciona o sistema, direcionando qualquer chamada para o controlador NavController.php.
	
`NavController.php`: verifica a origem da chamada e só aceita chamadas vindas do host que está armazenado na constante HOST. Caso o host não coincida com a constante HOST, ou a página não exista, a navegação será direcionada para o arquivo "not_found.html". Caso tudo esteja certo, a navegação será direcionada para a rota "scraping".

`Routes.php`: de acordo com a tomada de decisão do arquivo "NavController.php", este arquivo irá direcionar o sistema. Por enquanto ele só tem 2 opções em funcionamento: scraping() e not_found();
	
`Scraping.php`: este é o arquivo principal do sistema.
	O sistema já começa a operar direto no método construtor com as seguintes atividades:
	- carrega o DOM das 5 páginas;
	- organiza os dados requeridos em 2 arrays (dom e xpath);
	- captura as informações desejadas e armazena nas variáveis com nomes das tags de origem (tagsA e tagsSpan);
	- através do método toReadTags os 4 itens solicitados são organizados em objetos separados (titles, links, dates, hours);
	- quando estas etapas são concluídas o sistema preenche toda a base de dados, ou apenas atualiza.

`TagsToDatabase.php`: este arquivo faz o papel de ponte entre o arquivo "Scraping.php" e 	o arquivo "Database.php". Ele é responsável por definir os parâmetros que serão enviados para as querys do arquivo "Database.php". Nele podem ser acrescentados quantos métodos forem necessários para solicitar ações na base de dados. Fazendo assim, o arquivo "Database.php" nunca precisará ser alterado.

`TagsToDatabase.php`: ainda não está implementado, mas será o responsável por armazenar os dados em um arquivo .CSV.

`Database.php`: é responsável por executar as querys na base de dados. Ele já está construído para executar qualquer ação padrão de acesso a base de dados (CRUD). Para que ele funcione corretamente, através do arquivo "TagsToDatabase", ou outro que instancie a classe Database, basta definir corretamente as variáveis WHERE, ORDER, LIMIT e FIELDS e enviá-las ao método que deseja executar na classe Database.

`Uuid.php`: gerador de código Universally Unique Identifier (UUID) para ser inserido na base de dados.

No diretório `view` está uma estrutura padrão que sempre utilizo nos meus projetos em PHP, e mesmo ainda não precisando desta estrutura, preferi fazê-la desse jeito para que fique pronta para a evolução do projeto.
	

### RETORNO
O sistema foi desenvolvido apenas para o back-end da aplicação, então ele retorna um objeto JSON com as 150 notícias do website https://www.gov.br/compras/pt-br/acesso-a-informacao/noticias?b_start:int=0 
