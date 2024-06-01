# Audio-Converter-PHP
Audio Converter

Este é um simples aplicativo web para converter arquivos de áudio para diferentes formatos usando PHP e FFmpeg.

Como Funciona
O aplicativo consiste em duas páginas:

1. index.php: Esta página exibe um formulário onde os usuários podem carregar um arquivo de áudio, escolher o formato de saída e fornecer um novo nome para o arquivo convertido. O formulário é estilizado usando CSS para uma melhor experiência do usuário.

2. convert.php: Esta página recebe os dados do formulário enviado pelo usuário, realiza a conversão do arquivo de áudio usando a biblioteca FFmpeg e fornece o arquivo convertido para download. Ele também usa PHP para lidar com a validação e processamento do formulário.

Requisitos
PHP (>= 5.6)
FFmpeg instalado no servidor

1. Clone este repositório em seu servidor web.
2. Certifique-se de que o servidor tenha o PHP e o FFmpeg instalados e configurados corretamente.
3. Acesse a página index.php em seu navegador.
4. Selecione um arquivo de áudio, escolha o formato de saída desejado e forneça um novo nome para o arquivo convertido.
5. Clique no botão "Convert Audio" para iniciar o processo de conversão.
6. Após a conversão, o arquivo convertido estará disponível para download.

Estilo CSS
O arquivo estilo.css fornece estilos para melhorar a aparência e a usabilidade do formulário de conversão de áudio. Ele define estilos para os elementos HTML, como botões, campos de entrada e rótulos, garantindo uma experiência de usuário consistente e agradável.
