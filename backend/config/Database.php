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
//   Sem isso, cada arquivo teria que escrever o código de conexão do zero.
//   Com essa classe, muda em um lugar só se precisar alterar algo.
//
// ▸ POR QUE PDO E NÃO mysqli?
//   PDO (PHP Data Objects) é uma camada de abstração — funciona com
//   MySQL, PostgreSQL, SQLite e outros. Se um dia trocar o banco,
//   muda só a string de conexão aqui, o resto do código não muda.
//   mysqli só funciona com MySQL.
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. Criar uma classe chamada "Database"
//
//   2. Criar uma propriedade estática privada para guardar a conexão:
//      private static ?PDO $connection = null;
//
//   3. Criar um método estático público chamado "getConnection()":
//      public static function getConnection(): PDO
//
//   4. Dentro do getConnection():
//
//      a) Se já existe conexão, retornar ela (padrão Singleton):
//         if (self::$connection !== null) return self::$connection;
//
//      b) Ler as variáveis de ambiente com getenv():
//         $host = getenv('DB_HOST');   → vem do .env, ex: "db"
//         $port = getenv('DB_PORT');   → vem do .env, ex: "3306"
//         $name = getenv('DB_NAME');   → vem do .env, ex: "gitlens"
//         $user = getenv('DB_USER');   → vem do .env, ex: "gitlens_user"
//         $pass = getenv('DB_PASS');   → vem do .env, ex: "gitlens_pass"
//
//      c) Montar a DSN (string de conexão do PDO):
//         $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
//         O charset=utf8mb4 garante suporte a acentos e emojis.
//
//      d) Criar a conexão PDO dentro de um try/catch:
//         try {
//             self::$connection = new PDO($dsn, $user, $pass, [
//                 PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//                 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//             ]);
//         } catch (PDOException $e) {
//             throw new Exception('Erro ao conectar ao banco: ' . $e->getMessage(), 500);
//         }
//
//         Explicando as opções:
//         - ERRMODE_EXCEPTION → lança exceção em caso de erro SQL (em vez de silenciar)
//         - FETCH_ASSOC       → resultados de SELECT vêm como array associativo
//                               ex: ['id' => 1, 'owner' => 'facebook']
//                               em vez de: [0 => 1, 'id' => 1, ...]
//
//      e) Retornar self::$connection
class Database {
    private static ?PDO $connection = null;
    public static function getConnection():PDO {
        if (self::$connection !== null) return self::$connection;
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $name = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $pass = getenv('DB_PASS');
        $dsn = "mysql:host=$host;port=$port;dbname=$name;charset=utf8mb4";
        try {
            self::$connection = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new Exception('Erro ao conectar ao banco: ' . $e->getMessage(), 500);
        }
        return self::$connection;
    }
}
//
// ▸ COMO USAR EM OUTROS ARQUIVOS:
//   $db = Database::getConnection();
//   $stmt = $db->prepare("SELECT * FROM analyses WHERE id = ?");
//   $stmt->execute([$id]);
//   $row = $stmt->fetch(); // retorna array associativo graças ao FETCH_ASSOC
//
// ▸ POR QUE SINGLETON?
//   Evita abrir múltiplas conexões com o banco na mesma requisição.
//   Toda vez que alguém chama getConnection(), recebe a MESMA conexão.
//   Conexões com banco são "caras" (custam tempo e memória), então
//   reutilizar a mesma é uma boa prática.
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - PDO no PHP (https://www.php.net/manual/pt_BR/book.pdo.php)
//   - DSN (Data Source Name) — string que identifica o banco e como conectar
//   - PDO::ATTR_ERRMODE e PDO::ERRMODE_EXCEPTION — tratamento de erros
//   - PDO::FETCH_ASSOC — formato dos resultados
//   - Padrão Singleton — o que é e por que usar
//   - Variáveis de ambiente no PHP (getenv)
//   - try/catch com PDOException
//
// ▸ COMO TESTAR SE FUNCIONA?
//   Adicionar temporariamente no index.php:
//     $db = Database::getConnection();
//     echo json_encode(["db" => "conectado!"]);
//   Se não der erro 500, a conexão está funcionando.
// =============================================================================
