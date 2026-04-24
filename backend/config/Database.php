<?php
// =============================================================================
// 📁 ARQUIVO: backend/config/Database.php
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É a classe responsável por CONECTAR o PHP ao banco de dados MySQL.
//   Toda vez que qualquer parte do sistema precisar falar com o banco,
//   ela vai passar por aqui.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Centralizar a conexão com o banco em UM lugar só.
//   Sem isso, cada arquivo teria que escrever o código de conexão do zero,
//   repetindo host, user, senha... Se mudar a senha, teria que mudar em
//   todos os arquivos. Com essa classe, muda em um lugar só.
//
// ▸ O QUE PRECISO FAZER AQUI?
//   1. Criar uma classe chamada "Database"
//   2. Criar um método estático chamado "getConnection()"
//   3. Dentro dele:
//      - Ler as variáveis de ambiente (DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS)
//        usando a função getenv() do PHP
//      - Criar uma conexão com o MySQL usando a classe "mysqli" do PHP
//        Exemplo conceitual: new mysqli(host, user, senha, banco, porta)
//      - Verificar se a conexão deu certo (checar connect_error)
//      - Definir o charset como utf8mb4 (para suportar acentos e emojis)
//      - Retornar o objeto de conexão
//   4. Usar o padrão SINGLETON: guardar a conexão numa variável estática
//      para que, se chamarem getConnection() duas vezes, retorne a MESMA
//      conexão ao invés de abrir uma nova.
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - PHP OOP (classes, métodos estáticos, propriedades estáticas)
//   - Padrão de projeto Singleton (o que é, por que usar)
//   - Extensão mysqli do PHP (como conectar ao MySQL)
//   - Variáveis de ambiente no PHP (getenv, putenv)
//   - Charset UTF-8 e utf8mb4 (por que usar, diferença entre eles)
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Criar um arquivo temporário que chama Database::getConnection()
//   e faz um SELECT simples (ex: SELECT 1). Se não der erro, a conexão
//   está funcionando.
//
// ▸ DICA:
//   As variáveis de ambiente são carregadas no index.php a partir do
//   arquivo .env. Então este arquivo depende do index.php ter rodado antes.
// =============================================================================
