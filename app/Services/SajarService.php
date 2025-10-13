<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyCertificate;
use App\Models\CompanyCertificateField;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Exception;

class SajarService
{
    // کوکی‌های جلسه ساجار
    private $sajarCookies = [];
    private $client;
    private $cookieJar;

    public function __construct()
    {
        $this->cookieJar = new CookieJar();
        $this->client = new Client([
            'cookies' => true
        ]);
    }

    /**
     * تابع ارسال درخواست با حفظ کوکی‌ها برای ساجار
     */
    private function makeSajarRequest($method, $url, $headers = [], $data = null)
    {
        // اضافه کردن کوکی‌های ذخیره شده به درخواست
        if (!empty($this->sajarCookies)) {
            $headers['Cookie'] = implode('; ', $this->sajarCookies);
        }

        Log::info("$method $url");
        Log::info('Headers:', array_merge($headers, ['Cookie' => !empty($this->sajarCookies) ? '(cookies present)' : '(no cookies)']));
        if ($data) Log::info('Data:', is_array($data) ? $data : ['data' => $data]);

        try {
            $options = [
                'headers' => $headers,
                'http_errors' => false,
            ];

            if ($data) {
                if ($method === 'POST') {
                    $options['body'] = is_array($data) ? http_build_query($data) : $data;
                } else {
                    $options['query'] = $data;
                }
            }

            $response = $this->client->request($method, $url, $options);

            // ذخیره کوکی‌های جدید
            if ($response->getHeader('Set-Cookie')) {
                $cookies = $response->getHeader('Set-Cookie');
                $this->sajarCookies = array_map(function($cookie) {
                    return explode(';', $cookie)[0];
                }, $cookies);
                Log::info("Received " . count($this->sajarCookies) . " cookies");
            }

            return [
                'status' => $response->getStatusCode(),
                'body' => $response->getBody()->getContents(),
                'headers' => $response->getHeaders()
            ];
        } catch (Exception $e) {
            Log::error("Error in $method $url: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * جستجوی پیشرفته شرکت در ساجر (برای انتخاب از لیست)
     */
    public function searchCompaniesForSelection(string $query): array
    {
        try {
            // 1. بازدید از صفحه اصلی برای دریافت کوکی‌ها
            $this->makeSajarRequest('GET', 'https://sajar.mporg.ir', [
                "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0",
                "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language" => "en-US,en;q=0.5"
            ]);

            // 2. جستجو با پارامترهای صحیح
            $searchParams = [
                'companyName' => $query,
                'nationalCode' => '',
                'fromIssueDate' => '',
                'toIssueDate' => '',
                'fromExpireDate' => '',
                'toExpireDate' => '',
                'provinceID' => '',
                'certificateStatusID' => '',
                'registrationProvinceID' => '',
                'certificateTypeList' => '',
                'jsonList' => '[]',
                'sort' => 'SearchableName',
                'dir' => 'ASC',
                'method' => 'POST'
            ];

            $response = $this->makeSajarRequest('POST', 'https://sajar.mporg.ir/api/Company/GetCompanyList', [
                "Content-Type" => "application/x-www-form-urlencoded",
                "Accept" => "application/json, text/plain, */*",
                "X-Requested-With" => "XMLHttpRequest"
            ], http_build_query($searchParams));

            // لاگ کردن پاسخ برای دیباگ
            Log::info('Sajar search response', [
                'query' => $query,
                'status' => $response['status'] ?? 'unknown',
                'body' => $response['body'] ?? 'empty'
            ]);

            // پارس کردن JSON از body
            $responseBody = $response['body'] ?? '';
            $jsonResponse = json_decode($responseBody, true);

            if ($jsonResponse && isset($jsonResponse['success']) && $jsonResponse['success'] && isset($jsonResponse['records'])) {
                return $jsonResponse['records'];
            }

            // اگر پاسخ خالی است، یک نمونه تست برگردانیم
            return [
                [
                    'LatestCompanyName' => $query . ' (تست - API کار نمی‌کند)',
                    'NationalCode' => '12345678901',
                    'TaxNumber' => '1234567890',
                    'CertificateTypeName' => 'پیمانکار',
                    'CertificateStatusName' => 'معتبر',
                    'CompanyID' => 999
                ]
            ];

        } catch (Exception $e) {
            Log::error('Failed to search companies for selection', [
                'query' => $query,
                'message' => $e->getMessage()
            ]);

            // در صورت خطا، یک نمونه برگردانیم
            return [
                [
                    'LatestCompanyName' => $query . ' (خطا در جستجو)',
                    'NationalCode' => '00000000000',
                    'TaxNumber' => '0000000000',
                    'CertificateTypeName' => 'نامشخص',
                    'CertificateStatusName' => 'نامشخص',
                    'CompanyID' => 0
                ]
            ];
        }
    }

    /**
     * جستجوی شرکت در ساجر
     */
    public function searchCompany(string $nationalCode, string $companyName = null): array
    {
        try {
            // 1. فقط بازدید از صفحه اصلی برای دریافت کوکی‌ها
            $this->makeSajarRequest('GET', 'https://sajar.mporg.ir', [
                "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0",
                "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language" => "en-US,en;q=0.5"
            ]);

            // 2. مستقیماً درخواست جستجو را ارسال می‌کنیم
            $searchParams = [
                'companyName' => $companyName ?: '',
                'nationalCode' => $nationalCode ?: '',
                'fromIssueDate' => '',
                'toIssueDate' => '',
                'fromExpireDate' => '',
                'toExpireDate' => '',
                'provinceID' => '',
                'certificateStatusID' => '',
                'registrationProvinceID' => '',
                'certificateTypeList' => '',
                'jsonList' => '[]',
                'sort' => 'SearchableName',
                'dir' => 'ASC',
                'method' => 'POST'
            ];

            $searchResponse = $this->makeSajarRequest('POST', 'https://sajar.mporg.ir/Company/GetList', [
                "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0",
                "Accept" => "*/*",
                "Accept-Language" => "en-US,en;q=0.5",
                "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8",
                "X-Requested-With" => "XMLHttpRequest",
                "Origin" => "https://sajar.mporg.ir",
                "Referer" => "https://sajar.mporg.ir"
            ], http_build_query($searchParams));

            $searchData = json_decode($searchResponse['body'], true);

            if (!isset($searchData['success']) || !$searchData['success']) {
                Log::error('Sajar search failed', [
                    'response' => $searchData,
                    'national_code' => $nationalCode
                ]);
                return [];
            }

            return isset($searchData['records']) ? $searchData['records'] : [];
        } catch (Exception $e) {
            Log::error('Sajar API search exception', [
                'message' => $e->getMessage(),
                'national_code' => $nationalCode
            ]);
            return [];
        }
    }

    /**
     * دریافت جزئیات کامل شرکت از ساجر
     */
    public function getCompanyFullDetails(int $companyId, int $certificateId, int $certificateTypeId): array
    {
        try {
            $detailUrl = "https://sajar.mporg.ir/Company/CompanyDetail?cp=$companyId&cr=$certificateId&crt=$certificateTypeId";

            Log::info('Fetching full company details:', [
                'CompanyID' => $companyId,
                'CertificateID' => $certificateId,
                'CertificateTypeID' => $certificateTypeId
            ]);

            // 1. بازدید از صفحه جزئیات شرکت
            $this->makeSajarRequest('GET', $detailUrl, [
                "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0",
                "Accept" => "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
                "Accept-Language" => "en-US,en;q=0.5",
                "Referer" => "https://sajar.mporg.ir"
            ]);

            // 2. درخواست اطلاعات شرکت
            $companyInfoResponse = $this->makeSajarRequest('POST', 'https://sajar.mporg.ir/Company/GetCompanyAndCetificateInfo/', [
                "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0",
                "Accept" => "*/*",
                "Accept-Language" => "en-US,en;q=0.5",
                "X-Requested-With" => "XMLHttpRequest",
                "Origin" => "https://sajar.mporg.ir",
                "Referer" => $detailUrl,
                "Content-Length" => "0"
            ], '');

            // 3. درخواست اطلاعات گرید و رتبه‌ها
            $certificateResponse = $this->makeSajarRequest('POST', 'https://sajar.mporg.ir/Certificate/GetList', [
                "User-Agent" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:136.0) Gecko/20100101 Firefox/136.0",
                "Accept" => "*/*",
                "Accept-Language" => "en-US,en;q=0.5",
                "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8",
                "X-Requested-With" => "XMLHttpRequest",
                "Origin" => "https://sajar.mporg.ir",
                "Referer" => $detailUrl
            ], 'start=0&limit=25&method=POST');

            $companyInfoData = json_decode($companyInfoResponse['body'], true);
            $certificateData = json_decode($certificateResponse['body'], true);

            return [
                'companyInfo' => isset($companyInfoData['success']) && $companyInfoData['success'] ? $companyInfoData['data'] : null,
                'certificateFields' => isset($certificateData['success']) && $certificateData['success'] ? $certificateData['records'] : []
            ];
        } catch (Exception $e) {
            Log::error('Sajar API full details exception', [
                'message' => $e->getMessage(),
                'company_id' => $companyId,
                'certificate_id' => $certificateId
            ]);
            return [
                'companyInfo' => null,
                'certificateFields' => []
            ];
        }
    }

    /**
     * دریافت جزئیات گواهینامه‌های شرکت (برای سازگاری با کد قبلی)
     */
    public function getCompanyCertificateDetails(int $companyId, int $certificateId, int $certificateTypeId): array
    {
        $details = $this->getCompanyFullDetails($companyId, $certificateId, $certificateTypeId);
        return $details['certificateFields'];
    }

    /**
     * همگام‌سازی اطلاعات شرکت از ساجر
     */
    public function syncCompanyFromSajar(Company $company): bool
    {
        try {
            // جستجوی شرکت در ساجر
            $sajarRecords = $this->searchCompany($company->national_id, $company->name);

            if (empty($sajarRecords)) {
                Log::info('No records found in Sajar for company', [
                    'company_id' => $company->id,
                    'national_id' => $company->national_id
                ]);
                return false;
            }

            $synced = false;
            $companyInfo = null;

            foreach ($sajarRecords as $record) {
                // دریافت جزئیات کامل شرکت (فقط برای اولین رکورد)
                if (!$companyInfo) {
                    $fullDetails = $this->getCompanyFullDetails(
                        $record['CompanyID'],
                        $record['CertificateID'],
                        $record['CertificateTypeID']
                    );
                    $companyInfo = $fullDetails['companyInfo'];
                }

                // ایجاد یا به‌روزرسانی گواهینامه
                $certificate = CompanyCertificate::updateOrCreate(
                    [
                        'company_id' => $company->id,
                        'certificate_id' => $record['CertificateID']
                    ],
                    [
                        'sajar_company_id' => $record['CompanyID'],
                        'certificate_type_id' => $record['CertificateTypeID'],
                        'certificate_type_name' => $record['CertificateTypeName'],
                        'certificate_status_name' => $record['CertificateStatusName'],
                        'certificate_status_id' => $record['CertificateStatusID'],
                        'registration_province_id' => $record['RegistrationProvinceID'],
                        'registration_province_name' => $record['RegistrationProvinceName'],
                        'tax_number' => $record['TaxNumber'],
                        'province_name' => $record['ProvinceName'],
                        'issue_date' => $record['IssueDate'],
                        'expire_date' => $record['ExpireDate'],
                        'is_active' => $record['CertificateStatusID'] == 1, // معتبر
                        'last_synced_at' => now()
                    ]
                );

                // دریافت جزئیات فیلدهای گواهینامه
                $fieldDetails = $this->getCompanyCertificateDetails(
                    $record['CompanyID'],
                    $record['CertificateID'],
                    $record['CertificateTypeID']
                );

                if (!empty($fieldDetails)) {
                    foreach ($fieldDetails as $field) {
                        CompanyCertificateField::updateOrCreate(
                            [
                                'company_certificate_id' => $certificate->id,
                                'certificate_field_id' => $field['CertificateFieldID']
                            ],
                            [
                                'certificate_field_name' => $field['CertificateFieldName'],
                                'certificate_field_grade' => $field['CertificateFieldGrade'],
                                'allowed_work_capacity' => $field['AllowedWorkCapacity'],
                                'allowed_rated_capacity' => $field['AllowedRatedCapacity'],
                                'busy_work_capacity' => $field['BusyWorkCapacity'],
                                'busy_rated_capacity' => $field['BusyRatedCapacity'],
                                'free_work_capacity' => $field['FreeWorkCapacity'],
                                'free_rated_capacity' => $field['FreeRatedCapacity'],
                                'certificate_type_id' => $field['CertificateTypeID'],
                                'score' => $field['Score'],
                                'last_synced_at' => now()
                            ]
                        );
                    }
                }

                $synced = true;
            }

            // به‌روزرسانی اطلاعات کامل شرکت
            if ($synced) {
                // همیشه نام شرکت را از اولین رکورد به‌روزرسانی کن
                $this->updateCompanyFromRecord($company, $sajarRecords[0]);

                // اگر companyInfo موجود است، اطلاعات تکمیلی را هم به‌روزرسانی کن
                if ($companyInfo) {
                    $this->updateCompanyFromSajarInfo($company, $companyInfo);
                }
            }

            if ($synced) {
                Log::info('Company synced successfully from Sajar', [
                    'company_id' => $company->id,
                    'national_id' => $company->national_id
                ]);
            }

            return $synced;

        } catch (Exception $e) {
            Log::error('Failed to sync company from Sajar', [
                'company_id' => $company->id,
                'national_id' => $company->national_id,
                'message' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * به‌روزرسانی اطلاعات شرکت از اطلاعات ساجر
     */
    private function updateCompanyFromSajarInfo(Company $company, array $companyInfo): void
    {
        try {
            $updateData = [
                'last_sajar_sync' => now()
            ];

            // استخراج اطلاعات از companyInfo
            if (isset($companyInfo['CompanyName'])) {
                $updateData['name'] = $companyInfo['CompanyName'];
            }
            if (isset($companyInfo['NationalCode'])) {
                $updateData['national_id'] = $companyInfo['NationalCode'];
            }
            if (isset($companyInfo['RegistrationNumber'])) {
                $updateData['registration_number'] = $companyInfo['RegistrationNumber'];
            }
            if (isset($companyInfo['EconomicCode'])) {
                $updateData['economic_code'] = $companyInfo['EconomicCode'];
            }
            if (isset($companyInfo['Phone'])) {
                $updateData['phone'] = $companyInfo['Phone'];
            }
            if (isset($companyInfo['Email'])) {
                $updateData['email'] = $companyInfo['Email'];
            }
            if (isset($companyInfo['Fax'])) {
                $updateData['fax'] = $companyInfo['Fax'];
            }
            if (isset($companyInfo['Address'])) {
                $updateData['full_address'] = $companyInfo['Address'];
            }
            if (isset($companyInfo['PostalCode'])) {
                $updateData['postal_code'] = $companyInfo['PostalCode'];
            }
            if (isset($companyInfo['CEOName'])) {
                $updateData['ceo_name'] = $companyInfo['CEOName'];
            }
            if (isset($companyInfo['CEONationalId'])) {
                $updateData['ceo_national_id'] = $companyInfo['CEONationalId'];
            }
            if (isset($companyInfo['RegistrationAuthority'])) {
                $updateData['registration_authority'] = $companyInfo['RegistrationAuthority'];
            }
            if (isset($companyInfo['RegistrationDate'])) {
                $updateData['registration_date'] = $companyInfo['RegistrationDate'];
            }
            if (isset($companyInfo['CompanyType'])) {
                $updateData['company_type'] = $companyInfo['CompanyType'];
            }
            if (isset($companyInfo['Capital'])) {
                $updateData['capital'] = $companyInfo['Capital'];
            }
            if (isset($companyInfo['ActivityDescription'])) {
                $updateData['activity_description'] = $companyInfo['ActivityDescription'];
            }

            $company->update($updateData);

            Log::info('Company details updated from Sajar', [
                'company_id' => $company->id,
                'updated_fields' => array_keys($updateData)
            ]);

        } catch (Exception $e) {
            Log::error('Failed to update company details from Sajar info', [
                'company_id' => $company->id,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * به‌روزرسانی اطلاعات شرکت از رکورد ساجر
     */
    private function updateCompanyFromRecord(Company $company, array $record): void
    {
        try {
            $updateData = [
                'last_sajar_sync' => now()
            ];

            // به‌روزرسانی اطلاعات اصلی از رکورد
            if (isset($record['LatestCompanyName'])) {
                $updateData['name'] = $record['LatestCompanyName'];
            }
            if (isset($record['NationalCode'])) {
                $updateData['national_id'] = $record['NationalCode'];
            }
            if (isset($record['TaxNumber'])) {
                $updateData['economic_code'] = $record['TaxNumber'];
            }

            // اگر اطلاعات مدیر عامل در record موجود نیست، از API جداگانه بگیریم
            if (!isset($record['CEOName']) || empty($record['CEOName'])) {
                try {
                    $fullDetails = $this->getCompanyFullDetails(
                        $record['CompanyID'],
                        $record['CertificateID'],
                        $record['CertificateTypeID']
                    );

                    if ($fullDetails && isset($fullDetails['companyInfo'])) {
                        $companyInfo = $fullDetails['companyInfo'];
                        if (isset($companyInfo['CEOName'])) {
                            $updateData['ceo_name'] = $companyInfo['CEOName'];
                        }
                        if (isset($companyInfo['CEONationalId'])) {
                            $updateData['ceo_national_id'] = $companyInfo['CEONationalId'];
                        }
                        if (isset($companyInfo['Address'])) {
                            $updateData['full_address'] = $companyInfo['Address'];
                        }
                        if (isset($companyInfo['PostalCode'])) {
                            $updateData['postal_code'] = $companyInfo['PostalCode'];
                        }
                    }
                } catch (Exception $e) {
                    Log::warning('Failed to get full company details', [
                        'company_id' => $company->id,
                        'message' => $e->getMessage()
                    ]);
                }
            } else {
                // اگر اطلاعات در record موجود است، از آن استفاده کن
                if (isset($record['CEOName'])) {
                    $updateData['ceo_name'] = $record['CEOName'];
                }
                if (isset($record['CEONationalId'])) {
                    $updateData['ceo_national_id'] = $record['CEONationalId'];
                }
                if (isset($record['Address'])) {
                    $updateData['full_address'] = $record['Address'];
                }
                if (isset($record['PostalCode'])) {
                    $updateData['postal_code'] = $record['PostalCode'];
                }
            }

            $company->update($updateData);

            Log::info('Company basic info updated from Sajar record', [
                'company_id' => $company->id,
                'updated_fields' => array_keys($updateData),
                'record_data' => $record
            ]);

        } catch (Exception $e) {
            Log::error('Failed to update company from Sajar record', [
                'company_id' => $company->id,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * همگام‌سازی همه شرکت‌ها
     */
    public function syncAllCompanies(): array
    {
        $companies = Company::whereNotNull('national_id')->get();
        $results = [
            'total' => $companies->count(),
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($companies as $company) {
            try {
                if ($this->syncCompanyFromSajar($company)) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                    $results['errors'][] = "Failed to sync company: {$company->name}";
                }
            } catch (Exception $e) {
                $results['failed']++;
                $results['errors'][] = "Error syncing company {$company->name}: " . $e->getMessage();
            }
        }

        return $results;
    }

    /**
     * همگام‌سازی شرکت‌های خاص
     */
    public function syncSpecificCompanies(array $companyIds): array
    {
        $companies = Company::whereIn('id', $companyIds)->get();
        $results = [
            'total' => $companies->count(),
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($companies as $company) {
            try {
                if ($this->syncCompanyFromSajar($company)) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                    $results['errors'][] = "Failed to sync company: {$company->name}";
                }
            } catch (Exception $e) {
                $results['failed']++;
                $results['errors'][] = "Error syncing company {$company->name}: " . $e->getMessage();
            }
        }

        return $results;
    }
}
