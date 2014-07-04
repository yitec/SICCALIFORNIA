VERSION 5.00
Begin VB.Form Form1 
   BorderStyle     =   1  'Fixed Single
   Caption         =   "Step7  Drawer control"
   ClientHeight    =   1860
   ClientLeft      =   7332
   ClientTop       =   6156
   ClientWidth     =   5184
   LinkTopic       =   "Form1"
   MaxButton       =   0   'False
   MinButton       =   0   'False
   ScaleHeight     =   1860
   ScaleWidth      =   5184
   Begin VB.Timer Timer1 
      Enabled         =   0   'False
      Interval        =   100
      Left            =   1320
      Top             =   1320
   End
   Begin VB.CommandButton Command1 
      Height          =   375
      Left            =   1800
      TabIndex        =   3
      Top             =   1320
      Visible         =   0   'False
      Width           =   735
   End
   Begin VB.CommandButton cmdClose 
      Caption         =   "Close"
      Height          =   350
      Left            =   3910
      TabIndex        =   2
      Top             =   1330
      Width           =   1110
   End
   Begin VB.Frame Frame1 
      Caption         =   "Receipt"
      Height          =   1140
      Left            =   165
      TabIndex        =   0
      Top             =   150
      Width           =   4855
      Begin VB.CommandButton Conectar 
         Caption         =   "Conectar"
         Height          =   372
         Left            =   2400
         TabIndex        =   4
         Top             =   360
         Width           =   1692
      End
      Begin VB.CommandButton cmdPrint 
         Caption         =   "Print"
         Height          =   375
         Left            =   360
         TabIndex        =   1
         Top             =   360
         Width           =   1110
      End
   End
   Begin VB.Image Image1 
      Height          =   540
      Left            =   120
      Picture         =   "Form1.frx":0000
      Top             =   1320
      Visible         =   0   'False
      Width           =   852
   End
End
Attribute VB_Name = "Form1"
Attribute VB_GlobalNameSpace = False
Attribute VB_Creatable = False
Attribute VB_PredeclaredId = True
Attribute VB_Exposed = False
Option Explicit

Public mpHandle As Long ' Printer handle for Status API
Public phase As Byte    ' Phasing for the timer control

Dim lpdwStatus As Long
Dim isFinish As Boolean
Dim cancelErr As Boolean

' Constants for the phases of the program execution.
Private Const PHASE_START = 0
Private Const PHASE_WAIT = 1
Private Const PHASE_END = 2

' Constant variable holding the printer name.
Private Const PRINTER_NAME = "EPSON TM-T88V Receipt"

' The executed function when the Print button is clicked.
Private Sub cmdPrint_Click()

    phase = PHASE_START
    
    ' Start the timer.
    ' Timer is used in this sample program to imitate threading.
    ' Threading is needed here so that the program will not hang-up or crash
    ' from waiting for the callback function call.
    Timer1.Enabled = True
    
End Sub

Private Sub Conectar_Click()


Dim CON As ADODB.Connection

Dim comd As ADODB.Command
Dim rt As ADODB.Recordset



Set CON = New ADODB.Connection
Set comd = New ADODB.Command
Set rt = New ADODB.Recordset
CON.CommandTimeout = 40
CON.CursorLocation = 1
'CON.ConnectionString = "server=localhost;driver=mysql;db=proyecto"
CON.Open "DRIVER={MySQL ODBC 5.1 Driver};DATABASE=bd_sic;SERVER=127.0.0.1;UID=root; PASSWORD=1q2w3e;PORT=3306;"

'CON.Open
Set comd.ActiveConnection = CON
comd.CommandType = 1
comd.CommandText = "select * from tbl_usuarios"

rt.Open comd, , 1, 1


MsgBox rt.Fields("usuario")
End Sub
' The event handler of Timer when it is started/enabled.
' This will just coordinate the phasing of the program execution.
Private Sub Timer1_Timer()
    On Error GoTo ErrorHandler
    
    Dim printerObj As Printer
    Dim hndleButton, retVal As Long
    Dim isSet As Boolean
    Dim sOpt As String
    
    Select Case phase
    
        ' Initialize printer phase
        Case PHASE_START
        
            isSet = False
        
            ' Change the printer to the indicated printer.
            For Each printerObj In Printers
               If printerObj.DeviceName = PRINTER_NAME Then
                    Set Printer = printerObj
                    isSet = True
                    Exit For
                End If
            Next
                
            ' Open a printer status monitor for the selected printer.
            mpHandle = BiOpenMonPrinter(TYPE_PRINTER, Printer.DeviceName)
            
            If mpHandle < 0 Then
               sOpt = MsgBox("Failed to open printer status monitor.", vbExclamation + vbOKOnly, "Program09")
                Timer1.Enabled = False
            Else
                
                If isSet Then
                
                    isFinish = False
                    cancelErr = False
                    
                        hndleButton = Command1.hWnd
                        
                        ' Associate the button's handle to the event handler of StatusAPI.
                        ' The button's OnClick event is executed whenever there is a change in the status.
                        If Not BiSetStatusBackWnd(mpHandle, hndleButton, VarPtr(lpdwStatus)) = SUCCESS Then
                            sOpt = MsgBox("Failed to set callback function.", vbExclamation + vbOKOnly, "Program09")
                            phase = PHASE_END
                        Else
                            Call PrintData
                            phase = PHASE_WAIT
                        End If
                        
                Else
                    Timer1.Enabled = False
                    sOpt = MsgBox("Printer is not available.", vbExclamation + vbOKOnly, "Program09")
                End If
            End If
            
        ' Waiting for printing phase
        Case PHASE_WAIT
        
            If isFinish = True Then
                phase = PHASE_END
            Else
                Sleep 200
            End If
        
        ' Finished printing phase
        Case PHASE_END
        
            If isFinish = True Then
            
                ' Display the status/error message.
                Call DisplayStatusMessage
                
                ' If an error occurred, restore the recoverable error.
                If cancelErr = True Then
                    retVal = BiCancelError(mpHandle)
                End If
                
                ' End the monitoring of printer status.
                BiCancelStatusBack (mpHandle)
                
            End If
                
            ' Always close the Status Monitor after using the Status API.
            If Not BiCloseMonPrinter(mpHandle) = SUCCESS Then
                sOpt = MsgBox("Failed to close printer status monitor.", vbExclamation + vbOKOnly, "Program09")
            End If
                
            Timer1.Enabled = False
            
    End Select
    
    Exit Sub
        
