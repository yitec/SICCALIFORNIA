Attribute VB_Name = "Mod_BD"
Public db As ADODB.Connection


Sub Main()
'Call listar_procesos
ConectarDB
Frm_imprimir.Show
Frm_imprimir.Hide
'Frm_pruebas.Show
End Sub


Public Sub ConectarDB()
Dim conexion As New ADODB.Connection
On Error GoTo Eterror


Set db = New ADODB.Connection
'db.Open "DRIVER={MySQL ODBC 5.1 Driver};DATABASE=bd_siccalifornia;SERVER=127.0.0.1;UID=root; PASSWORD=1q2w3e;PORT=3306;"
db.Open "DRIVER={MySQL ODBC 5.1 Driver};DATABASE=escalant_sic;SERVER=199.58.186.59;UID=escalant_sic; PASSWORD=Sic2012;PORT=3306;"




Exit Sub
Eterror:

MsgBox "Ha ocurrido el siguiente error: " & Err.Description, vbCritical, "Error al intentar Conectar a la Base de Datos"

End Sub

