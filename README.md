Tabelas e Relacionamentos


Tabela marcas

id: Identificador único da marca.
nome: Nome da marca (único).
imagem: Logo da marca.
Tabela modelos

id: Identificador único do modelo.
marca_id: Relaciona o modelo a uma marca específica. (Chave estrangeira referenciando id da tabela marcas).
nome: Nome do modelo.
imagem: Imagem do modelo.
numero_portas: Número de portas do carro.
lugares: Número de lugares do carro.
air_bag: Indica se o modelo possui airbag.
abs: Indica se o modelo possui ABS.
Relacionamento:

Uma Marca pode ter vários Modelos (um para muitos).
Um Modelo pertence a uma Marca (muitos para um).





Tabela carros

id: Identificador único do carro.
modelo_id: Relaciona o carro a um modelo específico. (Chave estrangeira referenciando id da tabela modelos).
placa: Placa do carro.
ano: Ano de fabricação do carro.
cor: Cor do carro.
km: Quilometragem do carro.
status: Status do carro (disponível, alugado, etc.).
Relacionamento:

Um Modelo pode ter vários Carros (um para muitos).
Um Carro pertence a um Modelo (muitos para um).





Tabela clientes

id: Identificador único do cliente.
nome: Nome do cliente.
email: Email do cliente.
telefone: Telefone do cliente.






Tabela locacoes

id: Identificador único da locação.
cliente_id: Relaciona a locação a um cliente específico. (Chave estrangeira referenciando id da tabela clientes).
carro_id: Relaciona a locação a um carro específico. (Chave estrangeira referenciando id da tabela carros).
data_inicio_periodo: Data e hora de início da locação.
data_final_previsto_periodo: Data e hora previstas para o fim da locação.
data_final_realizado_periodo: Data e hora em que a locação realmente terminou.
valor_diaria: Valor da diária de locação.
km_inicial: Quilometragem do carro no início da locação.
km_final: Quilometragem do carro no final da locação.
Relacionamento:

Um Cliente pode ter várias Locacoes (um para muitos).
Um Carro pode estar envolvido em várias Locacoes (um para muitos).
Cada Locacao pertence a um Cliente e a um Carro (muitos para um).




Resumo Geral dos Relacionamentos
Marcas têm Modelos.
Modelos têm Carros.
Carros são Locados por Clientes.
Clientes podem fazer várias Locações.
Carros podem estar envolvidos em várias Locações.
Essa estrutura permite que você gerencie marcas e modelos de carros, controle o inventário de carros disponíveis, e rastreie as locações feitas pelos clientes.

https://chatgpt.com/share/e3ff1f91-64a1-4505-88e9-b7d966538ff1