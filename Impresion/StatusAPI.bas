Attribute VB_Name = "StatusAPI"
Option Explicit

Public status As Long

Public Const SUCCESS As Integer = 0

'BiOpenMonPrinter Argument
Public Const TYPE_PORT As Integer = 1
Public Const TYPE_PRINTER As Integer = 2

'BiOpenDrawer Argument
Public Const EPS_BI_DRAWER_1 As Integer = 1
Public Const EPS_BI_DRAWER_2 As Integer = 2

Public Const EPS_BI_PULSE_100 As Integer = 1
Public Const EPS_BI_PULSE_200 As Long = 2
Public Const EPS_BI_PULSE_300 As Long = 3
Public Const EPS_BI_PULSE_400 As Long = 4
Public Const EPS_BI_PULSE_500 As Long = 5
Public Const EPS_BI_PULSE_600 As Long = 6
Public Const EPS_BI_PULSE_700 As Long = 7
Public Const EPS_BI_PULSE_800 As Long = 8

'Printer Status
Public Const ASB_NO_RESPONSE As Long = &H1              ' No response
Public Const ASB_PRINT_SUCCESS As Long = &H2            ' Finish to print
Public Const ASB_UNRECOVER_ERR As Long = &H2000         ' Unrecoverable error
Public Const ASB_AUTORECOVER_ERR As Long = &H4000       ' Auto-Recoverable error
Public Const ASB_OFF_LINE As Long = &H8                 ' Off-line
Public Const ASB_WAIT_ON_LINE As Long = &H100           ' Waiting for on-line recovery
Public Const ASB_PANEL_SWITCH As Long = &H200           ' Panel switch
Public Const ASB_PRINTER_FEED As Long = &H40            ' Paper is being fed by using the PAPER FEED button
Public Const ASB_MECHANICAL_ERR As Long = &H400         ' Mechanical error
Public Const ASB_AUTOCUTTER_ERR As Long = &H800         ' Auto cutter error
Public Const ASB_DRAWER_KICK As Long = &H4              ' Drawer kick-out connector pin3 is HIGH
Public Const ASB_JOURNAL_END As Long = &H40000          ' Journal paper roll end
Public Const ASB_RECEIPT_END As Long = &H80000          ' Receipt paper roll end
Public Const ASB_COVER_OPEN As Long = &H20              ' Cover is open
Public Const ASB_JOURNAL_NEAR_END As Long = &H10000     ' Journal paper roll near-end
Public Const ASB_RECEIPT_NEAR_END As Long = &H20000     ' Receipt paper roll near-end
Public Const ASB_SLIP_TOF As Long = &H200000            ' SLIP TOF
Public Const ASB_SLIP_BOF As Long = &H400000            ' SLIP BOF
Public Const ASB_SLIP_SELECTED As Long = &H1000000      ' Slip is not Selected
Public Const ASB_PRINT_SLIP As Long = &H2000000         ' Cannot print on slip
Public Const ASB_VALIDATION_SELECTED As Long = &H4000000    ' Validation is not selected
Public Const ASB_PRINT_VALIDATION As Long = &H8000000   ' Cannot print on validation
Public Const ASB_VALIDATION_TOF As Long = &H20000000    ' Validation TOF
Public Const ASB_VALIDATION_BOF As Long = &H40000000    ' Validation BOF
Public Const INK_ASB_NEAR_END As Long = &H1             'Ink near-end
Public Const INK_ASB_END As Long = &H2                  'Ink end
Public Const INK_ASB_NO_CARTRIDGE As Long = &H4         'Cartridge is not present
Public Const INK_ASB_CLEANING As Long = &H20            'Being cleaned
Public Const INK_ASB_NEAR_END2 As Long = &H100          'Ink near-end2
Public Const INK_ASB_END2 As Long = &H200               'Ink end2
Public Const ASB_PRESENTER_COVER As Long = &H4          'Presenter cover is open
Public Const ASB_PLATEN_OPEN As Long = &H20             'Platen is open
Public Const ASB_JOURNAL_NEAR_END_FIRST As Long = &H10000   'Journal paper roll near-end-first
Public Const ASB_RECEIPT_NEAR_END_FIRST As Long = &H20000   'Paper low (First)
Public Const ASB_PSUPPLIER_END As Long = &H200000       'Paper suppliyer end
Public Const ASB_RECEIPT_NEAR_END_SECOND As Long = &H400000 'Receipt paper roll near-end-second
Public Const ASB_PRESENTER_TE As Long = &H1000000       'Presenter T/E receipt end
Public Const ASB_PRESENTER_TT As Long = &H2000000       'Presenter T/T receipt end
Public Const ASB_RETRACTOR_R1JAM As Long = &H4000000    'Presenter receipt end R1JAM
Public Const ASB_RETRACTOR_BOX As Long = &H8000000      'Retractor box
Public Const ASB_RETRACTOR_R2JAM As Long = &H20000000   'Retractor receipt end R2JAM
Public Const ASB_RETRACTOR_SENSOR3 As Long = &H40000000 'Receipt end retractor box
Public Const ASB_BATTERY_OFFLINE As Long = &H4          'Off-line for BATTERY QUANTITY(3.01)
Public Const ASB_PAPER_FEED As Long = &H40              'Paper is now feeding by PF FW (3.01)
Public Const ASB_PAPER_END_FIRST As Long = &H40000      'Detected paper roll end first (3.01)
Public Const ASB_PAPER_END_SECOND As Long = &H80000     'Detected paper roll end second (3.01)

Public Declare Function BiOpenMonPrinter Lib "EpsStmApi.dll" _
    (ByVal nType As Long, ByVal pName As String) _
    As Long
    
Declare Function BiGetStatus Lib "EpsStmApi.dll" _
    (ByVal nHandle As Long, ByRef lpStatus As Integer) _
    As Long
    
Declare Function BiCancelError Lib "EpsStmApi.dll" _
    (ByVal nHandle As Long) _
    As Long

Declare Function BiSetStatusBackFunction Lib "EpsStmApi.dll" _
    (ByVal nHandle As Long, ByVal pStatusCB As Long) _
    As Long

Declare Function BiSetStatusBackWnd Lib "EpsStmApi.dll" _
    (ByVal nHandle As Long, ByVal hWnd As Long, ByVal lpdwStatus As Long) _
    As Long

Declare Function BiOpenDrawer Lib "EpsStmApi.dll" _
    (ByVal nHandle As Long, ByVal drawer As Byte, ByVal pulse As Byte) _
    As Long
    
Declare Function BiCancelStatusBack Lib "EpsStmApi.dll" _
    (ByVal nHandle As Long) _
    As Long
    
Declare Function BiCloseMonPrinter Lib "EpsStmApi.dll" _
    (ByVal nHandle As Long) _
    As Long
    
Declare Sub Sleep Lib "kernel32" (ByVal dwMilliseconds As Long)


