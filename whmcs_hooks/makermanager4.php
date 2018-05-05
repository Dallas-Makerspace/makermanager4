<?php


$availableHooks = [
    "AcceptQuote",
    "AddInvoiceLateFee",
    "AddInvoicePayment",
    "AddTransaction",
    "AfterInvoicingGenerateInvoiceItems",
    "CancelAndRefundOrder",
    "InvoiceCancelled",
    "InvoiceChangeGateway",
    "InvoiceCreated",
    "InvoiceCreation",
    "InvoiceCreationPreEmail",
    "InvoicePaid",
    "InvoicePaidPreEmail",
    "InvoicePaymentReminder",
    "InvoiceRefunded",
    "InvoiceSplit",
    "InvoiceUnpaid",
    "LogTransaction",
    "ManualRefund",
    "PreInvoicingGenerateInvoiceItems",
    "QuoteCreated",
    "QuoteStatusChange",
    "UpdateInvoiceTotal",
    "ViewInvoiceDetailsPage",
    "AcceptOrder",
    "AddonFraud",
    "AfterCalculateCartTotals",
    "AfterFraudCheck",
    "AfterShoppingCartCheckout",
    "CancelOrder",
    "CartTotalAdjustment",
    "DeleteOrder",
    "FraudCheckAwaitingUserInput",
    "FraudCheckFailed",
    "FraudCheckPassed",
    "FraudOrder",
    "OrderAddonPricingOverride",
    "OrderDomainPricingOverride",
    "OrderPaid",
    "OrderProductPricingOverride",
    "OrderProductUpgradeOverride",
    "OverrideOrderNumberGeneration",
    "PendingOrder",
    "PreCalculateCartTotals",
    "PreShoppingCartCheckout",
    "RunFraudCheck",
    "ShoppingCartCheckoutCompletePage",
    "ShoppingCartValidateCheckout",
    "ShoppingCartValidateDomain",
    "ShoppingCartValidateDomainsConfig",
    "ShoppingCartValidateProductUpdate",
    "ViewOrderDetailsPage",
    "CancellationRequest",
    "PreServiceEdit",
    "ServiceDelete",
    "ServiceEdit",
    "ServiceRecurringCompleted",
    "AfterModuleChangePackage",
    "AfterModuleChangePackageFailed",
    "AfterModuleChangePassword",
    "AfterModuleChangePasswordFailed",
    "AfterModuleCreate",
    "AfterModuleCreateFailed",
    "AfterModuleSuspend",
    "AfterModuleSuspendFailed",
    "AfterModuleTerminate",
    "AfterModuleTerminateFailed",
    "AfterModuleUnsuspend",
    "AfterModuleUnsuspendFailed",
    "OverrideModuleUsernameGeneration",
    "PreModuleChangePackage",
    "PreModuleChangePassword",
    "PreModuleCreate",
    "PreModuleSuspend",
    "PreModuleTerminate",
    "PreModuleUnsuspend",
    "DomainDelete",
    "DomainEdit",
    "DomainTransferCompleted",
    "DomainTransferFailed",
    "DomainValidation",
    "PreDomainRegister",
    "PreDomainTransfer",
    "PreRegistrarRegisterDomain",
    "PreRegistrarRenewDomain",
    "PreRegistrarTransferDomain",
    "TopLevelDomainAdd",
    "TopLevelDomainDelete",
    "TopLevelDomainPricingUpdate",
    "TopLevelDomainUpdate",
    "AfterRegistrarGetContactDetails",
    "AfterRegistrarGetDNS",
    "AfterRegistrarGetEPPCode",
    "AfterRegistrarGetNameservers",
    "AfterRegistrarRegister",
    "AfterRegistrarRegistration",
    "AfterRegistrarRegistrationFailed",
    "AfterRegistrarRenew",
    "AfterRegistrarRenewal",
    "AfterRegistrarRenewalFailed",
    "AfterRegistrarRequestDelete",
    "AfterRegistrarSaveContactDetails",
    "AfterRegistrarSaveDNS",
    "AfterRegistrarSaveNameservers",
    "AfterRegistrarTransfer",
    "AfterRegistrarTransfer",
    "AfterRegistrarTransferFailed",
    "PreRegistrarGetContactDetails",
    "PreRegistrarGetDNS",
    "PreRegistrarGetEPPCode",
    "PreRegistrarGetNameservers",
    "PreRegistrarRequestDelete",
    "PreRegistrarSaveContactDetails",
    "PreRegistrarSaveDNS",
    "PreRegistrarSaveNameservers",
    "AddonActivated",
    "AddonActivation",
    "AddonAdd",
    "AddonCancelled",
    "AddonConfig",
    "AddonConfigSave",
    "AddonDeleted",
    "AddonEdit",
    "AddonRenewal",
    "AddonSuspended",
    "AddonTerminated",
    "AddonUnsuspended",
    "AfterAddonUpgrade",
    "LicensingAddonReissue",
    "LicensingAddonVerify",
    "ProductAddonDelete",
    "AddonActivated",
    "AddonActivation",
    "AddonAdd",
    "AddonCancelled",
    "AddonConfig",
    "AddonConfigSave",
    "AddonDeleted",
    "AddonEdit",
    "AddonRenewal",
    "AddonSuspended",
    "AddonTerminated",
    "AddonUnsuspended",
    "AfterAddonUpgrade",
    "LicensingAddonReissue",
    "LicensingAddonVerify",
    "ProductAddonDelete",
    "ContactAdd",
    "ContactChangePassword",
    "ContactDelete",
    "ContactDetailsValidation",
    "ContactEdit",
    "AfterProductUpgrade",
    "ProductDelete",
    "ProductEdit",
    "ServerAdd",
    "ServerDelete",
    "ServerEdit",
    "AdminAreaViewTicketPage",
    "ClientAreaPageSubmitTicket",
    "ClientAreaPageSupportTickets",
    "ClientAreaPageViewTicket",
    "SubmitTicketAnswerSuggestions",
    "TicketAddNote",
    "TicketAdminReply",
    "TicketClose",
    "TicketDelete",
    "TicketDeleteReply",
    "TicketDepartmentChange",
    "TicketFlagged",
    "TicketOpen",
    "TicketOpenAdmin",
    "TicketPiping",
    "TicketPriorityChange",
    "TicketStatusChange",
    "TicketSubjectChange",
    "TicketUserReply",
    "TransliterateTicketText",
    "AnnouncementAdd",
    "AnnouncementEdit",
    "FileDownload",
    "NetworkIssueAdd",
    "NetworkIssueClose",
    "NetworkIssueDelete",
    "NetworkIssueEdit",
    "NetworkIssueReopen",
    "ClientLogin",
    "ClientLoginShare",
    "ClientLogout",
    "ClientAreaDomainDetails",
    "ClientAreaHomepage",
    "ClientAreaHomepagePanels",
    "ClientAreaNavbars",
    "ClientAreaPage",
    "ClientAreaPageAddContact",
    "ClientAreaPageAddFunds",
    "ClientAreaPageAffiliates",
    "ClientAreaPageAnnouncements",
    "ClientAreaPageBanned",
    "ClientAreaPageBulkDomainManagement",
    "ClientAreaPageCancellation",
    "ClientAreaPageCart",
    "ClientAreaPageChangePassword",
    "ClientAreaPageConfigureSSL",
    "ClientAreaPageContact",
    "ClientAreaPageContacts",
    "ClientAreaPageCreditCard",
    "ClientAreaPageCreditCardCheckout",
    "ClientAreaPageDomainAddons",
    "ClientAreaPageDomainChecker",
    "ClientAreaPageDomainContacts",
    "ClientAreaPageDomainDNSManagement",
    "ClientAreaPageDomainDetails",
    "ClientAreaPageDomainEPPCode",
    "ClientAreaPageDomainEmailForwarding",
    "ClientAreaPageDomainRegisterNameservers",
    "ClientAreaPageDomains",
    "ClientAreaPageDownloads",
    "ClientAreaPageEmails",
    "ClientAreaPageHome",
    "ClientAreaPageInvoices",
    "ClientAreaPageKnowledgebase",
    "ClientAreaPageLogin",
    "ClientAreaPageLogout",
    "ClientAreaPageMassPay",
    "ClientAreaPageNetworkIssues",
    "ClientAreaPagePasswordReset",
    "ClientAreaPageProductDetails",
    "ClientAreaPageProductsServices",
    "ClientAreaPageProfile",
    "ClientAreaPageQuotes",
    "ClientAreaPageRegister",
    "ClientAreaPageSecurity",
    "ClientAreaPageServerStatus",
    "ClientAreaPageUnsubscribe",
    "ClientAreaPageUpgrade",
    "ClientAreaPageViewEmail",
    "ClientAreaPageViewInvoice",
    "ClientAreaPageViewQuote",
    "ClientAreaPageViewWHOIS",
    "ClientAreaPrimaryNavbar",
    "ClientAreaPrimarySidebar",
    "ClientAreaProductDetails",
    "ClientAreaProductDetailsPreModuleTemplate",
    "ClientAreaRegister",
    "ClientAreaSecondaryNavbar",
    "ClientAreaSecondarySidebar",
    "ClientAreaSidebars",
    "AdminAreaClientSummaryActionLinks",
    "AdminAreaClientSummaryPage",
    "AdminAreaPage",
    "AdminAreaViewQuotePage",
    "AdminClientDomainsTabFields",
    "AdminClientDomainsTabFieldsSave",
    "AdminClientFileUpload",
    "AdminClientProfileTabFields",
    "AdminClientProfileTabFieldsSave",
    "AdminClientServicesTabFields",
    "AdminClientServicesTabFieldsSave",
    "AdminHomepage",
    "AdminLogin",
    "AdminLogout",
    "AdminProductConfigFields",
    "AdminProductConfigFieldsSave",
    "AdminServiceEdit",
    "AuthAdmin",
    "AuthAdminApi",
    "InvoiceCreationAdminArea",
    "PreAdminServiceEdit",
    "AdminAreaFooterOutput",
    "AdminAreaHeadOutput",
    "AdminAreaHeaderOutput",
    "AdminInvoicesControlsOutput",
    "ClientAreaDomainDetailsOutput",
    "ClientAreaFooterOutput",
    "ClientAreaHeadOutput",
    "ClientAreaHeaderOutput",
    "ClientAreaProductDetailsOutput",
    "ReportViewPostOutput",
    "ReportViewPreOutput",
    "ShoppingCartCheckoutOutput",
    "ShoppingCartConfigureProductAddonsOutput",
    "ShoppingCartViewCartOutput",
    "ShoppingCartViewCategoryAboveProductsOutput",
    "ShoppingCartViewCategoryBelowProductsOutput",
    "AfterCronJob",
    "DailyCronJob",
    "DailyCronJobPreEmail",
    "PreCronJob",
    "AffiliateActivation",
    "AffiliateClickthru",
    "AffiliateCommission",
    "AffiliateWithdrawalRequest",
    "AfterConfigOptionsUpgrade",
    "CCUpdate",
    "CalcAffiliateCommission",
    "CustomFieldLoad",
    "CustomFieldSave",
    "EmailPreLog",
    "EmailPreSend",
    "EmailTplMergeFields",
    "FetchCurrencyExchangeRates",
    "IntelligentSearch",
    "LinkTracker",
    "LogActivity",
    "NotificationPreSend",
    "PostAutomationTask",
    "PreAutomationTask",
    "PremiumPriceOverride",
    "PremiumPriceRecalculationOverride",
];

