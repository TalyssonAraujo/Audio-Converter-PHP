<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Converter</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Convert Audio</h1>
    <form action="convert.php" method="post" enctype="multipart/form-data">
        <!-- Botão personalizado para selecionar arquivo -->
        <label for="file-upload" class="custom-file-upload">
            Choose File
        </label>
        <input id="file-upload" type="file" name="audio_file" id="audio_file" required>
        <!-- Restante do formulário -->
        <label for="audio_format">Escolha um formato:</label>
        <select name="audio_format" id="audio_format">
            <option value="mp3">.mp3</option>
            <option value="ogg">.ogg</option>
            <option value="wav">.wav</option>
            <option value="opus">.opus</option>
            <option value="flac">.flac</option>
            <option value="aac">.aac</option>
        </select>
        <label for="rename">Renomear o Arquivo:</label>
        <input type="text" name="rename" id="rename" required>
        <button type="submit" name="convert">Convert Audio</button>
    </form>
</body>
</html>
