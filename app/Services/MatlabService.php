<?php

namespace App\Services;

class MatlabService
{
    protected $matlabPath;

    public function __construct()
    {
        $this->matlabPath = '/usr/local/MATLAB/R2023a/bin/matlab'; // MATLAB yolunu doğru şekilde ayarlayın
    }

    public function runMatlabFunction($functionName, $args = [])
    {
        // Argümanları MATLAB komut satırı için formatlayın
        $formattedArgs = implode(',', array_map('escapeshellarg', $args));
        $matlabCommand = sprintf('%s -nodisplay -nosplash -r "%s(%s); exit;"', $this->matlabPath, $functionName, $formattedArgs);

        // Komutu çalıştır
        $output = shell_exec($matlabCommand);

        // MATLAB çıktısını işleyin
        return $this->parseMatlabOutput($output);
    }

    protected function parseMatlabOutput($output)
    {
        // MATLAB çıktısını işlemek için basit bir örnek
        // Gerçek uygulamada daha karmaşık bir işlem gerekebilir
        preg_match('/result = ([\d\.]+)/', $output, $matches);
        return $matches[1] ?? null;
    }
}