foreach($availableHooks as $hook) {
    add_hook($hook, 2, function($payload) use($hook) {
        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => MM4_URL . '/api/v1/whmcs/process-hook',
            CURLOPT_USERPWD => MM4_USERNAME . ":" . MM4_PASSWORD,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'hook' => $hook,
                'payload' => $payload
            ]
        ]);
    });
}

<?php


define("MM4_URL", "https://makermanager.dallasmakerspace.org/");
define("MM4_USERNAME", "");
define("MM4_PASSWORD", "");

function curlPostData($url, $payload) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    $output = curl_exec($ch);
    curl_close($ch);
}

function sendAddonActivation($vars) {
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/addonActivate', $vars);
}

function sendAddonCancelled($vars) {
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/addonCancel', $vars);
}

function sendClientAdd($vars) {
    $vars['username'] = $vars['customfields'][2];
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/clientAdd', $vars);
}

function sendClientChangePassword($vars) {
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/clientChangePassword', $vars);
}

function sendClientEdit($vars) {
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/clientEdit', $vars);
}

function sendInvoicePaid($vars) {
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/invoicePaid', $vars);
}

function sendAfterModuleCreate($vars) {
    // Normalize data under params key for call
    $vars = $vars['params'];
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/moduleCreate', $vars);
}

