## 🏆 awards

| Campo               | Tipo          | Restrições | Descrição                               |
|---------------------|---------------|------------|-----------------------------------------|
| id                  | BIGINT        | PK         | Identificador da premiação              |
| name                | VARCHAR(255)  | NOT NULL   | Nome da premiação                       |
| year                | INT           | NOT NULL   | Ano da premiação                        |
| voting_start_date   | DATETIME      | NOT NULL   | Início da votação                       |
| voting_end_date     | DATETIME      | NOT NULL   | Fim da votação                          |
| status              | ENUM          | NOT NULL   | `draft`, `active`, `voting`, `finished` |
| created_at          | TIMESTAMP     |            | Criado em                               |
| updated_at          | TIMESTAMP     |            | Atualizado em                           |

### **Relacionamentos**
- **Possui muitas** `categories` (1:N)
- **Possui muitos** `jury_members` (1:N)


## 🗂️ categories

| Campo                   | Tipo          | Restrições            | Descrição                              |
|-------------------------|---------------|-----------------------|----------------------------------------|
| id                      | BIGINT        | PK                    | Identificador da categoria             |
| award_id                | BIGINT        | FK → awards.id        | Premiação associada                    |
| name                    | VARCHAR(255)  | NOT NULL              | Nome da categoria                      |
| description             | TEXT          |                       | Descrição detalhada                    |
| type                    | ENUM          | NOT NULL              | `public_vote`, `quantitative`, `jury`, `mixed` |
| public_vote_weight      | INT           | DEFAULT 0             | Peso do voto público (%)               |
| quantitative_weight     | INT           | DEFAULT 0             | Peso quantitativo (%)                  |
| jury_weight             | INT           | DEFAULT 0             | Peso do júri (%)                       |
| order                   | INT           |                       | Ordem de exibição                      |
| created_at              | TIMESTAMP     |                       | Criado em                              |
| updated_at              | TIMESTAMP     |                       | Atualizado em                          |

**Regra:** a soma dos pesos deve ser **100%**

### **Relacionamentos**
- **Pertence a** `awards` (N:1)
- **Possui muitos** `nominees` (1:N)
- **Possui muitos** `votes` (1:N)
- **Possui muitos** `jury_votes` (1:N)



## 👤 nominees

| Campo                     | Tipo           | Restrições             | Descrição                          |
|---------------------------|----------------|------------------------|------------------------------------|
| id                        | BIGINT         | PK                     | Identificador do indicado          |
| category_id               | BIGINT         | FK → categories.id     | Categoria                          |
| user_id                   | BIGINT         | FK → users.id          | Usuário indicado                   |
| quantitative_description  | TEXT           | NULL                   | Justificativa                      |
| quantitative_value        | DECIMAL(10,2)  | NULL                   | Valor quantitativo                 |
| created_at                | TIMESTAMP      |                        | Criado em                          |
| updated_at                | TIMESTAMP      |                        | Atualizado em                      |

**Índice único:** `(category_id, user_id)`

### **Relacionamentos**
- **Pertence a** `categories` (N:1)
- **Pertence a** `users` (N:1)
- **Possui muitos** `votes` (1:N)
- **Possui muitos** `jury_votes` (1:N)



## 🗳️ votes

| Campo       | Tipo         | Restrições            | Descrição                            |
|-------------|---------------|------------------------|------------------------------------|
| id          | BIGINT        | PK                     | Identificador do voto              |
| nominee_id  | BIGINT        | FK → nominees.id       | Indicado votado                    |
| user_id     | BIGINT        | FK → users.id          | Usuário votante                    |
| category_id | BIGINT        | FK → categories.id     | Categoria                          |
| ip_address  | VARCHAR(45)   |                        | IP do votante                      |
| created_at  | TIMESTAMP     |                        | Data do voto                       |
| updated_at  | TIMESTAMP     |                        | Atualizado em                      |

**Índice único:** `(user_id, category_id)`

### **Relacionamentos**
- **Pertence a** `nominees` (N:1)
- **Pertence a** `users` (N:1)
- **Pertence a** `categories` (N:1)



## 🎓 jury_members

| Campo      | Tipo      | Restrições          | Descrição               |
|------------|-----------|---------------------|-------------------------|
| id         | BIGINT    | PK                  | Identificador           |
| award_id   | BIGINT    | FK → awards.id      | Premiação               |
| user_id    | BIGINT    | FK → users.id       | Usuário jurado          |
| created_at | TIMESTAMP |                     | Criado em               |
| updated_at | TIMESTAMP |                     | Atualizado em           |

**Índice único:** `(award_id, user_id)`

### **Relacionamentos**
- **Pertence a** `awards` (N:1)
- **Pertence a** `users` (N:1)
- **Possui muitos** `jury_votes` (1:N)


## 📝 jury_votes

| Campo           | Tipo      | Restrições                 | Descrição              |
|-----------------|-----------|----------------------------|------------------------|
| id              | BIGINT    | PK                         | Identificador          |
| jury_member_id  | BIGINT    | FK → jury_members.id       | Membro do júri         |
| nominee_id      | BIGINT    | FK → nominees.id           | Indicado               |
| category_id     | BIGINT    | FK → categories.id         | Categoria              |
| score           | INT       | CHECK (0–10)               | Nota do jurado         |
| created_at      | TIMESTAMP |                            | Data da avaliação      |
| updated_at      | TIMESTAMP |                            | Atualizado em          |

**Índice único:** `(jury_member_id, nominee_id)`

### **Relacionamentos**
- **Pertence a** `jury_members` (N:1)
- **Pertence a** `nominees` (N:1)
- **Pertence a** `categories` (N:1)
