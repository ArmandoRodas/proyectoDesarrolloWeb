<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaDetalle;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;

class TicketVentaController extends Controller
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new Fpdf('P','mm', array(80,297));
    }

    public function index(Venta $venta)
    {
        $detalleVentas = VentaDetalle::where('id_venta', $venta->id_venta)->get();

        $this->pdf->SetMargins(4,10,4);
        $this->pdf->AddPage();
        
        # Encabezado y datos de la empresa #
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(0,0,0);

        // Logo
        $logo = public_path('assets/img/logo.png');
        $logoWidth = 20; // Ancho del logo
        $logoHeight = 20; // Alto del logo

        // Calcular la posición x para centrar el logo
        $pageWidth = $this->pdf->GetPageWidth();
        $x = ($pageWidth - $logoWidth) / 2; // Centrar
        
        $this->pdf->Image($logo, $x, 3, $logoWidth, $logoHeight, 'PNG');
        $this->pdf->Ln(15);

        $this->pdf->SetFont('Arial','',9);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",config('direccion_empresa')),0,'C',false);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: " . config('telefono_empresa')),0,'C',false);

        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);

        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Fecha: ".date('d-m-Y', strtotime($venta->created_at))),0,'C',false);
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",strtoupper($venta->tipoDocumento->nombre_tipoDocumento.": " . $venta->documento_venta)),0,'C',false);
        $this->pdf->SetFont('Arial','',9);

        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(5);

        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Cliente: ".$venta->cliente->nombre_persona),0,'C',false);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","NIT: ".$venta->cliente->nit_persona),0,'C',false);
        $this->pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Teléfono: ".$venta->cliente->telefono_persona),0,'C',false);

        $this->pdf->Ln(1);
        $this->pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(3);

        // # Tabla de productos #
        $this->pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1","Cant."),0,0,'C');
        $this->pdf->Cell(19,5,iconv("UTF-8", "ISO-8859-1","Precio"),0,0,'C');
        $this->pdf->Cell(15,5,iconv("UTF-8", "ISO-8859-1","Desc. %"),0,0,'C');
        $this->pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1","Total"),0,0,'C');

        $this->pdf->Ln(3);
        $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
        $this->pdf->Ln(3);

        // /*----------  Detalles de la tabla  ----------*/
        foreach ($detalleVentas as $d)
        {
            $this->pdf->MultiCell(0,4,iconv("UTF-8", "ISO-8859-1",$d->producto->descripcion_producto),0,0,false);
            $this->pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$d->cantidad_venta_detalle),0,0,'C');
            $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1","Q.".$d->producto->precio_venta_producto),0,0,'C');
            $this->pdf->Cell(19,4,iconv("UTF-8", "ISO-8859-1",$d->descuento),0,0,'C');
            $this->pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1","Q.".$d->producto->precio_venta_producto * $d->cantidad_venta_detalle),0,0,'C');
            $this->pdf->Ln(4);

            $this->pdf->Cell(72,5,iconv("UTF-8", "ISO-8859-1","-------------------------------------------------------------------"),0,0,'C');
            $this->pdf->Ln(3);
        }
        // /*----------  Fin Detalles de la tabla  ----------*/

        // # Impuestos & totales #
        $this->pdf->Cell(18,5,iconv("UTF-8", "ISO-8859-1",""),0,0,'C');
        $this->pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1","SUBTOTAL"),0,0,'C');
        $this->pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1","Q." . $venta->total_venta),0,0,'C');

        $this->pdf->Ln(15);

        $this->pdf->SetFont('Arial','B',9);
        $this->pdf->Cell(0,7,iconv("UTF-8", "ISO-8859-1","Gracias por su compra"),'',0,'C');

        # Nombre del archivo PDF #
        header('Content-type: application/pdf');
        $this->pdf->Output("I",$venta->tipoDocumento->nombre_tipoDocumento."_Nro_".$venta->documento_venta.".pdf",true);

        exit();
    }
}
