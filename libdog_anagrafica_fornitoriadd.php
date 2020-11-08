<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "libdog_anagrafica_fornitoriinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$libdog_anagrafica_fornitori_add = NULL; // Initialize page object first

class clibdog_anagrafica_fornitori_add extends clibdog_anagrafica_fornitori {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = '{786116b9-2f9b-4c95-b134-d4458b0ddc10}';

	// Table name
	var $TableName = 'libdog_anagrafica_fornitori';

	// Page object name
	var $PageObjName = 'libdog_anagrafica_fornitori_add';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (libdog_anagrafica_fornitori)
		if (!isset($GLOBALS["libdog_anagrafica_fornitori"]) || get_class($GLOBALS["libdog_anagrafica_fornitori"]) == "clibdog_anagrafica_fornitori") {
			$GLOBALS["libdog_anagrafica_fornitori"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["libdog_anagrafica_fornitori"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'libdog_anagrafica_fornitori', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->name->SetVisibility();
		$this->PI->SetVisibility();
		$this->town->SetVisibility();
		$this->address->SetVisibility();
		$this->zip->SetVisibility();
		$this->prov->SetVisibility();
		$this->mail->SetVisibility();
		$this->mobile->SetVisibility();
		$this->phone->SetVisibility();
		$this->CF->SetVisibility();
		$this->mobile2->SetVisibility();
		$this->mail2->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $libdog_anagrafica_fornitori;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($libdog_anagrafica_fornitori);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Show as modal
					$row["modal"] = "1";
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "libdog_anagrafica_fornitoriview.php")
						$row["view"] = "1";
				}
				echo ew_ArrayToJson(array($row));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewAddForm form-horizontal";

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["idlibdog_Anagrafica_Fornitori"] != "") {
				$this->idlibdog_Anagrafica_Fornitori->setQueryStringValue($_GET["idlibdog_Anagrafica_Fornitori"]);
				$this->setKey("idlibdog_Anagrafica_Fornitori", $this->idlibdog_Anagrafica_Fornitori->CurrentValue); // Set up key
			} else {
				$this->setKey("idlibdog_Anagrafica_Fornitori", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("libdog_anagrafica_fornitorilist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "libdog_anagrafica_fornitorilist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "libdog_anagrafica_fornitoriview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to View page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->name->CurrentValue = NULL;
		$this->name->OldValue = $this->name->CurrentValue;
		$this->PI->CurrentValue = NULL;
		$this->PI->OldValue = $this->PI->CurrentValue;
		$this->town->CurrentValue = NULL;
		$this->town->OldValue = $this->town->CurrentValue;
		$this->address->CurrentValue = NULL;
		$this->address->OldValue = $this->address->CurrentValue;
		$this->zip->CurrentValue = NULL;
		$this->zip->OldValue = $this->zip->CurrentValue;
		$this->prov->CurrentValue = NULL;
		$this->prov->OldValue = $this->prov->CurrentValue;
		$this->mail->CurrentValue = NULL;
		$this->mail->OldValue = $this->mail->CurrentValue;
		$this->mobile->CurrentValue = NULL;
		$this->mobile->OldValue = $this->mobile->CurrentValue;
		$this->phone->CurrentValue = NULL;
		$this->phone->OldValue = $this->phone->CurrentValue;
		$this->CF->CurrentValue = NULL;
		$this->CF->OldValue = $this->CF->CurrentValue;
		$this->mobile2->CurrentValue = NULL;
		$this->mobile2->OldValue = $this->mobile2->CurrentValue;
		$this->mail2->CurrentValue = NULL;
		$this->mail2->OldValue = $this->mail2->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->name->FldIsDetailKey) {
			$this->name->setFormValue($objForm->GetValue("x_name"));
		}
		if (!$this->PI->FldIsDetailKey) {
			$this->PI->setFormValue($objForm->GetValue("x_PI"));
		}
		if (!$this->town->FldIsDetailKey) {
			$this->town->setFormValue($objForm->GetValue("x_town"));
		}
		if (!$this->address->FldIsDetailKey) {
			$this->address->setFormValue($objForm->GetValue("x_address"));
		}
		if (!$this->zip->FldIsDetailKey) {
			$this->zip->setFormValue($objForm->GetValue("x_zip"));
		}
		if (!$this->prov->FldIsDetailKey) {
			$this->prov->setFormValue($objForm->GetValue("x_prov"));
		}
		if (!$this->mail->FldIsDetailKey) {
			$this->mail->setFormValue($objForm->GetValue("x_mail"));
		}
		if (!$this->mobile->FldIsDetailKey) {
			$this->mobile->setFormValue($objForm->GetValue("x_mobile"));
		}
		if (!$this->phone->FldIsDetailKey) {
			$this->phone->setFormValue($objForm->GetValue("x_phone"));
		}
		if (!$this->CF->FldIsDetailKey) {
			$this->CF->setFormValue($objForm->GetValue("x_CF"));
		}
		if (!$this->mobile2->FldIsDetailKey) {
			$this->mobile2->setFormValue($objForm->GetValue("x_mobile2"));
		}
		if (!$this->mail2->FldIsDetailKey) {
			$this->mail2->setFormValue($objForm->GetValue("x_mail2"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->name->CurrentValue = $this->name->FormValue;
		$this->PI->CurrentValue = $this->PI->FormValue;
		$this->town->CurrentValue = $this->town->FormValue;
		$this->address->CurrentValue = $this->address->FormValue;
		$this->zip->CurrentValue = $this->zip->FormValue;
		$this->prov->CurrentValue = $this->prov->FormValue;
		$this->mail->CurrentValue = $this->mail->FormValue;
		$this->mobile->CurrentValue = $this->mobile->FormValue;
		$this->phone->CurrentValue = $this->phone->FormValue;
		$this->CF->CurrentValue = $this->CF->FormValue;
		$this->mobile2->CurrentValue = $this->mobile2->FormValue;
		$this->mail2->CurrentValue = $this->mail2->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->idlibdog_Anagrafica_Fornitori->setDbValue($row['idlibdog_Anagrafica_Fornitori']);
		$this->name->setDbValue($row['name']);
		$this->PI->setDbValue($row['PI']);
		$this->town->setDbValue($row['town']);
		$this->address->setDbValue($row['address']);
		$this->zip->setDbValue($row['zip']);
		$this->prov->setDbValue($row['prov']);
		$this->mail->setDbValue($row['mail']);
		$this->mobile->setDbValue($row['mobile']);
		$this->phone->setDbValue($row['phone']);
		$this->CF->setDbValue($row['CF']);
		$this->mobile2->setDbValue($row['mobile2']);
		$this->mail2->setDbValue($row['mail2']);
	}

	// Return a row with NULL values
	function NullRow() {
		$row = array();
		$row['idlibdog_Anagrafica_Fornitori'] = NULL;
		$row['name'] = NULL;
		$row['PI'] = NULL;
		$row['town'] = NULL;
		$row['address'] = NULL;
		$row['zip'] = NULL;
		$row['prov'] = NULL;
		$row['mail'] = NULL;
		$row['mobile'] = NULL;
		$row['phone'] = NULL;
		$row['CF'] = NULL;
		$row['mobile2'] = NULL;
		$row['mail2'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (is_array($rs))
			$row = $rs;
		elseif (is_null($rs))
			$row = $this->NullRow();
		elseif ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			return;

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$row || !is_array($row))
			return;
		$this->idlibdog_Anagrafica_Fornitori->DbValue = $row['idlibdog_Anagrafica_Fornitori'];
		$this->name->DbValue = $row['name'];
		$this->PI->DbValue = $row['PI'];
		$this->town->DbValue = $row['town'];
		$this->address->DbValue = $row['address'];
		$this->zip->DbValue = $row['zip'];
		$this->prov->DbValue = $row['prov'];
		$this->mail->DbValue = $row['mail'];
		$this->mobile->DbValue = $row['mobile'];
		$this->phone->DbValue = $row['phone'];
		$this->CF->DbValue = $row['CF'];
		$this->mobile2->DbValue = $row['mobile2'];
		$this->mail2->DbValue = $row['mail2'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idlibdog_Anagrafica_Fornitori")) <> "")
			$this->idlibdog_Anagrafica_Fornitori->CurrentValue = $this->getKey("idlibdog_Anagrafica_Fornitori"); // idlibdog_Anagrafica_Fornitori
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idlibdog_Anagrafica_Fornitori
		// name
		// PI
		// town
		// address
		// zip
		// prov
		// mail
		// mobile
		// phone
		// CF
		// mobile2
		// mail2

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idlibdog_Anagrafica_Fornitori
		$this->idlibdog_Anagrafica_Fornitori->ViewValue = $this->idlibdog_Anagrafica_Fornitori->CurrentValue;
		$this->idlibdog_Anagrafica_Fornitori->ViewCustomAttributes = "";

		// name
		$this->name->ViewValue = $this->name->CurrentValue;
		$this->name->ViewCustomAttributes = "";

		// PI
		$this->PI->ViewValue = $this->PI->CurrentValue;
		$this->PI->ViewCustomAttributes = "";

		// town
		$this->town->ViewValue = $this->town->CurrentValue;
		$this->town->ViewCustomAttributes = "";

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

		// zip
		$this->zip->ViewValue = $this->zip->CurrentValue;
		$this->zip->ViewCustomAttributes = "";

		// prov
		$this->prov->ViewValue = $this->prov->CurrentValue;
		$this->prov->ViewCustomAttributes = "";

		// mail
		$this->mail->ViewValue = $this->mail->CurrentValue;
		$this->mail->ViewCustomAttributes = "";

		// mobile
		$this->mobile->ViewValue = $this->mobile->CurrentValue;
		$this->mobile->ViewCustomAttributes = "";

		// phone
		$this->phone->ViewValue = $this->phone->CurrentValue;
		$this->phone->ViewCustomAttributes = "";

		// CF
		$this->CF->ViewValue = $this->CF->CurrentValue;
		$this->CF->ViewCustomAttributes = "";

		// mobile2
		$this->mobile2->ViewValue = $this->mobile2->CurrentValue;
		$this->mobile2->ViewCustomAttributes = "";

		// mail2
		$this->mail2->ViewValue = $this->mail2->CurrentValue;
		$this->mail2->ViewCustomAttributes = "";

			// name
			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";
			$this->name->TooltipValue = "";

			// PI
			$this->PI->LinkCustomAttributes = "";
			$this->PI->HrefValue = "";
			$this->PI->TooltipValue = "";

			// town
			$this->town->LinkCustomAttributes = "";
			$this->town->HrefValue = "";
			$this->town->TooltipValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";
			$this->address->TooltipValue = "";

			// zip
			$this->zip->LinkCustomAttributes = "";
			$this->zip->HrefValue = "";
			$this->zip->TooltipValue = "";

			// prov
			$this->prov->LinkCustomAttributes = "";
			$this->prov->HrefValue = "";
			$this->prov->TooltipValue = "";

			// mail
			$this->mail->LinkCustomAttributes = "";
			$this->mail->HrefValue = "";
			$this->mail->TooltipValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";
			$this->mobile->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// CF
			$this->CF->LinkCustomAttributes = "";
			$this->CF->HrefValue = "";
			$this->CF->TooltipValue = "";

			// mobile2
			$this->mobile2->LinkCustomAttributes = "";
			$this->mobile2->HrefValue = "";
			$this->mobile2->TooltipValue = "";

			// mail2
			$this->mail2->LinkCustomAttributes = "";
			$this->mail2->HrefValue = "";
			$this->mail2->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// name
			$this->name->EditAttrs["class"] = "form-control";
			$this->name->EditCustomAttributes = "";
			$this->name->EditValue = ew_HtmlEncode($this->name->CurrentValue);
			$this->name->PlaceHolder = ew_RemoveHtml($this->name->FldCaption());

			// PI
			$this->PI->EditAttrs["class"] = "form-control";
			$this->PI->EditCustomAttributes = "";
			$this->PI->EditValue = ew_HtmlEncode($this->PI->CurrentValue);
			$this->PI->PlaceHolder = ew_RemoveHtml($this->PI->FldCaption());

			// town
			$this->town->EditAttrs["class"] = "form-control";
			$this->town->EditCustomAttributes = "";
			$this->town->EditValue = ew_HtmlEncode($this->town->CurrentValue);
			$this->town->PlaceHolder = ew_RemoveHtml($this->town->FldCaption());

			// address
			$this->address->EditAttrs["class"] = "form-control";
			$this->address->EditCustomAttributes = "";
			$this->address->EditValue = ew_HtmlEncode($this->address->CurrentValue);
			$this->address->PlaceHolder = ew_RemoveHtml($this->address->FldCaption());

			// zip
			$this->zip->EditAttrs["class"] = "form-control";
			$this->zip->EditCustomAttributes = "";
			$this->zip->EditValue = ew_HtmlEncode($this->zip->CurrentValue);
			$this->zip->PlaceHolder = ew_RemoveHtml($this->zip->FldCaption());

			// prov
			$this->prov->EditAttrs["class"] = "form-control";
			$this->prov->EditCustomAttributes = "";
			$this->prov->EditValue = ew_HtmlEncode($this->prov->CurrentValue);
			$this->prov->PlaceHolder = ew_RemoveHtml($this->prov->FldCaption());

			// mail
			$this->mail->EditAttrs["class"] = "form-control";
			$this->mail->EditCustomAttributes = "";
			$this->mail->EditValue = ew_HtmlEncode($this->mail->CurrentValue);
			$this->mail->PlaceHolder = ew_RemoveHtml($this->mail->FldCaption());

			// mobile
			$this->mobile->EditAttrs["class"] = "form-control";
			$this->mobile->EditCustomAttributes = "";
			$this->mobile->EditValue = ew_HtmlEncode($this->mobile->CurrentValue);
			$this->mobile->PlaceHolder = ew_RemoveHtml($this->mobile->FldCaption());

			// phone
			$this->phone->EditAttrs["class"] = "form-control";
			$this->phone->EditCustomAttributes = "";
			$this->phone->EditValue = ew_HtmlEncode($this->phone->CurrentValue);
			$this->phone->PlaceHolder = ew_RemoveHtml($this->phone->FldCaption());

			// CF
			$this->CF->EditAttrs["class"] = "form-control";
			$this->CF->EditCustomAttributes = "";
			$this->CF->EditValue = ew_HtmlEncode($this->CF->CurrentValue);
			$this->CF->PlaceHolder = ew_RemoveHtml($this->CF->FldCaption());

			// mobile2
			$this->mobile2->EditAttrs["class"] = "form-control";
			$this->mobile2->EditCustomAttributes = "";
			$this->mobile2->EditValue = ew_HtmlEncode($this->mobile2->CurrentValue);
			$this->mobile2->PlaceHolder = ew_RemoveHtml($this->mobile2->FldCaption());

			// mail2
			$this->mail2->EditAttrs["class"] = "form-control";
			$this->mail2->EditCustomAttributes = "";
			$this->mail2->EditValue = ew_HtmlEncode($this->mail2->CurrentValue);
			$this->mail2->PlaceHolder = ew_RemoveHtml($this->mail2->FldCaption());

			// Add refer script
			// name

			$this->name->LinkCustomAttributes = "";
			$this->name->HrefValue = "";

			// PI
			$this->PI->LinkCustomAttributes = "";
			$this->PI->HrefValue = "";

			// town
			$this->town->LinkCustomAttributes = "";
			$this->town->HrefValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";

			// zip
			$this->zip->LinkCustomAttributes = "";
			$this->zip->HrefValue = "";

			// prov
			$this->prov->LinkCustomAttributes = "";
			$this->prov->HrefValue = "";

			// mail
			$this->mail->LinkCustomAttributes = "";
			$this->mail->HrefValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";

			// CF
			$this->CF->LinkCustomAttributes = "";
			$this->CF->HrefValue = "";

			// mobile2
			$this->mobile2->LinkCustomAttributes = "";
			$this->mobile2->HrefValue = "";

			// mail2
			$this->mail2->LinkCustomAttributes = "";
			$this->mail2->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->address->FldIsDetailKey && !is_null($this->address->FormValue) && $this->address->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->address->FldCaption(), $this->address->ReqErrMsg));
		}
		if (!$this->mail2->FldIsDetailKey && !is_null($this->mail2->FormValue) && $this->mail2->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->mail2->FldCaption(), $this->mail2->ReqErrMsg));
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		$this->LoadDbValues($rsold);
		if ($rsold) {
		}
		$rsnew = array();

		// name
		$this->name->SetDbValueDef($rsnew, $this->name->CurrentValue, NULL, FALSE);

		// PI
		$this->PI->SetDbValueDef($rsnew, $this->PI->CurrentValue, NULL, FALSE);

		// town
		$this->town->SetDbValueDef($rsnew, $this->town->CurrentValue, NULL, FALSE);

		// address
		$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, "", FALSE);

		// zip
		$this->zip->SetDbValueDef($rsnew, $this->zip->CurrentValue, NULL, FALSE);

		// prov
		$this->prov->SetDbValueDef($rsnew, $this->prov->CurrentValue, NULL, FALSE);

		// mail
		$this->mail->SetDbValueDef($rsnew, $this->mail->CurrentValue, NULL, FALSE);

		// mobile
		$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, NULL, FALSE);

