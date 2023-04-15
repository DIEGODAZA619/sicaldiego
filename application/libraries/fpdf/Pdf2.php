<?php
ini_set("allow_url_fopen", 1);

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . "/libraries/fpdf/fpdf/fpdf.php";

class Pdf2 extends FPDF {

    public $xheader;
    public $yheader;
    public $anchoheader = 205; 
    public $cabecera;
    public $tituloCabecera;
    public $gestion;
    public $opcion_cabecera;
    public $rubro;
    public $opcion_pie;

    public $subTitulo;
    public $subEncabezado;
    public $subEncabezado2;
    public $tipoReporte;
    public $fecha;
    public $fechaini;
    public $fechafin; 

    private $encabezado;
    private $wi;
    private $cds220;
    

    public function __construct() {
        parent::__construct();
        $this->mes = array('', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    }
    function setEncabezadoG($e){
        $this->encabezado = $e;
    }
    function setWidthsG($w){
        $this->wi = $w;
        $this->widths = $w;
    }

    public function Header() {
        $this->SetFont('Arial', 'B', 8);

        //CABECERA PARA LA LISTA DE ENTIDADES
        if($this->opcion_cabecera==1)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 165, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',14);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
            $this->Ln(6);

            //Cabecera
            $this->SetFillColor(156,156,156);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',8);
            $this->Cell(21,6,utf8_decode('NRO PARTIDA'),1,0,'C',1);
            $this->Cell(65,6,utf8_decode('DESCRIPCION'),1,0,'C',1);
            $this->Cell(25,6,utf8_decode('UNIDAD'),1,0,'C',1);
            $this->Cell(25,6,utf8_decode('CANT. ENTRADA'),1,0,'C',1);
            $this->Cell(25,6,utf8_decode('CANT. SALIDA'),1,0,'C',1);
            $this->Cell(25,6,utf8_decode('SALDO'),1,0,'C',1);
            $this->Ln();
            $this->SetWidths($this->wi);
        }
        //CABECERA PARA LA LISTA DE  SOLICITUDES CONFIRMADAS
        if($this->opcion_cabecera==2)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 165, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',14);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
            $this->SetFont('Times','B',10);
            $this->Ln(6);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(6);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera2),0,1,'C',0);
            $this->Ln(6);

            //Cabecera
            $this->SetFillColor(156,156,156);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',8);
            $this->Cell(10,6,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(30,6,utf8_decode('SOLICITANTE'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('CODIGO'),1,0,'C',1);
            $this->Cell(40,6,utf8_decode('DESCRIPCION'),1,0,'C',1);
            $this->Cell(25,6,utf8_decode('UNIDAD'),1,0,'C',1);
            $this->Cell(25,6,utf8_decode('PARTIDA'),1,0,'C',1);
            $this->Cell(25,6,utf8_decode('CANT. SOLIC'),1,0,'C',1);
            //$this->Cell(25,6,utf8_decode('SALDO'),1,0,'C',1);
            $this->Ln();
            $this->SetWidths($this->wi);
        }

        if($this->opcion_cabecera==3)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 165, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
            $this->SetFont('Times','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera2),0,1,'C',0);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera3),0,1,'C',0);
            $this->Ln(6);

            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',7);
            $this->Cell(10,6,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(35,6,utf8_decode('SOLICITANTE'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('CODIGO'),1,0,'C',1);
            $this->Cell(60,6,utf8_decode('DESCRIPCION'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('UNIDAD'),1,0,'C',1);
            $this->Cell(18,6,utf8_decode('PARTIDA'),1,0,'C',1);
            $this->Cell(17,6,utf8_decode('CANTIDAD'),1,0,'C',1);
            $this->Ln();
            $this->SetWidths($this->wi);
        }
        //  Reporte Ingresos
        if($this->opcion_cabecera==4)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 165, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',14);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
            $this->SetFont('Times','B',10);
            $this->Ln(6);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(6);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera2),0,1,'C',0);
            $this->Ln(6);

            //Cabecera
            $this->SetFillColor(156,156,156);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',8);
            $this->Cell(10,6,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('PARTIDA'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('CODIGO'),1,0,'C',1);
            $this->Cell(40,6,utf8_decode('DESCRIPCION'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('PRECIO UNIT.'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('PRECIO TOTAL'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('FECHA REG.'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('CANTIDAD.'),1,0,'C',1);
            $this->Ln();
            $this->SetWidths($this->wi);
        }

        if($this->opcion_cabecera==5)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 165, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
            $this->SetFont('Times','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera2),0,1,'C',0);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera3),0,1,'C',0);
            $this->Ln(6);
            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',7);
            $this->Cell(10,6,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('CODIGO'),1,0,'C',1);
            $this->Cell(95,6,utf8_decode('DESCRIPCION'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('UNIDAD'),1,0,'C',1);
            $this->Cell(18,6,utf8_decode('PARTIDA'),1,0,'C',1);
            $this->Cell(17,6,utf8_decode('CANTIDAD'),1,0,'C',1);
            $this->Ln();
            $this->SetWidths($this->wi);
        }
        if($this->opcion_cabecera==6)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 165, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
             $this->SetFont('Times','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            
            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',7);
            $this->Cell(10,6,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('FECHA'),1,0,'C',1);
            $this->Cell(30,6,utf8_decode('CITE(CORRELATIVO)'),1,0,'C',1);
            $this->Cell(90,6,utf8_decode('DIRECCION/UNIDAD/ÁREA SOLICITANTE'),1,0,'C',1);
            $this->Cell(30,6,utf8_decode('VALORADO BS'),1,0,'C',1);            
            $this->Ln();
            $this->SetWidths($this->wi);
        }
        if($this->opcion_cabecera==7)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 165, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
             $this->SetFont('Times','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            
            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',7);
            $this->Cell(10,6,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(20,6,utf8_decode('FECHA'),1,0,'C',1);
            $this->Cell(30,6,utf8_decode('CITE(CORRELATIVO)'),1,0,'C',1);
            $this->Cell(90,6,utf8_decode('PROVEEDOR'),1,0,'C',1);
            $this->Cell(30,6,utf8_decode('VALORADO BS'),1,0,'C',1);            
            $this->Ln();
            $this->SetWidths($this->wi);
        }

        if($this->opcion_cabecera==8)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            $this->Image('resources/images/logos/chakana.png', 210, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
             $this->SetFont('Times','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            
            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',7);
            $this->Cell(7,10,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(13,10,utf8_decode('CÓDIGO'),1,0,'C',1);
            $this->Cell(11,10,utf8_decode('PARTIDA'),1,0,'C',1);
            $this->Cell(15,10,utf8_decode('UNIDAD'),1,0,'C',1);
            $this->Cell(74,10,utf8_decode('DESCRIPCIÓN'),1,0,'C',1);    
            $this->SetFont('Arial','B',6);
            $y=$this->GetY();
            $this->SetXY(140,$y);
            $this->MultiCell(17,5,utf8_decode('INICIAL FÍSICO'),1,'C',1);
            $this->SetXY(157,$y);
            $this->MultiCell(15,5,utf8_decode('INGRESO FÍSICO'),1,'C',1);
            $this->SetXY(172,$y);
            $this->MultiCell(15,5,utf8_decode('SALIDA FÍSICO'),1,'C',1);
            $this->SetXY(187,$y);
            $this->MultiCell(17,10,utf8_decode('FINAL FÍSICO'),1,'C',1);            
            $this->SetXY(204,$y);
            $this->MultiCell(17,5,utf8_decode('INICIAL VALORADO'),1,'C',1);
            $this->SetXY(221,$y);
            $this->MultiCell(17,5,utf8_decode('INGRESO VALORADO'),1,'C',1);
            $this->SetXY(236,$y);
            $this->MultiCell(17,5,utf8_decode('SALIDA VALORADO'),1,'C',1);
            $this->SetXY(251,$y);            
            $this->MultiCell(17,5,utf8_decode('FINAL VALORADO'),1,'C',1);
            $this->SetXY(188,38);

            $this->Ln();
            $this->SetWidths($this->wi);
        }

        if($this->opcion_cabecera==9)
        {
            //$this->Image('resources/images/logos/logo_senape_reporte.png', 15, 6, 75);
            //$this->Image('resources/images/logos/chakana.png', 210, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Times','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);
             $this->SetFont('Times','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            
            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',7);
            $this->Cell(7,10,utf8_decode('NRO'),1,0,'C',1);            
            $this->Cell(12,10,utf8_decode('PARTIDA'),1,0,'C',1);            
            $this->Cell(101,10,utf8_decode('DESCRIPCIÓN'),1,0,'C',1);            
            $this->SetFont('Arial','B',6);
            $y=$this->GetY();
            $this->SetXY(140,$y);
            $this->MultiCell(17,5,utf8_decode('INICIAL FÍSICO'),1,'C',1);
            $this->SetXY(157,$y);
            $this->MultiCell(15,5,utf8_decode('INGRESO FÍSICO'),1,'C',1);
            $this->SetXY(172,$y);
            $this->MultiCell(15,5,utf8_decode('SALIDA FÍSICO'),1,'C',1);
            $this->SetXY(187,$y);
            $this->MultiCell(17,10,utf8_decode('FINAL FÍSICO'),1,'C',1);            
            $this->SetXY(204,$y);
            $this->MultiCell(17,5,utf8_decode('INICIAL VALORADO'),1,'C',1);
            $this->SetXY(221,$y);
            $this->MultiCell(17,5,utf8_decode('INGRESO VALORADO'),1,'C',1);
            $this->SetXY(236,$y);
            $this->MultiCell(17,5,utf8_decode('SALIDA VALORADO'),1,'C',1);
            $this->SetXY(251,$y);            
            $this->MultiCell(17,5,utf8_decode('FINAL VALORADO'),1,'C',1);
            $this->SetXY(188,38);
            $this->Ln();
            $this->SetWidths($this->wi);
        }

        //CABECERA PARA EL DETALLE DE INFORMACIÓN DE LAS ENTIDADES
        //***** Cabecera Vacía *****//
        if($this->opcion_cabecera==0)
        {
            //Sin cabecera
        }
    }

    public function Footer() {
        switch ($this->opcion_pie) {
            case 'FOOTER_VACIO':

                break;
            case 'SOLO_NUMERACION':
                    $this->SetY(-15);
                    $this->SetFont('Arial', 'I', 8);
                    $this->SetTextColor(0);
                    $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
                break;
            default:
                    $this->SetY(-22);
                    $fecha_hoy = $this->fechacompleta2();
                    $this->SetFont('Arial', 'B', 8);
                    $this->SetTextColor(0);
                    $this->Cell(0, 10, $fecha_hoy, 0, 0, 'L');
                    $this->SetY(-15);
                    $this->SetFont('Arial', 'I', 8);
                    $this->SetTextColor(0);
                    $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'C');
                break;
        }

    }

    public function Footer_vacio() {

    }

    function AjustaCelda($ancho, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true) {
        $TamanoInicial = $this->FontSizePt;
        $TamanoLetra = $this->FontSizePt;
        $Decremento = 0.5;
        while ($this->GetStringWidth($txt) > $ancho)
            $this->SetFontSize($TamanoLetra -= $Decremento);
        $this->Cell($ancho, $h, $txt, $border, $ln, $align, $fill, $link, $scale, $force);
        $this->SetFontSize($TamanoInicial);
    }

    function SetFontSize($size) {
        if ($this->FontSizePt == $size)
            return;
        $this->FontSizePt = $size;
        $this->FontSize = $size / $this->k;
        if ($this->page > 0)
            $this->_out(sprintf('BT /F%d %.2F Tf ET', $this->CurrentFont['i'], $this->FontSizePt));
    }

/** @var fransc  * */
var $widths;
var $aligns;
var $ah;
var $aw;
var $ax;
var $ay;
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}
function SetFills($f)
{
    //Set the array of column alignments
    $this->fills=$f;
}
function SetBorders($b)
{
    //Set the array of column alignments
    $this->borders=$b;
}

function Get_x(){
    return $this->ax;
}
function Get_y(){
    return $this->ay;
}
function Get_w(){
    return $this->aw;
}
function Get_h(){
    return $this->ah;
}
function WriteTable($tcolums)
    {
        // go through all colums
        for ($i = 0; $i < sizeof($tcolums); $i++)
        {
            //para centra un poco la tabla
            $this->Cell(2);//10
            $current_col = $tcolums[$i];
            $height = 0;

            // get max height of current col
            $nb=0;
            for($b = 0; $b < sizeof($current_col); $b++)
            {
                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $nb = max($nb, $this->NbLines($current_col[$b]['width'], $current_col[$b]['text']));
                $height = $current_col[$b]['height'];
            }
            $h=$height*$nb;


            // Issue a page break first if needed
            $this->CheckPageBreak($h);

            // Draw the cells of the row
            for($b = 0; $b < sizeof($current_col); $b++)
            {
                $w = $current_col[$b]['width'];
                $a = $current_col[$b]['align'];

                // Save the current position
                $x=$this->GetX();
                $y=$this->GetY();

                // set style
                $this->SetFont($current_col[$b]['font_name'], $current_col[$b]['font_style'], $current_col[$b]['font_size']);
                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetFillColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['textcolor']);
                $this->SetTextColor($color[0], $color[1], $color[2]);
                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);
                $this->SetLineWidth($current_col[$b]['linewidth']);

                $color = explode(",", $current_col[$b]['fillcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);


                // Draw Cell Background
                $this->Rect($x, $y, $w, $h, 'FD');

                $color = explode(",", $current_col[$b]['drawcolor']);
                $this->SetDrawColor($color[0], $color[1], $color[2]);

                // Draw Cell Border
                if (substr_count($current_col[$b]['linearea'], "T") > 0)
                {
                    $this->Line($x, $y, $x+$w, $y);
                }

                if (substr_count($current_col[$b]['linearea'], "B") > 0)
                {
                    $this->Line($x, $y+$h, $x+$w, $y+$h);
                }

                if (substr_count($current_col[$b]['linearea'], "L") > 0)
                {
                    $this->Line($x, $y, $x, $y+$h);
                }

                if (substr_count($current_col[$b]['linearea'], "R") > 0)
                {
                    $this->Line($x+$w, $y, $x+$w, $y+$h);
                }


                // Print the text
                $this->MultiCell($w, $current_col[$b]['height'], $current_col[$b]['text'], 0, $a, 0);

                // Put the position to the right of the cell
                $this->SetXY($x+$w, $y);
            }

            // Go to the next line
            $this->Ln($h);
        }
    }
function Row($data,$code=false,$fills='',$fh='')
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    if ($fh==""){
        $h=3*$nb;
    }else{
        $h=3*$nb;
        if ($h < $fh)
            $h = $fh;
    }
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $ax=$x; $ay=$y; $aw=$w; $ah=$h;
        $this->Rect($x,$y,$w,$h,$fills);
        //Print the text
        $this->MultiCell($w,3,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function Row_General($data,$code=false,$fills='',$fh='') //fh: Alto de fila
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    if ($fh=="")
        $fh=4;
    
    $h=$fh*$nb;
    if ($h < $fh)
        $h = $fh;
    
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        $f=$this->fills[$i];
        $b=isset($this->borders[$i]) ? $this->borders[$i] : '1';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $ax=$x; $ay=$y; $aw=$w; $ah=$h;
        $this->Rect($x,$y,$w,$h,$fills);
        //Print the text
        $this->MultiCell($w,$fh,$data[$i],$b,$a,$f);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function Row_Entidad($data,$code=false,$fills='',$fh='')
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    if ($fh==""){
        $h=4*$nb;
    }else{
        $h=4*$nb;
        if ($h < $fh)
            $h = $fh;
    }
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $ax=$x; $ay=$y; $aw=$w; $ah=$h;
        $this->Rect($x,$y,$w,$h,$fills);
        //Print the text
        $this->MultiCell($w,4,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function Row_Reportes($data,$code=false,$fills='',$fh='')
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    if ($fh==""){
        $h=4*$nb;
    }else{
        $h=4*$nb;
        if ($h < $fh)
            $h = $fh;
    }
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $ax=$x; $ay=$y; $aw=$w; $ah=$h;
        $this->Rect($x,$y,$w,$h,$fills);
        //Print the text
        $this->MultiCell($w,4,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function RowHeader($data,$code=false,$fills='',$fh='')
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    if ($fh==""){
        $h=3*$nb;
    }else{
        $h=3*$nb;
        if ($h < $fh)
            $h = $fh;
    }
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $ax=$x; $ay=$y; $aw=$w; $ah=$h;
        $this->Rect($x,$y,$w,$h,$fills);
        //Print the text
        $this->MultiCell($w,3,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}


function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if($style=='F')
            $op='f';
        elseif($style=='FD' || $style=='DF')
            $op='B';
        else
            $op='S';
        $MyArc = 4/3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
        $xc = $x+$w-$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));

        $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
        $xc = $x+$w-$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
        $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x+$r ;
        $yc = $y+$h-$r;
        $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
        $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
        $xc = $x+$r ;
        $yc = $y+$r;
        $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
        $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
            $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
    }

    function fecha() {
        $mes =  array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
        return;
    }
    function fechacompleta(){
       $fecha = date('Y-m-j');
      //  $nuevafecha = strtotime ( '-4 hour' , strtotime ( $fecha ) ) ;
        //$fecha = date ( 'Y-m-j H:i:s' , $nuevafecha );
        return  $fecha;
      

      /*  $GetD = getdate();
        $verd = array(
        1=>"Lunes",2=>"Martes",3=>"Mi&eacute;rcoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",7=>"Domingo"
        );
        $verm = array(
        1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",
            8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"
        );
        //return $verd[$GetD['wday']].", ".$GetD['mday']." de ".$verm[$GetD['mon']]." del ".$GetD['year'];
        return " ".$GetD['mday']." de ".$verm[$GetD['mon']]." de ".$GetD['year']."  Hora:  ".$GetD['hours'].":".$GetD['minutes'].":".$GetD['seconds'];*/
    }

    function fechacompleta2(){
        $GetD = getdate();

        $mifecha = new DateTime(); 
        //$mifecha->modify('-55 minute');
        $hora = $mifecha->format('H:i:s');

       // $hora = date("H:i:s");
        $verd = array(
            1=>"Lunes",2=>"Martes",3=>"Mi&eacute;rcoles",4=>"Jueves",5=>"Viernes",6=>"Sábado",7=>"Domingo"
        );
        $verm = array(
            1=>"Enero",2=>"Febrero",3=>"Marzo",4=>"Abril",5=>"Mayo",6=>"Junio",7=>"Julio",
            8=>"Agosto",9=>"Septiembre",10=>"Octubre",11=>"Noviembre",12=>"Diciembre"
        );
        return " ".$GetD['mday']." de ".$verm[$GetD['mon']]." de ".$GetD['year'].",  Hora: ".$hora;
    }

    function fechayhoracompleta(){
        $GetD = getdate();

        $mifecha = new DateTime(); 
        //$mifecha->modify('-55 minute');
        $fechayhora = $mifecha->format('d-m-Y H:i:s');

        return "Fecha: ".$fechayhora;
    }


    function RowTitle($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 2.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 8);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h, 'FD');
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, 'C');
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h - 5);
    }
    function RowWell($data) {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 2.5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        $this->SetFillColor(200, 200, 200);
        $this->SetFont('Arial', 'B', 7);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h, 'FD');
            //Print the text
            $this->MultiCell($w, 2.5, $data[$i], 0, 'C');
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h+1);
    }

    function SetDash($black=false, $white=false)
    {
        if($black and $white)
            $s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
        else
            $s='[] 0 d';
        $this->_out($s);
    }



}

?>