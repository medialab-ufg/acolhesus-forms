Plugin WordPress para Formulários AcolheSUS-RHS
=============

### Instalação
Plugin utilizado apenas em conjunto com a [RHS](https://github.com/medialab-ufg/wp-rhs).

Adicione-o à pasta padrão de plugins do WordPress e ative no painel admin.

Além disso, é essencial que tenha o plugin [Caldera-Forms](https://wordpress.org/plugins/caldera-forms/) ativado.

### Ambiente de desenvolvimento (estilo CSS)
A partir da raiz do plugin, navegar para a seguinte pasta: `cd assets/sass/`.

Depois, basta deixar o [SASS](https://sass-lang.com/) observando as alterações no código fonte: 

`sass --watch index.scss:../css/acolhesus.css`

### Script para compilar sass
Opcionalmente, execute o arquivo `scripts/compile-sass.sh` para compilar o sass de uma única vez.

### Execução de testes unitários
Garanta que tenha o [phpunit](https://phpunit.de/) instalado em seu ambiente local, e execute-o na raiz do projeto.