function sendAfterModuleSuspend($vars) {
    // Normalize data under params key for call
    $vars = $vars['params'];
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/moduleSuspend', $vars);
}

function sendAfterModuleTerminate($vars) {
    // Normalize data under params key for call
    $vars = $vars['params'];
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/moduleTerminate', $vars);
}

function sendAfterModuleUnsuspend($vars) {
    // Normalize data under params key for call
    $vars = $vars['params'];
    curlPostData('https://accounts.dallasmakerspace.org/makermanager/endpoints/moduleUnsuspend', $vars);
}

add_hook('AddonActivation', 2, 'sendAddonActivation');
add_hook('AddonCancelled', 2, 'sendAddonCancelled');
add_hook('ClientAdd', 2, 'sendClientAdd');
add_hook('ClientChangePassword', 2, 'sendClientChangePassword');
add_hook('ClientEdit', 2, 'sendClientEdit');
add_hook('InvoicePaid', 2, 'sendInvoicePaid');
add_hook('AfterModuleCreate', 2, 'sendAfterModuleCreate');
add_hook('AfterModuleSuspend', 2, 'sendAfterModuleSuspend');
add_hook('AfterModuleTerminate', 2, 'sendAfterModuleTerminate');
add_hook('AfterModuleUnsuspend', 2, 'sendAfterModuleUnsuspend');
