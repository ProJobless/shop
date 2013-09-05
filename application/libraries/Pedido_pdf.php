<?php

require_once('fpdf/fpdf.php');

Class Pedido_pdf extends fpdf {

    const entrelineado = 5;
    const parrafo = 4;
    const una_linea = 0;
    const un_renglon = 8;
    const margen_izq = 15;
    const margen_der = 15;
    const letra_tamano = 12;

    

    function Header() {
        $this->Rect(5,5,200,287,'D');
        // Logo
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/asesores/img/logo-angel.jpg', 10, 8, 33);
        // Arial bold 15
        $this->SetFont('Helvetica', 'B', 15);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->Cell(30, 10, utf8_decode('Asesoría Herbolaria'), 0, 0, 'C');
        $this->Image($_SERVER['DOCUMENT_ROOT'].'/asesores/img/logo-angel.jpg', 165, 8, 33);
        // Salto de línea
        $this->Ln(30);
        
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-7);
        // Arial italic 8
        $this->SetFont('Helvetica', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    public function abre_documento($orientacion = 'P') {

        $this->Open();
        $this->AliasNbPages();
        $this->AddPage($orientacion, 'Letter');
        $this->setLeftMargin(self::margen_izq);
        $this->setRightMargin(self::margen_der);
    }

    public function cierra_documento() {
        FPDF::Output();
    }

    public function nueva_hoja($orientacion = 'P') {
        //$this->AliasNbPages();
        $this->AddPage($orientacion, 'Letter');
        //$this->setLeftMargin(self::margen_izq);
        //$this->setRightMargin(self::margen_der);
    }
    
    

}

/* End of file carta_pdf.php */
/* Location: ./application/libraries/carta_pdf.php */