		// phone
		$this->phone->SetDbValueDef($rsnew, $this->phone->CurrentValue, NULL, FALSE);

		// CF
		$this->CF->SetDbValueDef($rsnew, $this->CF->CurrentValue, NULL, FALSE);

		// mobile2
		$this->mobile2->SetDbValueDef($rsnew, $this->mobile2->CurrentValue, NULL, FALSE);

		// mail2
		$this->mail2->SetDbValueDef($rsnew, $this->mail2->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("libdog_anagrafica_fornitorilist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($libdog_anagrafica_fornitori_add)) $libdog_anagrafica_fornitori_add = new clibdog_anagrafica_fornitori_add();

// Page init
$libdog_anagrafica_fornitori_add->Page_Init();

// Page main
$libdog_anagrafica_fornitori_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$libdog_anagrafica_fornitori_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = flibdog_anagrafica_fornitoriadd = new ew_Form("flibdog_anagrafica_fornitoriadd", "add");

// Validate form
flibdog_anagrafica_fornitoriadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_address");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $libdog_anagrafica_fornitori->address->FldCaption(), $libdog_anagrafica_fornitori->address->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_mail2");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $libdog_anagrafica_fornitori->mail2->FldCaption(), $libdog_anagrafica_fornitori->mail2->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
flibdog_anagrafica_fornitoriadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
flibdog_anagrafica_fornitoriadd.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $libdog_anagrafica_fornitori_add->ShowPageHeader(); ?>
<?php
$libdog_anagrafica_fornitori_add->ShowMessage();
?>
<form name="flibdog_anagrafica_fornitoriadd" id="flibdog_anagrafica_fornitoriadd" class="<?php echo $libdog_anagrafica_fornitori_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($libdog_anagrafica_fornitori_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $libdog_anagrafica_fornitori_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="libdog_anagrafica_fornitori">
<input type="hidden" name="a_add" id="a_add" value="A">
<input type="hidden" name="modal" value="<?php echo intval($libdog_anagrafica_fornitori_add->IsModal) ?>">
<div class="ewAddDiv"><!-- page* -->
<?php if ($libdog_anagrafica_fornitori->name->Visible) { // name ?>
	<div id="r_name" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_name" for="x_name" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->name->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->name->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_name">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_name" name="x_name" id="x_name" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->name->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->name->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->name->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->PI->Visible) { // PI ?>
	<div id="r_PI" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_PI" for="x_PI" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->PI->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->PI->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_PI">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_PI" name="x_PI" id="x_PI" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->PI->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->PI->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->PI->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->PI->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->town->Visible) { // town ?>
	<div id="r_town" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_town" for="x_town" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->town->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->town->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_town">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_town" name="x_town" id="x_town" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->town->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->town->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->town->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->town->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->address->Visible) { // address ?>
	<div id="r_address" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_address" for="x_address" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->address->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->address->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_address">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_address" name="x_address" id="x_address" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->address->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->address->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->address->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->zip->Visible) { // zip ?>
	<div id="r_zip" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_zip" for="x_zip" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->zip->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->zip->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_zip">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_zip" name="x_zip" id="x_zip" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->zip->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->zip->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->zip->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->zip->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->prov->Visible) { // prov ?>
	<div id="r_prov" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_prov" for="x_prov" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->prov->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->prov->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_prov">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_prov" name="x_prov" id="x_prov" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->prov->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->prov->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->prov->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->prov->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->mail->Visible) { // mail ?>
	<div id="r_mail" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_mail" for="x_mail" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->mail->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->mail->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_mail">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_mail" name="x_mail" id="x_mail" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->mail->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->mail->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->mail->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->mail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_mobile" for="x_mobile" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->mobile->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->mobile->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_mobile">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->mobile->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->mobile->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->mobile->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->phone->Visible) { // phone ?>
	<div id="r_phone" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_phone" for="x_phone" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->phone->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->phone->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_phone">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_phone" name="x_phone" id="x_phone" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->phone->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->phone->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->phone->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->phone->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->CF->Visible) { // CF ?>
	<div id="r_CF" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_CF" for="x_CF" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->CF->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->CF->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_CF">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_CF" name="x_CF" id="x_CF" size="30" maxlength="20" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->CF->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->CF->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->CF->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->CF->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->mobile2->Visible) { // mobile2 ?>
	<div id="r_mobile2" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_mobile2" for="x_mobile2" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->mobile2->FldCaption() ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->mobile2->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_mobile2">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_mobile2" name="x_mobile2" id="x_mobile2" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->mobile2->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->mobile2->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->mobile2->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->mobile2->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($libdog_anagrafica_fornitori->mail2->Visible) { // mail2 ?>
	<div id="r_mail2" class="form-group">
		<label id="elh_libdog_anagrafica_fornitori_mail2" for="x_mail2" class="<?php echo $libdog_anagrafica_fornitori_add->LeftColumnClass ?>"><?php echo $libdog_anagrafica_fornitori->mail2->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $libdog_anagrafica_fornitori_add->RightColumnClass ?>"><div<?php echo $libdog_anagrafica_fornitori->mail2->CellAttributes() ?>>
<span id="el_libdog_anagrafica_fornitori_mail2">
<input type="text" data-table="libdog_anagrafica_fornitori" data-field="x_mail2" name="x_mail2" id="x_mail2" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($libdog_anagrafica_fornitori->mail2->getPlaceHolder()) ?>" value="<?php echo $libdog_anagrafica_fornitori->mail2->EditValue ?>"<?php echo $libdog_anagrafica_fornitori->mail2->EditAttributes() ?>>
</span>
<?php echo $libdog_anagrafica_fornitori->mail2->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$libdog_anagrafica_fornitori_add->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $libdog_anagrafica_fornitori_add->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $libdog_anagrafica_fornitori_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
flibdog_anagrafica_fornitoriadd.Init();
</script>
<?php
$libdog_anagrafica_fornitori_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$libdog_anagrafica_fornitori_add->Page_Terminate();
?>
