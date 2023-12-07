<?php

namespace App\Models;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDF
{
    public function generatePDF($html, $name)
    {
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream($name, ['Attachment' => false]);
    }
}