ErrorHandler:

    sOpt = MsgBox("Failed to open StatusAPI.", vbExclamation + vbOKOnly, "Program09")
    
End Sub

Private Sub PrintData()
    Dim sPrevAppTitle As String
    
    sPrevAppTitle = App.Title
    App.Title = "Testing"
    
    Printer.ScaleMode = vbPoints
    
    Printer.PaintPicture Image1.Picture, 82, 0, , , , , , vbMergeCopy
    
    Printer.CurrentY = Printer.CurrentY + 22
    Printer.ScaleLeft = -12.5
            
    Printer.FontSize = 9.5
    Printer.FontName = "FontA11"
    
    Printer.Print ""
    Printer.Print "123xxstreet,xxxcity,xxxxstate"
    Printer.Print "        TEL   9999-99-9999       C#2"
    Printer.Print "    November.23, 2007     PM 4:24"
    Printer.Print ""
    Printer.Print "apples                       $20.00"
    Printer.Print "grapes                       $30.00"
    Printer.Print "bananas                      $40.00"
    Printer.Print "lemons                       $50.00"
    Printer.Print "oranges                      $60.00"
    Printer.Print ""
    Printer.Print "Tax excluded.               $200.00"
    Printer.Print "Tax     5.0%                 $10.00"
    Printer.CurrentX = Printer.CurrentX - 2
    Printer.Print "___________________________________"
    Printer.Print ""
    
    Printer.FontName = "FontA22"
    Printer.FontSize = 19
    
    Printer.Print "Total     $210.00"
    
    Printer.FontName = "FontA11"
    Printer.FontSize = 9.5
    
    Printer.Print "Customer's payment         $250.00"
    Printer.Print "Change                      $40.00"
        
    Printer.EndDoc
    
    App.Title = sPrevAppTitle
End Sub

' The callback function that will monitor printer/printing status.
Private Sub Command1_Click()
    On Error Resume Next
        
    If (lpdwStatus And ASB_PRINT_SUCCESS) = ASB_PRINT_SUCCESS Then
        isFinish = True
        status = lpdwStatus
    ElseIf (lpdwStatus And ASB_NO_RESPONSE) = ASB_NO_RESPONSE Or _
       (lpdwStatus And ASB_COVER_OPEN) = ASB_COVER_OPEN Or _
       (lpdwStatus And ASB_AUTOCUTTER_ERR) = ASB_AUTOCUTTER_ERR Or _
       ((lpdwStatus And ASB_PAPER_END_FIRST) = ASB_PAPER_END_FIRST) Or ((lpdwStatus And ASB_PAPER_END_SECOND) = ASB_PAPER_END_SECOND) Then
        isFinish = True
        cancelErr = True
        status = lpdwStatus
    End If
End Sub

' Open the cash drawer using the Status API.
Private Sub OpenDrawer(ByRef mpHandle As Long)
    On Error GoTo ErrorHandler
    
    Dim sOpt As String
    
    ' Execute drawer operation.
    If Not BiOpenDrawer(mpHandle, EPS_BI_DRAWER_1, EPS_BI_PULSE_100) = SUCCESS Then
        sOpt = MsgBox("Failed to open drawer.", vbExclamation + vbOKOnly, "Program09")
    End If
    
    Exit Sub
        
ErrorHandler:

    sOpt = MsgBox("Failed to open StatusAPI.", vbExclamation + vbOKOnly, "Program09")
End Sub

Private Sub DisplayStatusMessage()
    Dim sOpt As String
    
    If (status And ASB_PRINT_SUCCESS) = ASB_PRINT_SUCCESS Then
        sOpt = MsgBox("Printing complete.", vbInformation + vbOKOnly, "Program09")
        ' If the printing completed, call BiOpenDrawer from the Status API to perform the drawer kick.
        Call OpenDrawer(mpHandle)
                        
    ElseIf (status And ASB_NO_RESPONSE) = ASB_NO_RESPONSE Then
        sOpt = MsgBox("No response.", vbExclamation + vbOKOnly, "Program09")
            
    ElseIf (status And ASB_COVER_OPEN) = ASB_COVER_OPEN Then
        sOpt = MsgBox("Cover is open.", vbExclamation + vbOKOnly, "Program09")
            
    ElseIf (status And ASB_AUTOCUTTER_ERR) = ASB_AUTOCUTTER_ERR Then
        sOpt = MsgBox("Autocutter error occurred.", vbExclamation + vbOKOnly, "Program09")
            
    ElseIf ((status And ASB_PAPER_END_FIRST) = ASB_PAPER_END_FIRST) Or ((status And ASB_PAPER_END_SECOND) = ASB_PAPER_END_SECOND) Then
        sOpt = MsgBox("Roll paper end sensor: paper not present.", vbExclamation + vbOKOnly, "Program09")
                
    End If
End Sub

' The executed function when the Close button is clicked.
Private Sub cmdClose_Click()
    Unload Me
End Sub
