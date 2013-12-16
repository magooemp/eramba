<?php
define('USER_NOTACTIVE', 0);
define('USER_ACTIVE', 1);

define('CURRENCY_SYMBOL', '$');

define('MEDIA_BASE_DIR', '\\media');
define('DATE_FORMAT', 'd.m.Y h:i');

define('FLASH_OK', 'messages/flash-ok');
define('FLASH_ERROR', 'messages/flash-error');
define('FLASH_WARNING', 'messages/flash-warning');
define('FLASH_INFO', 'messages/flash-info');

//path to elements
define('CORE_ELEMENT_PATH', 'core/');

//default page limit for all paginate sites
define('DEFAULT_PAGE_LIMIT', 20);

//asset_media_types
define('ASSET_MEDIA_TYPE_DATA', 1);

//security_policy
define('SECURITY_POLICY_DRAFT', 0);
define('SECURITY_POLICY_RELEASED', 1);

//risk_mitigation_strategies
define('RISK_MITIGATION_MITIGATE', 1);
define('RISK_MITIGATION_ACCEPT', 2);
define('RISK_MITIGATION_TRANSFER', 3);

//security_service_types
define('SECURITY_SERVICE_PRODUCTION', 4);
define('SECURITY_SERVICE_RETIRED', 5);

//compliance_treatment_strategy
define('COMPLIANCE_TREATMENT_MITIGATE', 1);
define('COMPLIANCE_TREATMENT_NOT_APPLICABLE', 2);
define('COMPLIANCE_TREATMENT_IGNORE', 3);

//compliance_finding_statuses
define('COMPLIANCE_FINDING_OPEN', 1);
define('COMPLIANCE_FINDING_CLOSED', 2);

//audits
define('AUDIT_PASSED', 1);