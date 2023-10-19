<?php
ini_set("allow_url_fopen", 1);

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . "/libraries/fpdf/fpdf/fpdf_oficio.php";

class Pdf3 extends FPDF_OFICIO {

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

        if($this->opcion_cabecera==10)
        {
            $this->Image('resources/images/logos/senape.png', 35, 20, 40);
            $this->SetY(20);
            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(0);
            $this->Cell(305, 6, 'DGCF - R1.06', 0, 1, 'R');
            $this->Cell(305, 0, utf8_decode('Versión 01'), 0, 0, 'R');     

            //$this->Image('resources/images/logos/chakana.png', 210, 5, 38);
            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);            
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->tituloCabeceraDos),0,1,'C',0);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->tituloCabeceraTres),0,1,'C',0);            
            $this->SetFont('Arial','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera2),0,1,'C',0);
            $this->Ln(5);
            
            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',7);

            $this->Cell(10,8,utf8_decode('NRO'),1,0,'C',1);
            $this->Cell(140,8,utf8_decode('DESCRIPCIÓN (ÍTEM)'),1,0,'C',1);             
            $this->SetFont('Arial','B',6);
            $y=$this->GetY();
            $x=68;
            $this->SetXY(117+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Unidad de Medida'),1,'C',1);
            $this->SetXY(132+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Precio Unitario'),1,'C',1);
            $this->SetXY(147+$x,$y);
            $this->Cell(60,4,utf8_decode('Cantidad'),1,0,'C',1);
            $this->Cell(60,4,utf8_decode('Valores'),1,0,'C',1);
            $y+=4;
            $this->SetXY(147+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Saldo Inicial'),1,'C',1);
            $this->SetXY(162+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Entradas'),1,'C',1);
            $this->SetXY(177+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Salidas'),1,'C',1);            
            $this->SetXY(192+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Saldo Final'),1,'C',1);
            $this->SetXY(207+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Saldo Inicial'),1,'C',1);
            $this->SetXY(222+$x,$y);
            $this->MultiCell(15,4,utf8_decode('Entradas'),1,'C',1);
            $this->SetXY(237+$x,$y);            
            $this->MultiCell(15,4,utf8_decode('Salidas'),1,'C',1);
            $this->SetXY(252+$x,$y);            
            $this->MultiCell(15,4,utf8_decode('Saldo final'),1,'C',1);
            //$this->SetXY(188,53);
            //$this->Ln();
            $this->SetWidths($this->wi);
        }

        if($this->opcion_cabecera==11)
        {
            $this->Image('resources/images/logos/senape.png', 42, 20, 40);
            $this->SetY(20);
            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(0);
            $this->Cell(295,6,'DGCF - R1.05', 0, 1, 'R');
            $this->Cell(295,0,utf8_decode('Versión 01'), 0, 0, 'R');       

            $this->Ln();
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',12);
            $this->SetY(23);
            $this->Cell(0,0,utf8_decode($this->tituloCabecera),0,1,'C',0);            
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->tituloCabeceraDos),0,1,'C',0);                      
            $this->SetFont('Arial','B',9);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera1),0,1,'C',0);
            $this->Ln(5);
            $this->Cell(0,0,utf8_decode($this->subtituloCabecera2),0,1,'C',0);
            $this->Ln(5);

            $cabe1 = "Cantidad Inicial al ".$this->fechaReporte;
            $cabe2 = "Saldo Inicial al ".$this->fechaReporte;
            $cabe3 = "Cantidad Final al ".$this->fechaReporte;
            $cabe4 = "Saldo Final al ".$this->fechaReporte;
            
            //Cabecera
            $this->SetFillColor(205,205,205);
            $this->SetTextColor(0);
            $this->SetFont('Arial','B',9);
            $this->Cell(10,8,utf8_decode('N°'),1,0,'C',1);            
            $this->Cell(140,8,utf8_decode('Partida'),1,0,'C',1);                        
            $this->SetFont('Arial','B',9);
            $y=$this->GetY();
            $x=35;
            $this->SetXY(155+$x,$y);
            $this->MultiCell(35,4,utf8_decode($cabe1),1,'C',1);
            $this->SetXY(190+$x,$y);
            $this->MultiCell(35,4,utf8_decode($cabe2),1,'C',1);
            $this->SetXY(225+$x,$y);
            $this->MultiCell(35,4,utf8_decode($cabe3),1,'C',1);
            $this->SetXY(260+$x,$y);
            $this->MultiCell(35,4,utf8_decode($cabe4),1,'C',1);
            $this->SetXY(295+$x,47);
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

    function Row($data,$code=false,$fills='',$fh='')
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        if ($fh==""){
            $h=5*$nb;
        }else{
            $h=5*$nb;
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
            $this->MultiCell($w,5,$data[$i],0,$a);
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
        return  $fecha;
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