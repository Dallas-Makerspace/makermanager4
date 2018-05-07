<?php

define("MM4_URL", "https://makermanager.dallasmakerspace.org/");
define("MM4_USERNAME", "");
define("MM4_PASSWORD", "");

$availableHooks = [
    "AddonActivation",
    "AddonCancelled",
    "ClientAdd",
    "ClientChangePassword",
    "ClientEdit",
    "InvoicePaid",
    "AfterModuleCreate",
    "AfterModuleSuspend",
    "AfterModuleTerminate",
    "AfterModuleUnsuspend",
];

try {
    foreach($availableHooks as $hook) {
        add_hook($hook, 3, function($payload) use($hook) {
            $ch = curl_init();

            $request = json_encode([
                'hook' => $hook,
                'payload' => base64_encode(serialize($payload))
            ]);

            curl_setopt_array($ch, [
                CURLOPT_URL => MM4_URL . 'api/v1/whmcs/process-hook',
                CURLOPT_USERPWD => MM4_USERNAME . ":" . MM4_PASSWORD,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_HTTPHEADER => [
                    "Accept: application/json",
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($request)
                ],
                CURLOPT_POSTFIELDS => $request
            ]);

            $output = curl_exec($ch);

            // close curl resource to free up system resources
            curl_close($ch);
        });
    }
} catch(\Exception $e) {
}
