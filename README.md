# Projeto Mosyle Campinas

O objetivo deste projeto é criar APIs REST utilizando PHP "puro", ou seja, sem a utilização de nenhum framework/plugin.

## Melhorias
Com o objetivo deixar o projeto o mais simples possível, não foi implementados todos os recursos que pensei para a aplicação. Segue algumas sugestões de melhorias:

- Tendo em vista que o token do usuário já possui o ID do mesmo e as APIs de edição e remoção são restritas ao usuário logado, é desnecessário ter o id na URL das mesmas;
- Validar a data do token e expirá-lo em "x" tempo;
- Implementar encriptação com hash no token;
- Validar se usuário existe em AuthHelper::validateAndReturnToken().

## APIs Disponíveis
| Endpoint | Método | Parâmetros | Descrição
| ------------ | ------------ | ------------ | ------------ |
| /users  | POST | users (string), name (string), password (string)  | Insere um novo usuário
| /login  | POST | email (string), password (string)  | Faz o login do usuário
| /users/:iduser | GET | - | Retorna os dados do usuário informado na url
| /users | GET | - | Retorna todos os usuários do sistema
| /users/:iduser | PUT | email (string), name (string), password (string)  | Edita o usuário logado
| /users/:iduser | DELETE | - | Remove o usuário logado
| /users/:iduser/drink | POST | drink_ml (int) | Registra nova bebida de água do usuário
| /users/:iduser/drink | GET | - | Retorna todos os registros de bebida de água do usuário
| /ranking | GET | - | Retorna o ranking (por ml) do dia atual dos usuários que mais beberam água
