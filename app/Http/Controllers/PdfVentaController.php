<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaDetalle;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;

class PdfVentaController extends Controller
{
    protected $pdf;

    public function __construct()
    {
        $this->pdf = new Fpdf();
    }

    public function index(Venta $venta)
    {
        $detalleVentas = VentaDetalle::where('id_venta', $venta->id_venta)->get();

        $this->pdf->SetMargins(17,17,17);
        $this->pdf->AddPage();
        $this->pdf->AliasNbPages();

        $this->pdf->SetDrawColor(23,83,201);

        // Logo
        $logo = public_path('assets/img/logo.png');
        $logoWidth = 35; // Ancho del logo
        $logoHeight = 35; // Alto del logo

        // Calcular la posición x para centrar el logo
        $pageWidth = $this->pdf->GetPageWidth();
        $x = ($pageWidth - $logoWidth) / 2; // Centrar

        $this->pdf->Image($logo, $x, 3, $logoWidth, $logoHeight, 'PNG');
        $this->pdf->Ln(20);

        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetTextColor(39,39,51);

        $this->pdf->Cell(177,9,iconv("UTF-8", "ISO-8859-1",config('direccion_empresa')),0,0,'C');
        $this->pdf->Ln(5);
        $this->pdf->Cell(175,9,iconv("UTF-8", "ISO-8859-1","Teléfono: " . config('telefono_empresa')),0,0,'C');
        $this->pdf->Ln(13);

        // Datos del cliente
        $this->pdf->Cell(4);
        $this->pdf->SetFont('Arial','B',14);
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(35,7,iconv("UTF-8", "ISO-8859-1","Datos del cliente:"),0,0,'C');

        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(144,7,iconv("UTF-8", "ISO-8859-1",strtoupper($venta->tipoDocumento->nombre_tipoDocumento.": " . $venta->documento_venta)),0,0,'R');

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(14,7,iconv("UTF-8", "ISO-8859-1","Nombre:"),0,0);
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$venta->cliente->nombre_persona),0,0,'L');

        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(198,7,iconv("UTF-8", "ISO-8859-1",strtoupper(date('d-m-Y', strtotime($venta->created_at)))),0,0,'C');

        $this->pdf->Ln(7);
        $this->pdf->SetFont('Arial','',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(8,7,iconv("UTF-8", "ISO-8859-1","NIT:"),0,0,'L');
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$venta->cliente->nit_persona),0,0,'L');

        $this->pdf->Ln(7);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1","Telefono:"),0,0,'L');
        $this->pdf->SetTextColor(97,97,97);
        $this->pdf->Cell(60,7,iconv("UTF-8", "ISO-8859-1",$venta->cliente->telefono_persona),0,0,'L');

        $this->pdf->Ln(15);

        // Tabla de productos (header)
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetFillColor(23,83,201);
        $this->pdf->SetDrawColor(23,83,201);
        $this->pdf->SetTextColor(255,255,255);
        $this->pdf->Cell(20,8,iconv("UTF-8", "ISO-8859-1","Código"),1,0,'C',true);
        $this->pdf->Cell(90,8,iconv("UTF-8", "ISO-8859-1","Descripción"),1,0,'C',true);
        $this->pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Cantidad"),1,0,'C',true);
        $this->pdf->Cell(25,8,iconv("UTF-8", "ISO-8859-1","Precio Unit."),1,0,'C',true);
        $this->pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Desc %"),1,0,'C',true);
        $this->pdf->Cell(15,8,iconv("UTF-8", "ISO-8859-1","Total"),1,0,'C',true);

        $this->pdf->Ln(8);

        // Productos
        $this->pdf->SetFont('Arial','',8);
        $this->pdf->SetTextColor(39,39,51);
        foreach ($detalleVentas as $d)
        {
            $this->pdf->Cell(20,7,iconv("UTF-8", "ISO-8859-1",$d->producto->sku_producto), 1, 0, 'C', 0);
            $this->pdf->Cell(90,7,iconv("UTF-8", "ISO-8859-1",$d->producto->descripcion_producto), 1, 0, 'L', 0);
            $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$d->cantidad_venta_detalle), 1, 0, 'C', 0);
            $this->pdf->Cell(25,7,iconv("UTF-8", "ISO-8859-1",$d->producto->precio_venta_producto), 1, 0, 'C', 0);
            $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$d->descuento), 1, 0, 'C', 0);
            $this->pdf->Cell(15,7,iconv("UTF-8", "ISO-8859-1",$d->producto->precio_venta_producto * $d->cantidad_venta_detalle), 1, 0, 'C', 0);
            $this->pdf->Ln(7);
        }

        // Subtotal
        $this->pdf->SetFont('Arial','B',10);
        $this->pdf->SetTextColor(39,39,51);
        $this->pdf->Cell(22,10,iconv("UTF-8", "ISO-8859-1","SUBTOTAL: "),0,0,'C');
        $this->pdf->Cell(32,10,iconv("UTF-8", "ISO-8859-1","Q." . $venta->total_venta),0,0,'L');

        // Nombre del pdf
        $this->pdf->Output("I", $venta->tipoDocumento->nombre_tipoDocumento."_Nro_".$venta->documento_venta.".pdf",true);

        exit();
    }
}
