<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CardToIbanController extends Controller
{
    /**
     * Display the card to IBAN conversion form
     */
    public function index()
    {
        return view('admin.card-to-iban.index');
    }

    /**
     * Convert card number to IBAN using Digikala API ONLY
     * No fallback methods - only uses Digikala API
     */
    public function convert(Request $request): JsonResponse
    {
        $request->validate([
            'card_number' => 'required|string|min:16|max:19',
        ]);

        $cardNumber = $this->cleanCardNumber($request->card_number);

        // Validate card number format
        if (!$this->isValidCardNumber($cardNumber)) {
            return response()->json([
                'success' => false,
                'message' => 'شماره کارت وارد شده معتبر نیست.'
            ], 400);
        }

        try {
            // Log the request
            Log::info('Card to IBAN conversion request', [
                'card_number' => $cardNumber,
                'original_input' => $request->card_number
            ]);

            // Call Digikala API with complete headers and proper gzip handling
            $response = Http::withOptions([
                'verify' => false,
                'decode_content' => true, // Enable gzip decompression
                'timeout' => 15,
            ])->withHeaders([
                'Accept' => 'application/json, text/plain, */*',
                'Accept-Encoding' => 'gzip, deflate, br, zstd',
                'Accept-Language' => 'en-GB,en;q=0.9,en-US;q=0.8',
                'Content-Type' => 'application/json',
                'Origin' => 'https://www.digikala.com',
                'Referer' => 'https://www.digikala.com/',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36 Edg/140.0.0.0',
                'x-web-client' => 'desktop',
                'x-web-optimize-response' => '1',
                'sec-ch-ua' => '"Chromium";v="140", "Not=A?Brand";v="24", "Microsoft Edge";v="140"',
                'sec-ch-ua-mobile' => '?0',
                'sec-ch-ua-platform' => '"Windows"',
                'sec-fetch-dest' => 'empty',
                'sec-fetch-mode' => 'cors',
                'sec-fetch-site' => 'same-site',
                'priority' => 'u=1, i',
                // Using stored or default cookies
                'Cookie' => $this->getStoredCookies()
            ])->post('https://api.digikala.com/v1/iban/card/', [
                'card_number' => $cardNumber
            ]);

            // Log the response
            Log::info('Digikala API Response', [
                'status_code' => $response->status(),
                'headers' => $response->headers(),
                'body' => $response->body(),
                'successful' => $response->successful()
            ]);

            if (!$response->successful()) {
                Log::error('Digikala API Error - Non-successful response', [
                    'status' => $response->status(),
                    'response' => $response->body(),
                    'card_number' => $cardNumber
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'خطا در دریافت اطلاعات از سرور. لطفاً دوباره تلاش کنید. (کد خطا: ' . $response->status() . ')'
                ], 500);
            }

            $data = $response->json();

            // Log parsed data
            Log::info('Parsed API Response', [
                'data' => $data,
                'card_number' => $cardNumber
            ]);

            if (!isset($data['status']) || $data['status'] !== 200) {
                Log::warning('Invalid API response format or status', [
                    'response_data' => $data,
                    'card_number' => $cardNumber,
                    'expected_status' => 200,
                    'actual_status' => $data['status'] ?? 'not_set'
                ]);

                // If API returns 401 (Unauthorized), return error
                if (isset($data['status']) && $data['status'] === 401) {
                    Log::error('API returned 401 - Unauthorized', [
                        'card_number' => $cardNumber,
                        'response' => $data
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'خطا در احراز هویت با سرور دیجی‌کالا. لطفاً cookies را به‌روزرسانی کنید.'
                    ], 401);
                }

            return response()->json([
                'success' => false,
                'message' => 'شماره کارت وارد شده معتبر نیست یا اطلاعات آن در سرور دیجی‌کالا یافت نشد. (وضعیت: ' . ($data['status'] ?? 'نامشخص') . ')'
            ], 400);
            }

            $bankAccount = $data['data']['bank_account'];
            $bankName = $this->getBankNameByCode($bankAccount['bank_code']);

            return response()->json([
                'success' => true,
                'data' => [
                    'card_number' => $this->formatCardNumber($bankAccount['card_number']),
                    'iban' => $bankAccount['iban'],
                    'owner' => $bankAccount['owner'] ?? 'نامشخص',
                    'bank_name' => $bankName,
                    'bank_code' => $bankAccount['bank_code'],
                    'sms_ttl' => $data['data']['sms_ttl'] ?? null
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Card to IBAN conversion error', [
                'error' => $e->getMessage(),
                'card_number' => $cardNumber,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'خطا در ارتباط با سرور دیجی‌کالا: ' . $e->getMessage()
            ], 500);
        }
    }




    /**
     * Clean card number (remove spaces, dashes, etc.)
     */
    private function cleanCardNumber(string $cardNumber): string
    {
        return preg_replace('/[^0-9]/', '', $cardNumber);
    }

    /**
     * Validate card number using Luhn algorithm
     */
    private function isValidCardNumber(string $cardNumber): bool
    {
        if (strlen($cardNumber) < 16 || strlen($cardNumber) > 19) {
            return false;
        }

        // Luhn algorithm
        $sum = 0;
        $alternate = false;

        for ($i = strlen($cardNumber) - 1; $i >= 0; $i--) {
            $n = intval($cardNumber[$i]);

            if ($alternate) {
                $n *= 2;
                if ($n > 9) {
                    $n = ($n % 10) + 1;
                }
            }

            $sum += $n;
            $alternate = !$alternate;
        }

        return ($sum % 10) == 0;
    }

    /**
     * Get bank name by bank code
     */
    private function getBankNameByCode(string $bankCode): string
    {
        $banks = [
            '010' => 'بانک مرکزی جمهوری اسلامی ایران',
            '011' => 'بانک صنعت و معدن',
            '012' => 'بانک ملت',
            '013' => 'بانک رفاه کارگران',
            '014' => 'بانک مسکن',
            '015' => 'بانک سپه',
            '016' => 'بانک کشاورزی',
            '017' => 'بانک ملی ایران',
            '018' => 'بانک تجارت',
            '019' => 'بانک صادرات ایران',
            '020' => 'بانک توسعه تعاون',
            '021' => 'پست بانک ایران',
            '022' => 'بانک توسعه صادرات ایران',
            '051' => 'موسسه اعتباری توسعه',
            '052' => 'بانک قوامین',
            '053' => 'بانک کارآفرین',
            '054' => 'بانک پارسیان',
            '055' => 'بانک اقتصاد نوین',
            '056' => 'بانک سامان',
            '057' => 'بانک پاسارگاد',
            '058' => 'بانک سرمایه',
            '059' => 'بانک سینا',
            '060' => 'بانک مهر ایران',
            '061' => 'بانک شهر',
            '062' => 'بانک آینده',
            '063' => 'بانک انصار',
            '064' => 'بانک گردشگری',
            '065' => 'بانک حکمت ایرانیان',
            '066' => 'بانک دی',
            '069' => 'بانک ایران زمین',
            '070' => 'بانک رسالت',
            '073' => 'بانک کوثر',
            '075' => 'بانک مهر اقتصاد',
            '078' => 'بانک خاورمیانه',
            '079' => 'بانک نور',
            '090' => 'بانک قرض‌الحسنه مهر ایران',
            '095' => 'بانک ایران و ونزوئلا'
        ];

        return $banks[$bankCode] ?? 'بانک نامشخص';
    }

    /**
     * Format card number for display
     */
    private function formatCardNumber(string $cardNumber): string
    {
        return chunk_split($cardNumber, 4, '-');
    }

    /**
     * Get list of supported banks
     */
    public function getBanks(): JsonResponse
    {
        $banks = [
            ['name' => 'بانک ملی ایران', 'code' => '017'],
            ['name' => 'بانک سپه', 'code' => '015'],
            ['name' => 'بانک صادرات ایران', 'code' => '019'],
            ['name' => 'بانک ملت', 'code' => '012'],
            ['name' => 'بانک تجارت', 'code' => '018'],
            ['name' => 'بانک کشاورزی', 'code' => '016'],
            ['name' => 'بانک مسکن', 'code' => '014'],
            ['name' => 'بانک رفاه کارگران', 'code' => '013'],
            ['name' => 'بانک پاسارگاد', 'code' => '057'],
            ['name' => 'بانک پارسیان', 'code' => '054'],
            ['name' => 'بانک اقتصاد نوین', 'code' => '055'],
            ['name' => 'بانک سامان', 'code' => '056'],
            ['name' => 'بانک سرمایه', 'code' => '058'],
            ['name' => 'بانک سینا', 'code' => '059'],
            ['name' => 'پست بانک ایران', 'code' => '021'],
            ['name' => 'بانک شهر', 'code' => '061'],
            ['name' => 'بانک دی', 'code' => '066'],
            ['name' => 'بانک آینده', 'code' => '062'],
            ['name' => 'بانک کارآفرین', 'code' => '053'],
            ['name' => 'بانک ایران زمین', 'code' => '069'],
        ];

        return response()->json([
            'success' => true,
            'data' => $banks
        ]);
    }

    /**
     * View logs for debugging
     */
    public function viewLogs()
    {
        $logPath = storage_path('logs/laravel.log');

        if (!file_exists($logPath)) {
            return response()->json([
                'success' => false,
                'message' => 'فایل لاگ یافت نشد'
            ]);
        }

        // Get last 100 lines of log file
        $lines = [];
        $file = new \SplFileObject($logPath);
        $file->seek(PHP_INT_MAX);
        $totalLines = $file->key();

        $startLine = max(0, $totalLines - 100);
        $file->seek($startLine);

        while (!$file->eof()) {
            $line = $file->current();
            if (strpos($line, 'Card to IBAN') !== false ||
                strpos($line, 'Digikala API') !== false ||
                strpos($line, 'card_number') !== false) {
                $lines[] = trim($line);
            }
            $file->next();
        }

        return response()->json([
            'success' => true,
            'logs' => array_slice($lines, -50) // Last 50 relevant lines
        ]);
    }

    /**
     * Update cookies for API requests
     */
    public function updateCookies(Request $request)
    {
        $request->validate([
            'cookies' => 'required|string'
        ]);

        // Store cookies in cache or config for future use
        cache(['digikala_cookies' => $request->cookies], now()->addHours(24));

        return response()->json([
            'success' => true,
            'message' => 'Cookies به‌روزرسانی شدند'
        ]);
    }

    /**
     * Get stored cookies
     */
    private function getStoredCookies(): string
    {
        // Updated cookies from working request
        return cache('digikala_cookies', '_ga=GA1.1.1558112388.1748186993; _ym_uid=1748186995270097537; _ym_d=1748186995; tracker_glob_new=a2bsZCI; Digikala:General:Location=cEFWbHVIUGRqLyt6aXRWbWI2MVEvQT09%26Ny9ZT2FuSmdNRDBYMXEyWTZEWkx6ZDhXVHJldnRqeFVGbWVockhwQmx5MkRidTkzU1FtR0d4ZUhoTWh5MnRVT3RXRTBVL1RoUHdOd0lLUmUvMDVOM0E9PQ~~; ab_test_experiments=%5B%22229ea1a233356b114984cf9fa2ecd3ff%22%2C%224905b18f64695e6dbfd739d20a4ae2c0%22%2C%22f0fd80107233fa604679779d7e121710%22%2C%2237136fdc21e0b782211ccac8c2d7be63%22%5D; _sp_ses.13cb=*; PHPSESSID=kp73in92rsonamr56ore65hh4j; tracker_session=aRbUQ2z; Digikala:User:Token:new=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoyNDUwMjA0MCwic3ViIjoyNDUwMjA0MCwiZXhwaXJlX3RpbWUiOjE3NjIxODQwMDEsImV4cCI6MTc2MjE4NDAwMSwicGF5bG9hZCI6W10sInBhc3N3b3JkX3ZlcnNpb24iOjEsInR5cGUiOiJ0b2tlbiIsInNpZCI6Ijc0MzFiOTg5LWEzYzktNDg5My04N2VmLWU4MWZiMTdhZTkwYiJ9.Xa2vJa59cF2gYpvYl2dDXqeLQ5DxOPzSNtiSmgWgN0g; TS01c77ebf=010231059104ad28a3f6a048a29a8d54a57c38a08424bc9b360daf995b5075f8f43bc78e0cadeba8c9b4fc6e65d5742201d413273f8fb3e38d3f8806556923c01512adf57e470a4f9297337229549f980ed374259e8271fdff1d38fc31bfa60cdcbb1d5b1c; TS01b6ea4d=0102310591505ad6bf7ea17db95b3e7d09c0af1a4924bc9b360daf995b5075f8f43bc78e0ca939ee69b7b2f525531fd52e7863187fb9d78c5ce9a4b69b12523477c00f78b6afb81c7c0f9e170fd57d0f093016b198; _sp_id.13cb=ab109986-8c44-421d-90e1-beba1f709b4a.1756216701.4.1759592196.1759387527.04d51ebb-c2c4-4a56-bb6c-3048fadfb26a.efae9b50-0fa1-4c85-972e-c33ab7dbe4d6.19563780-03f9-48d1-94df-9ce3d4621d46.1759592000151.14; _ga_QQKVTD5TG8=GS2.1.s1759592001$o5$g1$t1759592196$j56$l0$h0');
    }
}
