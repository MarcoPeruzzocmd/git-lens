<?php
// =============================================================================
// 📁 ARQUIVO: backend/repositories/AnalysisRepository.php
// =============================================================================
//
// ▸ O QUE É ESTE ARQUIVO?
//   É o REPOSITORY — a camada que fala diretamente com o banco de dados.
//   Toda query SQL do projeto fica concentrada aqui.
//   Nenhum outro arquivo do projeto deve escrever SQL.
//
// ▸ QUAL A FUNÇÃO DELE NO PROJETO?
//   Quando o Controller quer salvar uma análise ou buscar o histórico,
//   ele chama ESTE arquivo. Este arquivo monta a query SQL, executa
//   no banco, e retorna os dados prontos como array PHP.
//
// ▸ POR QUE SEPARAR O SQL NUM ARQUIVO SÓ?
//   Se amanhã você trocar MySQL por PostgreSQL, ou por um banco NoSQL,
//   só precisa mudar ESTE arquivo. O resto do sistema nem percebe.
//   Isso se chama "separação de responsabilidades".
//
// ▸ O QUE PRECISO FAZER AQUI?
//
//   1. CONSTRUTOR: __construct()
//      - Chamar Database::getConnection() para pegar a conexão MySQL
//      - Guardar numa propriedade da classe (ex: $this->db)
//
//   2. MÉTODO: save($owner, $repo, $stats, $totalCommits, $branch)
//      O que faz: Salva uma nova análise no banco.
//      Como fazer:
//        a) Preparar um INSERT com prepared statements (NUNCA concatenar variáveis no SQL!)
//           Query: INSERT INTO analyses (owner, repo, stats, total_commits, branch) VALUES (?, ?, ?, ?, ?)
//        b) Converter o array $stats para JSON usando json_encode()
//        c) Vincular os parâmetros com bind_param()
//           Os tipos são: s=string, i=inteiro → "sssis"
//        d) Executar com execute()
//        e) Retornar o ID gerado (insert_id)
//
//   3. MÉTODO: findAll($limit)
//      O que faz: Busca todas as análises salvas (resumo, sem o JSON pesado).
//      Como fazer:
//        a) SELECT id, owner, repo, total_commits, branch, created_at FROM analyses
//        b) ORDER BY created_at DESC (mais recente primeiro)
//        c) LIMIT ? (para não trazer milhares de registros)
//        d) Iterar com fetch_assoc() e montar um array
//        e) Retornar o array
//
//   4. MÉTODO: findById($id)
//      O que faz: Busca UMA análise específica com todos os dados.
//      Como fazer:
//        a) SELECT * FROM analyses WHERE id = ?
//        b) Se não encontrar, retornar null
//        c) Se encontrar, decodificar o campo "stats" de JSON para array
//           usando json_decode($row['stats'], true)
//        d) Retornar o array completo
//
// ▸ SEGURANÇA — PREPARED STATEMENTS (MUITO IMPORTANTE!):
//   NUNCA faça isso: "SELECT * FROM analyses WHERE id = $id"
//   Isso permite SQL INJECTION (um ataque onde alguém injeta SQL malicioso).
//   SEMPRE use prepared statements com ? e bind_param().
//   Isso é a regra #1 de segurança em banco de dados.
//
// ▸ CONCEITOS QUE PRECISO ESTUDAR:
//   - SQL básico (INSERT, SELECT, WHERE, ORDER BY, LIMIT)
//   - Prepared Statements no PHP (prepare, bind_param, execute)
//   - SQL Injection (o que é, por que é perigoso, como prevenir)
//   - Padrão Repository (separar acesso a dados da lógica de negócio)
//   - JSON no PHP (json_encode para salvar, json_decode para ler)
//   - mysqli no PHP (get_result, fetch_assoc, insert_id)
//
// ▸ COMO TESTAR SE FUNCIONA?
//   - Chamar save() com dados fake e verificar se aparece no banco
//     (usar phpMyAdmin ou MySQL CLI para conferir)
//   - Chamar findAll() e ver se retorna os registros
//   - Chamar findById() com um ID que existe e um que não existe
//   - Tentar injetar SQL no ID para confirmar que prepared statements protegem
//
// ▸ DICA:
//   Este arquivo depende do Database.php estar funcionando.
//   Implemente e teste o Database.php primeiro.
// =============================================================================
