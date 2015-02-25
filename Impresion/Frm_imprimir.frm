VERSION 5.00
Begin VB.Form Frm_imprimir 
   Caption         =   "Form2"
   ClientHeight    =   960
   ClientLeft      =   108
   ClientTop       =   432
   ClientWidth     =   3756
   LinkTopic       =   "Form2"
   ScaleHeight     =   960
   ScaleWidth      =   3756
   StartUpPosition =   3  'Windows Default
   Begin VB.Timer Timer1 
      Interval        =   500
      Left            =   1560
      Top             =   480
   End
   Begin VB.Label Label1 
      Caption         =   "Modulo Impresión"
      Height          =   372
      Left            =   1200
      TabIndex        =   0
      Top             =   120
      Width           =   1332
   End
End
Attribute VB_Name = "Frm_imprimir"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Private Sub Form_Load()
Call SetPrinter("Generica")
End Sub
Private Sub SetPrinter(PrnName As String)
    Dim prn As Printer
    If Printers.Count > 0 Then
        For Each prn In Printers
            If prn.DeviceName = PrnName Then
                Set Printer = prn
                Exit For
            End If
        Next prn
    End If
End Sub
Private Sub Timer1_Timer()
Dim rs As New ADODB.Recordset
Dim rs2 As New ADODB.Recordset

rs.Open "select fac.id,fac.consecutivo_solicitud,fac.monto_original,fac.monto_descuento,fac.monto_total,cli.nombre from tbl_facturas fac join tbl_clientes cli on fac.id_cliente=cli.id where fac.impresa=0 LIMIT 1 ", db

If rs.EOF = False Then

    Dim sPrevAppTitle As String
    
    sPrevAppTitle = App.Title
    App.Title = "Testing"
    
    Printer.ScaleMode = vbPoints
    
    'Printer.PaintPicture Image1.Picture, 82, 0, , , , , , vbMergeCopy
    
    Printer.CurrentY = Printer.CurrentY + 22
    Printer.ScaleLeft = -12.5
            
    Printer.FontSize = 9.5
    Printer.FontName = "FontA11"
    
    Printer.Print ""
    Printer.Print "     Laboratorio Clinico     "
    Printer.Print "  DRA. LILLIAM ESCALANTE S.A "
    Printer.Print "       Cedula Juridica       "
    Printer.Print "         3-101-154330        "
    Printer.Print "       " & Now() & "  "
    Printer.Print "#Factura:" & rs!consecutivo_solicitud
    Printer.Print ""
    Printer.Print "Cliente: " & rs!nombre
    Printer.Print ""
    Printer.Print "        Detalle          "
    Printer.Print "-------------------------"

    rs2.Open "select ana.precio,cat.nombre from tbl_analisis ana inner join tbl_categoriasanalisis cat on ana.id_analisis=cat.id where cat.imprimir_contrato=1 and ana.consecutivo_solicitud='" & rs!consecutivo_solicitud & "'  ", db
    
    While Not rs2.EOF

    
    Printer.Print "" & rs2!nombre & " "
    Printer.Print "                     " & "c" & rs2!precio
    Printer.Print ""
    
    rs2.MoveNext
    
    Wend
    
    Printer.Print "-------------------------"
    Printer.Print "Sub Total:          " & Chr(189) & rs!monto_original
    Printer.Print "Descuento:          " & Chr(189) & rs!monto_descuento
    Printer.Print "Monto Total:        " & Chr(189) & rs!monto_total '
    'Printer.Print "Monto Total:        " & "¢" & rs!monto_total '
    Printer.Print ""
    Printer.Print "-------------------------"
    Printer.Print "  Gracias por su visita  "
    Printer.Print ""
    Printer.Print ""
    Printer.Print ""
    Printer.Print ""
    Printer.Print ""
    Printer.Print ""
    Printer.Print "          --             "
    
    Printer.Print ""
    Printer.EndDoc
    
    App.Title = sPrevAppTitle
db.Execute "update tbl_facturas set impresa=1 where id='" & rs!id & "' "
rs.MoveNext
rs.Close


End If


End Sub
