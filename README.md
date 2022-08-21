## Sobre a API Contato seguro

Api é uma lista de contatos e empresas que possui filtros intuitivos, serviço de validação de CNPJ: o serviço utiliza algumas apis de verificação de CNPJ e retorna as informações da empresa.


## Configuração
### Executar o docker
```
docker-compose up
```

### Instalando as dependências do composer
Executar o comando dentro do container da api
```
composer install
```

### Gerar chave
Executar o comando dentro do container da api
```
php artisan key:generate
```


### Gerar banco de dados 
O dump do banco vai dentro da migration, ao rodar o comando será gerado o banco de dados e os dados.  
Executar o comando dentro do container da api
```
php artisan migrate
```

### Executar os tests
Executar o comando dentro do container da api
```
php artisan test
```

# Resposta do participante

### Sobre o Banco de dados
Escolhi o mysql porque tenho mais experiência com ele, mas possuo conhecimentos em outros banco de dados, por exemplo: postgreSQL e mongoDB.

### Soluções
Fiz um serviço de verificação de CNPJ, este serviço utilizar 3 apis diferentes para verificar o cnpj e retorna as seguintes informações : Situação da empresa, nome, nome fantasia, porte da empresa, abertura, atividade principal e atividade secundaria.

### dificuldades
Por falta de tempo fiz um teste bem simples, somente testando o CRUD. Mas gostaria de ter feito um teste mais completo, utilizando todo o conceito de TDD.