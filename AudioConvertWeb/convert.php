    <?php

    function getDuration($file) {
        $cmd = "ffmpeg -i " . escapeshellarg($file) . " 2>&1";
        $output = shell_exec($cmd);
        preg_match('/Duration: (\d{2}):(\d{2}):(\d{2})\.(\d{2})/', $output, $matches);
        if (count($matches) == 5) {
            $hours = intval($matches[1]);
            $minutes = intval($matches[2]);
            $seconds = intval($matches[3]);
            return $hours * 3600 + $minutes * 60 + $seconds;
        }
        return null;
    }

    function sanitizeFileName($fileName) {
        // Remove caracteres especiais e substituir por sublinhado
        return preg_replace('/[^A-Za-z0-9_\-]/', '_', $fileName);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input_file = $_FILES["audio_file"]["tmp_name"];
        $original_name = pathinfo($_FILES["audio_file"]["name"], PATHINFO_FILENAME);
        $format = $_POST["audio_format"];
        $rename = sanitizeFileName($_POST["rename"]);
        $noise_level = -30; // Ajuste o nível de ruído conforme necessário

        $temp_output_file = 'temp_output.mp3';
        $temp_noise_file = 'temp_noise.mp3';
        $output_file = $rename . "." . $format;

        // Obter a duração do arquivo de entrada
        $duration = getDuration($input_file);

        if ($duration !== null) {
            // Gerar ruído branco e sobrepor ao áudio original
            $cmd_generate_noise = "ffmpeg -f lavfi -i anullsrc=r=44100:cl=stereo -t $duration -filter:a \"volume={$noise_level}dB\" " . escapeshellarg($temp_noise_file);
            exec($cmd_generate_noise);

            $cmd_add_noise = "ffmpeg -i " . escapeshellarg($input_file) . " -i " . escapeshellarg($temp_noise_file) . " -filter_complex \"[0:a][1:a]amix=inputs=2:duration=first:dropout_transition=2,volume=2\" " . escapeshellarg($temp_output_file);
            exec($cmd_add_noise);

            if ($format == "ogg") {
                $cmd_convert = "ffmpeg -i " . escapeshellarg($temp_output_file) . " -c:a libvorbis -b:a 128k " . escapeshellarg($output_file);
            } elseif ($format == "wav") {
                $cmd_convert = "ffmpeg -i " . escapeshellarg($temp_output_file) . " -c:a pcm_s16le -b:a 128k " . escapeshellarg($output_file);
            } elseif ($format == "flac") {
                $cmd_convert = "ffmpeg -i " . escapeshellarg($temp_output_file) . " -c:a flac -b:a 128k " . escapeshellarg($output_file);
            } elseif ($format == "aac") {
                $cmd_convert = "ffmpeg -i " . escapeshellarg($temp_output_file) . " -c:a aac -b:a 128k " . escapeshellarg($output_file);
            } elseif ($format == "opus") {
                $cmd_convert = "ffmpeg -i " . escapeshellarg($temp_output_file) . " -c:a libopus -b:a 128k " . escapeshellarg($output_file);
            } else {
                $cmd_convert = "ffmpeg -i " . escapeshellarg($temp_output_file) . " -c:a libmp3lame -b:a 128k " . escapeshellarg($output_file); // Default to mp3
            }

            exec($cmd_convert);

            // Remover arquivos temporários
            unlink($temp_output_file);
            unlink($temp_noise_file);

            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=" . basename($output_file));
            header("Content-Transfer-Encoding: binary");
            header("Accept-Ranges: bytes");

            readfile($output_file);

            unlink($output_file);
        } else {
            echo "Erro ao obter a duração do arquivo de entrada.";
        }
    } else {
        echo "Método de requisição inválido.";
    }

    ?>
